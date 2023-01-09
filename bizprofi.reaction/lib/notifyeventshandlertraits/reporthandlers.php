<?php

namespace Bizprofi\Reaction\NotifyEventsHandlerTraits;

use Bitrix\Main\Type\DateTime;
use Bitrix\Socialnetwork;
use Bizprofi\Reaction\DataManager\NotificationBindingTable;
use Bizprofi\Reaction\DataManager\NotificationResponsibleTable;
use Bizprofi\Reaction\DataManager\NotificationTable;
use Bizprofi\Tools\Lang;

trait ReportHandlers
{
    /**
     * @param $fields
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\Db\SqlQueryException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public static function onAfterReportAdd($fields)
    {
        if ('Y' !== $fields['ACTIVE']) {
            return;
        }

        $managerId = (int) \CUserOptions::getOption('bizprofi.timemanext', 'report_manager', 0, $fields['USER_ID']);
        if (0 >= $managerId) {
            $arManagers = \CTimeMan::GetUserManagers($fields['USER_ID']);
            $managerId = (int) $arManagers[0];
        }

        // ������ ��� ����������� � ����� �������� �����
        NotificationTable::clearEntityById($fields['ID'], NotificationBindingTable::REPORT_ENTITY);

        static::sendReportNotify(
            $fields['ID'],
            $managerId,
            $fields['USER_ID'],
            $fields['REPORT_DATE'],
            NotificationTable::NEED_REACTION
        );

        static::sendReportNotify(
            $fields['ID'],
            $fields['USER_ID'],
            $managerId,
            $fields['REPORT_DATE'],
            NotificationTable::WAIT_REACTION,
            $managerId
        );
    }

    /**
     * @param $id
     * @param $fields
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\Db\SqlQueryException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\ObjectException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public static function onReportCommentUpdate($id, $fields)
    {
        // ���� ��� �� ����������� � ������ ������� ����������
        if ('report_comment' !== $fields['EVENT_ID']) {
            return;
        }

        static::onUpsertReportComment($id);
    }

    /**
     * @param $id
     * @param $fields
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\Db\SqlQueryException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\ObjectException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public static function onReportComment($id, $fields)
    {
        // ���� ��� �� ����������� � ������ ������� ����������
        if ('report_comment' !== $fields['EVENT_ID']) {
            return;
        }

        static::onUpsertReportComment($id);
    }

    public static function OnAfterFullReportUpdate($reportId, $fields)
    {
        //����� ��������� ������� �������� �� ��� �����������
        if ('Y' === $fields['ACTIVE']) {
            $report = \CTimemanReportFull::getById($reportId)->fetch();

            if ('Y' !== $report['APPROVE']) {
                static::onAfterReportAdd($report);

                return;
            }
        }

        if ($fields['APPROVER'] <= 0) {
            return;
        }

        if ('Y' !== $fields['APPROVE']) {
            return;
        }

        NotificationTable::clearEntityById($reportId, NotificationBindingTable::REPORT_ENTITY, NotificationTable::NEED_REACTION);
        NotificationResponsibleTable::clearResponsibleByEntity($reportId, NotificationBindingTable::REPORT_ENTITY);
    }

    // �������� ������ ������ � ������������� ��� ��������� ��� ���������� ����������� � ������
    protected static function onUpsertReportComment($logCommentId)
    {
        // ������� ������ �� ���� ������ ��� ��� � $fields ��� ����
        $comment = Socialnetwork\LogCommentTable::getById($logCommentId)->fetchObject();
        if (!$comment) {
            AddMessage2Log(
                Lang::render('fda7721b21c972193023b5e2133b87d2')
            );

            return;
        }

        // ������� ��������� ������ � ����� ����� ��� ��� � ������������� ����������� ��� ����� ENTITY_TYPE � ENTITY_ID
        $log = $comment->fillLog();
        if (!$log) {
            AddMessage2Log(
                Lang::render('25f75b6167ad335e11fec27887439850')
            );

            return;
        }

        // ������� ���������� �������������
        $users = static::getUsersFromMessage(
            $comment->getMessage()
        );

        // ������ ��������� ����������� ��� ����������, ����������� � ������ ������
        NotificationTable::clearEntityByUser(
            array_merge(
                $users,
                [
                    $log->getEntityId(),
                    $comment->getUserId(),
                ]
            ),
            NotificationBindingTable::SOC_LOG_REPORT_ENTITY,
            $comment->getLogId(),
            NotificationTable::NEED_REACTION
        );

        // ������ ������ ��������� �� ����������� �� �����
        NotificationResponsibleTable::clearResponsible(
            $comment->getLogId(),
            NotificationBindingTable::SOC_LOG_REPORT_ENTITY,
            $comment->getUserId()
        );

        // ������ ��� ����������� ��� ������ (��� �������� ��� ��������� �����������, �� ������ ��� ��� ����� ���� �������������)
        // NotificationTable::clearEntityById($log->getId(), NotificationBindingTable::SOC_LOG_REPORT_ENTITY);

        // ���� ����� ������ � ����������� �� ���������
        if ((int) $log->getEntityId() != (int) $comment->getUserId()) {
            // ��������� ��������� ������
            static::sendCommentReportNotify(
                $comment->getId(),
                $comment->getLogId(),
                $log->getEntityId(),
                $comment->getUserId(),
                $comment->getLogDate(),
                NotificationTable::NEED_REACTION
            );

            // ��������� �����������
            static::sendCommentReportNotify(
                $comment->getId(),
                $comment->getLogId(),
                $comment->getUserId(),
                $log->getEntityId(),
                $comment->getLogDate(),
                NotificationTable::WAIT_REACTION,
                [ $log->getEntityId() ]
            );
        }

        // ���� ��� ���������� �� ������ �� ���� ������
        if (!is_array($users) || 0 >= count($users)) {
            return;
        }

        // �������� ����������� ���������� �������������
        foreach ($users as $key => $userId) {
            // ���� ��������� ��������� ������ �� ������ �� ���� �������� ���
            if ((int) $userId === (int) $log->getEntityId()) {
                continue;
            }

            static::sendCommentReportNotify(
                $comment->getId(),
                $comment->getLogId(),
                $comment->getUserId(),
                $userId,
                $comment->getLogDate(),
                NotificationTable::WAIT_REACTION,
                [ $userId ]
            );

            static::sendCommentReportNotify(
                $comment->getId(),
                $comment->getLogId(),
                $userId,
                $comment->getUserId(),
                $comment->getLogDate(),
                NotificationTable::NEED_REACTION
            );
        }
    }

    /**
     * @param int    $reportId
     * @param int    $to
     * @param int    $from
     * @param string $date
     * @param int    $direction
     * @param int    $responsibleUser
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\Db\SqlQueryException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\ObjectException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    protected static function sendReportNotify(
        int $reportId,
        int $to,
        int $from,
        string $date,
        int $direction,
        int $responsibleUser = 0
    ) {
        if (0 > $reportId) {
            return;
        }

        $connecton = NotificationTable::getEntity()->getConnection();
        $connecton->startTransaction();
        $result = NotificationTable::add([
            'TO_USER' => $to,
            'FROM_USER' => $from,
            'DATE' => new DateTime($date),
            'DIRECTION' => $direction,
        ]);

        if (!$result->isSuccess()) {
            $connecton->rollbackTransaction();
            AddMessage2Log($result->getErrorMessages());

            return;
        }

        $id = $result->getId();
        if ($responsibleUser && NotificationTable::WAIT_REACTION == $direction) {
            $resultResponseble = NotificationResponsibleTable::add([
                'NOTIFICATION_ID' => $id,
                'USER_ID' => $from,
                'ENTITY_TYPE' => NotificationBindingTable::REPORT_ENTITY,
                'ENTITY_ID' => $reportId,
            ]);

            if (!$resultResponseble->isSuccess()) {
                $connecton->rollbackTransaction();
                AddMessage2Log($result->getErrorMessages());

                return;
            }
        }

        $result = NotificationBindingTable::add([
            'NOTIFICATION_ID' => $id,
            'ENTITY_TYPE' => NotificationBindingTable::REPORT_ENTITY,
            'ENTITY_ID' => $reportId,
        ]);

        if (!$result->isSuccess()) {
            $connecton->rollbackTransaction();
            AddMessage2Log($result->getErrorMessages());

            return;
        }

        $connecton->commitTransaction();
        static::sendPull([$to]);
    }

    /**
     * @param int   $messageId
     * @param int   $logId
     * @param int   $to
     * @param int   $from
     * @param       $date
     * @param int   $direction
     * @param array $needReactionUsers
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\Db\SqlQueryException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    protected static function sendCommentReportNotify(
        int $messageId,
        int $logId,
        int $to,
        int $from,
        $date,
        int $direction,
        array $needReactionUsers = []
    ) {
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
                'ENTITY_TYPE' => NotificationBindingTable::SOC_LOG_REPORT_ENTITY,
                'ENTITY_ID' => $logId,
            ]);

            if (!$resultResponseble->isSuccess()) {
                $connecton->rollbackTransaction();
                AddMessage2Log($resultResponseble->getErrorMessages());

                return;
            }
        }

        $result = NotificationBindingTable::add([
            'NOTIFICATION_ID' => $id,
            'ENTITY_TYPE' => NotificationBindingTable::COMMENT_REPORT_ENTITY,
            'ENTITY_ID' => $messageId,
        ]);

        if (!$result->isSuccess()) {
            $connecton->rollbackTransaction();
            AddMessage2Log($result->getErrorMessages());

            return;
        }

        $result = NotificationBindingTable::add([
            'NOTIFICATION_ID' => $id,
            'ENTITY_TYPE' => NotificationBindingTable::SOC_LOG_REPORT_ENTITY,
            'ENTITY_ID' => $logId,
        ]);

        if (!$result->isSuccess()) {
            $connecton->rollbackTransaction();
            AddMessage2Log($result->getErrorMessages());

            return;
        }

        $connecton->commitTransaction();
        static::sendPull([$to]);
    }

    public static function onAfterMessageDelete(int $id)
    {
        NotificationTable::clearEntityById($id, NotificationBindingTable::COMMENT_REPORT_ENTITY);
    }
}
