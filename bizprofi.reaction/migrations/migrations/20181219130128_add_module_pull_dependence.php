<?php

use Bizprofi\Tools\Module\Traits\Migration;
use Phinx\Migration\AbstractMigration;

class AddModulePullDependence extends AbstractMigration
{
    use Migration\RegisterEventHandler;

    protected function getParams(): array
    {
        return [
            'from_module' => 'pull',
            'event_type' => 'OnGetDependentModule',
            'to_module' => 'bizprofi.reaction',
            'to_class' => 'Bizprofi\Reaction\Main',
            'to_method' => 'OnGetDependentModule',
            'sort' => 100,
            'to_path' => '',
            'to_method_arg' => [],
        ];
    }
}
