<?php

/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2023 Bitrix
 */

use Bitrix\Main;
use Bitrix\Main\Session\Legacy\HealerEarlySessionStart;

require_once(__DIR__."/bx_root.php");
require_once(__DIR__."/start.php");

$application = Main\HttpApplication::getInstance();
$application->initializeExtendedKernel([
	"get" => $_GET,
	"post" => $_POST,
	"files" => $_FILES,
	"cookie" => $_COOKIE,
	"server" => $_SERVER,
	"env" => $_ENV
]);

if (defined('SITE_ID'))
{
	define('LANG', SITE_ID);
}

$context = $application->getContext();
$context->initializeCulture(defined('LANG') ? LANG : null, defined('LANGUAGE_ID') ? LANGUAGE_ID : null);

// needs to be after culture initialization
$application->start();

// constants for compatibility
$culture = $context->getCulture();
define('SITE_CHARSET', $culture->getCharset());
define('FORMAT_DATE', $culture->getFormatDate());
define('FORMAT_DATETIME', $culture->getFormatDatetime());
define('LANG_CHARSET', SITE_CHARSET);

$site = $context->getSiteObject();
if (!defined('LANG'))
{
	define('LANG', ($site ? $site->getLid() : $context->getLanguage()));
}
define('SITE_DIR', ($site ? $site->getDir() : ''));
if (!defined('SITE_SERVER_NAME'))
{
	define('SITE_SERVER_NAME', ($site ? $site->getServerName() : ''));
}
define('LANG_DIR', SITE_DIR);

if (!defined('LANGUAGE_ID'))
{
	define('LANGUAGE_ID', $context->getLanguage());
}
define('LANG_ADMIN_LID', LANGUAGE_ID);

if (!defined('SITE_ID'))
{
	define('SITE_ID', LANG);
}

/** @global $lang */
$lang = $context->getLanguage();

//define global application object
$GLOBALS["APPLICATION"] = new CMain;

if (!defined("POST_FORM_ACTION_URI"))
{
	define("POST_FORM_ACTION_URI", htmlspecialcharsbx(GetRequestUri()));
}

$GLOBALS["MESS"] = [];
$GLOBALS["ALL_LANG_FILES"] = [];
IncludeModuleLangFile(__DIR__."/tools.php");
IncludeModuleLangFile(__FILE__);

error_reporting(COption::GetOptionInt("main", "error_reporting", E_COMPILE_ERROR | E_ERROR | E_CORE_ERROR | E_PARSE) & ~E_STRICT & ~E_DEPRECATED & ~E_WARNING & ~E_NOTICE);

if (!defined("BX_COMP_MANAGED_CACHE") && COption::GetOptionString("main", "component_managed_cache_on", "Y") <> "N")
{
	define("BX_COMP_MANAGED_CACHE", true);
}

// global functions
require_once(__DIR__."/filter_tools.php");

define('BX_AJAX_PARAM_ID', 'bxajaxid');

