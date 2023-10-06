<?php

use Bizprofi\Tools\Module\Traits\Migration;
use Phinx\Migration\AbstractMigration;

class CreateCssLink extends AbstractMigration
{
    use Migration\CreateSymbolicLink;

    /**
     * @return array
     */
    protected function getParams(): array
    {
        return [
            'from' => 'modules/bizprofi.reaction/install/css/bizprofi.reaction',
            'to' => 'css/bizprofi.reaction',
        ];
    }
}
