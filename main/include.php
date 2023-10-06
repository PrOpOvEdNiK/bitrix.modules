<?php

/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2023 Bitrix
 */

use Bitrix\Main;
use Bitrix\Main\Session\Legacy\HealerEarlySessionStart;

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

if (class_exists('\Dev\Main\Migrator\ModuleUpdater'))
{
	\Dev\Main\Migrator\ModuleUpdater::checkUpdates('main', __DIR__);
}

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

/*ZDUyZmZMTA3NTY1MjAzMDEyYzNhOGYzMWY1MjQxZWU1MDBhM2Y=*/$GLOBALS['_____461692350']= array(base64_decode('R2V0TW9'.'k'.'dWx'.'lRXZl'.'bnR'.'z'),base64_decode('RXhlY3'.'V0ZU1vZHVsZUV2ZW'.'50RXg='));$GLOBALS['____2110425316']= array(base64_decode('Z'.'GVmaW'.'5l'),base64_decode(''.'YmF'.'zZTY0X'.'2'.'R'.'l'.'Y29k'.'ZQ'.'=='),base64_decode(''.'d'.'W'.'5zZXJpYWxpemU'.'='),base64_decode('aXNfYXJyYXk'.'='),base64_decode('aW5fYXJ'.'yYXk='),base64_decode('c2Vy'.'aW'.'FsaXpl'),base64_decode('YmFzZTY0X2Vu'.'Y29'.'kZ'.'Q='.'='),base64_decode('bWt0aW'.'1l'),base64_decode('Z'.'GF'.'0'.'ZQ=='),base64_decode(''.'ZGF0ZQ=='),base64_decode('c3'.'RybG'.'Vu'),base64_decode(''.'bWt0aW1'.'l'),base64_decode(''.'ZG'.'F0ZQ=='),base64_decode('ZG'.'F0ZQ='.'='),base64_decode('bW'.'V0aG9k'.'X2V4aXN0c'.'w=='),base64_decode('Y'.'2Fs'.'bF91c2VyX'.'2Z1b'.'mNfYXJ'.'yYXk='),base64_decode('c'.'3RybGVu'),base64_decode('c'.'2VyaWFsaXp'.'l'),base64_decode('YmFz'.'ZTY0'.'X'.'2Vu'.'Y'.'29kZQ'.'=='),base64_decode('c3RybGVu'),base64_decode('aXN'.'fYXJy'.'YXk='),base64_decode('c2'.'V'.'y'.'aWFsaXp'.'l'),base64_decode('YmFzZ'.'TY0X2V'.'uY29kZQ=='),base64_decode('c2V'.'yaWF'.'saX'.'pl'),base64_decode('YmFzZTY0X'.'2'.'Vu'.'Y29k'.'ZQ=='),base64_decode(''.'aX'.'Nf'.'YXJ'.'yYXk='),base64_decode('aXN'.'fYXJ'.'yYXk='),base64_decode('aW5fYXJ'.'yYXk='),base64_decode('aW5fYXJ'.'yYXk='),base64_decode('b'.'Wt0aW1l'),base64_decode(''.'ZGF0ZQ='.'='),base64_decode('ZGF0'.'ZQ=='),base64_decode('ZG'.'F'.'0ZQ=='),base64_decode('b'.'Wt0aW'.'1'.'l'),base64_decode('ZGF0'.'ZQ'.'=='),base64_decode('Z'.'GF0Z'.'Q=='),base64_decode('aW5'.'fYXJyYX'.'k='),base64_decode('c'.'2VyaWF'.'saXpl'),base64_decode(''.'YmFzZTY0X'.'2Vu'.'Y2'.'9kZQ=='),base64_decode('aW'.'50dmFs'),base64_decode('d'.'Gl'.'tZQ'.'=='),base64_decode('Zml'.'sZV9l'.'eG'.'lz'.'dHM='),base64_decode(''.'c3'.'R'.'yX3JlcGxhY2U='),base64_decode('Y2x'.'hc3N'.'fZ'.'Xhpc3Rz'),base64_decode('ZGVmaW5l'));if(!function_exists(__NAMESPACE__.'\\___1499599049')){function ___1499599049($_1309451423){static $_1951117794= false; if($_1951117794 == false) $_1951117794=array('SU5UUkF'.'ORVR'.'fRUR'.'JV'.'ElPTg==','WQ'.'==','bWFp'.'bg==',''.'f'.'mN'.'w'.'Zl9tYXBfdm'.'FsdWU=','','','Y'.'Wxsb3dlZF9jbG'.'Fzc'.'2'.'Vz','Z'.'Q'.'==','Zg==','Z'.'Q==',''.'R'.'g==','W'.'A==','Z'.'g==',''.'bW'.'Fpb'.'g'.'==',''.'fmNwZl'.'9t'.'YX'.'BfdmFs'.'dWU=','UG9yd'.'GF'.'s','Rg='.'=','ZQ==','ZQ='.'=',''.'WA='.'=','R'.'g==','RA==','RA==',''.'bQ==','ZA==','WQ'.'==',''.'Zg'.'==','Zg='.'=',''.'Z'.'g==','Zg='.'=','UG9y'.'dGFs','Rg==','ZQ==','ZQ==','WA==','Rg==','RA==','RA'.'==','b'.'Q==','ZA==','WQ==','bWFp'.'bg'.'==','T'.'24=','U2V'.'0dGl'.'uZ3NDa'.'GFu'.'Z2U=','Zg==','Zg==',''.'Zg'.'==',''.'Z'.'g==','bWF'.'pbg==',''.'fmNwZl9'.'tY'.'XBfd'.'m'.'Fs'.'dWU=','ZQ==','Z'.'Q='.'=','RA'.'==','ZQ==',''.'ZQ==','Zg==','Zg'.'==','Zg'.'==','ZQ'.'==','bWFpbg='.'=','fmNwZl9t'.'YXBfdmFsdW'.'U=','ZQ==','Zg==','Zg==','Zg==','Zg==','bWFpbg='.'=','fmNwZl9tY'.'XBf'.'dmFsdWU=',''.'ZQ='.'=','Zg'.'==','UG9ydGFs',''.'UG9y'.'dGFs',''.'ZQ==','ZQ==','UG9ydGFs','Rg==','WA==',''.'R'.'g==','RA'.'='.'=','ZQ='.'=','Z'.'Q==',''.'RA'.'='.'=','bQ==','ZA'.'==','WQ'.'==','ZQ'.'==',''.'W'.'A==','ZQ'.'==',''.'Rg='.'=',''.'ZQ==','RA'.'==','Z'.'g==','ZQ==',''.'RA'.'==','ZQ==','bQ==','ZA'.'==','W'.'Q='.'=','Z'.'g'.'==',''.'Z'.'g==','Zg==','Zg==','Z'.'g==','Zg==',''.'Zg'.'==','Zg==','bWFpbg='.'=','fmNwZl9tYX'.'Bfd'.'mF'.'sdWU=','ZQ='.'=','ZQ==','UG9ydGFs','Rg='.'=','WA='.'=','VFlQ'.'R'.'Q==',''.'R'.'EFURQ==','RkVBV'.'FVSRV'.'M=',''.'R'.'Vh'.'Q'.'S'.'VJ'.'FRA==','V'.'FlQ'.'R'.'Q==',''.'RA==',''.'V'.'FJZ'.'X0'.'R'.'BWV'.'NfQ'.'09VTlQ=','REFURQ==','VFJZX0R'.'BWVNfQ09V'.'TlQ=','RV'.'hQ'.'SVJFRA='.'=','RkVBVFVSRV'.'M=',''.'Zg==','Zg'.'==','RE9DV'.'U1FTlR'.'f'.'Uk9PV'.'A='.'=','L2Jp'.'dHJpe'.'C9'.'tb2R1'.'b'.'GVzLw'.'==','L2lu'.'c3'.'RhbGwvaW5kZX'.'gucGhw','Lg'.'==','Xw='.'=','c2Vhcm'.'No','Tg='.'=','','','QUN'.'USVZF','WQ='.'=','c29'.'jaWFsbm'.'V0'.'d29yaw'.'==','Y'.'W'.'xsb3dfZnJpZWxk'.'cw'.'==','W'.'Q==','SU'.'Q=','c'.'29jaWFsb'.'mV0d2'.'9yaw'.'='.'=','YW'.'xsb3dfZnJpZWx'.'kcw='.'=',''.'SUQ=',''.'c'.'29j'.'a'.'WFsbm'.'V0d29'.'y'.'aw='.'=','Y'.'Wxsb3dfZnJpZWxkcw==','Tg==','','','QUNU'.'SVZF','WQ==','c29j'.'aWFsbmV0d29y'.'aw='.'=','YWxs'.'b3df'.'b'.'Wljc'.'m9ibG9n'.'X'.'3'.'VzZX'.'I'.'=','WQ==','SU'.'Q=',''.'c29'.'jaWFsbmV0'.'d2'.'9'.'y'.'aw==','Y'.'Wxsb3'.'dfbW'.'l'.'j'.'cm'.'9ibG9nX'.'3VzZX'.'I'.'=','SUQ'.'=','c2'.'9ja'.'WFsbmV0d29yaw'.'='.'=','YWxsb3dfbWl'.'jc'.'m9ibG'.'9nX'.'3VzZ'.'XI'.'=','c'.'29ja'.'WFsbmV0d29y'.'a'.'w==','YWx'.'sb3'.'dfb'.'Wljcm9i'.'bG9n'.'X2dyb'.'3Vw','WQ'.'='.'=','SUQ'.'=','c'.'29'.'j'.'aWFsbmV0d29yaw==','YWxsb3dfb'.'W'.'ljcm9ibG9nX2dyb3Vw','S'.'UQ=','c2'.'9jaWFsbmV0d29yaw==','YW'.'xsb3'.'dfbWljc'.'m9ibG9nX2dy'.'b3Vw','Tg='.'=','','',''.'QUNU'.'SVZF','WQ==','c'.'29jaWFsbmV0d'.'29ya'.'w==',''.'YWx'.'s'.'b'.'3'.'dfZm'.'ls'.'Z'.'X'.'NfdXN'.'lc'.'g'.'==','WQ='.'=','S'.'UQ=','c29jaWFs'.'bm'.'V'.'0d29yaw==','YW'.'xsb3df'.'Z'.'m'.'lsZXNfdX'.'N'.'lcg==','SUQ=','c29j'.'aWFs'.'b'.'mV'.'0d29yaw==','YWxsb3dfZmlsZ'.'XNfdX'.'N'.'lc'.'g==',''.'T'.'g==','','','Q'.'UNUSVZ'.'F','WQ==','c29jaWFsbm'.'V0d29yaw'.'==','YWxs'.'b3d'.'f'.'YmxvZ1'.'9'.'1c'.'2V'.'y','WQ'.'==','SUQ'.'=',''.'c2'.'9'.'jaW'.'F'.'sb'.'mV0d2'.'9'.'yaw='.'=','YWxsb'.'3dfYmxvZ1'.'91c2'.'Vy','SU'.'Q=','c2'.'9jaWFsbmV0d2'.'9'.'yaw==','YWxsb3'.'dfYmxvZ1'.'91c2Vy',''.'Tg'.'==','','','QUNUSVZ'.'F','WQ='.'=','c29jaWFsbmV0d'.'29yaw==','YW'.'xsb3df'.'cG'.'hvdG9'.'fdX'.'Nlcg==','W'.'Q==',''.'S'.'UQ=','c2'.'9j'.'aWFsbmV0d29'.'y'.'a'.'w==',''.'YW'.'xs'.'b3dfcGhvdG9fdXNl'.'cg==','SUQ'.'=',''.'c29jaW'.'Fsb'.'mV0d29yaw==',''.'YWxsb3df'.'cG'.'hvd'.'G9fdXNl'.'cg==',''.'Tg==','','','QUNUSVZF','WQ==','c29'.'j'.'aWFs'.'bmV0d29yaw==','Y'.'W'.'xs'.'b3dfZ'.'m9ydW1fdXN'.'l'.'cg==','WQ==','SUQ=','c29jaWFsbmV0'.'d2'.'9ya'.'w==','Y'.'Wxsb3dfZm9ydW1fdX'.'Nlcg==','S'.'U'.'Q'.'=','c29jaWF'.'sbm'.'V0d29ya'.'w==','Y'.'Wxsb3dfZm9'.'ydW1fdXNl'.'cg==','Tg'.'==','','',''.'QUNUSVZF','W'.'Q==','c2'.'9jaWFsb'.'mV0d'.'29'.'yaw==',''.'YW'.'xs'.'b3dfdGFz'.'a'.'3N'.'f'.'dXNlc'.'g==','WQ==',''.'SU'.'Q'.'=',''.'c29jaWFsb'.'mV0d29'.'ya'.'w==','YWxsb3dfd'.'GF'.'za3N'.'fdXNlcg'.'==','SUQ=','c2'.'9ja'.'WFsbmV0d29'.'yaw==',''.'YWx'.'sb3dfd'.'GF'.'za3NfdXNl'.'cg==',''.'c'.'2'.'9jaWFsbmV0d29'.'ya'.'w'.'==','YWxsb'.'3dfdGFza3Nf'.'Z'.'3JvdXA'.'=','WQ'.'='.'=',''.'SUQ=','c29jaWFsbmV'.'0d'.'29yaw==','YW'.'xsb3dfd'.'GF'.'za3NfZ'.'3'.'Jv'.'dXA'.'=','SUQ=','c29jaWFsbmV0d'.'29yaw==','YWxsb3'.'dfdGFza3NfZ3Jvd'.'XA'.'=',''.'dGFza3M=','Tg==','','','QU'.'NUSVZF','WQ==',''.'c'.'29'.'ja'.'WFs'.'bm'.'V0d'.'29ya'.'w==','YWxsb3d'.'fY'.'2FsZW5kYXJfdXNlcg==','WQ==',''.'SUQ'.'=','c29jaWF'.'sbm'.'V0d29yaw==','YWx'.'sb3'.'d'.'fY2'.'Fs'.'ZW5kYX'.'Jfd'.'XN'.'l'.'cg='.'=','S'.'UQ=','c29jaWFsbmV'.'0d'.'2'.'9yaw==',''.'YWxsb3dfY2FsZW5k'.'Y'.'XJfdXNlcg'.'==','c29'.'jaWFsbmV0d29'.'y'.'aw==','YWxsb3dfY2FsZW5kYXJfZ'.'3JvdXA=',''.'WQ='.'=',''.'SUQ=','c29jaWFs'.'bmV0d29'.'yaw==','YWx'.'s'.'b3dfY'.'2F'.'sZW'.'5k'.'YXJfZ3JvdXA=','SUQ=',''.'c'.'2'.'9j'.'aWFs'.'bmV'.'0d29'.'ya'.'w==','YW'.'xsb'.'3dfY2FsZW5'.'kYXJ'.'f'.'Z'.'3J'.'vdX'.'A=','QU'.'NUSVZF','WQ==','Tg==','ZXh0'.'cmFuZ'.'XQ=','aWJsb2Nr','T'.'25BZnRlcklCbG9'.'ja0V'.'sZW1lbnRVcGRhdGU=','aW5'.'0cm'.'Fu'.'ZX'.'Q=','Q0lud'.'HJ'.'hbmV0R'.'XZl'.'bnR'.'IYW'.'5kbGV'.'ycw'.'='.'=','U1BSZW'.'dpc3RlclVwZGF0ZW'.'RJdGVt','Q0l'.'udHJhb'.'mV0U2hh'.'cmVwb2ludDo6QW'.'dlbnR'.'Ma'.'X'.'N'.'0'.'cy'.'g'.'pOw==','aW'.'50'.'cmFuZXQ=','Tg==','Q0lu'.'dHJhbm'.'V0U2'.'hh'.'cmVw'.'b2l'.'u'.'dDo'.'6QWdlbnRRdW'.'V1Z'.'Sgp'.'Ow'.'='.'=',''.'aW50cmFuZXQ=','Tg==','Q0ludHJhbmV'.'0U2'.'h'.'hc'.'mVwb2ludD'.'o'.'6'.'QWdlbnRVcGRhdGUoKTs=','aW50cmFu'.'ZXQ=','T'.'g'.'==','aW'.'Jsb2'.'Nr','T2'.'5BZn'.'RlcklCbG'.'9ja0VsZ'.'W'.'1lbnRBZ'.'GQ=','aW50'.'c'.'mFu'.'ZXQ=','Q0lu'.'dHJ'.'hbm'.'V0R'.'XZlbn'.'RIY'.'W5k'.'bGVycw==','U1BSZWdpc'.'3R'.'lc'.'lVwZGF0Z'.'W'.'RJd'.'GV'.'t',''.'aWJ'.'sb2Nr','T25BZnRlcklC'.'bG'.'9ja0'.'VsZ'.'W1l'.'b'.'nRV'.'cG'.'Rhd'.'GU=','aW50cmFu'.'ZXQ=','Q0lud'.'H'.'JhbmV0R'.'X'.'Z'.'lbnRIYW5kbGV'.'ycw==','U'.'1BSZ'.'Wdpc3RlclVwZGF0Z'.'WRJd'.'GVt','Q0lud'.'HJhbm'.'V0U2hhcmV'.'w'.'b2ludDo6Q'.'Wdl'.'bn'.'R'.'MaXN'.'0cygpO'.'w==','aW50cmF'.'u'.'ZXQ'.'=','Q'.'0l'.'udHJh'.'bmV0U2hhcm'.'V'.'wb2lu'.'d'.'Do6Q'.'Wdl'.'bnRRdW'.'V1Z'.'Sg'.'pO'.'w==','aW50cmFuZX'.'Q=',''.'Q0lud'.'HJh'.'bm'.'V0'.'U2hhcmV'.'wb2ludDo'.'6'.'QWdlbnRVc'.'G'.'RhdG'.'UoKT'.'s=','a'.'W50c'.'m'.'FuZXQ'.'=','Y3Jt','bWF'.'p'.'bg==','T25CZWZ'.'vcmVQcm9sb2'.'c=','bWFpb'.'g==','Q'.'1dpem'.'Fy'.'ZF'.'Nvb'.'F'.'BhbmVs'.'SW5'.'0cmFuZXQ=','U2hvd1BhbmVs','L21vZHVsZ'.'X'.'Mva'.'W50cm'.'FuZ'.'XQvc'.'G'.'FuZW'.'xf'.'Y'.'nV0d'.'G'.'9uLnBocA='.'=',''.'RU5D'.'T'.'0R'.'F','WQ'.'==');return base64_decode($_1951117794[$_1309451423]);}};$GLOBALS['____2110425316'][0](___1499599049(0), ___1499599049(1));class CBXFeatures{ private static $_852654920= 30; private static $_1054432810= array( "Portal" => array( "CompanyCalendar", "CompanyPhoto", "CompanyVideo", "CompanyCareer", "StaffChanges", "StaffAbsence", "CommonDocuments", "MeetingRoomBookingSystem", "Wiki", "Learning", "Vote", "WebLink", "Subscribe", "Friends", "PersonalFiles", "PersonalBlog", "PersonalPhoto", "PersonalForum", "Blog", "Forum", "Gallery", "Board", "MicroBlog", "WebMessenger",), "Communications" => array( "Tasks", "Calendar", "Workgroups", "Jabber", "VideoConference", "Extranet", "SMTP", "Requests", "DAV", "intranet_sharepoint", "timeman", "Idea", "Meeting", "EventList", "Salary", "XDImport",), "Enterprise" => array( "BizProc", "Lists", "Support", "Analytics", "crm", "Controller", "LdapUnlimitedUsers",), "Holding" => array( "Cluster", "MultiSites",),); private static $_2078044868= null; private static $_1266692365= null; private static function __1189706611(){ if(self::$_2078044868 === null){ self::$_2078044868= array(); foreach(self::$_1054432810 as $_1330464623 => $_1247947772){ foreach($_1247947772 as $_138480735) self::$_2078044868[$_138480735]= $_1330464623;}} if(self::$_1266692365 === null){ self::$_1266692365= array(); $_2013102600= COption::GetOptionString(___1499599049(2), ___1499599049(3), ___1499599049(4)); if($_2013102600 != ___1499599049(5)){ $_2013102600= $GLOBALS['____2110425316'][1]($_2013102600); $_2013102600= $GLOBALS['____2110425316'][2]($_2013102600,[___1499599049(6) => false]); if($GLOBALS['____2110425316'][3]($_2013102600)){ self::$_1266692365= $_2013102600;}} if(empty(self::$_1266692365)){ self::$_1266692365= array(___1499599049(7) => array(), ___1499599049(8) => array());}}} public static function InitiateEditionsSettings($_1289266651){ self::__1189706611(); $_879735171= array(); foreach(self::$_1054432810 as $_1330464623 => $_1247947772){ $_1644686005= $GLOBALS['____2110425316'][4]($_1330464623, $_1289266651); self::$_1266692365[___1499599049(9)][$_1330464623]=($_1644686005? array(___1499599049(10)): array(___1499599049(11))); foreach($_1247947772 as $_138480735){ self::$_1266692365[___1499599049(12)][$_138480735]= $_1644686005; if(!$_1644686005) $_879735171[]= array($_138480735, false);}} $_1987798111= $GLOBALS['____2110425316'][5](self::$_1266692365); $_1987798111= $GLOBALS['____2110425316'][6]($_1987798111); COption::SetOptionString(___1499599049(13), ___1499599049(14), $_1987798111); foreach($_879735171 as $_1669118734) self::__926083330($_1669118734[(1300/2-650)], $_1669118734[round(0+1)]);} public static function IsFeatureEnabled($_138480735){ if($_138480735 == '') return true; self::__1189706611(); if(!isset(self::$_2078044868[$_138480735])) return true; if(self::$_2078044868[$_138480735] == ___1499599049(15)) $_235633537= array(___1499599049(16)); elseif(isset(self::$_1266692365[___1499599049(17)][self::$_2078044868[$_138480735]])) $_235633537= self::$_1266692365[___1499599049(18)][self::$_2078044868[$_138480735]]; else $_235633537= array(___1499599049(19)); if($_235633537[(177*2-354)] != ___1499599049(20) && $_235633537[(774-2*387)] != ___1499599049(21)){ return false;} elseif($_235633537[(922-2*461)] == ___1499599049(22)){ if($_235633537[round(0+0.5+0.5)]< $GLOBALS['____2110425316'][7](min(10,0,3.3333333333333),(216*2-432),(1356/2-678), Date(___1499599049(23)), $GLOBALS['____2110425316'][8](___1499599049(24))- self::$_852654920, $GLOBALS['____2110425316'][9](___1499599049(25)))){ if(!isset($_235633537[round(0+0.66666666666667+0.66666666666667+0.66666666666667)]) ||!$_235633537[round(0+0.4+0.4+0.4+0.4+0.4)]) self::__1353654586(self::$_2078044868[$_138480735]); return false;}} return!isset(self::$_1266692365[___1499599049(26)][$_138480735]) || self::$_1266692365[___1499599049(27)][$_138480735];} public static function IsFeatureInstalled($_138480735){ if($GLOBALS['____2110425316'][10]($_138480735) <= 0) return true; self::__1189706611(); return(isset(self::$_1266692365[___1499599049(28)][$_138480735]) && self::$_1266692365[___1499599049(29)][$_138480735]);} public static function IsFeatureEditable($_138480735){ if($_138480735 == '') return true; self::__1189706611(); if(!isset(self::$_2078044868[$_138480735])) return true; if(self::$_2078044868[$_138480735] == ___1499599049(30)) $_235633537= array(___1499599049(31)); elseif(isset(self::$_1266692365[___1499599049(32)][self::$_2078044868[$_138480735]])) $_235633537= self::$_1266692365[___1499599049(33)][self::$_2078044868[$_138480735]]; else $_235633537= array(___1499599049(34)); if($_235633537[(147*2-294)] != ___1499599049(35) && $_235633537[(846-2*423)] != ___1499599049(36)){ return false;} elseif($_235633537[(229*2-458)] == ___1499599049(37)){ if($_235633537[round(0+0.25+0.25+0.25+0.25)]< $GLOBALS['____2110425316'][11]((145*2-290),(1248/2-624),(1100/2-550), Date(___1499599049(38)), $GLOBALS['____2110425316'][12](___1499599049(39))- self::$_852654920, $GLOBALS['____2110425316'][13](___1499599049(40)))){ if(!isset($_235633537[round(0+0.66666666666667+0.66666666666667+0.66666666666667)]) ||!$_235633537[round(0+0.4+0.4+0.4+0.4+0.4)]) self::__1353654586(self::$_2078044868[$_138480735]); return false;}} return true;} private static function __926083330($_138480735, $_253183512){ if($GLOBALS['____2110425316'][14]("CBXFeatures", "On".$_138480735."SettingsChange")) $GLOBALS['____2110425316'][15](array("CBXFeatures", "On".$_138480735."SettingsChange"), array($_138480735, $_253183512)); $_452459176= $GLOBALS['_____461692350'][0](___1499599049(41), ___1499599049(42).$_138480735.___1499599049(43)); while($_1649165898= $_452459176->Fetch()) $GLOBALS['_____461692350'][1]($_1649165898, array($_138480735, $_253183512));} public static function SetFeatureEnabled($_138480735, $_253183512= true, $_488458442= true){ if($GLOBALS['____2110425316'][16]($_138480735) <= 0) return; if(!self::IsFeatureEditable($_138480735)) $_253183512= false; $_253183512= (bool)$_253183512; self::__1189706611(); $_507380170=(!isset(self::$_1266692365[___1499599049(44)][$_138480735]) && $_253183512 || isset(self::$_1266692365[___1499599049(45)][$_138480735]) && $_253183512 != self::$_1266692365[___1499599049(46)][$_138480735]); self::$_1266692365[___1499599049(47)][$_138480735]= $_253183512; $_1987798111= $GLOBALS['____2110425316'][17](self::$_1266692365); $_1987798111= $GLOBALS['____2110425316'][18]($_1987798111); COption::SetOptionString(___1499599049(48), ___1499599049(49), $_1987798111); if($_507380170 && $_488458442) self::__926083330($_138480735, $_253183512);} private static function __1353654586($_1330464623){ if($GLOBALS['____2110425316'][19]($_1330464623) <= 0 || $_1330464623 == "Portal") return; self::__1189706611(); if(!isset(self::$_1266692365[___1499599049(50)][$_1330464623]) || self::$_1266692365[___1499599049(51)][$_1330464623][(1248/2-624)] != ___1499599049(52)) return; if(isset(self::$_1266692365[___1499599049(53)][$_1330464623][round(0+0.66666666666667+0.66666666666667+0.66666666666667)]) && self::$_1266692365[___1499599049(54)][$_1330464623][round(0+0.66666666666667+0.66666666666667+0.66666666666667)]) return; $_879735171= array(); if(isset(self::$_1054432810[$_1330464623]) && $GLOBALS['____2110425316'][20](self::$_1054432810[$_1330464623])){ foreach(self::$_1054432810[$_1330464623] as $_138480735){ if(isset(self::$_1266692365[___1499599049(55)][$_138480735]) && self::$_1266692365[___1499599049(56)][$_138480735]){ self::$_1266692365[___1499599049(57)][$_138480735]= false; $_879735171[]= array($_138480735, false);}} self::$_1266692365[___1499599049(58)][$_1330464623][round(0+0.5+0.5+0.5+0.5)]= true;} $_1987798111= $GLOBALS['____2110425316'][21](self::$_1266692365); $_1987798111= $GLOBALS['____2110425316'][22]($_1987798111); COption::SetOptionString(___1499599049(59), ___1499599049(60), $_1987798111); foreach($_879735171 as $_1669118734) self::__926083330($_1669118734[min(44,0,14.666666666667)], $_1669118734[round(0+0.5+0.5)]);} public static function ModifyFeaturesSettings($_1289266651, $_1247947772){ self::__1189706611(); foreach($_1289266651 as $_1330464623 => $_732504533) self::$_1266692365[___1499599049(61)][$_1330464623]= $_732504533; $_879735171= array(); foreach($_1247947772 as $_138480735 => $_253183512){ if(!isset(self::$_1266692365[___1499599049(62)][$_138480735]) && $_253183512 || isset(self::$_1266692365[___1499599049(63)][$_138480735]) && $_253183512 != self::$_1266692365[___1499599049(64)][$_138480735]) $_879735171[]= array($_138480735, $_253183512); self::$_1266692365[___1499599049(65)][$_138480735]= $_253183512;} $_1987798111= $GLOBALS['____2110425316'][23](self::$_1266692365); $_1987798111= $GLOBALS['____2110425316'][24]($_1987798111); COption::SetOptionString(___1499599049(66), ___1499599049(67), $_1987798111); self::$_1266692365= false; foreach($_879735171 as $_1669118734) self::__926083330($_1669118734[(978-2*489)], $_1669118734[round(0+0.2+0.2+0.2+0.2+0.2)]);} public static function SaveFeaturesSettings($_648512488, $_875981){ self::__1189706611(); $_1322678050= array(___1499599049(68) => array(), ___1499599049(69) => array()); if(!$GLOBALS['____2110425316'][25]($_648512488)) $_648512488= array(); if(!$GLOBALS['____2110425316'][26]($_875981)) $_875981= array(); if(!$GLOBALS['____2110425316'][27](___1499599049(70), $_648512488)) $_648512488[]= ___1499599049(71); foreach(self::$_1054432810 as $_1330464623 => $_1247947772){ if(isset(self::$_1266692365[___1499599049(72)][$_1330464623])){ $_745925259= self::$_1266692365[___1499599049(73)][$_1330464623];} else{ $_745925259=($_1330464623 == ___1499599049(74)? array(___1499599049(75)): array(___1499599049(76)));} if($_745925259[(1108/2-554)] == ___1499599049(77) || $_745925259[(1368/2-684)] == ___1499599049(78)){ $_1322678050[___1499599049(79)][$_1330464623]= $_745925259;} else{ if($GLOBALS['____2110425316'][28]($_1330464623, $_648512488)) $_1322678050[___1499599049(80)][$_1330464623]= array(___1499599049(81), $GLOBALS['____2110425316'][29]((980-2*490), min(112,0,37.333333333333),(233*2-466), $GLOBALS['____2110425316'][30](___1499599049(82)), $GLOBALS['____2110425316'][31](___1499599049(83)), $GLOBALS['____2110425316'][32](___1499599049(84)))); else $_1322678050[___1499599049(85)][$_1330464623]= array(___1499599049(86));}} $_879735171= array(); foreach(self::$_2078044868 as $_138480735 => $_1330464623){ if($_1322678050[___1499599049(87)][$_1330464623][(136*2-272)] != ___1499599049(88) && $_1322678050[___1499599049(89)][$_1330464623][(1220/2-610)] != ___1499599049(90)){ $_1322678050[___1499599049(91)][$_138480735]= false;} else{ if($_1322678050[___1499599049(92)][$_1330464623][(231*2-462)] == ___1499599049(93) && $_1322678050[___1499599049(94)][$_1330464623][round(0+0.25+0.25+0.25+0.25)]< $GLOBALS['____2110425316'][33](min(192,0,64), min(2,0,0.66666666666667),(1456/2-728), Date(___1499599049(95)), $GLOBALS['____2110425316'][34](___1499599049(96))- self::$_852654920, $GLOBALS['____2110425316'][35](___1499599049(97)))) $_1322678050[___1499599049(98)][$_138480735]= false; else $_1322678050[___1499599049(99)][$_138480735]= $GLOBALS['____2110425316'][36]($_138480735, $_875981); if(!isset(self::$_1266692365[___1499599049(100)][$_138480735]) && $_1322678050[___1499599049(101)][$_138480735] || isset(self::$_1266692365[___1499599049(102)][$_138480735]) && $_1322678050[___1499599049(103)][$_138480735] != self::$_1266692365[___1499599049(104)][$_138480735]) $_879735171[]= array($_138480735, $_1322678050[___1499599049(105)][$_138480735]);}} $_1987798111= $GLOBALS['____2110425316'][37]($_1322678050); $_1987798111= $GLOBALS['____2110425316'][38]($_1987798111); COption::SetOptionString(___1499599049(106), ___1499599049(107), $_1987798111); self::$_1266692365= false; foreach($_879735171 as $_1669118734) self::__926083330($_1669118734[(856-2*428)], $_1669118734[round(0+0.5+0.5)]);} public static function GetFeaturesList(){ self::__1189706611(); $_999574927= array(); foreach(self::$_1054432810 as $_1330464623 => $_1247947772){ if(isset(self::$_1266692365[___1499599049(108)][$_1330464623])){ $_745925259= self::$_1266692365[___1499599049(109)][$_1330464623];} else{ $_745925259=($_1330464623 == ___1499599049(110)? array(___1499599049(111)): array(___1499599049(112)));} $_999574927[$_1330464623]= array( ___1499599049(113) => $_745925259[(766-2*383)], ___1499599049(114) => $_745925259[round(0+0.25+0.25+0.25+0.25)], ___1499599049(115) => array(),); $_999574927[$_1330464623][___1499599049(116)]= false; if($_999574927[$_1330464623][___1499599049(117)] == ___1499599049(118)){ $_999574927[$_1330464623][___1499599049(119)]= $GLOBALS['____2110425316'][39](($GLOBALS['____2110425316'][40]()- $_999574927[$_1330464623][___1499599049(120)])/ round(0+21600+21600+21600+21600)); if($_999574927[$_1330464623][___1499599049(121)]> self::$_852654920) $_999574927[$_1330464623][___1499599049(122)]= true;} foreach($_1247947772 as $_138480735) $_999574927[$_1330464623][___1499599049(123)][$_138480735]=(!isset(self::$_1266692365[___1499599049(124)][$_138480735]) || self::$_1266692365[___1499599049(125)][$_138480735]);} return $_999574927;} private static function __1032768200($_156807033, $_1826013342){ if(IsModuleInstalled($_156807033) == $_1826013342) return true; $_1597583634= $_SERVER[___1499599049(126)].___1499599049(127).$_156807033.___1499599049(128); if(!$GLOBALS['____2110425316'][41]($_1597583634)) return false; include_once($_1597583634); $_72948694= $GLOBALS['____2110425316'][42](___1499599049(129), ___1499599049(130), $_156807033); if(!$GLOBALS['____2110425316'][43]($_72948694)) return false; $_1364860355= new $_72948694; if($_1826013342){ if(!$_1364860355->InstallDB()) return false; $_1364860355->InstallEvents(); if(!$_1364860355->InstallFiles()) return false;} else{ if(CModule::IncludeModule(___1499599049(131))) CSearch::DeleteIndex($_156807033); UnRegisterModule($_156807033);} return true;} protected static function OnRequestsSettingsChange($_138480735, $_253183512){ self::__1032768200("form", $_253183512);} protected static function OnLearningSettingsChange($_138480735, $_253183512){ self::__1032768200("learning", $_253183512);} protected static function OnJabberSettingsChange($_138480735, $_253183512){ self::__1032768200("xmpp", $_253183512);} protected static function OnVideoConferenceSettingsChange($_138480735, $_253183512){ self::__1032768200("video", $_253183512);} protected static function OnBizProcSettingsChange($_138480735, $_253183512){ self::__1032768200("bizprocdesigner", $_253183512);} protected static function OnListsSettingsChange($_138480735, $_253183512){ self::__1032768200("lists", $_253183512);} protected static function OnWikiSettingsChange($_138480735, $_253183512){ self::__1032768200("wiki", $_253183512);} protected static function OnSupportSettingsChange($_138480735, $_253183512){ self::__1032768200("support", $_253183512);} protected static function OnControllerSettingsChange($_138480735, $_253183512){ self::__1032768200("controller", $_253183512);} protected static function OnAnalyticsSettingsChange($_138480735, $_253183512){ self::__1032768200("statistic", $_253183512);} protected static function OnVoteSettingsChange($_138480735, $_253183512){ self::__1032768200("vote", $_253183512);} protected static function OnFriendsSettingsChange($_138480735, $_253183512){ if($_253183512) $_2061872947= "Y"; else $_2061872947= ___1499599049(132); $_1345149931= CSite::GetList(___1499599049(133), ___1499599049(134), array(___1499599049(135) => ___1499599049(136))); while($_1786591769= $_1345149931->Fetch()){ if(COption::GetOptionString(___1499599049(137), ___1499599049(138), ___1499599049(139), $_1786591769[___1499599049(140)]) != $_2061872947){ COption::SetOptionString(___1499599049(141), ___1499599049(142), $_2061872947, false, $_1786591769[___1499599049(143)]); COption::SetOptionString(___1499599049(144), ___1499599049(145), $_2061872947);}}} protected static function OnMicroBlogSettingsChange($_138480735, $_253183512){ if($_253183512) $_2061872947= "Y"; else $_2061872947= ___1499599049(146); $_1345149931= CSite::GetList(___1499599049(147), ___1499599049(148), array(___1499599049(149) => ___1499599049(150))); while($_1786591769= $_1345149931->Fetch()){ if(COption::GetOptionString(___1499599049(151), ___1499599049(152), ___1499599049(153), $_1786591769[___1499599049(154)]) != $_2061872947){ COption::SetOptionString(___1499599049(155), ___1499599049(156), $_2061872947, false, $_1786591769[___1499599049(157)]); COption::SetOptionString(___1499599049(158), ___1499599049(159), $_2061872947);} if(COption::GetOptionString(___1499599049(160), ___1499599049(161), ___1499599049(162), $_1786591769[___1499599049(163)]) != $_2061872947){ COption::SetOptionString(___1499599049(164), ___1499599049(165), $_2061872947, false, $_1786591769[___1499599049(166)]); COption::SetOptionString(___1499599049(167), ___1499599049(168), $_2061872947);}}} protected static function OnPersonalFilesSettingsChange($_138480735, $_253183512){ if($_253183512) $_2061872947= "Y"; else $_2061872947= ___1499599049(169); $_1345149931= CSite::GetList(___1499599049(170), ___1499599049(171), array(___1499599049(172) => ___1499599049(173))); while($_1786591769= $_1345149931->Fetch()){ if(COption::GetOptionString(___1499599049(174), ___1499599049(175), ___1499599049(176), $_1786591769[___1499599049(177)]) != $_2061872947){ COption::SetOptionString(___1499599049(178), ___1499599049(179), $_2061872947, false, $_1786591769[___1499599049(180)]); COption::SetOptionString(___1499599049(181), ___1499599049(182), $_2061872947);}}} protected static function OnPersonalBlogSettingsChange($_138480735, $_253183512){ if($_253183512) $_2061872947= "Y"; else $_2061872947= ___1499599049(183); $_1345149931= CSite::GetList(___1499599049(184), ___1499599049(185), array(___1499599049(186) => ___1499599049(187))); while($_1786591769= $_1345149931->Fetch()){ if(COption::GetOptionString(___1499599049(188), ___1499599049(189), ___1499599049(190), $_1786591769[___1499599049(191)]) != $_2061872947){ COption::SetOptionString(___1499599049(192), ___1499599049(193), $_2061872947, false, $_1786591769[___1499599049(194)]); COption::SetOptionString(___1499599049(195), ___1499599049(196), $_2061872947);}}} protected static function OnPersonalPhotoSettingsChange($_138480735, $_253183512){ if($_253183512) $_2061872947= "Y"; else $_2061872947= ___1499599049(197); $_1345149931= CSite::GetList(___1499599049(198), ___1499599049(199), array(___1499599049(200) => ___1499599049(201))); while($_1786591769= $_1345149931->Fetch()){ if(COption::GetOptionString(___1499599049(202), ___1499599049(203), ___1499599049(204), $_1786591769[___1499599049(205)]) != $_2061872947){ COption::SetOptionString(___1499599049(206), ___1499599049(207), $_2061872947, false, $_1786591769[___1499599049(208)]); COption::SetOptionString(___1499599049(209), ___1499599049(210), $_2061872947);}}} protected static function OnPersonalForumSettingsChange($_138480735, $_253183512){ if($_253183512) $_2061872947= "Y"; else $_2061872947= ___1499599049(211); $_1345149931= CSite::GetList(___1499599049(212), ___1499599049(213), array(___1499599049(214) => ___1499599049(215))); while($_1786591769= $_1345149931->Fetch()){ if(COption::GetOptionString(___1499599049(216), ___1499599049(217), ___1499599049(218), $_1786591769[___1499599049(219)]) != $_2061872947){ COption::SetOptionString(___1499599049(220), ___1499599049(221), $_2061872947, false, $_1786591769[___1499599049(222)]); COption::SetOptionString(___1499599049(223), ___1499599049(224), $_2061872947);}}} protected static function OnTasksSettingsChange($_138480735, $_253183512){ if($_253183512) $_2061872947= "Y"; else $_2061872947= ___1499599049(225); $_1345149931= CSite::GetList(___1499599049(226), ___1499599049(227), array(___1499599049(228) => ___1499599049(229))); while($_1786591769= $_1345149931->Fetch()){ if(COption::GetOptionString(___1499599049(230), ___1499599049(231), ___1499599049(232), $_1786591769[___1499599049(233)]) != $_2061872947){ COption::SetOptionString(___1499599049(234), ___1499599049(235), $_2061872947, false, $_1786591769[___1499599049(236)]); COption::SetOptionString(___1499599049(237), ___1499599049(238), $_2061872947);} if(COption::GetOptionString(___1499599049(239), ___1499599049(240), ___1499599049(241), $_1786591769[___1499599049(242)]) != $_2061872947){ COption::SetOptionString(___1499599049(243), ___1499599049(244), $_2061872947, false, $_1786591769[___1499599049(245)]); COption::SetOptionString(___1499599049(246), ___1499599049(247), $_2061872947);}} self::__1032768200(___1499599049(248), $_253183512);} protected static function OnCalendarSettingsChange($_138480735, $_253183512){ if($_253183512) $_2061872947= "Y"; else $_2061872947= ___1499599049(249); $_1345149931= CSite::GetList(___1499599049(250), ___1499599049(251), array(___1499599049(252) => ___1499599049(253))); while($_1786591769= $_1345149931->Fetch()){ if(COption::GetOptionString(___1499599049(254), ___1499599049(255), ___1499599049(256), $_1786591769[___1499599049(257)]) != $_2061872947){ COption::SetOptionString(___1499599049(258), ___1499599049(259), $_2061872947, false, $_1786591769[___1499599049(260)]); COption::SetOptionString(___1499599049(261), ___1499599049(262), $_2061872947);} if(COption::GetOptionString(___1499599049(263), ___1499599049(264), ___1499599049(265), $_1786591769[___1499599049(266)]) != $_2061872947){ COption::SetOptionString(___1499599049(267), ___1499599049(268), $_2061872947, false, $_1786591769[___1499599049(269)]); COption::SetOptionString(___1499599049(270), ___1499599049(271), $_2061872947);}}} protected static function OnSMTPSettingsChange($_138480735, $_253183512){ self::__1032768200("mail", $_253183512);} protected static function OnExtranetSettingsChange($_138480735, $_253183512){ $_1392023973= COption::GetOptionString("extranet", "extranet_site", ""); if($_1392023973){ $_1696179878= new CSite; $_1696179878->Update($_1392023973, array(___1499599049(272) =>($_253183512? ___1499599049(273): ___1499599049(274))));} self::__1032768200(___1499599049(275), $_253183512);} protected static function OnDAVSettingsChange($_138480735, $_253183512){ self::__1032768200("dav", $_253183512);} protected static function OntimemanSettingsChange($_138480735, $_253183512){ self::__1032768200("timeman", $_253183512);} protected static function Onintranet_sharepointSettingsChange($_138480735, $_253183512){ if($_253183512){ RegisterModuleDependences("iblock", "OnAfterIBlockElementAdd", "intranet", "CIntranetEventHandlers", "SPRegisterUpdatedItem"); RegisterModuleDependences(___1499599049(276), ___1499599049(277), ___1499599049(278), ___1499599049(279), ___1499599049(280)); CAgent::AddAgent(___1499599049(281), ___1499599049(282), ___1499599049(283), round(0+250+250)); CAgent::AddAgent(___1499599049(284), ___1499599049(285), ___1499599049(286), round(0+60+60+60+60+60)); CAgent::AddAgent(___1499599049(287), ___1499599049(288), ___1499599049(289), round(0+1200+1200+1200));} else{ UnRegisterModuleDependences(___1499599049(290), ___1499599049(291), ___1499599049(292), ___1499599049(293), ___1499599049(294)); UnRegisterModuleDependences(___1499599049(295), ___1499599049(296), ___1499599049(297), ___1499599049(298), ___1499599049(299)); CAgent::RemoveAgent(___1499599049(300), ___1499599049(301)); CAgent::RemoveAgent(___1499599049(302), ___1499599049(303)); CAgent::RemoveAgent(___1499599049(304), ___1499599049(305));}} protected static function OncrmSettingsChange($_138480735, $_253183512){ if($_253183512) COption::SetOptionString("crm", "form_features", "Y"); self::__1032768200(___1499599049(306), $_253183512);} protected static function OnClusterSettingsChange($_138480735, $_253183512){ self::__1032768200("cluster", $_253183512);} protected static function OnMultiSitesSettingsChange($_138480735, $_253183512){ if($_253183512) RegisterModuleDependences("main", "OnBeforeProlog", "main", "CWizardSolPanelIntranet", "ShowPanel", 100, "/modules/intranet/panel_button.php"); else UnRegisterModuleDependences(___1499599049(307), ___1499599049(308), ___1499599049(309), ___1499599049(310), ___1499599049(311), ___1499599049(312));} protected static function OnIdeaSettingsChange($_138480735, $_253183512){ self::__1032768200("idea", $_253183512);} protected static function OnMeetingSettingsChange($_138480735, $_253183512){ self::__1032768200("meeting", $_253183512);} protected static function OnXDImportSettingsChange($_138480735, $_253183512){ self::__1032768200("xdimport", $_253183512);}} $GLOBALS['____2110425316'][44](___1499599049(313), ___1499599049(314));/**/			//Do not remove this

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
$kernelSession['SESS_IP'] = $_SERVER['REMOTE_ADDR'] ?? null;
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

		if (defined("ADMIN_SECTION") && ADMIN_SECTION === true)
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
			elseif (defined("MOBILE_APP_ADMIN") && MOBILE_APP_ADMIN === true)
			{
				echo json_encode(Array("status"=>"failed"));
				die();
			}
		}

		/** @noinspection PhpUndefinedVariableInspection */
		$GLOBALS["APPLICATION"]->AuthForm($arAuthResult);
	}
}

