<?php

use Bizprofi\Tools\Module\Traits\Migration;
use Phinx\Migration\AbstractMigration;

class AddBlogDeleteHandler extends AbstractMigration
{
    use Migration\RegisterEventHandler;

    protected function getParams() : array
    {
        return [
            'from_module' => 'blog',
            'event_type' => 'OnCommentDelete',
            'to_module' => 'bizprofi.reaction',
            'to_class' => 'Bizprofi\Reaction\NotifyEventsHandler',
            'to_method' => 'OnBlogDelete',
            'sort' => 100,
            'to_path' => '',
            'to_method_arg' => [],
        ];
    }
}