/*ZDUyZmZYTJmYmUyZTQ5MTc5MGUyNTIzZGRhZGI3ZDMzZDgzY2I=*/$GLOBALS['_____713528315']= array(base64_decode('R2V0TW9k'.'dWxlRXZlbn'.'Rz'),base64_decode('RX'.'hlY3V0ZU1'.'v'.'ZHVsZUV2ZW5'.'0RXg='));$GLOBALS['____1986864793']= array(base64_decode('ZGVma'.'W5'.'l'),base64_decode('YmFzZTY'.'0X2RlY29k'.'Z'.'Q=='),base64_decode('dW'.'5z'.'ZXJp'.'YWxpe'.'m'.'U='),base64_decode('aX'.'NfYXJyYXk='),base64_decode('aW5fYXJyYXk='),base64_decode(''.'c2VyaWF'.'saXpl'),base64_decode('YmFzZTY0X2'.'V'.'uY'.'29k'.'ZQ=='),base64_decode(''.'bW'.'t0a'.'W1'.'l'),base64_decode('Z'.'G'.'F0Z'.'Q'.'=='),base64_decode('Z'.'GF0ZQ=='),base64_decode('c3'.'Ry'.'bGVu'),base64_decode('b'.'Wt0aW1l'),base64_decode('ZG'.'F0ZQ=='),base64_decode(''.'Z'.'G'.'F0ZQ='.'='),base64_decode('bWV0'.'aG9kX2V4a'.'X'.'N0cw=='),base64_decode('Y2FsbF'.'91c2VyX2Z1bm'.'Nf'.'YXJ'.'yYXk'.'='),base64_decode('c'.'3'.'RybGV'.'u'),base64_decode('c'.'2'.'Vya'.'W'.'FsaX'.'pl'),base64_decode(''.'Y'.'mFzZ'.'TY0'.'X2V'.'uY'.'2'.'9'.'kZQ=='),base64_decode('c'.'3RybGVu'),base64_decode(''.'aXNfY'.'XJ'.'yYXk='),base64_decode('c2V'.'y'.'a'.'W'.'Fsa'.'Xpl'),base64_decode(''.'Ym'.'F'.'zZTY0'.'X2'.'VuY29'.'kZ'.'Q=='),base64_decode(''.'c2'.'Vya'.'WFs'.'aX'.'p'.'l'),base64_decode('YmFzZ'.'TY'.'0'.'X2V'.'uY29kZQ'.'=='),base64_decode('aXNfY'.'XJyYX'.'k'.'='),base64_decode('a'.'XNf'.'YXJy'.'YXk'.'='),base64_decode('aW5fYXJy'.'Y'.'Xk='),base64_decode('aW5fYXJyY'.'X'.'k='),base64_decode('bWt0aW1l'),base64_decode('Z'.'G'.'F0ZQ=='),base64_decode('Z'.'GF0ZQ'.'='.'='),base64_decode('ZGF0ZQ'.'=='),base64_decode('bW'.'t0a'.'W1l'),base64_decode(''.'ZG'.'F0'.'ZQ=='),base64_decode('ZGF0'.'ZQ=='),base64_decode('aW'.'5fYXJy'.'YXk='),base64_decode('c2VyaWFs'.'aXpl'),base64_decode('Ym'.'F'.'zZTY0'.'X2VuY2'.'9'.'kZQ=='),base64_decode('aW50'.'dmFs'),base64_decode('dGl'.'tZQ=='),base64_decode('Zm'.'ls'.'Z'.'V'.'9leGl'.'zdHM='),base64_decode('c3RyX3Jl'.'cGxh'.'Y2U='),base64_decode('Y2'.'x'.'hc3NfZXhpc3'.'Rz'),base64_decode('ZGVmaW5l'));if(!function_exists(__NAMESPACE__.'\\___1536721661')){function ___1536721661($_1233913830){static $_476834829= false; if($_476834829 == false) $_476834829=array('SU5UU'.'kFO'.'R'.'VRf'.'RURJVEl'.'PTg==','WQ'.'='.'=','b'.'WF'.'p'.'bg='.'=',''.'f'.'mNwZl'.'9tYX'.'Bfd'.'m'.'Fsd'.'WU'.'=','','',''.'YWxsb'.'3'.'dl'.'ZF9jbGFzc2Vz','Z'.'Q='.'=','Zg==','Z'.'Q==','R'.'g==',''.'WA==',''.'Zg='.'=','b'.'WFpbg'.'==','fmN'.'wZl9tYXBfd'.'mFsd'.'WU=','UG9ydGFs','Rg'.'==',''.'ZQ='.'=','Z'.'Q'.'='.'=',''.'WA'.'==','R'.'g'.'==','RA==',''.'R'.'A==',''.'bQ==','ZA==','WQ==','Zg==','Zg==','Z'.'g==','Z'.'g==','UG9ydGFs','Rg==','Z'.'Q==','Z'.'Q==','WA'.'==','Rg'.'==','R'.'A==','RA==','b'.'Q='.'=','Z'.'A='.'=','WQ==','bW'.'Fpbg'.'='.'=','T24=','U2V0dGluZ'.'3ND'.'aGFuZ2U=','Zg==','Zg'.'==','Zg==','Z'.'g==',''.'bWFpbg'.'==',''.'fmN'.'wZl9tYXBf'.'dmFsd'.'WU'.'=','ZQ'.'==','ZQ='.'=','RA'.'==','ZQ'.'==','ZQ==',''.'Zg==','Zg==','Z'.'g==','ZQ='.'=','b'.'W'.'F'.'pbg==','fmNw'.'Z'.'l9tYXB'.'fd'.'m'.'FsdWU=','ZQ==','Zg'.'==',''.'Zg='.'=',''.'Z'.'g==','Zg==','bWFpb'.'g==','fmNwZl9tYXB'.'fdmFsdWU=','ZQ==','Zg'.'==',''.'U'.'G9yd'.'G'.'F'.'s','UG9'.'ydGFs','ZQ='.'=','ZQ='.'=','UG'.'9yd'.'GFs','R'.'g==','WA==','Rg==','RA='.'=','ZQ==',''.'ZQ==','RA'.'==','bQ==','Z'.'A==','WQ'.'==','ZQ==','WA==','ZQ'.'==','Rg==',''.'ZQ'.'==','RA==','Zg='.'=','ZQ==','RA==','ZQ'.'==','b'.'Q==','ZA==','WQ==',''.'Zg==','Zg='.'=',''.'Zg==','Zg='.'=','Zg='.'=','Z'.'g='.'=',''.'Zg==',''.'Zg==','bWFpb'.'g'.'==','fmN'.'wZl'.'9'.'tY'.'XB'.'fdmFsdWU=','ZQ==','ZQ'.'==','UG'.'9ydG'.'Fs','Rg='.'=','WA'.'==','V'.'FlQR'.'Q='.'=','REFUR'.'Q='.'=',''.'RkVB'.'VFVSRVM=','R'.'VhQSVJFRA='.'=','VFlQRQ'.'='.'=','R'.'A==',''.'VFJZX'.'0'.'R'.'BWVNfQ09V'.'TlQ=','REF'.'URQ==','VF'.'JZX0R'.'BWVNfQ09VTl'.'Q'.'=',''.'RVhQSVJ'.'FRA'.'==','RkVBV'.'FV'.'S'.'RVM'.'=','Zg==','Z'.'g==','RE9'.'DVU'.'1FTlRfUk9PVA==','L2'.'Jpd'.'H'.'JpeC9'.'tb'.'2R1bG'.'VzL'.'w==','L2lu'.'c'.'3Rhb'.'GwvaW5kZXgucGhw','L'.'g='.'=','Xw==','c'.'2VhcmNo','Tg'.'==','','','QUNUSVZF','WQ==','c'.'29jaW'.'Fsb'.'mV0d'.'29y'.'aw==',''.'YWxsb'.'3dfZnJp'.'ZWxkcw='.'=','WQ==','SUQ=','c'.'29jaWFsbmV0d29'.'yaw==','Y'.'Wxsb3dfZnJ'.'p'.'ZWxkcw==','SUQ=',''.'c29jaWFsbmV0'.'d2'.'9yaw==','YW'.'xsb3dfZnJpZWx'.'kcw==',''.'T'.'g='.'=','','','QU'.'NUSVZF',''.'WQ==','c29'.'jaW'.'Fs'.'bmV0d29ya'.'w==','YWxsb3d'.'fbWljcm9ibG9nX'.'3VzZX'.'I=','WQ==','S'.'UQ'.'=',''.'c29j'.'aWF'.'sbmV0d29'.'yaw==','YWx'.'s'.'b3'.'dfbWljcm9ib'.'G9nX3VzZXI=','SUQ=','c29jaWFs'.'bmV0d2'.'9yaw==','YWxsb3dfbW'.'ljcm'.'9ibG9n'.'X3VzZX'.'I=','c29jaWFs'.'b'.'mV0d29yaw==',''.'Y'.'Wxsb3'.'dfbWljcm'.'9i'.'b'.'G9nX2dyb3V'.'w','WQ'.'==','SUQ=',''.'c29jaWFs'.'bmV0d2'.'9'.'ya'.'w'.'==','YWxsb3dfb'.'Wljcm9i'.'b'.'G9nX'.'2dyb3Vw',''.'SUQ'.'=','c2'.'9j'.'a'.'WF'.'s'.'bm'.'V0d2'.'9yaw==','YW'.'xsb'.'3dfbWljc'.'m9ib'.'G9n'.'X2dyb3'.'V'.'w','Tg='.'=','','','QUNUSVZF','WQ==',''.'c29'.'jaWFs'.'b'.'m'.'V0'.'d2'.'9yaw==','YWxs'.'b3'.'dfZm'.'lsZXNfdXNlcg==','WQ'.'==',''.'SU'.'Q=','c'.'29ja'.'W'.'FsbmV0d29ya'.'w==',''.'YWxsb3dfZmlsZXN'.'fdXNlcg'.'==','SUQ=','c'.'29j'.'a'.'W'.'FsbmV'.'0d29yaw'.'==',''.'YWx'.'sb3dfZm'.'lsZXNfdXN'.'lcg='.'=','Tg==','','','QUN'.'USVZF','WQ='.'=','c29'.'jaWFsbm'.'V0d29ya'.'w'.'==','YWx'.'sb3df'.'Ym'.'xvZ191'.'c2Vy','WQ==','SUQ=','c29'.'jaWFsb'.'mV'.'0d29yaw'.'==','YWxsb3'.'dfYm'.'xvZ1'.'9'.'1c2Vy','SUQ=','c29jaWFsb'.'m'.'V0d29yaw==','YWxsb3dfYmx'.'v'.'Z191c2V'.'y','Tg='.'=','','','QUNUSVZF','W'.'Q==',''.'c'.'29jaW'.'Fsb'.'mV0d29y'.'a'.'w==','Y'.'Wx'.'sb3dfcGhvdG9fdXNlcg'.'='.'=','WQ==','SUQ=','c29ja'.'W'.'Fsbm'.'V'.'0d29yaw==',''.'YWxs'.'b3dfcGhv'.'dG9fdXNlcg==','SU'.'Q=','c2'.'9jaWF'.'sbm'.'V0d29'.'yaw==','YWxs'.'b3dfcG'.'hvdG9fdXNlcg==','Tg==','','','QU'.'NUSVZF','WQ==','c2'.'9jaW'.'F'.'sbmV0d2'.'9yaw==','Y'.'Wxsb3dfZm9yd'.'W1fdXN'.'lcg==','W'.'Q==','S'.'UQ=','c2'.'9j'.'aWFs'.'bmV0'.'d29yaw'.'==','YWxsb3dfZm9yd'.'W1fdXNlcg'.'==','SUQ=',''.'c29jaW'.'F'.'sbmV0d29yaw'.'==','YW'.'xsb3dfZm9yd'.'W'.'1fdXNlcg==','Tg==','','','QU'.'NU'.'S'.'V'.'ZF',''.'WQ==',''.'c29j'.'aWF'.'sb'.'m'.'V0d2'.'9yaw==','YW'.'xs'.'b3dfdGFza3NfdXNl'.'cg==','WQ==',''.'SUQ=','c29'.'ja'.'WFs'.'bmV0d29yaw'.'==','Y'.'W'.'xs'.'b3d'.'f'.'dGF'.'za3'.'Nf'.'d'.'X'.'Nlcg==','SUQ'.'=','c29jaW'.'Fs'.'bmV0d2'.'9'.'yaw='.'=',''.'YWxsb3dfd'.'GFza3Nf'.'dX'.'Nl'.'cg==','c2'.'9jaWFsbmV0d29ya'.'w==','YW'.'xsb'.'3dfdGFza3NfZ'.'3J'.'vd'.'XA=','WQ==','SUQ=',''.'c29jaWFsbmV0d29'.'y'.'aw'.'==',''.'YWxs'.'b'.'3d'.'fdGF'.'z'.'a'.'3'.'NfZ3JvdXA'.'=','SU'.'Q'.'=','c29jaWFsb'.'m'.'V0'.'d'.'29ya'.'w==','YWxsb'.'3dfdGFza'.'3NfZ3JvdXA=','dGFza3M=','Tg'.'==','','','QUNUSVZF','WQ==','c29jaWF'.'sbmV0d29ya'.'w'.'==','YWxs'.'b'.'3d'.'fY2FsZW5kYXJfdX'.'Nlcg==','WQ==','SUQ=','c29jaWFsbmV0d29ya'.'w==','YWxs'.'b'.'3dfY2F'.'sZW5kYX'.'Jf'.'d'.'XNlcg==','SUQ=','c2'.'9jaW'.'FsbmV'.'0d29y'.'a'.'w==','YW'.'x'.'sb'.'3dfY2FsZ'.'W5kYX'.'JfdX'.'Nlcg='.'=','c29ja'.'WFsbmV0d'.'29yaw==','YWxsb3'.'dfY2'.'F'.'sZW5'.'kYX'.'Jf'.'Z'.'3JvdXA=',''.'WQ==','SU'.'Q'.'=','c29j'.'a'.'WFsbmV0d'.'29yaw'.'==',''.'YWxs'.'b3df'.'Y'.'2'.'FsZW5k'.'Y'.'XJfZ'.'3JvdXA=','SUQ=','c29jaWFsbm'.'V0d29yaw==','Y'.'W'.'x'.'sb3'.'dfY2F'.'s'.'ZW5kYXJfZ3J'.'vdXA'.'=',''.'QUN'.'USVZF',''.'W'.'Q==',''.'Tg='.'=',''.'ZXh0'.'c'.'mFuZX'.'Q=','a'.'WJsb2Nr','T25BZnRlckl'.'CbG'.'9ja0'.'V'.'sZW1lbnR'.'VcGRhdG'.'U=','aW'.'50cmFuZXQ=',''.'Q'.'0'.'lud'.'HJhbmV0RXZ'.'lbnRIYW5'.'k'.'bG'.'Vycw'.'='.'=','U1BS'.'ZWd'.'pc3R'.'l'.'clVwZGF0ZWRJ'.'dG'.'Vt','Q0l'.'udHJhbmV0U2hhcmV'.'wb2'.'ludDo'.'6Q'.'Wdl'.'b'.'nRMaXN0c'.'ygp'.'Ow==',''.'a'.'W50cmFuZXQ=','Tg==','Q0ludHJhb'.'mV0U2hhcm'.'Vwb'.'2'.'lud'.'D'.'o6QWdl'.'bnRR'.'dWV1ZSg'.'pOw'.'==','aW50'.'c'.'m'.'FuZXQ'.'=','T'.'g==','Q0ludHJhb'.'m'.'V0U2'.'h'.'hcmVw'.'b2ludDo'.'6Q'.'Wdl'.'bnRVcGRhdGUoK'.'Ts=',''.'a'.'W50cmFu'.'ZXQ=',''.'Tg==','aWJsb2Nr','T2'.'5BZnR'.'lck'.'lCbG9j'.'a'.'0V'.'s'.'ZW1'.'lbnRBZGQ=','aW'.'50cm'.'F'.'uZXQ=','Q0lu'.'dH'.'J'.'hbmV0R'.'XZlbn'.'RIY'.'W'.'5kbGVycw='.'=','U1BSZW'.'dp'.'c'.'3'.'Rl'.'c'.'l'.'Vw'.'ZGF0Z'.'WRJdGVt',''.'aWJsb'.'2Nr',''.'T25BZnR'.'lcklCbG9ja'.'0'.'VsZ'.'W1l'.'bnRVc'.'GRhdGU=','aW50c'.'mFuZXQ=','Q0ludHJhb'.'mV0'.'RXZlbnRIYW5kbGV'.'ycw'.'==',''.'U1BSZW'.'dpc3R'.'lclVw'.'ZGF0ZW'.'RJdGVt',''.'Q0ludHJhbmV0U'.'2h'.'hcmVw'.'b2'.'l'.'udDo6QWd'.'l'.'bnRMaXN0cyg'.'p'.'Ow='.'=','a'.'W50cmFuZXQ=','Q0l'.'udHJhbmV0U2'.'hhcmVw'.'b2ludDo6'.'Q'.'Wdl'.'bnRRdWV1ZSgpOw==','a'.'W50cmFu'.'ZXQ=','Q0l'.'udHJhbmV0U2hhcmVwb'.'2ludD'.'o'.'6QWdlbnRVcG'.'R'.'hdGUoK'.'Ts=','a'.'W50cmFuZXQ=','Y3Jt',''.'bW'.'Fpbg'.'==','T25CZWZv'.'c'.'mVQcm9sb2c=','bWFpbg'.'==','Q1dpemFyZFNvb'.'FB'.'hb'.'m'.'V'.'s'.'SW50c'.'m'.'FuZXQ=','U2hvd1Bh'.'bmVs','L21'.'v'.'ZHVs'.'Z'.'XM'.'vaW5'.'0c'.'mFuZ'.'XQvcG'.'FuZ'.'WxfYnV0'.'dG9uLnBo'.'cA==','R'.'U5DT0'.'R'.'F','WQ==');return base64_decode($_476834829[$_1233913830]);}};$GLOBALS['____1986864793'][0](___1536721661(0), ___1536721661(1));class CBXFeatures{ private static $_1627486871= 30; private static $_325015979= array( "Portal" => array( "CompanyCalendar", "CompanyPhoto", "CompanyVideo", "CompanyCareer", "StaffChanges", "StaffAbsence", "CommonDocuments", "MeetingRoomBookingSystem", "Wiki", "Learning", "Vote", "WebLink", "Subscribe", "Friends", "PersonalFiles", "PersonalBlog", "PersonalPhoto", "PersonalForum", "Blog", "Forum", "Gallery", "Board", "MicroBlog", "WebMessenger",), "Communications" => array( "Tasks", "Calendar", "Workgroups", "Jabber", "VideoConference", "Extranet", "SMTP", "Requests", "DAV", "intranet_sharepoint", "timeman", "Idea", "Meeting", "EventList", "Salary", "XDImport",), "Enterprise" => array( "BizProc", "Lists", "Support", "Analytics", "crm", "Controller", "LdapUnlimitedUsers",), "Holding" => array( "Cluster", "MultiSites",),); private static $_2620581= null; private static $_326443499= null; private static function __588251546(){ if(self::$_2620581 === null){ self::$_2620581= array(); foreach(self::$_325015979 as $_295670170 => $_628021388){ foreach($_628021388 as $_443867567) self::$_2620581[$_443867567]= $_295670170;}} if(self::$_326443499 === null){ self::$_326443499= array(); $_234211545= COption::GetOptionString(___1536721661(2), ___1536721661(3), ___1536721661(4)); if($_234211545 != ___1536721661(5)){ $_234211545= $GLOBALS['____1986864793'][1]($_234211545); $_234211545= $GLOBALS['____1986864793'][2]($_234211545,[___1536721661(6) => false]); if($GLOBALS['____1986864793'][3]($_234211545)){ self::$_326443499= $_234211545;}} if(empty(self::$_326443499)){ self::$_326443499= array(___1536721661(7) => array(), ___1536721661(8) => array());}}} public static function InitiateEditionsSettings($_1287861200){ self::__588251546(); $_626841318= array(); foreach(self::$_325015979 as $_295670170 => $_628021388){ $_1064613899= $GLOBALS['____1986864793'][4]($_295670170, $_1287861200); self::$_326443499[___1536721661(9)][$_295670170]=($_1064613899? array(___1536721661(10)): array(___1536721661(11))); foreach($_628021388 as $_443867567){ self::$_326443499[___1536721661(12)][$_443867567]= $_1064613899; if(!$_1064613899) $_626841318[]= array($_443867567, false);}} $_291476381= $GLOBALS['____1986864793'][5](self::$_326443499); $_291476381= $GLOBALS['____1986864793'][6]($_291476381); COption::SetOptionString(___1536721661(13), ___1536721661(14), $_291476381); foreach($_626841318 as $_765166925) self::__1025620829($_765166925[(1264/2-632)], $_765166925[round(0+0.25+0.25+0.25+0.25)]);} public static function IsFeatureEnabled($_443867567){ if($_443867567 == '') return true; self::__588251546(); if(!isset(self::$_2620581[$_443867567])) return true; if(self::$_2620581[$_443867567] == ___1536721661(15)) $_828234853= array(___1536721661(16)); elseif(isset(self::$_326443499[___1536721661(17)][self::$_2620581[$_443867567]])) $_828234853= self::$_326443499[___1536721661(18)][self::$_2620581[$_443867567]]; else $_828234853= array(___1536721661(19)); if($_828234853[(138*2-276)] != ___1536721661(20) && $_828234853[min(6,0,2)] != ___1536721661(21)){ return false;} elseif($_828234853[min(174,0,58)] == ___1536721661(22)){ if($_828234853[round(0+1)]< $GLOBALS['____1986864793'][7]((231*2-462),(804-2*402),(936-2*468), Date(___1536721661(23)), $GLOBALS['____1986864793'][8](___1536721661(24))- self::$_1627486871, $GLOBALS['____1986864793'][9](___1536721661(25)))){ if(!isset($_828234853[round(0+0.4+0.4+0.4+0.4+0.4)]) ||!$_828234853[round(0+2)]) self::__1677485748(self::$_2620581[$_443867567]); return false;}} return!isset(self::$_326443499[___1536721661(26)][$_443867567]) || self::$_326443499[___1536721661(27)][$_443867567];} public static function IsFeatureInstalled($_443867567){ if($GLOBALS['____1986864793'][10]($_443867567) <= 0) return true; self::__588251546(); return(isset(self::$_326443499[___1536721661(28)][$_443867567]) && self::$_326443499[___1536721661(29)][$_443867567]);} public static function IsFeatureEditable($_443867567){ if($_443867567 == '') return true; self::__588251546(); if(!isset(self::$_2620581[$_443867567])) return true; if(self::$_2620581[$_443867567] == ___1536721661(30)) $_828234853= array(___1536721661(31)); elseif(isset(self::$_326443499[___1536721661(32)][self::$_2620581[$_443867567]])) $_828234853= self::$_326443499[___1536721661(33)][self::$_2620581[$_443867567]]; else $_828234853= array(___1536721661(34)); if($_828234853[(1360/2-680)] != ___1536721661(35) && $_828234853[(176*2-352)] != ___1536721661(36)){ return false;} elseif($_828234853[(202*2-404)] == ___1536721661(37)){ if($_828234853[round(0+0.2+0.2+0.2+0.2+0.2)]< $GLOBALS['____1986864793'][11]((930-2*465),(151*2-302), min(148,0,49.333333333333), Date(___1536721661(38)), $GLOBALS['____1986864793'][12](___1536721661(39))- self::$_1627486871, $GLOBALS['____1986864793'][13](___1536721661(40)))){ if(!isset($_828234853[round(0+0.4+0.4+0.4+0.4+0.4)]) ||!$_828234853[round(0+2)]) self::__1677485748(self::$_2620581[$_443867567]); return false;}} return true;} private static function __1025620829($_443867567, $_487617675){ if($GLOBALS['____1986864793'][14]("CBXFeatures", "On".$_443867567."SettingsChange")) $GLOBALS['____1986864793'][15](array("CBXFeatures", "On".$_443867567."SettingsChange"), array($_443867567, $_487617675)); $_1931823056= $GLOBALS['_____713528315'][0](___1536721661(41), ___1536721661(42).$_443867567.___1536721661(43)); while($_544448572= $_1931823056->Fetch()) $GLOBALS['_____713528315'][1]($_544448572, array($_443867567, $_487617675));} public static function SetFeatureEnabled($_443867567, $_487617675= true, $_1194611115= true){ if($GLOBALS['____1986864793'][16]($_443867567) <= 0) return; if(!self::IsFeatureEditable($_443867567)) $_487617675= false; $_487617675= (bool)$_487617675; self::__588251546(); $_1201650212=(!isset(self::$_326443499[___1536721661(44)][$_443867567]) && $_487617675 || isset(self::$_326443499[___1536721661(45)][$_443867567]) && $_487617675 != self::$_326443499[___1536721661(46)][$_443867567]); self::$_326443499[___1536721661(47)][$_443867567]= $_487617675; $_291476381= $GLOBALS['____1986864793'][17](self::$_326443499); $_291476381= $GLOBALS['____1986864793'][18]($_291476381); COption::SetOptionString(___1536721661(48), ___1536721661(49), $_291476381); if($_1201650212 && $_1194611115) self::__1025620829($_443867567, $_487617675);} private static function __1677485748($_295670170){ if($GLOBALS['____1986864793'][19]($_295670170) <= 0 || $_295670170 == "Portal") return; self::__588251546(); if(!isset(self::$_326443499[___1536721661(50)][$_295670170]) || self::$_326443499[___1536721661(51)][$_295670170][(932-2*466)] != ___1536721661(52)) return; if(isset(self::$_326443499[___1536721661(53)][$_295670170][round(0+1+1)]) && self::$_326443499[___1536721661(54)][$_295670170][round(0+2)]) return; $_626841318= array(); if(isset(self::$_325015979[$_295670170]) && $GLOBALS['____1986864793'][20](self::$_325015979[$_295670170])){ foreach(self::$_325015979[$_295670170] as $_443867567){ if(isset(self::$_326443499[___1536721661(55)][$_443867567]) && self::$_326443499[___1536721661(56)][$_443867567]){ self::$_326443499[___1536721661(57)][$_443867567]= false; $_626841318[]= array($_443867567, false);}} self::$_326443499[___1536721661(58)][$_295670170][round(0+2)]= true;} $_291476381= $GLOBALS['____1986864793'][21](self::$_326443499); $_291476381= $GLOBALS['____1986864793'][22]($_291476381); COption::SetOptionString(___1536721661(59), ___1536721661(60), $_291476381); foreach($_626841318 as $_765166925) self::__1025620829($_765166925[min(114,0,38)], $_765166925[round(0+0.25+0.25+0.25+0.25)]);} public static function ModifyFeaturesSettings($_1287861200, $_628021388){ self::__588251546(); foreach($_1287861200 as $_295670170 => $_1847071999) self::$_326443499[___1536721661(61)][$_295670170]= $_1847071999; $_626841318= array(); foreach($_628021388 as $_443867567 => $_487617675){ if(!isset(self::$_326443499[___1536721661(62)][$_443867567]) && $_487617675 || isset(self::$_326443499[___1536721661(63)][$_443867567]) && $_487617675 != self::$_326443499[___1536721661(64)][$_443867567]) $_626841318[]= array($_443867567, $_487617675); self::$_326443499[___1536721661(65)][$_443867567]= $_487617675;} $_291476381= $GLOBALS['____1986864793'][23](self::$_326443499); $_291476381= $GLOBALS['____1986864793'][24]($_291476381); COption::SetOptionString(___1536721661(66), ___1536721661(67), $_291476381); self::$_326443499= false; foreach($_626841318 as $_765166925) self::__1025620829($_765166925[min(62,0,20.666666666667)], $_765166925[round(0+0.5+0.5)]);} public static function SaveFeaturesSettings($_1100780544, $_529252022){ self::__588251546(); $_1598229308= array(___1536721661(68) => array(), ___1536721661(69) => array()); if(!$GLOBALS['____1986864793'][25]($_1100780544)) $_1100780544= array(); if(!$GLOBALS['____1986864793'][26]($_529252022)) $_529252022= array(); if(!$GLOBALS['____1986864793'][27](___1536721661(70), $_1100780544)) $_1100780544[]= ___1536721661(71); foreach(self::$_325015979 as $_295670170 => $_628021388){ if(isset(self::$_326443499[___1536721661(72)][$_295670170])){ $_914153061= self::$_326443499[___1536721661(73)][$_295670170];} else{ $_914153061=($_295670170 == ___1536721661(74)? array(___1536721661(75)): array(___1536721661(76)));} if($_914153061[(1072/2-536)] == ___1536721661(77) || $_914153061[(139*2-278)] == ___1536721661(78)){ $_1598229308[___1536721661(79)][$_295670170]= $_914153061;} else{ if($GLOBALS['____1986864793'][28]($_295670170, $_1100780544)) $_1598229308[___1536721661(80)][$_295670170]= array(___1536721661(81), $GLOBALS['____1986864793'][29]((816-2*408),(840-2*420),(832-2*416), $GLOBALS['____1986864793'][30](___1536721661(82)), $GLOBALS['____1986864793'][31](___1536721661(83)), $GLOBALS['____1986864793'][32](___1536721661(84)))); else $_1598229308[___1536721661(85)][$_295670170]= array(___1536721661(86));}} $_626841318= array(); foreach(self::$_2620581 as $_443867567 => $_295670170){ if($_1598229308[___1536721661(87)][$_295670170][(826-2*413)] != ___1536721661(88) && $_1598229308[___1536721661(89)][$_295670170][min(72,0,24)] != ___1536721661(90)){ $_1598229308[___1536721661(91)][$_443867567]= false;} else{ if($_1598229308[___1536721661(92)][$_295670170][(1336/2-668)] == ___1536721661(93) && $_1598229308[___1536721661(94)][$_295670170][round(0+0.25+0.25+0.25+0.25)]< $GLOBALS['____1986864793'][33]((1368/2-684),(1016/2-508), min(162,0,54), Date(___1536721661(95)), $GLOBALS['____1986864793'][34](___1536721661(96))- self::$_1627486871, $GLOBALS['____1986864793'][35](___1536721661(97)))) $_1598229308[___1536721661(98)][$_443867567]= false; else $_1598229308[___1536721661(99)][$_443867567]= $GLOBALS['____1986864793'][36]($_443867567, $_529252022); if(!isset(self::$_326443499[___1536721661(100)][$_443867567]) && $_1598229308[___1536721661(101)][$_443867567] || isset(self::$_326443499[___1536721661(102)][$_443867567]) && $_1598229308[___1536721661(103)][$_443867567] != self::$_326443499[___1536721661(104)][$_443867567]) $_626841318[]= array($_443867567, $_1598229308[___1536721661(105)][$_443867567]);}} $_291476381= $GLOBALS['____1986864793'][37]($_1598229308); $_291476381= $GLOBALS['____1986864793'][38]($_291476381); COption::SetOptionString(___1536721661(106), ___1536721661(107), $_291476381); self::$_326443499= false; foreach($_626841318 as $_765166925) self::__1025620829($_765166925[(768-2*384)], $_765166925[round(0+0.33333333333333+0.33333333333333+0.33333333333333)]);} public static function GetFeaturesList(){ self::__588251546(); $_583036634= array(); foreach(self::$_325015979 as $_295670170 => $_628021388){ if(isset(self::$_326443499[___1536721661(108)][$_295670170])){ $_914153061= self::$_326443499[___1536721661(109)][$_295670170];} else{ $_914153061=($_295670170 == ___1536721661(110)? array(___1536721661(111)): array(___1536721661(112)));} $_583036634[$_295670170]= array( ___1536721661(113) => $_914153061[(1020/2-510)], ___1536721661(114) => $_914153061[round(0+0.2+0.2+0.2+0.2+0.2)], ___1536721661(115) => array(),); $_583036634[$_295670170][___1536721661(116)]= false; if($_583036634[$_295670170][___1536721661(117)] == ___1536721661(118)){ $_583036634[$_295670170][___1536721661(119)]= $GLOBALS['____1986864793'][39](($GLOBALS['____1986864793'][40]()- $_583036634[$_295670170][___1536721661(120)])/ round(0+43200+43200)); if($_583036634[$_295670170][___1536721661(121)]> self::$_1627486871) $_583036634[$_295670170][___1536721661(122)]= true;} foreach($_628021388 as $_443867567) $_583036634[$_295670170][___1536721661(123)][$_443867567]=(!isset(self::$_326443499[___1536721661(124)][$_443867567]) || self::$_326443499[___1536721661(125)][$_443867567]);} return $_583036634;} private static function __1636128402($_1894149674, $_1090235697){ if(IsModuleInstalled($_1894149674) == $_1090235697) return true; $_241210275= $_SERVER[___1536721661(126)].___1536721661(127).$_1894149674.___1536721661(128); if(!$GLOBALS['____1986864793'][41]($_241210275)) return false; include_once($_241210275); $_876096656= $GLOBALS['____1986864793'][42](___1536721661(129), ___1536721661(130), $_1894149674); if(!$GLOBALS['____1986864793'][43]($_876096656)) return false; $_2085215209= new $_876096656; if($_1090235697){ if(!$_2085215209->InstallDB()) return false; $_2085215209->InstallEvents(); if(!$_2085215209->InstallFiles()) return false;} else{ if(CModule::IncludeModule(___1536721661(131))) CSearch::DeleteIndex($_1894149674); UnRegisterModule($_1894149674);} return true;} protected static function OnRequestsSettingsChange($_443867567, $_487617675){ self::__1636128402("form", $_487617675);} protected static function OnLearningSettingsChange($_443867567, $_487617675){ self::__1636128402("learning", $_487617675);} protected static function OnJabberSettingsChange($_443867567, $_487617675){ self::__1636128402("xmpp", $_487617675);} protected static function OnVideoConferenceSettingsChange($_443867567, $_487617675){ self::__1636128402("video", $_487617675);} protected static function OnBizProcSettingsChange($_443867567, $_487617675){ self::__1636128402("bizprocdesigner", $_487617675);} protected static function OnListsSettingsChange($_443867567, $_487617675){ self::__1636128402("lists", $_487617675);} protected static function OnWikiSettingsChange($_443867567, $_487617675){ self::__1636128402("wiki", $_487617675);} protected static function OnSupportSettingsChange($_443867567, $_487617675){ self::__1636128402("support", $_487617675);} protected static function OnControllerSettingsChange($_443867567, $_487617675){ self::__1636128402("controller", $_487617675);} protected static function OnAnalyticsSettingsChange($_443867567, $_487617675){ self::__1636128402("statistic", $_487617675);} protected static function OnVoteSettingsChange($_443867567, $_487617675){ self::__1636128402("vote", $_487617675);} protected static function OnFriendsSettingsChange($_443867567, $_487617675){ if($_487617675) $_260548381= "Y"; else $_260548381= ___1536721661(132); $_1835377393= CSite::GetList(___1536721661(133), ___1536721661(134), array(___1536721661(135) => ___1536721661(136))); while($_1005145921= $_1835377393->Fetch()){ if(COption::GetOptionString(___1536721661(137), ___1536721661(138), ___1536721661(139), $_1005145921[___1536721661(140)]) != $_260548381){ COption::SetOptionString(___1536721661(141), ___1536721661(142), $_260548381, false, $_1005145921[___1536721661(143)]); COption::SetOptionString(___1536721661(144), ___1536721661(145), $_260548381);}}} protected static function OnMicroBlogSettingsChange($_443867567, $_487617675){ if($_487617675) $_260548381= "Y"; else $_260548381= ___1536721661(146); $_1835377393= CSite::GetList(___1536721661(147), ___1536721661(148), array(___1536721661(149) => ___1536721661(150))); while($_1005145921= $_1835377393->Fetch()){ if(COption::GetOptionString(___1536721661(151), ___1536721661(152), ___1536721661(153), $_1005145921[___1536721661(154)]) != $_260548381){ COption::SetOptionString(___1536721661(155), ___1536721661(156), $_260548381, false, $_1005145921[___1536721661(157)]); COption::SetOptionString(___1536721661(158), ___1536721661(159), $_260548381);} if(COption::GetOptionString(___1536721661(160), ___1536721661(161), ___1536721661(162), $_1005145921[___1536721661(163)]) != $_260548381){ COption::SetOptionString(___1536721661(164), ___1536721661(165), $_260548381, false, $_1005145921[___1536721661(166)]); COption::SetOptionString(___1536721661(167), ___1536721661(168), $_260548381);}}} protected static function OnPersonalFilesSettingsChange($_443867567, $_487617675){ if($_487617675) $_260548381= "Y"; else $_260548381= ___1536721661(169); $_1835377393= CSite::GetList(___1536721661(170), ___1536721661(171), array(___1536721661(172) => ___1536721661(173))); while($_1005145921= $_1835377393->Fetch()){ if(COption::GetOptionString(___1536721661(174), ___1536721661(175), ___1536721661(176), $_1005145921[___1536721661(177)]) != $_260548381){ COption::SetOptionString(___1536721661(178), ___1536721661(179), $_260548381, false, $_1005145921[___1536721661(180)]); COption::SetOptionString(___1536721661(181), ___1536721661(182), $_260548381);}}} protected static function OnPersonalBlogSettingsChange($_443867567, $_487617675){ if($_487617675) $_260548381= "Y"; else $_260548381= ___1536721661(183); $_1835377393= CSite::GetList(___1536721661(184), ___1536721661(185), array(___1536721661(186) => ___1536721661(187))); while($_1005145921= $_1835377393->Fetch()){ if(COption::GetOptionString(___1536721661(188), ___1536721661(189), ___1536721661(190), $_1005145921[___1536721661(191)]) != $_260548381){ COption::SetOptionString(___1536721661(192), ___1536721661(193), $_260548381, false, $_1005145921[___1536721661(194)]); COption::SetOptionString(___1536721661(195), ___1536721661(196), $_260548381);}}} protected static function OnPersonalPhotoSettingsChange($_443867567, $_487617675){ if($_487617675) $_260548381= "Y"; else $_260548381= ___1536721661(197); $_1835377393= CSite::GetList(___1536721661(198), ___1536721661(199), array(___1536721661(200) => ___1536721661(201))); while($_1005145921= $_1835377393->Fetch()){ if(COption::GetOptionString(___1536721661(202), ___1536721661(203), ___1536721661(204), $_1005145921[___1536721661(205)]) != $_260548381){ COption::SetOptionString(___1536721661(206), ___1536721661(207), $_260548381, false, $_1005145921[___1536721661(208)]); COption::SetOptionString(___1536721661(209), ___1536721661(210), $_260548381);}}} protected static function OnPersonalForumSettingsChange($_443867567, $_487617675){ if($_487617675) $_260548381= "Y"; else $_260548381= ___1536721661(211); $_1835377393= CSite::GetList(___1536721661(212), ___1536721661(213), array(___1536721661(214) => ___1536721661(215))); while($_1005145921= $_1835377393->Fetch()){ if(COption::GetOptionString(___1536721661(216), ___1536721661(217), ___1536721661(218), $_1005145921[___1536721661(219)]) != $_260548381){ COption::SetOptionString(___1536721661(220), ___1536721661(221), $_260548381, false, $_1005145921[___1536721661(222)]); COption::SetOptionString(___1536721661(223), ___1536721661(224), $_260548381);}}} protected static function OnTasksSettingsChange($_443867567, $_487617675){ if($_487617675) $_260548381= "Y"; else $_260548381= ___1536721661(225); $_1835377393= CSite::GetList(___1536721661(226), ___1536721661(227), array(___1536721661(228) => ___1536721661(229))); while($_1005145921= $_1835377393->Fetch()){ if(COption::GetOptionString(___1536721661(230), ___1536721661(231), ___1536721661(232), $_1005145921[___1536721661(233)]) != $_260548381){ COption::SetOptionString(___1536721661(234), ___1536721661(235), $_260548381, false, $_1005145921[___1536721661(236)]); COption::SetOptionString(___1536721661(237), ___1536721661(238), $_260548381);} if(COption::GetOptionString(___1536721661(239), ___1536721661(240), ___1536721661(241), $_1005145921[___1536721661(242)]) != $_260548381){ COption::SetOptionString(___1536721661(243), ___1536721661(244), $_260548381, false, $_1005145921[___1536721661(245)]); COption::SetOptionString(___1536721661(246), ___1536721661(247), $_260548381);}} self::__1636128402(___1536721661(248), $_487617675);} protected static function OnCalendarSettingsChange($_443867567, $_487617675){ if($_487617675) $_260548381= "Y"; else $_260548381= ___1536721661(249); $_1835377393= CSite::GetList(___1536721661(250), ___1536721661(251), array(___1536721661(252) => ___1536721661(253))); while($_1005145921= $_1835377393->Fetch()){ if(COption::GetOptionString(___1536721661(254), ___1536721661(255), ___1536721661(256), $_1005145921[___1536721661(257)]) != $_260548381){ COption::SetOptionString(___1536721661(258), ___1536721661(259), $_260548381, false, $_1005145921[___1536721661(260)]); COption::SetOptionString(___1536721661(261), ___1536721661(262), $_260548381);} if(COption::GetOptionString(___1536721661(263), ___1536721661(264), ___1536721661(265), $_1005145921[___1536721661(266)]) != $_260548381){ COption::SetOptionString(___1536721661(267), ___1536721661(268), $_260548381, false, $_1005145921[___1536721661(269)]); COption::SetOptionString(___1536721661(270), ___1536721661(271), $_260548381);}}} protected static function OnSMTPSettingsChange($_443867567, $_487617675){ self::__1636128402("mail", $_487617675);} protected static function OnExtranetSettingsChange($_443867567, $_487617675){ $_148590544= COption::GetOptionString("extranet", "extranet_site", ""); if($_148590544){ $_1194026461= new CSite; $_1194026461->Update($_148590544, array(___1536721661(272) =>($_487617675? ___1536721661(273): ___1536721661(274))));} self::__1636128402(___1536721661(275), $_487617675);} protected static function OnDAVSettingsChange($_443867567, $_487617675){ self::__1636128402("dav", $_487617675);} protected static function OntimemanSettingsChange($_443867567, $_487617675){ self::__1636128402("timeman", $_487617675);} protected static function Onintranet_sharepointSettingsChange($_443867567, $_487617675){ if($_487617675){ RegisterModuleDependences("iblock", "OnAfterIBlockElementAdd", "intranet", "CIntranetEventHandlers", "SPRegisterUpdatedItem"); RegisterModuleDependences(___1536721661(276), ___1536721661(277), ___1536721661(278), ___1536721661(279), ___1536721661(280)); CAgent::AddAgent(___1536721661(281), ___1536721661(282), ___1536721661(283), round(0+500)); CAgent::AddAgent(___1536721661(284), ___1536721661(285), ___1536721661(286), round(0+300)); CAgent::AddAgent(___1536721661(287), ___1536721661(288), ___1536721661(289), round(0+3600));} else{ UnRegisterModuleDependences(___1536721661(290), ___1536721661(291), ___1536721661(292), ___1536721661(293), ___1536721661(294)); UnRegisterModuleDependences(___1536721661(295), ___1536721661(296), ___1536721661(297), ___1536721661(298), ___1536721661(299)); CAgent::RemoveAgent(___1536721661(300), ___1536721661(301)); CAgent::RemoveAgent(___1536721661(302), ___1536721661(303)); CAgent::RemoveAgent(___1536721661(304), ___1536721661(305));}} protected static function OncrmSettingsChange($_443867567, $_487617675){ if($_487617675) COption::SetOptionString("crm", "form_features", "Y"); self::__1636128402(___1536721661(306), $_487617675);} protected static function OnClusterSettingsChange($_443867567, $_487617675){ self::__1636128402("cluster", $_487617675);} protected static function OnMultiSitesSettingsChange($_443867567, $_487617675){ if($_487617675) RegisterModuleDependences("main", "OnBeforeProlog", "main", "CWizardSolPanelIntranet", "ShowPanel", 100, "/modules/intranet/panel_button.php"); else UnRegisterModuleDependences(___1536721661(307), ___1536721661(308), ___1536721661(309), ___1536721661(310), ___1536721661(311), ___1536721661(312));} protected static function OnIdeaSettingsChange($_443867567, $_487617675){ self::__1636128402("idea", $_487617675);} protected static function OnMeetingSettingsChange($_443867567, $_487617675){ self::__1636128402("meeting", $_487617675);} protected static function OnXDImportSettingsChange($_443867567, $_487617675){ self::__1636128402("xdimport", $_487617675);}} $GLOBALS['____1986864793'][44](___1536721661(313), ___1536721661(314));/**/			//Do not remove this

