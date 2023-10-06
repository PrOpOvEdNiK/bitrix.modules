<?php

use Bizprofi\Tools\Module\Traits\Migration;
use Phinx\Migration\AbstractMigration;

class AddReportAddHandler extends AbstractMigration
{
    use Migration\RegisterEventHandler;

    protected function getParams() : array
    {
        return [
            'from_module' => 'timeman',
            'event_type' => 'OnAfterFullReportAdd',
            'to_module' => 'bizprofi.reaction',
            'to_class' => 'Bizprofi\Reaction\NotifyEventsHandler',
            'to_method' => 'onAfterReportAdd',
            'sort' => 100,
            'to_path' => '',
            'to_method_arg' => [],
        ];
    }
}
