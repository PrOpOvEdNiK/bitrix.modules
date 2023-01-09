<?php

use Bizprofi\Tools\Module\Traits\Migration;
use Phinx\Migration\AbstractMigration;

class AddRatingVoteHandler extends AbstractMigration
{
    use Migration\RegisterEventHandler;

    protected function getParams(): array
    {
        return [
            'from_module' => 'main',
            'event_type' => 'OnAddRatingVote',
            'to_module' => 'bizprofi.reaction',
            'to_class' => 'Bizprofi\Reaction\NotifyEventsHandler',
            'to_method' => 'OnAddRatingVote',
            'sort' => 100,
            'to_path' => '',
            'to_method_arg' => [],
        ];
    }
}
