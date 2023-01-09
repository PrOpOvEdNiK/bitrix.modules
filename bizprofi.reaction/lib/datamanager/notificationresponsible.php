<?php

namespace Bizprofi\Reaction\DataManager;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields;

/**
 * Class NotificationTable.
 */
class NotificationResponsibleTable extends DataManager
{
    /**
     * {@inheritdoc}
     */
    public static function getTableName()
    {
        return 'bizprofi_reaction_notification_responsibles';
    }

    /**
     * {@inheritdoc}
     */
    public static function getMap()
    {
        return [
            new Fields\IntegerField('NOTIFICATION_ID', [
                'title' => 'ID',
                'primary' => true,
            ]),
            new Fields\IntegerField('USER_ID', [
                'title' => 'USER_ID',
                'primary' => true,
            ]),
            new Fields\IntegerField('ENTITY_TYPE', [
                'title' => 'ENTITY_TYPE',
                'primary' => true,
            ]),
            new Fields\IntegerField('ENTITY_ID', [
                'title' => 'ENTITY_ID',
                'primary' => true,
            ]),
        ];
    }

    //очищает отмеченных в сущности, используется в статусах
    public static function clearResponsible(int $entityId, int $entityType, int $userId)
    {
        $connection = static::getEntity()->getConnection();
        $connection->startTransaction();
        $notyCollection = static::query()
            ->setSelect(['*'])
            ->where('ENTITY_ID', $entityId)
            ->where('ENTITY_TYPE', $entityType)
            ->where('USER_ID', $userId)
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

    public static function clearResponsibleByEntity(int $entityId, int $entityType)
    {
        $connection = static::getEntity()->getConnection();
        $connection->startTransaction();
        $notyCollection = static::query()
            ->setSelect(['*'])
            ->where('ENTITY_ID', $entityId)
            ->where('ENTITY_TYPE', $entityType)
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
}
