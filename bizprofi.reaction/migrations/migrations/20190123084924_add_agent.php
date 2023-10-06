<?php

use Phinx\Migration\AbstractMigration;

class AddAgent extends AbstractMigration
{
    public function up()
    {
        $result = \CAgent::AddAgent(
            '\Bizprofi\Reaction\Agent\CrmCatchAgent::initialize();',
            'bizprofi.reaction',
            'N',
            60, //1 минут
            strval((new \Bitrix\Main\Type\Datetime())->add('T20M')),
            'Y',
            strval((new \Bitrix\Main\Type\Datetime())->add('T15M')),
            100
        );

        if (0 >= (int) $result) {
            throw new \Exception('Fail add agent');
        }
    }

    public function down()
    {
        \CAgent::RemoveAgent(
            '\Bizprofi\Reaction\Agent\CrmCatchAgent::initialize();',
            'bizprofi.reaction'
        );
    }
}