require_once(__DIR__."/autoload.php");

// Component 2.0 template engines
$GLOBALS['arCustomTemplateEngines'] = [];

// User fields manager
$GLOBALS['USER_FIELD_MANAGER'] = new CUserTypeManager;

// todo: remove global
$GLOBALS['BX_MENU_CUSTOM'] = CMenuCustom::getInstance();

if (file_exists(($_fname = __DIR__."/classes/general/update_db_updater.php")))
{
	$US_HOST_PROCESS_MAIN = false;
	include($_fname);
}

if (file_exists(($_fname = $_SERVER["DOCUMENT_ROOT"]."/bitrix/init.php")))
{
	include_once($_fname);
}

if (($_fname = getLocalPath("php_interface/init.php", BX_PERSONAL_ROOT)) !== false)
{
	include_once($_SERVER["DOCUMENT_ROOT"].$_fname);
}

if (($_fname = getLocalPath("php_interface/".SITE_ID."/init.php", BX_PERSONAL_ROOT)) !== false)
{
	include_once($_SERVER["DOCUMENT_ROOT"].$_fname);
}

if (!defined("BX_FILE_PERMISSIONS"))
{
	define("BX_FILE_PERMISSIONS", 0644);
}
if (!defined("BX_DIR_PERMISSIONS"))
{
	define("BX_DIR_PERMISSIONS", 0755);
}

