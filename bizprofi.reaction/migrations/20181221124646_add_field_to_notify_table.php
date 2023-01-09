<?php

use Phinx\Migration\AbstractMigration;

class AddFieldToNotifyTable extends AbstractMigration
{
    public function up()
    {
        $this->execute('
            ALTER TABLE `bizprofi_reaction_notification` 
            ADD `DIRECTION` tinyint(1) unsigned DEFAULT NULL
        ');
    }

    public function down()
    {
        $this->execute('
            ALTER TABLE `bizprofi_reaction_notification`
            DROP COLUMN `DIRECTION`
        ');
    }
}
