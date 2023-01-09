<?php

namespace Bizprofi\Reaction\NotifyEventsHandlerTraits;

use Bitrix\Socialnetwork;
use Bizprofi\Reaction\DataManager\NotificationBindingTable;
use Bizprofi\Reaction\DataManager\NotificationResponsibleTable;
use Bizprofi\Reaction\DataManager\NotificationTable;
use Bizprofi\Tools\Lang;

trait SocialnetworkHandlers
{
    public static function onSocLogComment($id, $fields)
    {
        if (empty($fields['EVENT_ID']) || empty($fields['USER_ID']) || empty($fields['MESSAGE'])) {
            return;
        }

        //��� ������� � ����� ���� �����
        if (
            'report_comment' === $fields['EVENT_ID']
            || 'tasks_comment' === $fields['EVENT_ID']
            || 'blog_comment' === $fields['EVENT_ID']
            || 'crm_activity_add_comment' === $fields['EVENT_ID'] // ��� �� ����� ���� ������
        ) {
            return;
        }

        $user = $fields['USER_ID'];
        $logId = $fields['LOG_ID'];

        $users = static::getUsersFromMessage($fields['MESSAGE']);

        //������� ���� �� �������
        $logComment = Socialnetwork\LogCommentTable::wakeUpObject($id);
        $logComment->fill(['LOG_DATE', 'LOG.ID', 'LOG.RATING_TYPE_ID']);
        $date = $logComment->getLogDate();

        if (!$logComment->getLog()) {
            return;
        }

        if ('TASK' === $logComment->getLog()->get('RATING_TYPE_ID')) {
            return;
        }

        // ������� ����������� � ���� �������� ��� ���������� ������������� � ������
        NotificationTable::clearEntityByUser(
            array_merge($users, [$user]),
            NotificationBindingTable::SOC_LOG,
            $logId,
            NotificationTable::NEED_REACTION
        );

        NotificationResponsibleTable::clearResponsible($logId, NotificationBindingTable::SOC_LOG, $user);
        //������ �� ���������, �������, ������ �� �������
        if (!count($users)) {
            return;
        }

        foreach ($users as $key => $userId) {
            //��������� �����������
            static::sendSocCommentNotify(
                $id,
                $logId,
                $user,
                $userId,
                $date,
                NotificationTable::WAIT_REACTION,
                [ $userId ]
            );

            //���������� �������������
            static::sendSocCommentNotify(
                $id,
                $logId,
                $userId,
                $user,
                $date,
                NotificationTable::NEED_REACTION
            );
        }
    }

    public static function onSocNetCommentUpdate($id, $fields)
    {
        if (empty($fields['EVENT_ID']) || empty($fields['MESSAGE'])) {
            return;
        }

        if ('report_comment' === $fields['EVENT_ID']) {
            return;
        }

        //������� id ������������
        $logComment = Socialnetwork\LogCommentTable::wakeUpObject($id);
        $logComment->fillUserId();
        $user = $logComment->getUserId();

        if (!$user) {
            AddMessage2Log(
                Lang::render('fc0668651f9e3fe3e11d9b0a38793b55')
            );

            return;
        }

        $logId = $fields['LOG_ID'];
        $users = static::getUsersFromMessage($fields['MESSAGE']);
        //������� ���� �� �������
        $logComment = Socialnetwork\LogCommentTable::wakeUpObject($id);
        $logComment->fillLogDate();
        $date = $logComment->getLogDate();

        // ������� ����������� � ���� �������� ��� ���������� ������������� � ������
        NotificationTable::clearEntityByUser(
            array_merge($users, [$user]),
            NotificationBindingTable::SOC_LOG,
            $logId
        );

        NotificationResponsibleTable::clearResponsible($logId, NotificationBindingTable::SOC_LOG, $user);
        //������ �� ���������, �������, ������ �� �������
        if (!count($users)) {
            return;
        }

        foreach ($users as $key => $userId) {
            //��������� �����������
            static::sendSocCommentNotify(
                $id,
                $logId,
                $user,
                $userId,
                $date,
                NotificationTable::WAIT_REACTION,
                [ $userId ]
            );

            //���������� �������������
            static::sendSocCommentNotify(
                $id,
                $logId,
                $userId,
                $user,
                $date,
                NotificationTable::NEED_REACTION
            );
        }
    }