//global var, is used somewhere
$GLOBALS["sDocPath"] = $GLOBALS["APPLICATION"]->GetCurPage();

if ((!(defined("STATISTIC_ONLY") && STATISTIC_ONLY && mb_substr($GLOBALS["APPLICATION"]->GetCurPage(), 0, mb_strlen(BX_ROOT."/admin/")) != BX_ROOT."/admin/")) && COption::GetOptionString("main", "include_charset", "Y")=="Y" && LANG_CHARSET <> '')
{
	header("Content-Type: text/html; charset=".LANG_CHARSET);
}

if (COption::GetOptionString("main", "set_p3p_header", "Y")=="Y")
{
	header("P3P: policyref=\"/bitrix/p3p.xml\", CP=\"NON DSP COR CUR ADM DEV PSA PSD OUR UNR BUS UNI COM NAV INT DEM STA\"");
}

$license = $application->getLicense();
header("X-Powered-CMS: Bitrix Site Manager (" . ($license->isDemoKey() ? "DEMO" : $license->getPublicHashKey()) . ")");

if (COption::GetOptionString("main", "update_devsrv", "") == "Y")
{
	header("X-DevSrv-CMS: Bitrix");
}

if (!defined("BX_CRONTAB_SUPPORT"))
{
	define("BX_CRONTAB_SUPPORT", defined("BX_CRONTAB"));
}

