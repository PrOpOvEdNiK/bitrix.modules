<?php

use Phinx\Migration\AbstractMigration;

class AddNotificationTableGarbageColumn extends AbstractMigration
{
    public function up()
    {
        $this->execute('
            ALTER TABLE bizprofi_reaction_notification ADD GARBAGE varchar(255);
        ');
    }

    public function down()
    {
        $this->execute('
            ALTER TABLE bizprofi_reaction_notification DROP COLUMN GARBAGE;
        ');
    }
}
