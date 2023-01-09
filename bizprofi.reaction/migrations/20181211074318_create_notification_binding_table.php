<?php

use Phinx\Migration\AbstractMigration;

class CreateNotificationBindingTable extends AbstractMigration
{
    public function up()
    {
        $this->execute('
            CREATE TABLE `bizprofi_reaction_notification_binding` (
                `NOTIFICATION_ID` int(11) unsigned NOT NULL,
                `ENTITY_TYPE` tinyint(1) unsigned NOT NULL,
                `ENTITY_ID` int(11) unsigned NOT NULL,
                PRIMARY KEY (`NOTIFICATION_ID`, `ENTITY_TYPE`, `ENTITY_ID`),
                CONSTRAINT `bizprofi_reaction_notification_binding_id_fk`
                    FOREIGN KEY (`NOTIFICATION_ID`)
                    REFERENCES `bizprofi_reaction_notification` (`ID`) ON DELETE CASCADE
            )
        ');
    }

    public function down()
    {
        $this->execute('
            DROP TABLE `bizprofi_reaction_notification_binding`
        ');
    }
}
