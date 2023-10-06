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

        //для отчётов и задач свой метод
        if (
            'report_comment' === $fields['EVENT_ID']
            || 'tasks_comment' === $fields['EVENT_ID']
            || 'blog_comment' === $fields['EVENT_ID']
            || 'crm_activity_add_comment' === $fields['EVENT_ID'] // Это на самом деле задачи
        ) {
            return;
        }

        $user = $fields['USER_ID'];
        $logId = $fields['LOG_ID'];

        $users = static::getUsersFromMessage($fields['MESSAGE']);

        //вытащим дату из таблицы
        $logComment = Socialnetwork\LogCommentTable::wakeUpObject($id);
        $logComment->fill(['LOG_DATE', 'LOG.ID', 'LOG.RATING_TYPE_ID']);
        $date = $logComment->getLogDate();

        if (!$logComment->getLog()) {
            return;
        }

        if ('TASK' === $logComment->getLog()->get('RATING_TYPE_ID')) {
            return;
        }

        // очистим уведомления в этой сущности для отмеченных пользователей и автора
        NotificationTable::clearEntityByUser(
            array_merge($users, [$user]),
            NotificationBindingTable::SOC_LOG,
            $logId,
            NotificationTable::NEED_REACTION
        );

        NotificationResponsibleTable::clearResponsible($logId, NotificationBindingTable::SOC_LOG, $user);
        //никого не упомянули, выходим, ничего не создаем
        if (!count($users)) {
            return;
        }

        foreach ($users as $key => $userId) {
            //владельцу комментария
            static::sendSocCommentNotify(
                $id,
                $logId,
                $user,
                $userId,
                $date,
                NotificationTable::WAIT_REACTION,
                [ $userId ]
            );

            //упомянутым пользователям
            static::sendSocCommentNotify(
                $id,
                $logId,
                $userId,
                $user,
                $date,
                NotificationTable::NEED_REACTION
            );


 \CSocNetLogRights::Add ($fields['LOG_ID'], array ('U'.$userId));
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

        //получем id комментатора
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
        //вытащим дату из таблицы
        $logComment = Socialnetwork\LogCommentTable::wakeUpObject($id);
        $logComment->fillLogDate();
        $date = $logComment->getLogDate();

        // очистим уведомления в этой сущности для отмеченных пользователей и автора
        NotificationTable::clearEntityByUser(
            array_merge($users, [$user]),
            NotificationBindingTable::SOC_LOG,
            $logId
        );

        NotificationResponsibleTable::clearResponsible($logId, NotificationBindingTable::SOC_LOG, $user);
        //никого не упомянули, выходим, ничего не создаем
        if (!count($users)) {
            return;
        }

        foreach ($users as $key => $userId) {
            //владельцу комментария
            static::sendSocCommentNotify(
                $id,
                $logId,
                $user,
                $userId,
                $date,
                NotificationTable::WAIT_REACTION,
                [ $userId ]
            );

            //упомянутым пользователям
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
        //по id комментария сонета найдём соответствующие записи нотификаций
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

        //удаляем в цикле
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

        //биндим отмеченных для статусов
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

        //биндим к ней соцлог, в рамках одного соц лога может быть много комментариев
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

        //биндим комментарий
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
        //шлём пулл что количество изменилось
        static::sendPull([$to]);
    }

    // Обработчик события OnBeforeSocNetLogDelete модуля socialnetwork
    public static function OnBeforeSocNetLogDelete($logId)
    {
        static::clearLogCommentNotification((int) $logId);
    }

    // Перед удалением записи в живой ленте удалим все уведомления связанные с данной записью
    protected static function clearLogCommentNotification(int $logId)
    {
        // Получим все комментарии связанные с данной записью
        $rows = Socialnetwork\LogCommentTable::query()
            ->addSelect('ID')
            ->where('LOG_ID', $logId)
            ->exec();

        // Если комментариев нет то ничего делать не надо
        if (0 >= $rows->getSelectedRowsCount()) {
            return;
        }

        // Откроем транзакцию
        $connecton = Socialnetwork\LogCommentTable::getEntity()->getConnection();
        $connecton->startTransaction();

        // Переберем все найденные комментарии и вручную вызовем обработчик удаления комментария к записи в живой ленте
        while ($row = $rows->fetch()) {
            static::onSocNetCommentDelete($row['ID']);
        }

        // Закроем транзакцию
        $connecton->commitTransaction();
    }
}
