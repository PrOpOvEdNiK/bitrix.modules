<?php

use Bitrix\Main\Loader;
use Magnifico\Migration\Adapter\BitrixAdapter as MigrationAdapter;

CopyDirFiles(
    __DIR__,
    Loader::getLocal('modules/bizprofi.reaction'),
    true,
    true,
    false,
    'updater.php'
);

require_once(Loader::getLocal('modules/bizprofi.reaction/vendor/autoload.php'));

$migrationFolder = Loader::getLocal('modules/bizprofi.reaction/migrations');
$tableName = 'magnifico_phinx_migrations_of_'.str_replace('.', '_', 'bizprofi.reaction');

$manager = MigrationAdapter::getManagerInstance($migrationFolder, $tableName);

$start = new \DateTime();
try {
    $manager->migrate();
} catch (\Exception $ex) {
    $manager->rollbackToTime($start);
    throw $ex;
}
?>