//agents
if (COption::GetOptionString("main", "check_agents", "Y") == "Y")
{
	$application->addBackgroundJob(["CAgent", "CheckAgents"], [], \Bitrix\Main\Application::JOB_PRIORITY_LOW);
}

//send email events
if (COption::GetOptionString("main", "check_events", "Y") !== "N")
{
	$application->addBackgroundJob(['\Bitrix\Main\Mail\EventManager', 'checkEvents'], [], \Bitrix\Main\Application::JOB_PRIORITY_LOW-1);
}

$healerOfEarlySessionStart = new HealerEarlySessionStart();
$healerOfEarlySessionStart->process($application->getKernelSession());

$kernelSession = $application->getKernelSession();
$kernelSession->start();
$application->getSessionLocalStorageManager()->setUniqueId($kernelSession->getId());

foreach (GetModuleEvents("main", "OnPageStart", true) as $arEvent)
{
	ExecuteModuleEventEx($arEvent);
}

//define global user object
$GLOBALS["USER"] = new CUser;

//session control from group policy
$arPolicy = $GLOBALS["USER"]->GetSecurityPolicy();
$currTime = time();
if (
	(
		//IP address changed
		$kernelSession['SESS_IP']
		&& $arPolicy["SESSION_IP_MASK"] <> ''
		&& (
			(ip2long($arPolicy["SESSION_IP_MASK"]) & ip2long($kernelSession['SESS_IP']))
			!=
			(ip2long($arPolicy["SESSION_IP_MASK"]) & ip2long($_SERVER['REMOTE_ADDR']))
		)
	)
	||
	(
		//session timeout
		$arPolicy["SESSION_TIMEOUT"]>0
		&& $kernelSession['SESS_TIME']>0
		&& $currTime-$arPolicy["SESSION_TIMEOUT"]*60 > $kernelSession['SESS_TIME']
	)
	||
	(
		//signed session
		isset($kernelSession["BX_SESSION_SIGN"])
		&& $kernelSession["BX_SESSION_SIGN"] <> bitrix_sess_sign()
	)
	||
	(
		//session manually expired, e.g. in $User->LoginHitByHash
		isSessionExpired()
	)
)
{
	$compositeSessionManager = $application->getCompositeSessionManager();
	$compositeSessionManager->destroy();

	$application->getSession()->setId(Main\Security\Random::getString(32));
	$compositeSessionManager->start();

	$GLOBALS["USER"] = new CUser;
}
$kernelSession['SESS_IP'] = $_SERVER['REMOTE_ADDR'];
if (empty($kernelSession['SESS_TIME']))
{
	$kernelSession['SESS_TIME'] = $currTime;
}
elseif (($currTime - $kernelSession['SESS_TIME']) > 60)
{
	$kernelSession['SESS_TIME'] = $currTime;
}
if (!isset($kernelSession["BX_SESSION_SIGN"]))
{
	$kernelSession["BX_SESSION_SIGN"] = bitrix_sess_sign();
}

