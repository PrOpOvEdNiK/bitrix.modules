<?php

namespace Bizprofi\Reaction\NotifyEventsHandlerTraits;

use Bitrix\Main\Config\Option;
use Bitrix\Forum\MessageTable;
use Bitrix\Main\Type\DateTime;
use Bizprofi\Reaction\DataManager\NotificationBindingTable;
use Bizprofi\Reaction\DataManager\NotificationResponsibleTable;
use Bizprofi\Reaction\DataManager\NotificationTable;

trait TasksHandlers
{
    /**
     * @param $taskId
     * @param $arData
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\Db\SqlQueryException
     * @throws \Bitrix\Main\SystemException
     */
    public static function onTaskAdd($taskId, &$arData)
    {
        static::onTaskUpsertProcessResponsible(
            $taskId,
            $arData['CREATED_BY'],
            $arData['RESPONSIBLE_ID'],
            $arData['CHANGED_DATE'],
            true
        );
    }

    /**
     * @param $taskId
     * @param $arData
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\Db\SqlQueryException
     * @throws \Bitrix\Main\SystemException
     */
    public static function onTaskUpdate($taskId, $arData)
    {
        static::onTaskUpdateProcessWaitControl($taskId, $arData);

        if (
            isset($arData['STATUS'])
            && (\CTasks::STATE_NEW != $arData['STATUS'])
            && (\CTasks::STATE_PENDING != $arData['STATUS'])
            && ($responsibleId = $arData['RESPONSIBLE_ID'] ?: $arData['META:PREV_FIELDS']['RESPONSIBLE_ID'] ?: false)
        ) {
            // ����� �������, ��� ���� ������������ ������ ������ ������ � ���������� - �� � ��� �����������
            NotificationResponsibleTable::clearResponsible($taskId, NotificationBindingTable::TASK_ACKNOWLEDGE_ENTITY, $responsibleId);
            NotificationTable::clearEntityByUser([$responsibleId], NotificationBindingTable::TASK_ACKNOWLEDGE_ENTITY, $taskId, NotificationTable::NEED_REACTION);
        }

        if (isset($arData['RESPONSIBLE_ID'])
            && isset($arData['META:PREV_FIELDS']['CREATED_BY'])
            && isset($arData['META:PREV_FIELDS']['RESPONSIBLE_ID'])
            && ($arData['RESPONSIBLE_ID'] != $arData['META:PREV_FIELDS']['RESPONSIBLE_ID'])
        ) {
            static::onTaskUpsertProcessResponsible(
                $taskId,
                $arData['META:PREV_FIELDS']['CREATED_BY'],
                $arData['RESPONSIBLE_ID'],
                $arData['CHANGED_DATE'],
                false
            );
        }
    }

