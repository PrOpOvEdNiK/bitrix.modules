<?php

use Bizprofi\Tools\Module\Traits\Migration;
use Phinx\Migration\AbstractMigration;

class AddReportUpdatecomentHandler extends AbstractMigration
{
    use Migration\RegisterEventHandler;

    protected function getParams() : array
    {
        return [
            'from_module' => 'socialnetwork',
            'event_type' => 'OnAfterSocNetLogCommentUpdate',
            'to_module' => 'bizprofi.reaction',
            'to_class' => 'Bizprofi\Reaction\NotifyEventsHandler',
            'to_method' => 'onReportCommentUpdate',
            'sort' => 100,
            'to_path' => '',
            'to_method_arg' => [],
        ];
    }
}