//session control from security module
if (
	(COption::GetOptionString("main", "use_session_id_ttl", "N") == "Y")
	&& (COption::GetOptionInt("main", "session_id_ttl", 0) > 0)
	&& !defined("BX_SESSION_ID_CHANGE")
)
{
	if (!isset($kernelSession['SESS_ID_TIME']))
	{
		$kernelSession['SESS_ID_TIME'] = $currTime;
	}
	elseif (($kernelSession['SESS_ID_TIME'] + COption::GetOptionInt("main", "session_id_ttl")) < $kernelSession['SESS_TIME'])
	{
		$compositeSessionManager = $application->getCompositeSessionManager();
		$compositeSessionManager->regenerateId();

		$kernelSession['SESS_ID_TIME'] = $currTime;
	}
}

define("BX_STARTED", true);

if (isset($kernelSession['BX_ADMIN_LOAD_AUTH']))
{
	define('ADMIN_SECTION_LOAD_AUTH', 1);
	unset($kernelSession['BX_ADMIN_LOAD_AUTH']);
}

$bRsaError = false;
$USER_LID = false;

if (!defined("NOT_CHECK_PERMISSIONS") || NOT_CHECK_PERMISSIONS!==true)
{
	$doLogout = isset($_REQUEST["logout"]) && (strtolower($_REQUEST["logout"]) == "yes");

	if ($doLogout && $GLOBALS["USER"]->IsAuthorized())
	{
		$secureLogout = (\Bitrix\Main\Config\Option::get("main", "secure_logout", "N") == "Y");

		if (!$secureLogout || check_bitrix_sessid())
		{
			$GLOBALS["USER"]->Logout();
			LocalRedirect($GLOBALS["APPLICATION"]->GetCurPageParam('', array('logout', 'sessid')));
		}
	}

	// authorize by cookies
	if (!$GLOBALS["USER"]->IsAuthorized())
	{
		$GLOBALS["USER"]->LoginByCookies();
	}

	$arAuthResult = false;

	//http basic and digest authorization
	if (($httpAuth = $GLOBALS["USER"]->LoginByHttpAuth()) !== null)
	{
		$arAuthResult = $httpAuth;
		$GLOBALS["APPLICATION"]->SetAuthResult($arAuthResult);
	}

	//Authorize user from authorization html form
	//Only POST is accepted
	if (isset($_POST["AUTH_FORM"]) && $_POST["AUTH_FORM"] <> '')
	{
		if (COption::GetOptionString('main', 'use_encrypted_auth', 'N') == 'Y')
		{
			//possible encrypted user password
			$sec = new CRsaSecurity();
			if (($arKeys = $sec->LoadKeys()))
			{
				$sec->SetKeys($arKeys);
				$errno = $sec->AcceptFromForm(['USER_PASSWORD', 'USER_CONFIRM_PASSWORD', 'USER_CURRENT_PASSWORD']);
				if ($errno == CRsaSecurity::ERROR_SESS_CHECK)
				{
					$arAuthResult = array("MESSAGE"=>GetMessage("main_include_decode_pass_sess"), "TYPE"=>"ERROR");
				}
				elseif ($errno < 0)
				{
					$arAuthResult = array("MESSAGE"=>GetMessage("main_include_decode_pass_err", array("#ERRCODE#"=>$errno)), "TYPE"=>"ERROR");
				}

				if ($errno < 0)
				{
					$bRsaError = true;
				}
			}
		}

		if (!$bRsaError)
		{
			if (!defined("ADMIN_SECTION") || ADMIN_SECTION !== true)
			{
				$USER_LID = SITE_ID;
			}

			$_POST["TYPE"] = $_POST["TYPE"] ?? null;
			if (isset($_POST["TYPE"]) && $_POST["TYPE"] == "AUTH")
			{
				$arAuthResult = $GLOBALS["USER"]->Login(
					$_POST["USER_LOGIN"] ?? '',
					$_POST["USER_PASSWORD"] ?? '',
					$_POST["USER_REMEMBER"] ?? ''
				);
			}
			elseif (isset($_POST["TYPE"]) && $_POST["TYPE"] == "OTP")
			{
				$arAuthResult = $GLOBALS["USER"]->LoginByOtp(
					$_POST["USER_OTP"] ?? '',
					$_POST["OTP_REMEMBER"] ?? '',
					$_POST["captcha_word"] ?? '',
					$_POST["captcha_sid"] ?? ''
				);
			}
			elseif (isset($_POST["TYPE"]) && $_POST["TYPE"] == "SEND_PWD")
			{
				$arAuthResult = CUser::SendPassword(
					$_POST["USER_LOGIN"] ?? '',
					$_POST["USER_EMAIL"] ?? '',
					$USER_LID,
					$_POST["captcha_word"] ?? '',
					$_POST["captcha_sid"] ?? '',
					$_POST["USER_PHONE_NUMBER"] ?? ''
				);
			}
			elseif (isset($_POST["TYPE"]) && $_POST["TYPE"] == "CHANGE_PWD")
			{
				$arAuthResult = $GLOBALS["USER"]->ChangePassword(
					$_POST["USER_LOGIN"] ?? '',
					$_POST["USER_CHECKWORD"] ?? '',
					$_POST["USER_PASSWORD"] ?? '',
					$_POST["USER_CONFIRM_PASSWORD"] ?? '',
					$USER_LID,
					$_POST["captcha_word"] ?? '',
					$_POST["captcha_sid"] ?? '',
					true,
					$_POST["USER_PHONE_NUMBER"] ?? '',
					$_POST["USER_CURRENT_PASSWORD"] ?? ''
				);
			}

			if ($_POST["TYPE"] == "AUTH" || $_POST["TYPE"] == "OTP")
			{
				//special login form in the control panel
				if ($arAuthResult === true && defined('ADMIN_SECTION') && ADMIN_SECTION === true)
				{
					//store cookies for next hit (see CMain::GetSpreadCookieHTML())
					$GLOBALS["APPLICATION"]->StoreCookies();
					$kernelSession['BX_ADMIN_LOAD_AUTH'] = true;

					// die() follows
					CMain::FinalActions('<script type="text/javascript">window.onload=function(){(window.BX || window.parent.BX).AUTHAGENT.setAuthResult(false);};</script>');
				}
			}
		}
		$GLOBALS["APPLICATION"]->SetAuthResult($arAuthResult);
	}
	elseif (!$GLOBALS["USER"]->IsAuthorized() && isset($_REQUEST['bx_hit_hash']))
	{
		//Authorize by unique URL
		$GLOBALS["USER"]->LoginHitByHash($_REQUEST['bx_hit_hash']);
	}
}