    /**
     * @param $id
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\Db\SqlQueryException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public static function onSocNetCommentDelete($id)
    {
        //�� id ����������� ������ ����� ��������������� ������ �����������
        $notyCollection = NotificationTable::query()
            ->setSelect(['ID'])
            ->where('BINDING.ENTITY_TYPE', NotificationBindingTable::SOC_LOG_COMMENT)
            ->where('BINDING.ENTITY_ID', $id)
            ->fetchCollection();

        if (empty($notyCollection)) {
            AddMessage2Log(
                Lang::render('adc8f526a2baaa813eacda17f4c7204b').$id
            );
        }

        $connection = NotificationTable::getEntity()->getConnection();
        $connection->startTransaction();

        //������� � �����
        foreach ($notyCollection as $noty) {
            $result = $noty->delete();
            if (!$result->isSuccess()) {
                $connection->rollbackTransaction();
                AddMessage2Log($result->getErrorMessages());

                return;
            }
        }

        $connection->commitTransaction();
    }

    protected static function sendSocCommentNotify(
        int $commentId,
        int $logId,
        int $to,
        int $from,
        $date,
        int $direction,
        array $needReactionUsers = []
    ) {
        $connecton = NotificationTable::getEntity()->getConnection();
        $connecton->startTransaction();
        //��������� �������� ������
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

        //������ ���������� ��� ��������
        foreach ($needReactionUsers as $user) {
            $resultResponseble = NotificationResponsibleTable::add([
                'NOTIFICATION_ID' => $id,
                'USER_ID' => $user,
                'ENTITY_TYPE' => NotificationBindingTable::SOC_LOG,
                'ENTITY_ID' => $logId,
            ]);

            if (!$resultResponseble->isSuccess()) {
                $connecton->rollbackTransaction();
                AddMessage2Log($resultResponseble->getErrorMessages());

                return;
            }
        }

        //������ � ��� ������, � ������ ������ ��� ���� ����� ���� ����� ������������
        $result = NotificationBindingTable::add([
            'NOTIFICATION_ID' => $id,
            'ENTITY_TYPE' => NotificationBindingTable::SOC_LOG,
            'ENTITY_ID' => $logId,
        ]);

        if (!$result->isSuccess()) {
            $connecton->rollbackTransaction();
            AddMessage2Log($result->getErrorMessages());

            return;
        }

        //������ �����������
        $result = NotificationBindingTable::add([
            'NOTIFICATION_ID' => $id,
            'ENTITY_TYPE' => NotificationBindingTable::SOC_LOG_COMMENT,
            'ENTITY_ID' => $commentId,
        ]);

        if (!$result->isSuccess()) {
            $connecton->rollbackTransaction();
            AddMessage2Log($result->getErrorMessages());
        }

        $connecton->commitTransaction();
        //��� ���� ��� ���������� ����������
        static::sendPull([$to]);
    }

    // ���������� ������� OnBeforeSocNetLogDelete ������ socialnetwork
    public static function OnBeforeSocNetLogDelete($logId)
    {
        static::clearLogCommentNotification((int) $logId);
    }

    // ����� ��������� ������ � ����� ����� ������ ��� ����������� ��������� � ������ �������
    protected static function clearLogCommentNotification(int $logId)
    {
        // ������� ��� ����������� ��������� � ������ �������
        $rows = Socialnetwork\LogCommentTable::query()
            ->addSelect('ID')
            ->where('LOG_ID', $logId)
            ->exec();

        // ���� ������������ ��� �� ������ ������ �� ����
        if (0 >= $rows->getSelectedRowsCount()) {
            return;
        }

        // ������� ����������
        $connecton = Socialnetwork\LogCommentTable::getEntity()->getConnection();
        $connecton->startTransaction();

        // ��������� ��� ��������� ����������� � ������� ������� ���������� �������� ����������� � ������ � ����� �����
        while ($row = $rows->fetch()) {
            static::onSocNetCommentDelete($row['ID']);
        }

        // ������� ����������
        $connecton->commitTransaction();
    }
}
