<?php

use Bizprofi\Tools\Module\Traits\Migration;
use Phinx\Migration\AbstractMigration;

class CreatePublicDirLink extends AbstractMigration
{
    use Migration\CreateSymbolicLink;

    /**
     * @return array
     */
    protected function getParams(): array
    {
        return [
            'from' => 'modules/bizprofi.reaction/install/services/bizprofi.reaction',
            'to' => $_SERVER['DOCUMENT_ROOT'].'/services/bizprofi.reaction',
        ];
    }
}
