<?php

namespace Bizprofi\Reaction\NotifyEventsHandlerTraits;

use Bitrix\Crm\Timeline\Entity\TimelineTable;
use Bitrix\Main\Event;
use Bizprofi\Reaction\DataManager\NotificationBindingTable;
use Bizprofi\Reaction\DataManager\NotificationResponsibleTable;
use Bizprofi\Reaction\DataManager\NotificationTable;

trait CrmTimelineHandlers
{
    // ����������� ��� ���������� ����������� � �������� CRM
    public static function OnAfterCrmTimelineCommentAdd(Event $event)
    {
        // ������� ������ �����������
        $params = $event->getParameters();

        $row = TimelineTable::wakeUpObject($params['ID']);
        $row->fill();

        // �������� ������� ����� � ��������� crm
        $bindings = $row->getBindings();
        if (!$bindings) {
            return;
        }

        // ���������� ���������
        $user = $row->getAuthorId();
        $users = static::getUsersFromMessage($row->getComment());
        $date = $row->getCreated();
        $entityId = $bindings->getEntityId();

        // ������� ����������� � ���� �������� ��� ���������� ������������� � ������
        NotificationTable::clearEntityByUser(
            array_merge($users, [$user]),
            NotificationBindingTable::CRM_ENTITY,
            $entityId,
            NotificationTable::NEED_REACTION
        );

        // ������� ������ ���������� ��� ��������� ��������
        NotificationResponsibleTable::clearResponsible($entityId, NotificationBindingTable::CRM_ENTITY, $user);

        // ������ �� ���������, �������, ������ �� �������
        if (!count($users)) {
            return;
        }

        foreach ($users as $key => $userId) {
            // ��������� �����������
            static::sendCrmCommentNotify(
                $row->getId(),
                $entityId,
                $user,
                $userId,
                $date,
                NotificationTable::WAIT_REACTION,
                [ $userId ]
            );

            // ���������� �������������
            static::sendCrmCommentNotify(
                $row->getId(),
                $entityId,
                $userId,
                $user,
                $date,
                NotificationTable::NEED_REACTION
            );
        }
    }

    // ����������� ��� ��������� ����������� � �������� CRM
    public static function OnAfterCrmTimelineCommentUpdate(Event $event)
    {
        $params = $event->getParameters();

        // ������� ����������� ����� ���������
        NotificationTable::clearEntityById(
            $params['ID'],
            NotificationBindingTable::CRM_ENTITY_COMMENT
        );

        // ��������� ���������� � ���������� ���������� �����������
        static::OnAfterCrmTimelineCommentAdd($event);
    }

    // ����������� ��� �������� ����������� � �������� CRM
    public static function OnAfterCrmTimelineCommentDelete(Event $event)
    {
        $params = $event->getParameters();

        // ������� ����������� ����� ���������
        NotificationTable::clearEntityById(
            $params['ID'],
            NotificationBindingTable::CRM_ENTITY_COMMENT
        );
    }

    protected static function sendCrmCommentNotify(
        int $commentId,
        int $entityId,
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

        foreach ($needReactionUsers as $user) {
            $resultResponseble = NotificationResponsibleTable::add([
                'NOTIFICATION_ID' => $id,
                'USER_ID' => $user,
                'ENTITY_TYPE' => NotificationBindingTable::CRM_ENTITY,
                'ENTITY_ID' => $entityId,
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
            'ENTITY_TYPE' => NotificationBindingTable::CRM_ENTITY,
            'ENTITY_ID' => $entityId,
        ]);

        if (!$result->isSuccess()) {
            $connecton->rollbackTransaction();
            AddMessage2Log($result->getErrorMessages());

            return;
        }

        //������ �����������
        $result = NotificationBindingTable::add([
            'NOTIFICATION_ID' => $id,
            'ENTITY_TYPE' => NotificationBindingTable::CRM_ENTITY_COMMENT,
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
}
