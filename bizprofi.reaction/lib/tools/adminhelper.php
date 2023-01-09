<?php

namespace Bizprofi\Reaction\Tools;

use Bitrix\Forum\MessageTable;
use Bitrix\Main\Application;
use Bitrix\Main\Db\Connection;
use Bitrix\Main\Loader;
use Bitrix\Main\ORM\Fields;
use Bitrix\Main\Type\Date;
use Bitrix\Socialnetwork\LogCommentTable;
use Bitrix\Tasks\TaskTable;
use Bizprofi\Reaction\NotifyEventsHandler;
use Bizprofi\Tools\Lang;

class AdminHelper
{
    const TYPE_TASK = 'task';
    const TYPE_REPORT = 'report';
    const TYPE_COMMENT = 'comment';
    const TYPE_BIZPROC = 'bizproc';

    // Начало периода генерации
    protected $from = null;

    // Конец периода генерации
    protected $to = null;

    // Типы уведомлений для генерации
    protected $types = [];

    // Агрегатор обработчиков событий
    protected $handler = null;

    public function __construct(string $from, string $to, array $types)
    {
        $this->from = new Date($from);

        $this->to = new Date($to);

        $this->types = array_intersect(
            $this->__types(),
            $types
        );

        $this->handler = new NotifyEventsHandler();
    }

    // Возвращает типы всех поддерживаемых уведомлений
    protected function __types(): array
    {
        return [
            static::TYPE_TASK,
            static::TYPE_REPORT,
            static::TYPE_COMMENT,
            static::TYPE_BIZPROC,
        ];
    }

    // Алиас на удобную работу с Connection
    protected function connection(): Connection
    {
        return Application::getConnection();
    }

    // Возвращает агрегатор обработчиков событий
    protected function handler(): NotifyEventsHandler
    {
        return $this->handler;
    }

    // Возвращает типы уведомлений для генерации
    public function types(): array
    {
        return $this->types;
    }

    // Возвращает дату начала интервала
    public function from(): Date
    {
        return $this->from;
    }

    // Возвращает дату завершения интервала
    public function to(): Date
    {
        return $this->to;
    }

    // Генерирует уведомления выбранных типов за указанный интервал
    public function generate()
    {
        if (in_array(static::TYPE_TASK, $this->types(), true)) {
            $this->generateForTask();
        }

        if (in_array(static::TYPE_REPORT, $this->types(), true)) {
            $this->generateForReport();
        }

        if (in_array(static::TYPE_COMMENT, $this->types(), true)) {
            $this->generateForComment();
        }

        if (in_array(static::TYPE_BIZPROC, $this->types(), true)) {
            $this->generateForBizproc();
        }
    }

    // Генерирует уведомления задач за указанный интервал
    protected function generateForTask()
    {
        if (!Loader::includeModule('tasks')) {
            throw new \Exception(
                Lang::render('88d3de4d78800f467fc769b584d81f3b')
            );
        }

        $rows = TaskTable::query()
            ->where('CREATED_DATE', '>=', $this->from())
            ->where('CREATED_DATE', '<=', $this->to())
            ->setSelect(['*'])
            ->exec();

        $this->connection()->startTransaction();

        while ($row = $rows->fetch()) {
            if (\CTasks::STATE_SUPPOSEDLY_COMPLETED === $row['STATUS']) {
                $row['META:PREV_FIELDS']['CREATED_BY'] = $row['CREATED_BY'];
                $this->handler()->onTaskUpdate($row['ID'], $row);
            }
        }

        $this->connection()->commitTransaction();
    }

    // Генерирует уведомления отчетов за указанный интервал
    protected function generateForReport()
    {
        if (!Loader::includeModule('timeman')) {
            throw new \Exception(
                Lang::render('0ac7f609b84ccba5f73b3ab61f7c3586')
            );
        }

        $this->connection()->startTransaction();

        $rows = \CTimeManReportFull::GetList(
            [],
            [
                '>=DATE_FROM' => $this->from(),
                '<=DATE_FROM' => $this->to(),
                'APPROVE' => 'N',
            ]
        );

        while ($row = $rows->fetch()) {
            $row['REPORT_DATE'] = $row['DATE_FROM'];
			$handlerClass = $this->handler();
	        $handlerClass::onAfterReportAdd($row);
        }

        $this->connection()->commitTransaction();
    }

    // Генерирует уведомления комментариев за указанный интервал
    protected function generateForComment()
    {
        $this->connection()->startTransaction();

        $this->generateForCommentTask();

        $this->generateForCommentReport();

        $this->generateForCommentSocNetLog();

        $this->connection()->commitTransaction();
    }

    // Генерирует уведомления комментариев задач за указанный интервал
    protected function generateForCommentTask()
    {
        if (!Loader::includeModule('tasks')) {
            throw new \Exception(
                Lang::render('88d3de4d78800f467fc769b584d81f3b')
            );
        }

        if (!Loader::includeModule('forum')) {
            throw new \Exception(
                Lang::render('81d03b5b49a599a93ad4421198fdf4dc')
            );
        }

        $rows = MessageTable::query()
            ->setSelect(['*'])
            ->whereIn(
                'XML_ID',
                TaskTable::query()
                    ->addSelect(
                        new Fields\ExpressionField(
                            'XML_ID',
                            'CONCAT("TASK_", %s)',
                            ['ID']
                        ),
                        'XML_ID'
                    )
                    ->where('CREATED_DATE', '>=', $this->from())
                    ->where('CREATED_DATE', '<=', $this->to())
            )
            ->where('NEW_TOPIC', 'N')
            ->exec();

        while ($row = $rows->fetch()) {
            $row['MESSAGE_ID'] = $row['ID'];
            $row['TASK_ID'] = (int) str_replace('TASK_', '', $row['XML_ID']);
            $row['COMMENT_TEXT'] = $row['POST_MESSAGE'];

	        $handlerClass = $this->handler();
	        $handlerClass::OnCommentAdd($row['TASK_ID'], $row);
        }
    }

    // Генерирует уведомления комментариев отчетов за указанный интервал
    protected function generateForCommentReport()
    {
        if (!Loader::includeModule('socialnetwork')) {
            throw new \Exception(
                Lang::render('2e7356bd7abdb9e447de0f2100bf4a08')
            );
        }

        $rows = \CSocNetLogComments::GetList(
            [],
            [
                '>=LOG_DATE' => $this->from(),
                '<=LOG_DATE' => $this->to(),
                'EVENT_ID' => 'report_comment',
                'ENTITY_TYPE' => 'R',
            ]
        );

        while ($row = $rows->fetch()) {
			$handlerClass = $this->handler();
	        $handlerClass::onReportComment($row['ID'], $row);
        }
    }

    protected function generateForCommentSocNetLog()
    {
        if (!Loader::includeModule('socialnetwork')) {
            throw new \Exception(
                Lang::render('2e7356bd7abdb9e447de0f2100bf4a08')
            );
        }

        $rows = LogCommentTable::query()
            ->setSelect(['*'])
            ->where('LOG_DATE', '>=', $this->from())
            ->where('LOG_DATE', '<=', $this->to())
            ->exec();

        while ($row = $rows->fetch()) {
	        $handlerClass = $this->handler();
	        $handlerClass::onSocLogComment($row['ID'], $row);
        }
    }

    // Генерирует уведомления бизнес-процессов за указанный интервал
    protected function generateForBizproc()
    {
        // Pass
    }
}
