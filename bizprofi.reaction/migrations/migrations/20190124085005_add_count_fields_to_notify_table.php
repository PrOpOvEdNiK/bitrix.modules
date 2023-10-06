<?php

use Phinx\Migration\AbstractMigration;

class AddCountFieldsToNotifyTable extends AbstractMigration
{
    public function up()
    {
        $this->execute('
            CREATE TABLE `bizprofi_reaction_notification_responsibles` (
                `NOTIFICATION_ID` int(11) unsigned NOT NULL,
                `USER_ID` int(11) unsigned NOT NULL,
                `ENTITY_TYPE` tinyint(1) unsigned NOT NULL,
                `ENTITY_ID` int(11) unsigned NOT NULL,
                PRIMARY KEY (`NOTIFICATION_ID`, `USER_ID`, `ENTITY_TYPE`),
                CONSTRAINT `bizprofi_reaction_notification_responsibles_id_fk`
                    FOREIGN KEY (`NOTIFICATION_ID`)
                    REFERENCES `bizprofi_reaction_notification` (`ID`) ON DELETE CASCADE
            )
        ');
    }

    public function down()
    {
        $this->execute('
            DROP TABLE `bizprofi_reaction_notification_responsibles`
        ');
    }
}
