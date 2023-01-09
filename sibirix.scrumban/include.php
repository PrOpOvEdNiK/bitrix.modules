<?

include(GetLangFileName($GLOBALS["DOCUMENT_ROOT"]."/bitrix/modules/sibirix.scrumban/lang/", "/general.php"));

$arClasses = array(
    "CKanban" => "classes/general/ckanban.php",
    "CKanbanSocnetLogger" => "classes/general/ckanbansocnetlogger.php",
    "Diff" => "classes/include/library/class.Diff.php",
);

$module = new CModule();
$module->AddAutoloadClasses("sibirix.scrumban", $arClasses);

?>
