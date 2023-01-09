<?php

namespace Bizprofi\Reaction\NotifyEventsHandlerTraits;

use Bitrix\Blog\Item;
use Bitrix\Main\Type\DateTime;
use Bizprofi\Reaction\DataManager\NotificationBindingTable;
use Bizprofi\Reaction\DataManager\NotificationResponsibleTable;
use Bizprofi\Reaction\DataManager\NotificationTable;
use Bizprofi\Tools\Lang;

trait BlogPostHandlers
{
    public static function OnPostUpdate($id, $fields)
    {
        //������� ��� ����������� ����� ����������� �����
        if (!$fields['DETAIL_TEXT'] || !$fields['PATH']) {
            return;
        }

        NotificationTable::clearEntityById($id, NotificationBindingTable::POST_NOTIFY);

        $row = $blogInfo = Item\Post::getById($id)->getFields();
        $fields = array_merge($row, $fields);

        static::OnPostAdd($id, $fields);
    }

    public static function OnPostAdd($id, $fields)
    {
        $user = $fields['AUTHOR_ID'];
        $users = static::getUsersFromMessage($fields['DETAIL_TEXT']);
        $date = new DateTime($fields['DATE_PUBLISH']);

        // ������� ����������� � ���� �������� ��� ���������� ������������� � ������
        NotificationTable::clearEntityByUser(
            array_merge($users, [$user]),
            NotificationBindingTable::POST_NOTIFY,
            $id,
            NotificationTable::NEED_REACTION
        );

        NotificationResponsibleTable::clearResponsible($id, NotificationBindingTable::POST_NOTIFY, $user);
        //������ �� ���������, �������, ������ �� �������
        if (!count($users)) {
            return;
        }

        foreach ($users as $key => $userId) {
            //���������
            static::sendPostNotify(
                $id,
                $user,
                $userId,
                $date,
                NotificationTable::WAIT_REACTION,
                [ $userId ]
            );

            //���������� �������������
            static::sendPostNotify(
                $id,
                $userId,
                $user,
                $date,
                NotificationTable::NEED_REACTION
            );
        }
    }

    public function OnPostDelete($id)
    {
        //�� id ����������� ������ ����� ��������������� ������ �����������
        $notyCollection = NotificationTable::query()
            ->setSelect(['ID', 'TO_USER', 'FROM_USER'])
            ->where('BINDING.ENTITY_TYPE', NotificationBindingTable::POST_NOTIFY)
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

    protected static function sendPostNotify(
        int $postId,
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
                'ENTITY_TYPE' => NotificationBindingTable::POST_NOTIFY,
                'ENTITY_ID' => $postId,
            ]);

            if (!$resultResponseble->isSuccess()) {
                $connecton->rollbackTransaction();
                AddMessage2Log($resultResponseble->getErrorMessages());

                return;
            }
        }

        //������ �����������
        $result = NotificationBindingTable::add([
            'NOTIFICATION_ID' => $id,
            'ENTITY_TYPE' => NotificationBindingTable::POST_NOTIFY,
            'ENTITY_ID' => $postId,
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
