<?php

namespace Bizprofi\Reaction\NotifyEventsHandlerTraits;

use Bitrix\Crm\Timeline\Entity\TimelineTable;
use Bitrix\Main\Event;
use Bizprofi\Reaction\DataManager\NotificationBindingTable;
use Bizprofi\Reaction\DataManager\NotificationResponsibleTable;
use Bizprofi\Reaction\DataManager\NotificationTable;

trait CrmTimelineHandlers
{
    // Срабатывает при добавлении комментария в карточке CRM
    public static function OnAfterCrmTimelineCommentAdd(Event $event)
    {
        // получим данные комментария
        $params = $event->getParameters();

        $row = TimelineTable::wakeUpObject($params['ID']);
        $row->fill();

        // проверим наличие связи с сущностью crm
        $bindings = $row->getBindings();
        if (!$bindings) {
            return;
        }

        // сформируем параметры
        $user = $row->getAuthorId();
        $users = static::getUsersFromMessage($row->getComment());
        $date = $row->getCreated();
        $entityId = $bindings->getEntityId();

        // очистим уведомления в этой сущности для отмеченных пользователей и автора
        NotificationTable::clearEntityByUser(
            array_merge($users, [$user]),
            NotificationBindingTable::CRM_ENTITY,
            $entityId,
            NotificationTable::NEED_REACTION
        );

        // очистим список упомянутых для выбранной сущности
        NotificationResponsibleTable::clearResponsible($entityId, NotificationBindingTable::CRM_ENTITY, $user);

        // никого не упомянули, выходим, ничего не создаем
        if (!count($users)) {
            return;
        }

        foreach ($users as $key => $userId) {
            // владельцу комментария
            static::sendCrmCommentNotify(
                $row->getId(),
                $entityId,
                $user,
                $userId,
                $date,
                NotificationTable::WAIT_REACTION,
                [ $userId ]
            );

            // упомянутым пользователям
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

    // Срабатывает при изменении комментария в карточке CRM
    public static function OnAfterCrmTimelineCommentUpdate(Event $event)
    {
        $params = $event->getParameters();

        // очистим уведомления этого сообщения
        NotificationTable::clearEntityById(
            $params['ID'],
            NotificationBindingTable::CRM_ENTITY_COMMENT
        );

        // передадим управление в обработчик добавления комментария
        static::OnAfterCrmTimelineCommentAdd($event);
    }

    // Срабатывает при удалении комментария в карточке CRM
    public static function OnAfterCrmTimelineCommentDelete(Event $event)
    {
        $params = $event->getParameters();

        // очистим уведомления этого сообщения
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
        //добавляем основную запись
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

        //биндим к ней соцлог, в рамках одного соц лога может быть много комментариев
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

        //биндим комментарий
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
        //шлём пулл что количество изменилось
        static::sendPull([$to]);
    }
}
