<?php

namespace Bizprofi\Reaction\NotifyEventsHandlerTraits;

use Bitrix\Blog\Item;
use Bitrix\Forum\MessageTable;
use Bitrix\Main\Loader;
use Bitrix\Socialnetwork;
use Bitrix\Main\Type\DateTime;
use Bizprofi\Reaction\DataManager\NotificationBindingTable;
use Bizprofi\Reaction\DataManager\NotificationResponsibleTable;
use Bizprofi\Reaction\DataManager\NotificationTable;

trait MainHandlers
{
    /**
     * when user press like on tasks or report or comment.
     *
     * @param $id
     * @param $data
     *
     * @throws \Bitrix\Main\LoaderException
     */
    public static function OnAddRatingVote($id, $data)
    { 
        if (!Loader::includeModule('tasks')) {
            throw new \Exception('tasks not install');
        }

        if (!Loader::includeModule('socialnetwork')) {
            throw new \Exception('socialnetwork not install');
        }

        $ownerId = $data['OWNER_ID'];
        $userId = $data['USER_ID'];
        $messageId = $data['ENTITY_ID'];

        // блоги
        if ('BLOG_COMMENT' === $data['ENTITY_TYPE_ID']) {
            $blogInfo = Item\Comment::getById($messageId)->getFields();
            NotificationResponsibleTable::clearResponsible($blogInfo['POST_ID'], NotificationBindingTable::POST_ENTITY, $userId);
            NotificationTable::clearEntityByUser([$userId], NotificationBindingTable::POST_ENTITY, $blogInfo['POST_ID'], NotificationTable::NEED_REACTION);

            static::clearLogCommentByBlogComment((int) $userId, (string) $data['ENTITY_TYPE_ID'], (int) $data['ENTITY_ID']);

            return;
        }

        // задачи
        if ('TASK' === $data['ENTITY_TYPE_ID']) {
            static::clearTaskAcknowledgeReaction(
                (int) $userId,
                (int) $messageId
            );

            return;
        }

        // посты
        if ('BLOG_POST' === $data['ENTITY_TYPE_ID']) {
            NotificationResponsibleTable::clearResponsible($messageId, NotificationBindingTable::POST_NOTIFY, $userId);
            NotificationTable::clearEntityByUser([$userId], NotificationBindingTable::POST_NOTIFY, $messageId, NotificationTable::NEED_REACTION);

            return;
        }

        // У некоторых задач рейтинг указывается как для FORUM_POST, при этом условия дальше не срабатывают, выполним тут данный сброс, если это не задача сброса не произойдет
        if ('FORUM_POST' === $data['ENTITY_TYPE_ID']) {
            static::clearTaskReactionFromForumMessage(
                (int) $userId,
                (int) $messageId
            );
        }

        $row = Socialnetwork\LogCommentTable::query()
            ->setSelect([
                'ID',
                'EVENT_ID',
                'LOG_ID',
                'LOG_SOURCE_ID' => 'LOG.SOURCE_ID',
                'LOG_EVENT_ID' => 'LOG.EVENT_ID',
                'LOG_RATING_TYPE_ID' => 'LOG.RATING_TYPE_ID',
                'LOG_RATING_ENTITY_ID' => 'LOG.RATING_ENTITY_ID',
            ])
            ->where('SOURCE_ID', $messageId)
            ->exec()
            ->fetch();

        if ('report' === $row['LOG_EVENT_ID']) {
            if (NotificationTable::isExistNoty($userId, NotificationBindingTable::COMMENT_REPORT_ENTITY, $row['ID'])) {
                NotificationResponsibleTable::clearResponsible($row['LOG_ID'], NotificationBindingTable::SOC_LOG_REPORT_ENTITY, $userId);

                NotificationTable::clearEntityByUser([$userId], NotificationBindingTable::SOC_LOG_REPORT_ENTITY, $row['LOG_ID'], NotificationTable::NEED_REACTION);

                return;
            }
        }

        if ('TASK' === $row['LOG_RATING_TYPE_ID']) {
            $taskId = $row['LOG_RATING_ENTITY_ID'];
            if (NotificationTable::isExistNoty($userId, NotificationBindingTable::MESSAGE_ENTITY, $messageId)) {
                NotificationResponsibleTable::clearResponsible($taskId, NotificationBindingTable::TASK_ENTITY, $userId);

                NotificationTable::clearEntityByUser([$userId], NotificationBindingTable::TASK_ENTITY, $taskId, NotificationTable::NEED_REACTION);

                return;
            }
        }

        // некоторые комменатии идентифицируеются как FORUM_POST и тут передаётся форумный id, а некоторые как LOG_COMMENT, и передаётся id коммента сонета
        if ('FORUM_POST' === $data['ENTITY_TYPE_ID']) {
            NotificationResponsibleTable::clearResponsible((int)$row['LOG_ID'], NotificationBindingTable::SOC_LOG, $userId);
            NotificationTable::clearEntityByUser([$userId], NotificationBindingTable::SOC_LOG_COMMENT, $row['ID'], NotificationTable::NEED_REACTION);
        }

        if ('LOG_COMMENT' === $data['ENTITY_TYPE_ID']) {
            NotificationResponsibleTable::clearResponsible($row['LOG_ID'], NotificationBindingTable::SOC_LOG, $userId);
            NotificationTable::clearEntityByUser([$userId], NotificationBindingTable::SOC_LOG_COMMENT, $data['ENTITY_ID'], NotificationTable::NEED_REACTION);
        }

        // Для задач имеющих связь с CRM получим идентификатор задачи через модуль форума
        if ('crm_activity_add_comment' === $row['EVENT_ID']) {
            static::clearTaskReactionFromForumMessage(
                (int) $userId,
                (int) $messageId
            );
        }
    }
  public static function OnCancelRatingVote($id, $data){

        if (!Loader::includeModule('tasks')) {
            throw new \Exception('tasks not install');
        }

        if (!Loader::includeModule('socialnetwork')) {
            throw new \Exception('socialnetwork not install');
        }

        $messageId = $data['ENTITY_ID'];

       
        if ('FORUM_POST' === $data['ENTITY_TYPE_ID']) {

            $message = Socialnetwork\LogCommentTable::query()
                ->setSelect([
                    'ID',
                    'EVENT_ID',
                    'LOG_ID',
                    'MESSAGE',
                    'USER_ID',
                    'LOG_SOURCE_ID' => 'LOG.SOURCE_ID',
                    'LOG_EVENT_ID' => 'LOG.EVENT_ID',
                    'LOG_RATING_TYPE_ID' => 'LOG.RATING_TYPE_ID',
                    'LOG_RATING_ENTITY_ID' => 'LOG.RATING_ENTITY_ID',
                ])
                ->where('SOURCE_ID', $messageId)
                ->exec()
                ->fetch();
            //Упомянутым пользователям
            $users = static::getUsersFromMessage($message['MESSAGE']);
            if (!count($users)) {
                return;
            }

			$objDateTime = new DateTime();
            $dateEdit = $objDateTime->toString();
            if ('TASK' === $message['LOG_RATING_TYPE_ID']) {
                $taskId = $message['LOG_RATING_ENTITY_ID'];
                foreach ($users as $key => $userId) {
                    //Комментатору
                    static::sendTaskCommentRatingNotify(
                        $messageId,
                        $taskId,
                        $message['USER_ID'],
                        $userId,
                        $objDateTime,
                        NotificationTable::WAIT_REACTION,
                        [ $userId ]
                    );

                    static::sendTaskCommentRatingNotify(
                        $messageId,
                        $taskId,
                        $userId,
                        $message['USER_ID'],
                        $objDateTime,
                        NotificationTable::NEED_REACTION
                    );

                }
}
        }
    }
 
