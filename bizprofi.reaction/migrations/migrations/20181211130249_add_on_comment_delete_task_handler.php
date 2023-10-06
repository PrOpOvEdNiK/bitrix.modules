<?php

use Bizprofi\Tools\Module\Traits\Migration;
use Phinx\Migration\AbstractMigration;

class AddOnCommentDeleteTaskHandler extends AbstractMigration
{
    use Migration\RegisterEventHandler;

    protected function getParams(): array
    {
        return [
            'from_module' => 'tasks',
            'event_type' => 'OnAfterCommentDelete',
            'to_module' => 'bizprofi.reaction',
            'to_class' => 'Bizprofi\Reaction\NotifyEventsHandler',
            'to_method' => 'OnCommentDelete',
            'sort' => 100,
            'to_path' => '',
            'to_method_arg' => [],
        ];
    }
}
