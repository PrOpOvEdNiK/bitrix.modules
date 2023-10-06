<?php

namespace Bizprofi\Reaction\DataManager;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields;

class BptaskTable extends DataManager
{
    /**
     * {@inheritdoc}
     */
    public static function getTableName()
    {
        return 'b_bp_task';
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
            new Fields\IntegerField('STATUS', [
                'title' => 'STATUS',
            ]),
            new Fields\IntegerField('DELEGATION_TYPE', [
                'title' => 'DELEGATION_TYPE',
            ]),
            new Fields\StringField('WORKFLOW_ID', [
                'title' => 'WORKFLOW_ID',
            ]),
            new Fields\StringField('ACTIVITY', [
                'title' => 'ACTIVITY',
            ]),
            new Fields\StringField('ACTIVITY_NAME', [
                'title' => 'ACTIVITY_NAME',
            ]),
            new Fields\StringField('NAME', [
                'title' => 'NAME',
            ]),
            new Fields\StringField('DESCRIPTION', [
                'title' => 'DESCRIPTION',
            ]),
            new Fields\StringField('PARAMETERS', [
                'title' => 'PARAMETERS',
            ]),
            new Fields\StringField('DOCUMENT_NAME', [
                'title' => 'DOCUMENT_NAME',
            ]),
            new Fields\DatetimeField('MODIFIED', [
                'title' => 'MODIFIED',
            ]),
        ];
    }
}
