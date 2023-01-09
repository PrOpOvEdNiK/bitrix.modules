<?php

use Bizprofi\Tools\Module\Traits\Migration;
use Phinx\Migration\AbstractMigration;

class CreateComponentsLink extends AbstractMigration
{
    use Migration\CreateSymbolicLink;

    /**
     * @return array
     */
    protected function getParams(): array
    {
        return [
            'from' => 'modules/bizprofi.reaction/install/components/bizprofi.reaction',
            'to' => 'components/bizprofi.reaction',
        ];
    }
}
