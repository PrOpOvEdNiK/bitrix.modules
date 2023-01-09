<?php

use Bizprofi\Tools\Module\Traits\Migration;
use Phinx\Migration\AbstractMigration;

class AddPageStartHandler extends AbstractMigration
{
    use Migration\RegisterEventHandler;

    protected function getParams(): array
    {
        return [
            'from_module' => 'main',
            'event_type' => 'OnBeforeEndBufferContent',
            'to_module' => 'bizprofi.reaction',
            'to_class' => 'Bizprofi\Reaction\MainEventHandler',
            'to_method' => 'appendScriptsToPage',
            'sort' => 100,
            'to_path' => '',
            'to_method_arg' => [],
        ];
    }
}
