<?php

use Bizprofi\Tools\Module\Traits\Migration\RegisterEventHandler;
use Phinx\Migration\AbstractMigration;

class RegisterHandlerOnTaskAdd extends AbstractMigration
{
    use RegisterEventHandler;

    protected function getParams() : array
    {
        return [
            'from_module' => 'tasks',
            'event_type' => 'OnTaskAdd',
            'to_module' => 'bizprofi.reaction',
            'to_class' => 'Bizprofi\Reaction\NotifyEventsHandler',
            'to_method' => 'OnTaskAdd',
        ];
    }
}
