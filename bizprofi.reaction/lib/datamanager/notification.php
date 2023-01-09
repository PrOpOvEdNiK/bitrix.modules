<?php

namespace Bizprofi\Reaction\DataManager;

use Bitrix\Main\Db;
use Bitrix\Main\Entity;
use Bitrix\Main\Loader;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;

/**
 * Class NotificationTable.
 */
class NotificationTable extends DataManager
{
    const NEED_REACTION = 2;
    const WAIT_REACTION = 1;

    /**
     * {@inheritdoc}
     */
    public static function getTableName()
    {
        return 'bizprofi_reaction_notification';
    }

    /**
     * {@inheritdoc}
     */
    public static function getMap()
    {
        return [
            new Fields\IntegerField('ID', [
                'title' => 'ID',
                'primary' => true,
                'autocomplete' => true,
            ]),
            new Fields\IntegerField('DIRECTION', [
                'title' => 'DIRECTION',
            ]),
            new Fields\IntegerField('FROM_USER', [
                'title' => 'FROM_USER',
            ]),
            new Fields\IntegerField('TO_USER', [
                'title' => 'TO_USER',
            ]),
            new Fields\StringField('NOTIFICATION', [
                'title' => 'NOTIFICATION',
            ]),
            new Fields\DatetimeField('DATE', [
                'title' => 'DATE',
            ]),
            (new Reference(
                'BINDING',
                NotificationBindingTable::class,
                Join::on('this.ID', 'ref.NOTIFICATION_ID')
            ))
                ->configureJoinType('inner'),
            (new Reference(
                'RESPONSIBLE',
                NotificationResponsibleTable::class,
                Join::on('this.ID', 'ref.NOTIFICATION_ID')
            ))
                ->configureJoinType('left'),
        ];
    }

    public static function onDelete(Entity\Event $event)
    {
        // при удалении находим симметричное уведомление и помечаем его среагированным
        if ($row = static::getByPrimary($event->getParameter('primary'))->fetch()) {
            if ($row['DIRECTION'] == static::NEED_REACTION) {
                $bindings = NotificationBindingTable::getList([
                    'select' => ['*'],
                    'filter' => ['=NOTIFICATION_ID' => $row['ID']],
                ]);
                while ($binding = $bindings->fetch()) {
                    NotificationResponsibleTable::clearResponsible($binding['ENTITY_ID'], $binding['ENTITY_TYPE'], $row['TO_USER']);
                }
            }
        }
    }

    /**
     * @param int $userId
     * @param     $entityType
     * @param     $entityId
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     *
     * @return bool
     */
    public static function isExistNoty(int $userId, $entityType, $entityId)
    {
        $rows = NotificationTable::query()
            ->registerRuntimeField(
                'BINDING',
                new Entity\ReferenceField(
                    'BINDING',
                    NotificationBindingTable::class,
                    ['ref.NOTIFICATION_ID' => 'this.ID'],
                    ['join_type' => 'inner']
                )
            )
            ->setSelect(['ID'])
            ->where('TO_USER', $userId)
            ->where('BINDING.ENTITY_TYPE', $entityType)
            ->where('BINDING.ENTITY_ID', $entityId)
            ->addGroup('ID')
            ->exec();

        return $rows->getSelectedRowsCount() > 0;
    }

    /**
     * Вернёт количество уведомлений по всем сущностям для пользователя, если их нет - будет 0.
     *
     * @param array $users
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     *
     * @return array
     */
    public static function getAllCounters(array $users) : array
    {
        $rows = NotificationTable::query()
            ->registerRuntimeField('COUNT', new Fields\ExpressionField('COUNT', 'COUNT(*)'))
            ->setSelect([
                'DIRECTION',
                'TO_USER',
                'ENTITY_TYPE' => 'BINDING.ENTITY_TYPE',
                'COUNT',
            ])
            ->setGroup(['DIRECTION', 'TO_USER', 'ENTITY_TYPE'])
            ->whereIn('TO_USER', $users)
            ->exec();

        $result = [];
        while ($row = $rows->fetch()) {
            if (NotificationTable::NEED_REACTION == $row['DIRECTION']) {
                $result[$row['TO_USER']][$row['DIRECTION']][$row['ENTITY_TYPE']] = (int) $row['COUNT'];
            }

            if (NotificationTable::WAIT_REACTION == $row['DIRECTION']) {
                $result[$row['TO_USER']][$row['DIRECTION']][$row['ENTITY_TYPE']] = (int) $row['COUNT'];
            }
        }

        return static::normalizeCounters($users, $result);
    }

