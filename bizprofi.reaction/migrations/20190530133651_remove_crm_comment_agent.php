<?php

use Phinx\Migration\AbstractMigration;

class RemoveCrmCommentAgent extends AbstractMigration
{
    public function up()
    {
        \CAgent::RemoveAgent(
            '\Bizprofi\Reaction\Agent\CrmCatchAgent::initialize();',
            'bizprofi.reaction'
        );

        // Почему-то на некоторых порталах агент был добавлен с таким именем, не уверен почему
        \CAgent::RemoveAgent(
            'Bizprofi\Reaction\Agent\CrmCatchAgent::initialize();',
            'bizprofi.reaction'
        );
    }

    public function down()
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
}