//logout or re-authorize the user if something importand has changed
$GLOBALS["USER"]->CheckAuthActions();

//magic short URI
if (defined("BX_CHECK_SHORT_URI") && BX_CHECK_SHORT_URI && CBXShortUri::CheckUri())
{
	//local redirect inside
	die();
}

//application password scope control
if (($applicationID = $GLOBALS["USER"]->getContext()->getApplicationId()) !== null)
{
	$appManager = Main\Authentication\ApplicationManager::getInstance();
	if ($appManager->checkScope($applicationID) !== true)
	{
		$event = new Main\Event("main", "onApplicationScopeError", Array('APPLICATION_ID' => $applicationID));
		$event->send();

		$context->getResponse()->setStatus("403 Forbidden");
		$application->end();
	}
}

//define the site template
if (!defined("ADMIN_SECTION") || ADMIN_SECTION !== true)
{
	$siteTemplate = "";
	if (isset($_REQUEST["bitrix_preview_site_template"]) && is_string($_REQUEST["bitrix_preview_site_template"]) && $_REQUEST["bitrix_preview_site_template"] <> "" && $GLOBALS["USER"]->CanDoOperation('view_other_settings'))
	{
		//preview of site template
		$signer = new Bitrix\Main\Security\Sign\Signer();
		try
		{
			//protected by a sign
			$requestTemplate = $signer->unsign($_REQUEST["bitrix_preview_site_template"], "template_preview".bitrix_sessid());

			$aTemplates = CSiteTemplate::GetByID($requestTemplate);
			if ($template = $aTemplates->Fetch())
			{
				$siteTemplate = $template["ID"];

				//preview of unsaved template
				if (isset($_GET['bx_template_preview_mode']) && $_GET['bx_template_preview_mode'] == 'Y' && $GLOBALS["USER"]->CanDoOperation('edit_other_settings'))
				{
					define("SITE_TEMPLATE_PREVIEW_MODE", true);
				}
			}
		}
		catch(\Bitrix\Main\Security\Sign\BadSignatureException $e)
		{
		}
	}
	if ($siteTemplate == "")
	{
		$siteTemplate = CSite::GetCurTemplate();
	}

	if (!defined('SITE_TEMPLATE_ID'))
	{
		define("SITE_TEMPLATE_ID", $siteTemplate);
	}

	define("SITE_TEMPLATE_PATH", getLocalPath('templates/'.SITE_TEMPLATE_ID, BX_PERSONAL_ROOT));
}
else
{
	// prevents undefined constants
	if (!defined('SITE_TEMPLATE_ID'))
	{
		define('SITE_TEMPLATE_ID', '.default');
	}

	define('SITE_TEMPLATE_PATH', '/bitrix/templates/.default');
}

//magic parameters: show page creation time
if (isset($_GET["show_page_exec_time"]))
{
	if ($_GET["show_page_exec_time"]=="Y" || $_GET["show_page_exec_time"]=="N")
	{
		$kernelSession["SESS_SHOW_TIME_EXEC"] = $_GET["show_page_exec_time"];
	}
}

//magic parameters: show included file processing time
if (isset($_GET["show_include_exec_time"]))
{
	if ($_GET["show_include_exec_time"]=="Y" || $_GET["show_include_exec_time"]=="N")
	{
		$kernelSession["SESS_SHOW_INCLUDE_TIME_EXEC"] = $_GET["show_include_exec_time"];
	}
}

//magic parameters: show include areas
if (isset($_GET["bitrix_include_areas"]) && $_GET["bitrix_include_areas"] <> "")
{
	$GLOBALS["APPLICATION"]->SetShowIncludeAreas($_GET["bitrix_include_areas"]=="Y");
}

