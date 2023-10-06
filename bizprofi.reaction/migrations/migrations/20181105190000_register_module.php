<?php

use Bizprofi\Tools\Module\Traits\Migration;
use Phinx\Migration\AbstractMigration;

class RegisterModule extends AbstractMigration
{
    use Migration\RegisterModule;

    /**
     * @return string
     */
    protected function getModuleId(): string
    {
        return 'bizprofi.reaction';
    }
}
