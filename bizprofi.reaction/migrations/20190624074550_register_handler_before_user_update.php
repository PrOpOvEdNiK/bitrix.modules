<?php

use Bizprofi\Tools\Module\Traits\Migration\RegisterEventHandler;
use Phinx\Migration\AbstractMigration;

class RegisterHandlerBeforeUserUpdate extends AbstractMigration
{
    use RegisterEventHandler;

    protected function getParams() : array
    {
        return [
            'from_module' => 'main',
            'event_type' => 'OnBeforeUserUpdate',
            'to_module' => 'bizprofi.reaction',
            'to_class' => 'Bizprofi\\Reaction\\MainEventHandler',
            'to_method' => 'OnBeforeUserUpdate',
        ];
    }
}