    protected static function onTaskUpsertProcessResponsible(int $taskId, int $createdBy, int $responsibleId, string $changedDate, bool $isNew)
    {
        // ������� ����������� ��� ����������� ��������������
        if (!$isNew) {
            NotificationTable::clearEntityById($taskId, NotificationBindingTable::TASK_ACKNOWLEDGE_ENTITY);
            NotificationResponsibleTable::clearResponsibleByEntity($taskId, NotificationBindingTable::TASK_ACKNOWLEDGE_ENTITY);
        }

        // �� ��� ������������ �� ������ ����
        if ($responsibleId == $createdBy) {
            return;
        }

        $connecton = NotificationTable::getEntity()->getConnection();
        $helper = $connecton->getSqlHelper();

        // �� ��������� �����������, ���� ��� ������� ��� ������
        if (!$isNew) {
            $likesCount = $connecton->queryScalar('
                SELECT COUNT(1) FROM `b_rating_vote`
                WHERE `ENTITY_TYPE_ID` = "TASK"
                    AND `ENTITY_ID` = "'.$helper->forSql($taskId).'"
                    AND `USER_ID` = "'.$helper->forSql($responsibleId).'"
            ');

            if ($likesCount > 0) {
                return;
            }
        }

        $connecton->startTransaction();

        // ��������� ����������� ��� �������� ��������������
        $addNotification = NotificationTable::add([
            'TO_USER' => $responsibleId,
            'FROM_USER' => $createdBy,
            'DATE' => new DateTime($changedDate),
            'DIRECTION' => NotificationTable::NEED_REACTION,
        ]);

        if (!$addNotification->isSuccess()) {
            $connecton->rollbackTransaction();
            AddMessage2Log($addNotification->getErrorMessages());

            return;
        }

        // ������ ��������� ����������� � ������
        $addBinding = NotificationBindingTable::add([
            'NOTIFICATION_ID' => $addNotification->getId(),
            'ENTITY_TYPE' => NotificationBindingTable::TASK_ACKNOWLEDGE_ENTITY,
            'ENTITY_ID' => $taskId,
        ]);

        if (!$addBinding->isSuccess()) {
            $connecton->rollbackTransaction();
            AddMessage2Log($addBinding->getErrorMessages());

            return;
        }

        // ��������� �������� ����������� ��� ������������
        $addWaitNotification = NotificationTable::add([
            'TO_USER' => $createdBy,
            'FROM_USER' => $responsibleId,
            'DATE' => new DateTime($changedDate),
            'DIRECTION' => NotificationTable::WAIT_REACTION,
        ]);

        if (!$addWaitNotification->isSuccess()) {
            $connecton->rollbackTransaction();
            AddMessage2Log($addWaitNotification->getErrorMessages());

            return;
        }

        // ��������� �������������� �� �����������
        $addNotificationResponsible = NotificationResponsibleTable::add([
            'NOTIFICATION_ID' => $addWaitNotification->getId(),
            'USER_ID' => $responsibleId,
            'ENTITY_TYPE' => NotificationBindingTable::TASK_ACKNOWLEDGE_ENTITY,
            'ENTITY_ID' => $taskId,
        ]);

        if (!$addNotificationResponsible->isSuccess()) {
            $connecton->rollbackTransaction();
            AddMessage2Log($addNotificationResponsible->getErrorMessages());

            return;
        }

        // ��������� ������� ��������� ����������� � ������
        $addBinding = NotificationBindingTable::add([
            'NOTIFICATION_ID' => $addWaitNotification->getId(),
            'ENTITY_TYPE' => NotificationBindingTable::TASK_ACKNOWLEDGE_ENTITY,
            'ENTITY_ID' => $taskId,
        ]);

        if (!$addBinding->isSuccess()) {
            $connecton->rollbackTransaction();
            AddMessage2Log($addBinding->getErrorMessages());

            return;
        }

        $connecton->commitTransaction();

        static::sendPull([$responsibleId, $createdBy]);
    }

    protected static function onTaskUpdateProcessWaitControl($taskId, $arData)
    {
        if (!$arData['STATUS']) {
            return;
        }

        if (
            \CTasks::STATE_SUPPOSEDLY_COMPLETED == $arData['META:PREV_FIELDS']['REAL_STATUS']
            && \CTasks::STATE_SUPPOSEDLY_COMPLETED !== $arData['STATUS']
        ) {
            NotificationTable::clearEntityById(
                $taskId,
                NotificationBindingTable::TASK_CONSTROL_ENTITY,
                NotificationTable::NEED_REACTION
            );
            NotificationResponsibleTable::clearResponsibleByEntity($taskId, NotificationBindingTable::TASK_CONSTROL_ENTITY);

            return;
        }

        if (\CTasks::STATE_SUPPOSEDLY_COMPLETED !== $arData['STATUS']) {
            return;
        }

        $taskInfo = \Bitrix\Tasks\TaskTable::query()
            ->setSelect(['ID', 'TITLE', 'RESPONSIBLE_ID'])
            ->where('ID', $taskId)
            ->exec()
            ->fetch();

        $creatorId = $arData['META:PREV_FIELDS']['CREATED_BY'];

        $connecton = NotificationTable::getEntity()->getConnection();
        $connecton->startTransaction();

        $result = NotificationTable::add([
            'TO_USER' => $creatorId,
            'FROM_USER' => $taskInfo['RESPONSIBLE_ID'],
            'DATE' => new DateTime($arData['STATUS_CHANGED_DATE']),
            'DIRECTION' => NotificationTable::NEED_REACTION,
        ]);

        if (!$result->isSuccess()) {
            $connecton->rollbackTransaction();
            AddMessage2Log($result->getErrorMessages());

            return;
        }

        $id = $result->getId();
        $result = NotificationBindingTable::add([
            'NOTIFICATION_ID' => $id,
            'ENTITY_TYPE' => NotificationBindingTable::TASK_CONSTROL_ENTITY,
            'ENTITY_ID' => $taskId,
        ]);

        if (!$result->isSuccess()) {
            $connecton->rollbackTransaction();
            AddMessage2Log($result->getErrorMessages());
        }

        $result = NotificationTable::add([
            'TO_USER' => $taskInfo['RESPONSIBLE_ID'],
            'FROM_USER' => $creatorId,
            'DATE' => new DateTime($arData['STATUS_CHANGED_DATE']),
            'DIRECTION' => NotificationTable::WAIT_REACTION,
        ]);

        if (!$result->isSuccess()) {
            $connecton->rollbackTransaction();
            AddMessage2Log($result->getErrorMessages());

            return;
        }

        $id = $result->getId();

        $resultResponseble = NotificationResponsibleTable::add([
            'NOTIFICATION_ID' => $id,
            'USER_ID' => $creatorId,
            'ENTITY_TYPE' => NotificationBindingTable::TASK_CONSTROL_ENTITY,
            'ENTITY_ID' => $taskId,
        ]);

        if (!$resultResponseble->isSuccess()) {
            $connecton->rollbackTransaction();
            AddMessage2Log($result->getErrorMessages());

            return;
        }

        $result = NotificationBindingTable::add([
            'NOTIFICATION_ID' => $id,
            'ENTITY_TYPE' => NotificationBindingTable::TASK_CONSTROL_ENTITY,
            'ENTITY_ID' => $taskId,
        ]);

        if (!$result->isSuccess()) {
            $connecton->rollbackTransaction();
            AddMessage2Log($result->getErrorMessages());
        }

        $connecton->commitTransaction();
        static::sendPull([$creatorId, $taskInfo['RESPONSIBLE_ID']]);
    }

    /**
     * @param int   $taskId
     * @param array $arData
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\Db\SqlQueryException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public static function OnCommentAdd(int $taskId, array $arData)
    {
        $messageId = $arData['MESSAGE_ID'];
        $taskId = $arData['TASK_ID'];

        $users = static::getUsersFromMessage($arData['COMMENT_TEXT']);
        $selectFields = ['AUTHOR_NAME', 'AUTHOR_ID', 'POST_DATE', 'POST_MESSAGE'];

        //ping message check compatibility for older cores
        $messageTableMap = MessageTable::getMap();
        $serviceTypeFieldExists = false;
        foreach($messageTableMap as $ormField){
            if(!is_object($ormField)){
                continue;
            }

            if($ormField->getName() == 'SERVICE_TYPE'){
                $serviceTypeFieldExists = true;
            }
        }

        if($serviceTypeFieldExists){
            $selectFields[] = 'SERVICE_TYPE';
        }

        $message = MessageTable::getRow(
            [
                'filter' => ['=ID' => $messageId],
                'select' => $selectFields,
            ]
        );

        //check if we processing system ping message, skipping...
        $enablePingMessagesReaction = Option::get('bizprofi.reaction', 'enablePingMessagesReaction', 'N');      
        if((int) $message['SERVICE_TYPE'] == 1 && $enablePingMessagesReaction != 'Y'){
            return;
        }
        
        NotificationResponsibleTable::clearResponsible($taskId, NotificationBindingTable::TASK_ENTITY, $message['AUTHOR_ID']);
        //������� ����������� ��� �������� ������������
        NotificationTable::clearEntityByUser([$message['AUTHOR_ID']], NotificationBindingTable::TASK_ENTITY, $taskId, NotificationTable::NEED_REACTION);

        // ����� �������, ��� ���� ������������ ���-�� ������������ � ������ - �� � ��� �����������
        NotificationResponsibleTable::clearResponsible($taskId, NotificationBindingTable::TASK_ACKNOWLEDGE_ENTITY, $message['AUTHOR_ID']);
        NotificationTable::clearEntityByUser([$message['AUTHOR_ID']], NotificationBindingTable::TASK_ACKNOWLEDGE_ENTITY, $taskId, NotificationTable::NEED_REACTION);

        // ������ �� ���������, ������ ��� ������ ������
        if (!count($users)) {
            return;
        }

        //������� ��� ����������
        NotificationTable::clearEntityByUser($users, NotificationBindingTable::TASK_ENTITY, $taskId, NotificationTable::NEED_REACTION);

        foreach ($users as $key => $userId) {
            //������������
            static::sendTaskCommentNotify(
                $messageId,
                $taskId,
                $message['AUTHOR_ID'],
                $userId,
                $message['POST_DATE'],
                NotificationTable::WAIT_REACTION,
                [ $userId ]
            );

            //���������� �������������
            static::sendTaskCommentNotify(
                $messageId,
                $taskId,
                $userId,
                $message['AUTHOR_ID'],
                $message['POST_DATE'],
                NotificationTable::NEED_REACTION
            );
        }
    }

    /**
     * @param       $taskId
     * @param array $arData
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\Db\SqlQueryException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public static function OnCommentUpdate($taskId, array $arData)
    {
        $messageId = $arData['MESSAGE_ID'];
        $taskId = $arData['TASK_ID'];

        $message = MessageTable::getRow(
            [
                'filter' => ['=ID' => $messageId],
                'select' => ['POST_MESSAGE', 'AUTHOR_NAME', 'POST_DATE', 'AUTHOR_ID', 'EDIT_DATE'],
            ]
        );

        $users = static::getUsersFromMessage($message['POST_MESSAGE']);

        NotificationResponsibleTable::clearResponsible($taskId, NotificationBindingTable::TASK_ENTITY, $message['AUTHOR_ID']);
        //������� ����������� ��� ���� � ������� �����������
        NotificationTable::clearEntityById($messageId, NotificationBindingTable::MESSAGE_ENTITY);

        // ������ �� ���������, ������
        if (!count($users)) {
            return;
        }

        //���������� �������������
        $users = static::getUsersFromMessage($message['POST_MESSAGE']);
        if (!count($users)) {
            return;
        }

        foreach ($users as $key => $userId) {
            //������������
            static::sendTaskCommentNotify(
                $messageId,
                $taskId,
                $message['AUTHOR_ID'],
                $userId,
                $message['POST_DATE'],
                NotificationTable::WAIT_REACTION,
                [ $userId ]
            );

            static::sendTaskCommentNotify(
                $messageId,
                $taskId,
                $userId,
                $message['AUTHOR_ID'],
                $message['POST_DATE'],
                NotificationTable::NEED_REACTION
            );
        }
    }

    /**
     * @param int   $messageId
     * @param int   $taskId
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
    protected static function sendTaskCommentNotify(
        int $messageId,
        int $taskId,
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
                'ENTITY_TYPE' => NotificationBindingTable::TASK_ENTITY,
                'ENTITY_ID' => $taskId,
            ]);

            if (!$resultResponseble->isSuccess()) {
                $connecton->rollbackTransaction();
                AddMessage2Log($result->getErrorMessages());

                return;
            }
        }

        $result = NotificationBindingTable::add([
            'NOTIFICATION_ID' => $id,
            'ENTITY_TYPE' => NotificationBindingTable::TASK_ENTITY,
            'ENTITY_ID' => $taskId,
        ]);

        if (!$result->isSuccess()) {
            $connecton->rollbackTransaction();
            AddMessage2Log($result->getErrorMessages());

            return;
        }

        $result = NotificationBindingTable::add([
            'NOTIFICATION_ID' => $id,
            'ENTITY_TYPE' => NotificationBindingTable::MESSAGE_ENTITY,
            'ENTITY_ID' => $messageId,
        ]);

        if (!$result->isSuccess()) {
            $connecton->rollbackTransaction();
            AddMessage2Log($result->getErrorMessages());
        }

        $connecton->commitTransaction();
        static::sendPull([$to]);
    }

    /**
     * @param int $taskId
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\Db\SqlQueryException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public static function onDelete(int $taskId)
    {
        NotificationTable::clearEntityById($taskId, NotificationBindingTable::TASK_ENTITY);
        NotificationTable::clearEntityById($taskId, NotificationBindingTable::TASK_CONSTROL_ENTITY);
        NotificationTable::clearEntityById($taskId, NotificationBindingTable::TASK_ACKNOWLEDGE_ENTITY);
    }

    /**
     * @param       $taskId
     * @param array $arData
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\Db\SqlQueryException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public static function OnCommentDelete($taskId, array $arData)
    {
        $messageId = $arData['MESSAGE_ID'];
        NotificationTable::clearEntityById($messageId, NotificationBindingTable::MESSAGE_ENTITY);
    }
}
