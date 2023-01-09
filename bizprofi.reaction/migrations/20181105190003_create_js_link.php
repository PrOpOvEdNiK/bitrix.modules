<?php

use Bizprofi\Tools\Module\Traits\Migration;
use Phinx\Migration\AbstractMigration;

class CreateJsLink extends AbstractMigration
{
    use Migration\CreateSymbolicLink;

    /**
     * @return array
     */
    protected function getParams(): array
    {
        return [
            'from' => 'modules/bizprofi.reaction/install/js/bizprofi.reaction',
            'to' => 'js/bizprofi.reaction',
        ];
    }
}
