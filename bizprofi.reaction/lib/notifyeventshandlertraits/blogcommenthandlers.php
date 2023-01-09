<?php

namespace Bizprofi\Reaction\NotifyEventsHandlerTraits;

use Bitrix\Blog\Item;
use Bitrix\Main\Loader;
use Bitrix\Main\Type\DateTime;
use Bizprofi\Reaction\DataManager\NotificationBindingTable;
use Bizprofi\Reaction\DataManager\NotificationResponsibleTable;
use Bizprofi\Reaction\DataManager\NotificationTable;
use Bizprofi\Tools\Lang;

trait BlogCommentHandlers
{
    public static function OnBlogAdd($id, $fields)
    {
        $user = $fields['AUTHOR_ID'];
        $blogId = $fields['POST_ID'];

        // ���� �������������� � ������ ���� ������ ������ �� ����
        if (static::isIdeaBlog((int) $fields['BLOG_ID'])) {
            return;
        }

        $users = static::getUsersFromMessage($fields['POST_TEXT']);
        $date = new DateTime($fields['DATE_CREATE']);

        // ������� ����������� � ���� �������� ��� ���������� ������������� � ������
        NotificationTable::clearEntityByUser(
            array_merge($users, [$user]),
            NotificationBindingTable::POST_ENTITY,
            $blogId,
            NotificationTable::NEED_REACTION
        );

        // ������� ����������� � ������������ ������
        NotificationTable::clearEntityByUser(
            array_merge($users, [$user]),
            NotificationBindingTable::POST_NOTIFY,
            $blogId,
            NotificationTable::NEED_REACTION
        );

        NotificationResponsibleTable::clearResponsible($blogId, NotificationBindingTable::POST_ENTITY, $user);
        NotificationResponsibleTable::clearResponsible($blogId, NotificationBindingTable::POST_NOTIFY, $user);
        //������ �� ���������, �������, ������ �� �������
        if (!count($users)) {
            return;
        }

        foreach ($users as $key => $userId) {
            //��������� �����������
            static::sendBlogCommentNotify(
                $id,
                $blogId,
                $user,
                $userId,
                $date,
                NotificationTable::WAIT_REACTION,
                [ $userId ]
            );

            //���������� �������������
            static::sendBlogCommentNotify(
                $id,
                $blogId,
                $userId,
                $user,
                $date,
                NotificationTable::NEED_REACTION
            );
        }
    }

    public static function OnBlogUpdate($id, $fields)
    {
        //������� ��� ����������� ����� ����������� ����� � �����������
        if (!$fields['POST_TEXT'] || !$fields['PATH']) {
            return;
        }

        NotificationTable::clearEntityById($id, NotificationBindingTable::BLOG_COMMENT);

        $row = $blogInfo = Item\Comment::getById($id)->getFields();
        $fields = array_merge($row, $fields);

        static::OnBlogAdd($id, $fields);
    }

    public static function OnBlogDelete($id)
    {
        //�� id ����������� ������ ����� ��������������� ������ �����������
        $notyCollection = NotificationTable::query()
            ->setSelect(['ID', 'TO_USER', 'FROM_USER'])
            ->where('BINDING.ENTITY_TYPE', NotificationBindingTable::BLOG_COMMENT)
            ->where('BINDING.ENTITY_ID', $id)
            ->fetchCollection();

        if (empty($notyCollection)) {
            AddMessage2Log(
                Lang::render('d1ff44483d55c69b301532914aeece40').$id
            );

            return;
        }

        $connection = NotificationTable::getEntity()->getConnection();
        $connection->startTransaction();

        //������� � �����
        $users = [];
        foreach ($notyCollection as $noty) {
            $users[] = $noty->getToUser();
            $users[] = $noty->getFromUser();
            $result = $noty->delete();
            if (!$result->isSuccess()) {
                $connection->rollbackTransaction();
                AddMessage2Log($result->getErrorMessages());

                return;
            }
        }

        $connection->commitTransaction();
        static::sendPull($users);
    }

    protected static function sendBlogCommentNotify(
        int $commentId,
        int $blogId,
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
                'ENTITY_TYPE' => NotificationBindingTable::POST_ENTITY,
                'ENTITY_ID' => $blogId,
            ]);

            if (!$resultResponseble->isSuccess()) {
                $connecton->rollbackTransaction();
                AddMessage2Log($resultResponseble->getErrorMessages());

                return;
            }
        }

        //������ � ��� ����, � ������ ������ ����� ����� ���� ����� ������������
        $result = NotificationBindingTable::add([
            'NOTIFICATION_ID' => $id,
            'ENTITY_TYPE' => NotificationBindingTable::POST_ENTITY,
            'ENTITY_ID' => $blogId,
        ]);

        if (!$result->isSuccess()) {
            $connecton->rollbackTransaction();
            AddMessage2Log($result->getErrorMessages());

            return;
        }

        //������ �����������
        $result = NotificationBindingTable::add([
            'NOTIFICATION_ID' => $id,
            'ENTITY_TYPE' => NotificationBindingTable::BLOG_COMMENT,
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

    // ��������� �������� �� ���� ������ ����
    protected static function isIdeaBlog(int $blogId): bool
    {
        // ���� ������ ����� �� ��������� ������ false
        if (!Loader::includeModule('blog')) {
            return false;
        }

        // ���� �� ���������� ������������� ����� ������ false
        if (0 >= $blogId) {
            return false;
        }

        // ���� �� ������� �������� ���������� �� ����� ���� ������ false
        if (!($ideaBlog = \CBlog::GetByUrl('idea_s1'))) {
            return false;
        }

        return $blogId === (int) $ideaBlog['ID'];
    }
}
