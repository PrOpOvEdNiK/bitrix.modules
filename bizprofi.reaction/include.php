<?php

\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

\Bitrix\Main\Loader::registerAutoLoadClasses('bizprofi.reaction', [
    '\\Bizprofi\\Reaction\\Main' => 'lib/maineventhandler.php',
]);

?><?php
require_once(__DIR__.'/vendor/autoload.php');
?>