<?php

use Bizprofi\Tools\Module\Traits\Migration;
use Phinx\Migration\AbstractMigration;

class AddReportAddcomentHandler extends AbstractMigration
{
    use Migration\RegisterEventHandler;

    protected function getParams() : array
    {
        return [
            'from_module' => 'socialnetwork',
            'event_type' => 'OnAfterSocNetLogCommentAdd',
            'to_module' => 'bizprofi.reaction',
            'to_class' => 'Bizprofi\Reaction\NotifyEventsHandler',
            'to_method' => 'onReportComment',
            'sort' => 100,
            'to_path' => '',
            'to_method_arg' => [],
        ];
    }
}