//magic sound
if ($GLOBALS["USER"]->IsAuthorized())
{
	$cookie_prefix = COption::GetOptionString('main', 'cookie_name', 'BITRIX_SM');
	if (!isset($_COOKIE[$cookie_prefix.'_SOUND_LOGIN_PLAYED']))
	{
		$GLOBALS["APPLICATION"]->set_cookie('SOUND_LOGIN_PLAYED', 'Y', 0);
	}
}

//magic cache
\Bitrix\Main\Composite\Engine::shouldBeEnabled();

// should be before proactive filter on OnBeforeProlog
$userPassword = $_POST["USER_PASSWORD"] ?? null;
$userConfirmPassword = $_POST["USER_CONFIRM_PASSWORD"] ?? null;

foreach(GetModuleEvents("main", "OnBeforeProlog", true) as $arEvent)
{
	ExecuteModuleEventEx($arEvent);
}

if (!defined("NOT_CHECK_PERMISSIONS") || NOT_CHECK_PERMISSIONS !== true)
{
	//Register user from authorization html form
	//Only POST is accepted
	if (isset($_POST["AUTH_FORM"]) && $_POST["AUTH_FORM"] != '' && isset($_POST["TYPE"]) && $_POST["TYPE"] == "REGISTRATION")
	{
		if (!$bRsaError)
		{
			if (COption::GetOptionString("main", "new_user_registration", "N") == "Y" && (!defined("ADMIN_SECTION") || ADMIN_SECTION !== true))
			{
				$arAuthResult = $GLOBALS["USER"]->Register(
					$_POST["USER_LOGIN"] ?? '',
					$_POST["USER_NAME"] ?? '',
					$_POST["USER_LAST_NAME"] ?? '',
					$userPassword,
					$userConfirmPassword,
					$_POST["USER_EMAIL"] ?? '',
					$USER_LID,
					$_POST["captcha_word"] ?? '',
					$_POST["captcha_sid"] ?? '',
					false,
					$_POST["USER_PHONE_NUMBER"] ?? ''
				);

				$GLOBALS["APPLICATION"]->SetAuthResult($arAuthResult);
			}
		}
	}
}

if ((!defined("NOT_CHECK_PERMISSIONS") || NOT_CHECK_PERMISSIONS!==true) && (!defined("NOT_CHECK_FILE_PERMISSIONS") || NOT_CHECK_FILE_PERMISSIONS!==true))
{
	$real_path = $context->getRequest()->getScriptFile();

	if (!$GLOBALS["USER"]->CanDoFileOperation('fm_view_file', array(SITE_ID, $real_path)) || (defined("NEED_AUTH") && NEED_AUTH && !$GLOBALS["USER"]->IsAuthorized()))
	{
		if ($GLOBALS["USER"]->IsAuthorized() && $arAuthResult["MESSAGE"] == '')
		{
			$arAuthResult = array("MESSAGE"=>GetMessage("ACCESS_DENIED").' '.GetMessage("ACCESS_DENIED_FILE", array("#FILE#"=>$real_path)), "TYPE"=>"ERROR");

			if (COption::GetOptionString("main", "event_log_permissions_fail", "N") === "Y")
			{
				CEventLog::Log("SECURITY", "USER_PERMISSIONS_FAIL", "main", $GLOBALS["USER"]->GetID(), $real_path);
			}
		}

		if (defined("ADMIN_SECTION") && ADMIN_SECTION==true)
		{
			if (isset($_REQUEST["mode"]) && ($_REQUEST["mode"] === "list" || $_REQUEST["mode"] === "settings"))
			{
				echo "<script>top.location='".$GLOBALS["APPLICATION"]->GetCurPage()."?".DeleteParam(array("mode"))."';</script>";
				die();
			}
			elseif (isset($_REQUEST["mode"]) && $_REQUEST["mode"] === "frame")
			{
				echo "<script type=\"text/javascript\">
					var w = (opener? opener.window:parent.window);
					w.location.href='".$GLOBALS["APPLICATION"]->GetCurPage()."?".DeleteParam(array("mode"))."';
				</script>";
				die();
			}
			elseif (defined("MOBILE_APP_ADMIN") && MOBILE_APP_ADMIN==true)
			{
				echo json_encode(Array("status"=>"failed"));
				die();
			}
		}

		/** @noinspection PhpUndefinedVariableInspection */
		$GLOBALS["APPLICATION"]->AuthForm($arAuthResult);
	}
}

/*ZDUyZmZYzFhMTI0YThiMzE3NjE4MWRkOTBiMzY5ZGM5OTljNjY=*/$GLOBALS['____2005163358']= array(base64_decode('bXRf'.'cmFu'.'ZA'.'='.'='),base64_decode('ZXhw'.'bG9'.'k'.'ZQ='.'='),base64_decode('cGFja'.'w=='),base64_decode(''.'bW'.'Q1'),base64_decode('Y29uc3'.'RhbnQ='),base64_decode('aGFzaF9obWFj'),base64_decode(''.'c3R'.'yY21w'),base64_decode(''.'aX'.'Nfb'.'2JqZWN'.'0'),base64_decode('Y'.'2'.'F'.'s'.'bF91'.'c2VyX'.'2'.'Z1bmM='),base64_decode(''.'Y2'.'F'.'sbF9'.'1'.'c'.'2Vy'.'X2'.'Z1b'.'mM='),base64_decode('Y2'.'FsbF91'.'c2VyX2Z1'.'bmM='),base64_decode('Y'.'2FsbF91c'.'2VyX2'.'Z'.'1bmM'.'='),base64_decode('Y'.'2FsbF91c2'.'V'.'yX2'.'Z'.'1b'.'mM='));if(!function_exists(__NAMESPACE__.'\\___1884363551')){function ___1884363551($_226382925){static $_1381599872= false; if($_1381599872 == false) $_1381599872=array('REI=','U0VMRUNUI'.'FZBTFVFIE'.'ZST'.'00'.'gYl9'.'vcHRpb'.'24gV0hFU'.'k'.'UgTkFNRT0n'.'flB'.'BUkF'.'N'.'X0'.'1BWF9VU0VSUycgQ'.'U5EIE1PRFVMRV9J'.'RD0n'.'b'.'WFp'.'bicgQ'.'U5EIFNJVEV'.'fSUQgSVMg'.'TlVMT'.'A==',''.'VkFM'.'VUU=','Lg'.'==','S'.'Co=','Yml0c'.'ml'.'4','TElD'.'RU5'.'TRV9LRVk=','c'.'2hhMjU2','VVNF'.'Ug==','V'.'VNF'.'Ug==','V'.'VN'.'FU'.'g==',''.'SX'.'NBd'.'XRo'.'b3JpemVk','VVNFUg='.'=',''.'S'.'XNBZ'.'G1p'.'b'.'g==','Q'.'VB'.'QTEl'.'DQVRJT04=',''.'UmVz'.'dGFydEJ1ZmZ'.'l'.'cg==',''.'T'.'G9jYWxSZWRp'.'cmV'.'j'.'d'.'A==',''.'L2xpY2Vuc2'.'V'.'f'.'cm'.'Vz'.'d'.'HJ'.'pY3Rpb2'.'4uc'.'Gh'.'w','XEJpd'.'H'.'J'.'peF'.'x'.'NYW'.'l'.'uXEN'.'v'.'bmZpZ1'.'xPcHRpb'.'2'.'46OnNld'.'A==','bW'.'F'.'pbg==','UEFSQU1f'.'TUFYX1VTRVJT');return base64_decode($_1381599872[$_226382925]);}};if($GLOBALS['____2005163358'][0](round(0+0.33333333333333+0.33333333333333+0.33333333333333), round(0+4+4+4+4+4)) == round(0+1.75+1.75+1.75+1.75)){ $_1576820967= $GLOBALS[___1884363551(0)]->Query(___1884363551(1), true); if($_972607725= $_1576820967->Fetch()){ $_768195821= $_972607725[___1884363551(2)]; list($_308616361, $_1214986623)= $GLOBALS['____2005163358'][1](___1884363551(3), $_768195821); $_1902700338= $GLOBALS['____2005163358'][2](___1884363551(4), $_308616361); $_1597982925= ___1884363551(5).$GLOBALS['____2005163358'][3]($GLOBALS['____2005163358'][4](___1884363551(6))); $_1857217675= $GLOBALS['____2005163358'][5](___1884363551(7), $_1214986623, $_1597982925, true); if($GLOBALS['____2005163358'][6]($_1857217675, $_1902700338) !==(181*2-362)){ if(isset($GLOBALS[___1884363551(8)]) && $GLOBALS['____2005163358'][7]($GLOBALS[___1884363551(9)]) && $GLOBALS['____2005163358'][8](array($GLOBALS[___1884363551(10)], ___1884363551(11))) &&!$GLOBALS['____2005163358'][9](array($GLOBALS[___1884363551(12)], ___1884363551(13)))){ $GLOBALS['____2005163358'][10](array($GLOBALS[___1884363551(14)], ___1884363551(15))); $GLOBALS['____2005163358'][11](___1884363551(16), ___1884363551(17), true);}}} else{ $GLOBALS['____2005163358'][12](___1884363551(18), ___1884363551(19), ___1884363551(20), round(0+2.4+2.4+2.4+2.4+2.4));}}/**/       //Do not remove this

