<?php

use Bitrix\Main\EventManager;
use Phinx\Migration\AbstractMigration;

class RemoveCrmCommentDeleteHandler extends AbstractMigration
{
    protected function getParams() : array
    {
        return [
            'from_module' => 'crm',
            'event_type' => 'TimelineonAfterDelete',
            'to_module' => 'bizprofi.reaction',
            'to_class' => 'Bizprofi\Reaction\NotifyEventsHandler',
            'to_method' => 'onAfterCrmDelete',
            'sort' => 100,
            'to_path' => '',
            'to_method_arg' => [],
        ];
    }

    public function up()
    {
        $params = $this->getParams();

        EventManager::getInstance()->unRegisterEventHandler(
            $params['from_module'],
            $params['event_type'],
            $params['to_module'],
            $params['to_class'] ?: '',
            $params['to_method'] ?: '',
            $params['to_path'] ?: '',
            $params['to_method_arg'] ?: []
        );
    }

    public function down()
    {
        $params = $this->getParams();

        EventManager::getInstance()->registerEventHandler(
            $params['from_module'],
            $params['event_type'],
            $params['to_module'],
            $params['to_class'] ?: '',
            $params['to_method'] ?: '',
            $params['sort'] ?: 100,
            $params['to_path'] ?: '',
            $params['to_method_arg'] ?: []
        );
    }
}