    // Удалим уведомления задачи для сотрудника
    protected static function clearTaskAcknowledgeReaction(int $employeeId, int $taskId)
    {
        NotificationResponsibleTable::clearResponsible($taskId, NotificationBindingTable::TASK_ACKNOWLEDGE_ENTITY, $employeeId);
        NotificationTable::clearEntityByUser([$employeeId], NotificationBindingTable::TASK_ACKNOWLEDGE_ENTITY, $taskId, NotificationTable::NEED_REACTION);
    }

    // Удалим уведомления задачи для сотрудника по идентификатору сообщения
    protected static function clearTaskReactionFromForumMessage(int $employeeId, int $messageId)
    {
        if (!Loader::includeModule('forum')) {
            return;
        }

        $row = MessageTable::query()
            ->addSelect('XML_ID')
            ->where('ID', $messageId)
            ->exec()
            ->fetch();

        if (empty($row)) {
            return;
        }

        $taskId = intval(
            str_replace('TASK_', '', $row['XML_ID'])
        );

        if (0 >= $taskId) {
            return;
        }

        NotificationResponsibleTable::clearResponsible($taskId, NotificationBindingTable::TASK_ENTITY, $employeeId);
        NotificationTable::clearEntityByUser([$employeeId], NotificationBindingTable::TASK_ENTITY, $taskId, NotificationTable::NEED_REACTION);
    }

    // Удаляет уведомления на комментарии социальной сети
    protected static function clearLogCommentByBlogComment(int $userId, string $entityTypeId, int $entityId)
    {
        // Если модуль социальной сети не подключен прервем выполнение
        if (!Loader::includeModule('socialnetwork')) {
            return;
        }

        // Найдем комментарий социальной сети который связан комментарием блога
        $rows = \CSocNetLogComments::getList(
            [],
            [
                '=RATING_TYPE_ID' => $entityTypeId,
                '=RATING_ENTITY_ID' => $entityId,
            ],
            false,
            false,
            ['ID', 'LOG_ID']
        );

        // Переберем найденные комментарии и очистим для них уведомления
        while ($row = $rows->fetch()) {
            NotificationResponsibleTable::clearResponsible($row['LOG_ID'], NotificationBindingTable::SOC_LOG, $userId);
            NotificationTable::clearEntityByUser([$userId], NotificationBindingTable::SOC_LOG_COMMENT, $row['ID'], NotificationTable::NEED_REACTION);
        }
    }
 protected static function sendTaskCommentRatingNotify(
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
}