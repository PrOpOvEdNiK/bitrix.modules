<?php

use Bizprofi\Tools\Module\Traits\Migration;
use Phinx\Migration\AbstractMigration;

class AddBpHandlerAddTask extends AbstractMigration
{
    use Migration\RegisterEventHandler;

    protected function getParams() : array
    {
        return [
            'from_module' => 'bizproc',
            'event_type' => 'OnTaskAdd',
            'to_module' => 'bizprofi.reaction',
            'to_class' => 'Bizprofi\Reaction\NotifyEventsHandler',
            'to_method' => 'OnBpTaskAdd',
            'sort' => 100,
            'to_path' => '',
            'to_method_arg' => [],
        ];
    }
}
