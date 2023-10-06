<?php

use Bizprofi\Tools\Module\Traits\Migration;
use Phinx\Migration\AbstractMigration;

class DeleteSonetCommentHandler extends AbstractMigration
{
    use Migration\RegisterEventHandler;

    protected function getParams() : array
    {
        return [
            'from_module' => 'socialnetwork',
            'event_type' => 'OnSocNetLogCommentDelete',
            'to_module' => 'bizprofi.reaction',
            'to_class' => 'Bizprofi\Reaction\NotifyEventsHandler',
            'to_method' => 'onSocNetCommentDelete',
            'sort' => 100,
            'to_path' => '',
            'to_method_arg' => [],
        ];
    }
}
