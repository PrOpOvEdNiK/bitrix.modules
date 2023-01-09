<?php

use Bizprofi\Tools\Module\Traits\Migration;
use Phinx\Migration\AbstractMigration;

class AddBpHandleDelegateTask extends AbstractMigration
{
    use Migration\RegisterEventHandler;

    protected function getParams() : array
    {
        return [
            'from_module' => 'bizproc',
            'event_type' => 'OnTaskDelegate',
            'to_module' => 'bizprofi.reaction',
            'to_class' => 'Bizprofi\Reaction\NotifyEventsHandler',
            'to_method' => 'OnBpTaskDelegate',
            'sort' => 100,
            'to_path' => '',
            'to_method_arg' => [],
        ];
    }
}
