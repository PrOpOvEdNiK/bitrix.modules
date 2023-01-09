<?

include(GetLangFileName($GLOBALS["DOCUMENT_ROOT"]."/bitrix/modules/sibirix.keyrights/lang/", "/general.php"));

$arClasses = array(
    "CKeyrights" => "classes/general/ckeyrights.php",
);

$module = new CModule();
$module->AddAutoloadClasses("sibirix.keyrights", $arClasses);
?>
