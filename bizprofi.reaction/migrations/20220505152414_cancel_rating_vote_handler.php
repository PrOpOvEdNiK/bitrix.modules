<?php

use Bizprofi\Tools\Module\Traits\Migration;
use Phinx\Migration\AbstractMigration;

class CancelRatingVoteHandler extends AbstractMigration
{
    use Migration\RegisterEventHandler;

    protected function getParams(): array
    {
        return [
            'from_module' => 'main',
            'event_type' => 'OnCancelRatingVote',
            'to_module' => 'bizprofi.reaction',
            'to_class' => 'Bizprofi\Reaction\NotifyEventsHandler',
            'to_method' => 'OnCancelRatingVote',
            'sort' => 100,
            'to_path' => '',
            'to_method_arg' => [],
        ];
    }
}