    /**
     * Нормализует счётчики, переводит значения констант в символьное, если количество уведомлений отсутствует - ставит
     * 0.
     *
     * @param array $users
     * @param array $data
     *
     * @return array
     */
    protected static function normalizeCounters(array $users, array $data) : array
    {
        $directions = [static::NEED_REACTION, static::WAIT_REACTION];
        $aggregationTypes = [
            NotificationBindingTable::AGGREGATION_TYPE_ALL,
            NotificationBindingTable::AGGREGATION_TYPE_BIZPROC,
            NotificationBindingTable::AGGREGATION_TYPE_COMMENT,
            NotificationBindingTable::AGGREGATION_TYPE_REPORT,
            NotificationBindingTable::AGGREGATION_TYPE_TASK,
        ];

        $result = [];
        foreach ($users as $user) {
            foreach ($directions as $direction) {
                foreach ($aggregationTypes as $type) {
                    $result[$user][$direction][$type] = 0;
                    foreach (NotificationBindingTable::aggregateEntityTypes($type) as $entityType) {
                        $result[$user][$direction][$type] += (int) $data[$user][$direction][$entityType];
                    }
                }
            }
        }

        return $result;
    }

    /**
     * @param array $ids
     * @param bool  $sendPull
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     *
     * @return array
     */
    public static function getCountByUserIds(array $ids, bool $sendPull = true): array
    {
        $ids = array_filter(array_unique($ids));

        if (!count($ids)) {
            return [];
        }

        $subQuery = NotificationBindingTable::query()
            ->addSelect('NOTIFICATION_ID')
            ->whereNotIn('ENTITY_TYPE', [
                    NotificationBindingTable::SOC_LOG,
                    NotificationBindingTable::TASK_ENTITY,
                    NotificationBindingTable::CRM_ENTITY,
                    NotificationBindingTable::POST_ENTITY,
                ]
            ); // они только для привязок

        if (12 === $entity) {
            $subQuery->whereIn(
                'ENTITY_TYPE',
                [
                    NotificationBindingTable::COMMENT_REPORT_ENTITY,
                    NotificationBindingTable::MESSAGE_ENTITY,
                    NotificationBindingTable::SOC_LOG_COMMENT,
                    NotificationBindingTable::CRM_ENTITY_COMMENT,
                ]
            );
        } elseif ($entity > 0) {
            $subQuery->where('ENTITY_TYPE', $entity);
        }

        $query = static::query()
            ->registerRuntimeField('COUNT', new Fields\ExpressionField('COUNT', 'COUNT(*)'))
            ->setSelect(['COUNT', 'TO_USER', 'DIRECTION'])
            ->addGroup('DIRECTION')
            ->whereNotNull('DIRECTION')
            ->wherein('ID', $subQuery)
            ->whereIn('TO_USER', $ids);

        if (!Loader::includeModule('pull')) {
            $sendPull = false;
        }

        $rows = $query->exec();
        $result = [];
        while ($row = $rows->fetch()) {
            if (NotificationTable::WAIT_REACTION === (int) $row['DIRECTION']) {
                $result[$row['TO_USER']]['countWait'] = (int) $row['COUNT'];
            }

            if (NotificationTable::NEED_REACTION === (int) $row['DIRECTION']) {
                $result[$row['TO_USER']]['countNeed'] = (int) $row['COUNT'];
            }
        }

        // Получим количество уведомлений ожидающих реакции без реакции
        $rows = static::query()
            ->registerRuntimeField('COUNT', new Fields\ExpressionField('COUNT', 'COUNT(*)'))
            ->setSelect(['COUNT', 'TO_USER'])
            ->where('DIRECTION', static::WAIT_REACTION)
            ->wherein('ID', $subQuery)
            ->whereIn('TO_USER', $ids)
            ->whereNotNull('RESPONSIBLE.NOTIFICATION_ID')
            ->addGroup('DIRECTION')
            ->exec();

        while ($row = $rows->fetch()) {
            $result[$row['TO_USER']]['countWaitWithoutReaction'] = (int) $row['COUNT'];
        }

        $userInfo = [];
        $userCounters = static::getAllCounters($ids);
        foreach ($ids as $id) {
            $userInfo[$id] = [
                'id' => $id,
                'countNeed' => $result[$id]['countNeed'] ?: 0,
                'countWait' => $result[$id]['countWait'] ?: 0,
                'countWaitWithoutReaction' => $result[$id]['countWaitWithoutReaction'] ?: 0,
                'allCounters' => $userCounters[$id],
            ];

            if ($sendPull) {
                if(!empty($userCounters[$id][NotificationTable::WAIT_REACTION])){
                    $userCounters[$id][NotificationTable::WAIT_REACTION]['with_reaction'] = $result[$id]['countWait'] - $result[$id]['countWaitWithoutReaction'];
                    $userCounters[$id][NotificationTable::WAIT_REACTION]['without_reaction'] = $result[$id]['countWaitWithoutReaction'];
                }
                
                \CPullStack::AddByUser($id, [
                    'module_id' => 'reaction',
                    'command' => 'changeNotifyCount',
                    'params' => [
                        'countNeed' => $result[$id]['countNeed'] ?: 0,
                        'countWait' => $result[$id]['countWait'] ?: 0,
                        'allCounters' => $userCounters[$id],
                    ],
                ]);
            }
        }

        return $userInfo;
    }

