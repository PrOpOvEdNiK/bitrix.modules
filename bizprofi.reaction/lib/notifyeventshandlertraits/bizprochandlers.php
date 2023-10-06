<?php

namespace Bizprofi\Reaction\NotifyEventsHandlerTraits;

use Bitrix\Bizproc\WorkflowStateTable;
use Bitrix\Main\Loader;
use Bizprofi\Reaction\DataManager\BptaskTable;
use Bizprofi\Reaction\DataManager\NotificationBindingTable;
use Bizprofi\Reaction\DataManager\NotificationResponsibleTable;
use Bizprofi\Reaction\DataManager\NotificationTable;
use Bizprofi\Tools\Lang;

trait BizprocHandlers
{
    // При удалении задания бизнес процесса удалим все связанные уведомления
    public static function OnBpTaskDelete($id)
    {
        // Найдем все нотификации с которыми связано данное задание
        $rows = NotificationBindingTable::query()
            ->addSelect('*')
            ->where('ENTITY_TYPE', NotificationBindingTable::BP_TASK)
            ->where('ENTITY_ID', $id)
            ->exec();

        // Откроем транзакцию зачем-то
        $connection = NotificationTable::getEntity()->getConnection();
        $connection->startTransaction();

        // Удалим все нотификации
        while ($task = $rows->fetchObject()) {
            NotificationTable::delete($task->getNotificationId());
        }

        // Раз открыли то надо бы закрыть
        $connection->commitTransaction();
    }

    public static function OnBpTaskUpdate($id, $fields)
    {
        //подразумевается что обновление задания бп происходит только при смене статуса
        //статус меняется только когда все ответственные за задание среагировали
        //статусы кстати 0 - в работе, 1 - подтверждено, 2 - отменено, 3 - вроде завершён(это не точно)

        if ($fields['STATUS']) {
            NotificationTable::clearEntityById($id, NotificationBindingTable::BP_TASK, NotificationTable::NEED_REACTION);
            NotificationResponsibleTable::clearResponsibleByEntity($id, NotificationBindingTable::BP_TASK);
        }
    }

    //задание можно делегировать на другого пользователя, нужно почистить всё у старого и создать для нового
    public static function OnBpTaskDelegate($taskId, $fromUserId, $toUserId)
    {
        NotificationTable::clearEntityByUser([$fromUserId], NotificationBindingTable::BP_TASK, $taskId, NotificationTable::NEED_REACTION);
        NotificationResponsibleTable::clearResponsible($taskId, NotificationBindingTable::BP_TASK, $fromUserId);

        $bpInfo = BptaskTable::query()
            ->setSelect(['ID', 'WORKFLOW_ID', 'DESCRIPTION'])
            ->where('ID', $taskId)
            ->exec()
            ->fetch();

        $bpInfo['USERS'][0] = $toUserId;
        static::OnBpTaskAdd($taskId, $bpInfo);
    }

    public static function OnBpTaskMarkCompleted($id, $userId, $status)
    {
        //срабатывет когда ответственный за задание среагировал
        NotificationTable::clearEntityByUser([$userId], NotificationBindingTable::BP_TASK, $id, NotificationTable::NEED_REACTION);
        NotificationResponsibleTable::clearResponsible($id, NotificationBindingTable::BP_TASK, $userId);
    }

    public static function OnBpTaskAdd($id, $fields)
    {
        if (!Loader::includeModule('bizproc')) {
            throw new \Exception('bizproc not install');
        }

        //получим дату и создателя задания бп
        $objWorkFlow = WorkflowStateTable::wakeUpObject($fields['WORKFLOW_ID']);
        $objWorkFlow->fill(['STARTED_BY', 'STARTED']);

        if (!$objWorkFlow) {
            AddMessage2Log(
                Lang::render('a372963afd34d0ec6832d3dd90b4a577')
            );

            return;
        }

        foreach ($fields['USERS'] as $user) {
            //уведомление создателю
            static::sendBpEntityNoty(
                $id,
                $objWorkFlow->getStartedBy(),
                $user,
                $objWorkFlow->getStarted(),
                NotificationTable::WAIT_REACTION,
                [ $user ]
            );

            //уведомление ответственнм за бп на текущем шаге
            static::sendBpEntityNoty(
                $id,
                $user,
                $objWorkFlow->getStartedBy(),
                $objWorkFlow->getStarted(),
                NotificationTable::NEED_REACTION
            );
        }
    }

    protected static function sendBpEntityNoty(
        int $bpId,
        int $to,
        int $from,
        $date,
        int $direction,
        array $needReactionUsers = [])
    {
        $connecton = NotificationTable::getEntity()->getConnection();
        $connecton->startTransaction();
        $result = NotificationTable::add([
            'TO_USER' => $to,
            'FROM_USER' => $from,
            'DATE' => $date,
            'DIRECTION' => $direction,
        ]);

        if (!$result->isSuccess()) {
            $connecton->rollbackTransaction();
            AddMessage2Log($result->getErrorMessages());

            return;
        }

        $id = $result->getId();

        foreach ($needReactionUsers as $user) {
            $resultResponseble = NotificationResponsibleTable::add([
                'NOTIFICATION_ID' => $id,
                'USER_ID' => $user,
                'ENTITY_TYPE' => NotificationBindingTable::BP_TASK,
                'ENTITY_ID' => $bpId,
            ]);

            if (!$resultResponseble->isSuccess()) {
                $connecton->rollbackTransaction();
                AddMessage2Log($resultResponseble->getErrorMessages());

                return;
            }
        }

        $result = NotificationBindingTable::add([
            'NOTIFICATION_ID' => $id,
            'ENTITY_TYPE' => NotificationBindingTable::BP_TASK,
            'ENTITY_ID' => $bpId,
        ]);

        if (!$result->isSuccess()) {
            $connecton->rollbackTransaction();
            AddMessage2Log($result->getErrorMessages());

            return;
        }

        $connecton->commitTransaction();
        static::sendPull([$to]);
    }
}
