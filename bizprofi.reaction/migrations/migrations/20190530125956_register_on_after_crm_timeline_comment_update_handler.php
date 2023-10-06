<?php

use Bizprofi\Tools\Module\Traits\Migration\RegisterEventHandler;
use Phinx\Migration\AbstractMigration;

class RegisterOnAfterCrmTimelineCommentUpdateHandler extends AbstractMigration
{
    use RegisterEventHandler;

    protected function getParams() : array
    {
        return [
            'from_module' => 'crm',
            'event_type' => 'OnAfterCrmTimelineCommentUpdate',
            'to_module' => 'bizprofi.reaction',
            'to_class' => 'Bizprofi\\Reaction\\NotifyEventsHandler',
            'to_method' => 'OnAfterCrmTimelineCommentUpdate',
        ];
    }
}
