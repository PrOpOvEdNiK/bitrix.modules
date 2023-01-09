<?php

use Bitrix\Crm\Timeline\Entity\TimelineTable;
use Bitrix\Crm\Timeline\TimelineType;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;
use Bitrix\Main\ORM\Query\Query;
use Phinx\Migration\AbstractMigration;

class AddOldCrmNoty extends AbstractMigration
{
    public function up()
    {
        if (!Loader::includeModule('crm')) {
            throw new \Exception('Module "crm" is`nt installed');
        }

        $dateStart = new \Bitrix\Main\Type\DateTime();
        $dateStart = $dateStart->add('-30D');

        $row = TimelineTable::query()
            ->addSelect(Query::expr()->min('ID'), 'MIN')
            ->where('CREATED', '>', $dateStart)
            ->where('TYPE_ID', TimelineType::COMMENT)
            ->fetch();

        if ($row) {
            Option::set('bizprofi.reaction', 'lastCrmCommentId', $row['MIN']);
        }
    }

    public function down()
    {
        Option::set('bizprofi.reaction', 'lastCrmCommentId', 0);
    }
}
