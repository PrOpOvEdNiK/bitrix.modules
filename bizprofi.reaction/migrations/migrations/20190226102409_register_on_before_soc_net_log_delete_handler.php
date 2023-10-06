<?php

use Bizprofi\Tools\Module\Traits\Migration\RegisterEventHandler;
use Phinx\Migration\AbstractMigration;

class RegisterOnBeforeSocNetLogDeleteHandler extends AbstractMigration
{
    use RegisterEventHandler;

    protected function getParams() : array
    {
        return [
            'from_module' => 'socialnetwork',
            'event_type' => 'OnBeforeSocNetLogDelete',
            'to_module' => 'bizprofi.reaction',
            'to_class' => 'Bizprofi\\Reaction\\NotifyEventsHandler',
            'to_method' => 'OnBeforeSocNetLogDelete',
            'sort' => 100,
            'to_path' => '',
            'to_method_arg' => [],
        ];
    }
}
