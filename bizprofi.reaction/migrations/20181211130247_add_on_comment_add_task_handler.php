<?php

use Bizprofi\Tools\Module\Traits\Migration;
use Phinx\Migration\AbstractMigration;

class AddOnCommentAddTaskHandler extends AbstractMigration
{
    use Migration\RegisterEventHandler;

    protected function getParams(): array
    {
        return [
            'from_module' => 'tasks',
            'event_type' => 'OnAfterCommentAdd',
            'to_module' => 'bizprofi.reaction',
            'to_class' => 'Bizprofi\Reaction\NotifyEventsHandler',
            'to_method' => 'OnCommentAdd',
            'sort' => 100,
            'to_path' => '',
            'to_method_arg' => [],
        ];
    }
}
