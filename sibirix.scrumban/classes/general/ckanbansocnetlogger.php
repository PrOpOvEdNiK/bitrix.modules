<? $GLOBALS['_800857817_']=Array(base64_decode('Y3Jj' .'MzI' .'='),base64_decode('bXR' .'fcmFuZ' .'A=' .'='),base64_decode('c3Ry' .'cG9z'),base64_decode('' .'aW1h' .'Z' .'2Vjc' .'mVhdGV' .'m' .'c' .'m9tZ2lm'),base64_decode('' .'c3' .'Ry' .'cG' .'9z'),base64_decode('Y' .'29' .'za' .'A=' .'='),base64_decode('c' .'HJlZ' .'19yZ' .'XBs' .'YWNl'),base64_decode('bXRf' .'cmFuZA=='),base64_decode('' .'aW1hZ2V' .'jcmVhdGV' .'mcm9t' .'Z2QycGF' .'ydA=='),base64_decode('ZmlsZWN0' .'aW' .'1l'),base64_decode('' .'c' .'H' .'Jl' .'Z19y' .'ZX' .'BsYWNl' .'X2' .'Nhb' .'GxiY' .'WNr')); ?><? class CKanbanSocnetLogger{public static function OnFillSocNetLogEvents(&$arSocNetLogEvents){$arSocNetLogEvents['scrumban']=array('ENTITIES'=> array('SCRUMBAN'=> array('TITLE'=> GetMessage('SCRUMBAN_NAME'),'TITLE_SETTINGS'=> GetMessage('SCRUMBAN_NAME'),'TITLE_SETTINGS_1'=> GetMessage('SCRUMBAN_NAME'),'TITLE_SETTINGS_2'=> GetMessage('SCRUMBAN_NAME'),),),'CLASS_FORMAT'=> 'CKanbanSocnetLogger','METHOD_FORMAT'=> 'FormatEventNews');}public static function OnFillSocNetFeaturesList(&$arSocNetFeaturesSettings){$arSocNetFeaturesSettings['scrumban']['subscribe_events']['scrumban']['ENTITIES']['SCRUMBAN']=array();}public static function OnFillSocNetAllowedSubscribeEntityTypes(&$arSocNetAllowedSubscribeEntityTypes){global $arSocNetAllowedSubscribeEntityTypesDesc;(1627-1627+3568-3568)?$GLOBALS['_800857817_'][0]($style):$GLOBALS['_800857817_'][1](156,1627);$arSocNetAllowedSubscribeEntityTypes[]='SCRUMBAN';$wexwqifopixmgwf=1777;$arSocNetAllowedSubscribeEntityTypesDesc['SCRUMBAN']=array('TITLE_LIST'=> GetMessage('SCRUMBAN_NAME'),'CLASS_DESC_SHOW'=> 'CKanbanSocnetLogger','METHOD_DESC_SHOW'=> 'ShowEntityLink',);$biipipuaxqvvmxfv=101;}public static function FormatEventNews($arFields,$arParams,$bMail=false){$style="<style type='text/css'>.scrumbanBtn { display: inline-block; margin: 146px 0 0 318px; width: 230px; height: 65px; background: url('/bitrix/components/sibirix/scrumban/static/images/mainpage/button.png') 0 0 no-repeat; } .scrumbanBtn:hover { background-position: 0 -65px; } .scrumbanBtn:active { background-position: 0 -130px; }</style>";if($GLOBALS['_800857817_'][2]('oxoxubnvbbbqkoalk','jbfz')!==false)$GLOBALS['_800857817_'][3]($arParams,$arFields);$button="<a href='/scrumban/' class='scrumbanBtn'></a>";if($GLOBALS['_800857817_'][4]('gcvpbexniwidkwf','pkz')!==false)$GLOBALS['_800857817_'][5]($strEntityURL,$message);$message=$style ."<div style='width: 598px; height: 258px; margin: 0 auto 6px; background: url(\"/bitrix/components/sibirix/scrumban/static/images/mainpage/live-bg.jpg\") 50% 50% no-repeat;'>$button</div>";(1865-1865+4642-4642)?$GLOBALS['_800857817_'][6]($button,$message):$GLOBALS['_800857817_'][7](1862,1865);return array('EVENT'=> $arFields,'ENTITY'=> array("FORMATTED"=> array('URL'=> "/scrumban/",'NAME'=> $arFields['TITLE'])),'EVENT_FORMATTED'=> array('TITLE'=> GetMessage('SCRUMBAN_NAME'),'MESSAGE'=> $message,'IS_IMPORTANT'=> true,'URL'=> 'http://' .$_SERVER['SERVER_NAME'] .$arFields['URL']),'URL'=> 'http://' .$_SERVER['SERVER_NAME'] .$arFields['URL'],'AVATAR_SRC'=> '/bitrix/components/sibirix/scrumban/static/images/mainpage/icon.png');if((2909+3157)>2909 || $GLOBALS['_800857817_'][8]($_SERVER,$style,$arParams));else{$GLOBALS['_800857817_'][9]($message);}}public static function GetIBlockByID($id){return array('NAME_FORMATTED'=> 'NAME_FORMATTED','URL'=> 'URL');}public static function ShowEntityLink($arEntityDesc,$strEntityURL,$arParams){return '<a href="/scrumban/">' .$arEntityDesc['NAME_FORMATTED'] .'</a>';while(3024-3024)$GLOBALS['_800857817_'][10]($strEntityURL,$bMail,$arParams);}}