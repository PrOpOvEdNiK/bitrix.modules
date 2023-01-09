<?php

use Bizprofi\Tools\Module\Traits\Migration;
use Phinx\Migration\AbstractMigration;

class UpdateSonetCommentHandler extends AbstractMigration
{
    use Migration\RegisterEventHandler;

    protected function getParams() : array
    {
        return [
            'from_module' => 'socialnetwork',
            'event_type' => 'OnAfterSocNetLogCommentUpdate',
            'to_module' => 'bizprofi.reaction',
            'to_class' => 'Bizprofi\Reaction\NotifyEventsHandler',
            'to_method' => 'onSocNetCommentUpdate',
            'sort' => 100,
            'to_path' => '',
            'to_method_arg' => [],
        ];
    }
}
