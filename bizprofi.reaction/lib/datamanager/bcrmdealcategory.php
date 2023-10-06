<?php

namespace Bizprofi\Reaction\DataManager;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields;

class BCrmDealCategoryTable extends DataManager
{
    /**
     * {@inheritdoc}
     */
    public static function getTableName()
    {
        return 'b_crm_deal_category';
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
            new Fields\DatetimeField('CREATED_DATE', [
                'title' => 'CREATED_DATE',
            ]),
            new Fields\StringField('NAME', [
                'title' => 'NAME',
            ]),
            new Fields\StringField('IS_LOCKED', [
                'title' => 'IS_LOCKED',
            ]),
            new Fields\IntegerField('SORT', [
                'title' => 'SORT',
            ]),
        ];
    }
}