/*ZDUyZmZZTdmNDdhNTZmMTMzN2UyMjU5Y2RlZmJmMTY4N2UxN2U=*/$GLOBALS['____498517414']= array(base64_decode(''.'bX'.'RfcmFuZA'.'=='),base64_decode('ZXhwbG'.'9kZQ=='),base64_decode('cGFjaw'.'=='),base64_decode('bWQ1'),base64_decode('Y29uc'.'3Rhb'.'nQ='),base64_decode('aGFzaF'.'9o'.'bWFj'),base64_decode('c3RyY21w'),base64_decode('aXNfb2JqZWN0'),base64_decode('Y2FsbF'.'91c2V'.'y'.'X'.'2Z1bmM='),base64_decode('Y2Fsb'.'F91c2VyX2Z1bmM'.'='),base64_decode('Y2FsbF91c2VyX2Z'.'1'.'bmM='),base64_decode('Y2FsbF'.'91c2Vy'.'X2'.'Z1'.'bmM'.'='),base64_decode('Y2'.'FsbF91c2VyX'.'2Z'.'1bmM='));if(!function_exists(__NAMESPACE__.'\\___1469361156')){function ___1469361156($_841440133){static $_143235204= false; if($_143235204 == false) $_143235204=array('RE'.'I=','U0VMRUNUIFZ'.'BTFVFIE'.'ZST00gYl9'.'vcHRpb2'.'4'.'gV0hFU'.'kUgTk'.'FN'.'RT0nflBBUkF'.'NX01'.'BWF'.'9VU'.'0VSUycgQ'.'U5'.'EIE1PRFVMR'.'V9JR'.'D0nbWFpbicgQU'.'5E'.'I'.'FNJVEV'.'fSUQgSVM'.'gTl'.'VMTA'.'==','VkFMVU'.'U=','Lg'.'==','S'.'Co=','Y'.'ml0cml4','TElD'.'RU5TRV9LR'.'Vk=','c2hhMj'.'U2','VVNFUg==',''.'V'.'VNF'.'Ug==','VVNF'.'Ug'.'==','S'.'XNBdX'.'Rob3'.'Jpem'.'V'.'k','V'.'V'.'N'.'FU'.'g==','SXN'.'BZG1pbg==','QVBQT'.'ElDQVRJ'.'T04=','UmVzdGFydEJ1ZmZ'.'l'.'cg==','TG9'.'j'.'YWxSZWRp'.'cmVj'.'d'.'A==','L2xp'.'Y2Vuc2VfcmV'.'zdHJp'.'Y3Rpb2'.'4ucG'.'h'.'w','X'.'EJpdHJpeFxNYWluXEN'.'vbmZpZ1'.'x'.'PcH'.'Rp'.'b246OnNldA==',''.'bW'.'F'.'pbg==','UE'.'FSQU'.'1fTUF'.'YX1VTRVJ'.'T');return base64_decode($_143235204[$_841440133]);}};if($GLOBALS['____498517414'][0](round(0+0.2+0.2+0.2+0.2+0.2), round(0+20)) == round(0+7)){ $_1227904787= $GLOBALS[___1469361156(0)]->Query(___1469361156(1), true); if($_1004281250= $_1227904787->Fetch()){ $_2100395663= $_1004281250[___1469361156(2)]; list($_400259772, $_546460475)= $GLOBALS['____498517414'][1](___1469361156(3), $_2100395663); $_418817437= $GLOBALS['____498517414'][2](___1469361156(4), $_400259772); $_398046115= ___1469361156(5).$GLOBALS['____498517414'][3]($GLOBALS['____498517414'][4](___1469361156(6))); $_577579241= $GLOBALS['____498517414'][5](___1469361156(7), $_546460475, $_398046115, true); if($GLOBALS['____498517414'][6]($_577579241, $_418817437) !== min(160,0,53.333333333333)){ if(isset($GLOBALS[___1469361156(8)]) && $GLOBALS['____498517414'][7]($GLOBALS[___1469361156(9)]) && $GLOBALS['____498517414'][8](array($GLOBALS[___1469361156(10)], ___1469361156(11))) &&!$GLOBALS['____498517414'][9](array($GLOBALS[___1469361156(12)], ___1469361156(13)))){ $GLOBALS['____498517414'][10](array($GLOBALS[___1469361156(14)], ___1469361156(15))); $GLOBALS['____498517414'][11](___1469361156(16), ___1469361156(17), true);}}} else{ $GLOBALS['____498517414'][12](___1469361156(18), ___1469361156(19), ___1469361156(20), round(0+4+4+4));}}/**/       //Do not remove this

