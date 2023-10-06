<?php

use Phinx\Migration\AbstractMigration;

class CreateNotificationTable extends AbstractMigration
{
    public function up()
    {
        $this->execute('
            CREATE TABLE `bizprofi_reaction_notification` (
                `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `FROM_USER` int(11) unsigned DEFAULT NULL,
                `TO_USER` int(11) unsigned DEFAULT NULL,
                `NOTIFICATION` TEXT DEFAULT null,
                `DATE` datetime DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`ID`)
            )
        ');
    }

    public function down()
    {
        $this->execute('
            DROP TABLE `bizprofi_reaction_notification`
        ');
    }
}
