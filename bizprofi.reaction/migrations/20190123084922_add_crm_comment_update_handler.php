<?php

use Bizprofi\Tools\Module\Traits\Migration;
use Phinx\Migration\AbstractMigration;

class AddCrmCommentUpdateHandler extends AbstractMigration
{
    use Migration\RegisterEventHandler;

    protected function getParams() : array
    {
        return [
            'from_module' => 'crm',
            'event_type' => 'TimelineonAfterUpdate',
            'to_module' => 'bizprofi.reaction',
            'to_class' => 'Bizprofi\Reaction\NotifyEventsHandler',
            'to_method' => 'onAfterCrmUpdate',
            'sort' => 100,
            'to_path' => '',
            'to_method_arg' => [],
        ];
    }
}