    /**
     * @param int $id
     * @param int $entityType
     * @param int $direction
     *
     * @throws Db\SqlQueryException
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public static function clearEntityById(int $id, int $entityType, int $direction = 0)
    {
        if ($id <= 0) {
            return;
        }

        $query = static::query()
            ->setSelect(['ID', 'TO_USER'])
            ->where('BINDING.ENTITY_TYPE', $entityType)
            ->where('BINDING.ENTITY_ID', $id)
            ->addGroup('ID');

        if ($direction > 0) {
            $query->where('DIRECTION', $direction);
        }

        $connection = static::getEntity()->getConnection();
        $connection->startTransaction();

        $rows = $query->exec();

        $users = [];
        while ($row = $rows->fetch()) {
            $users[] = $row['TO_USER'];

            $result = static::delete($row['ID']);
            if (!$result->isSuccess()) {
                $connection->rollbackTransaction();
                AddMessage2Log($result->getErrorMessages());

                return;
            }
        }

        $connection->commitTransaction();

        if (0 >= count($users)) {
            return;
        }

        if (!Loader::includeModule('pull')) {
            return;
        }

        static::getCountByUserIds($users);
    }

    public static function clearEntityByUser(array $ids, int $entityType, int $etityId, int $direction = 0)
    {
        $ids = array_filter(array_unique($ids));
        if (!count($ids)) {
            return;
        }

        $query = static::query()
            ->setSelect(['ID', 'TO_USER'])
            ->whereIn('TO_USER', $ids)
            ->where('BINDING.ENTITY_TYPE', $entityType)
            ->where('BINDING.ENTITY_ID', $etityId)
            ->addGroup('ID');

        if ($direction > 0) {
            $query->where('DIRECTION', $direction);
        }

        $connection = static::getEntity()->getConnection();
        $connection->startTransaction();

        $rows = $query->exec();

        $users = [];
        while ($row = $rows->fetch()) {
            $users[] = $row['TO_USER'];

            $result = static::delete($row['ID']);

            if (!$result->isSuccess()) {
                $connection->rollbackTransaction();
                AddMessage2Log($result->getErrorMessages());

                return;
            }
        }

        $connection->commitTransaction();

        if (0 >= count($users)) {
            return;
        }

        if (!Loader::includeModule('pull')) {
            return;
        }

        static::getCountByUserIds($users);
    }

    /**
     * @param int $user
     *
     * @throws Db\SqlQueryException
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public static function deleteAllWaitReaction(int $user)
    {
        return static::deleteAllByDirection($user, static::WAIT_REACTION);
    }

    /**
     * @param int $user
     *
     * @throws Db\SqlQueryException
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public static function deleteAllNeedReaction(int $user)
    {
        return static::deleteAllByDirection($user, static::NEED_REACTION);
    }

    /**
     * @param int $user
     *
     * @throws Db\SqlQueryException
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public static function deleteAllByDirection(int $user, int $direction)
    {
        $connection = static::getEntity()->getConnection();
        $connection->startTransaction();
        $notyCollection = static::query()
            ->setSelect(['ID'])
            ->where('DIRECTION', $direction)
            ->where('TO_USER', $user)
            ->fetchCollection();

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

    // Удаляет все уведомления ожидающие реакции на которые была получена реакция для пользователя
    public static function deleteWaitReactionWithReaction(int $user)
    {
        // Откроем транзакцию
        $connection = static::getEntity()->getConnection();
        $connection->startTransaction();

        // Получим все такие уведомления
        $notyCollection = static::query()
            ->setSelect(['ID'])
            ->where('DIRECTION', static::WAIT_REACTION)
            ->where('TO_USER', $user)
            ->whereNull('RESPONSIBLE.NOTIFICATION_ID')
            ->fetchCollection();

        // Переберем полученные уведомления и удалим их
        foreach ($notyCollection as $noty) {
            $result = $noty->delete();

            // Если что-то пошло не так откатим транзакцию, запишем ошибку и прервем выполнение
            if (!$result->isSuccess()) {
                $connection->rollbackTransaction();
                AddMessage2Log($result->getErrorMessages());

                return;
            }
        }

        // Закроем транзакцию
        $connection->commitTransaction();
    }

    // Удаляет все уведомления ожидающие реакции на которые не была получена реакция для пользователя
    public static function deleteWaitReactionWithoutReaction(int $user)
    {
        // Откроем транзакцию
        $connection = static::getEntity()->getConnection();
        $connection->startTransaction();

        // Получим все такие уведомления
        $notyCollection = static::query()
            ->setSelect(['ID'])
            ->where('DIRECTION', static::WAIT_REACTION)
            ->where('TO_USER', $user)
            ->whereNotNull('RESPONSIBLE.NOTIFICATION_ID')
            ->fetchCollection();

        // Переберем полученные уведомления и удалим их
        foreach ($notyCollection as $noty) {
            $result = $noty->delete();

            // Если что-то пошло не так откатим транзакцию, запишем ошибку и прервем выполнение
            if (!$result->isSuccess()) {
                $connection->rollbackTransaction();
                AddMessage2Log($result->getErrorMessages());

                return;
            }
        }

        // Закроем транзакцию
        $connection->commitTransaction();
    }
}
