<?php

use Bizprofi\Tools\Module\Traits\Migration;
use Phinx\Migration\AbstractMigration;

class AddBpHandleCompleteTask extends AbstractMigration
{
    use Migration\RegisterEventHandler;

    protected function getParams() : array
    {
        return [
            'from_module' => 'bizproc',
            'event_type' => 'OnTaskMarkCompleted',
            'to_module' => 'bizprofi.reaction',
            'to_class' => 'Bizprofi\Reaction\NotifyEventsHandler',
            'to_method' => 'OnBpTaskMarkCompleted',
            'sort' => 100,
            'to_path' => '',
            'to_method_arg' => [],
        ];
    }
}
