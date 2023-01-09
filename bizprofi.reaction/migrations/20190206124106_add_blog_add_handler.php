<?php

use Bizprofi\Tools\Module\Traits\Migration;
use Phinx\Migration\AbstractMigration;

class AddBlogAddHandler extends AbstractMigration
{
    use Migration\RegisterEventHandler;

    protected function getParams() : array
    {
        return [
            'from_module' => 'blog',
            'event_type' => 'OnCommentAdd',
            'to_module' => 'bizprofi.reaction',
            'to_class' => 'Bizprofi\Reaction\NotifyEventsHandler',
            'to_method' => 'OnBlogAdd',
            'sort' => 100,
            'to_path' => '',
            'to_method_arg' => [],
        ];
    }
}
