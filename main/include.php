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

/*ZDUyZmZNjllZWU2ZGE1ZTkwZmU5YWViNTMyNmI1ZmFkMmFlNjc=*/$GLOBALS['_____114593584']= array(base64_decode('R2V'.'0'.'TW9kdWx'.'lRXZlbnRz'),base64_decode('RX'.'hlY'.'3V0ZU1vZHVsZU'.'V2ZW50RXg'.'='));$GLOBALS['____504656571']= array(base64_decode(''.'ZGVmaW5l'),base64_decode('Ym'.'FzZ'.'T'.'Y0'.'X2'.'RlY29kZQ=='),base64_decode('dW5zZXJpYW'.'xpemU='),base64_decode('a'.'XNfYXJyYX'.'k='),base64_decode('aW5fYX'.'JyYXk='),base64_decode('c2VyaWFsaXp'.'l'),base64_decode(''.'YmFzZT'.'Y0X'.'2'.'VuY2'.'9kZQ='.'='),base64_decode('bWt0'.'aW1l'),base64_decode('Z'.'G'.'F0ZQ=='),base64_decode('ZGF0'.'ZQ'.'=='),base64_decode('c3'.'Ry'.'bGV'.'u'),base64_decode(''.'bWt0aW1l'),base64_decode(''.'ZGF'.'0ZQ'.'=='),base64_decode('ZG'.'F0ZQ'.'=='),base64_decode('bWV0aG'.'9'.'kX'.'2'.'V4a'.'XN0'.'cw=='),base64_decode('Y'.'2FsbF'.'91c'.'2VyX2Z1bmNfYXJyYXk='),base64_decode('c3'.'R'.'ybGVu'),base64_decode('c'.'2VyaWFsaXp'.'l'),base64_decode('YmFzZ'.'T'.'Y0X'.'2VuY29kZQ=='),base64_decode('c3Ry'.'bGVu'),base64_decode(''.'aXNfY'.'XJyYXk='),base64_decode(''.'c2VyaW'.'FsaXpl'),base64_decode('YmFzZTY'.'0'.'X'.'2VuY'.'2'.'9kZQ='.'='),base64_decode('c2VyaWFsaXpl'),base64_decode('Ym'.'F'.'zZTY0X'.'2VuY29kZ'.'Q='.'='),base64_decode('aXNf'.'YXJyYXk='),base64_decode('a'.'X'.'N'.'f'.'YXJyY'.'Xk='),base64_decode(''.'aW'.'5f'.'YXJy'.'YX'.'k='),base64_decode('aW'.'5fYXJyYXk='),base64_decode(''.'bW'.'t0a'.'W'.'1l'),base64_decode('ZGF'.'0ZQ'.'=='),base64_decode('ZGF0'.'ZQ=='),base64_decode('ZGF'.'0'.'ZQ'.'=='),base64_decode('b'.'Wt'.'0aW1l'),base64_decode('ZGF'.'0'.'Z'.'Q=='),base64_decode('ZGF0'.'ZQ=='),base64_decode('aW'.'5f'.'Y'.'X'.'JyY'.'Xk='),base64_decode(''.'c2VyaWFsaXp'.'l'),base64_decode('YmFz'.'Z'.'TY0X'.'2'.'VuY2'.'9kZQ'.'=='),base64_decode('aW50d'.'mFs'),base64_decode('dG'.'ltZQ=='),base64_decode('Zmls'.'ZV'.'9le'.'GlzdHM='),base64_decode('c'.'3'.'RyX3'.'J'.'lcG'.'xhY2'.'U'.'='),base64_decode('Y2xhc3NfZX'.'h'.'pc3Rz'),base64_decode('ZG'.'V'.'maW5'.'l'));if(!function_exists(__NAMESPACE__.'\\___506759864')){function ___506759864($_1509653832){static $_1658914827= false; if($_1658914827 == false) $_1658914827=array(''.'SU'.'5UUkFORV'.'R'.'fR'.'U'.'RJVElPTg==','W'.'Q'.'==',''.'bWFpb'.'g==','fmNwZl9'.'tYXBfdm'.'Fsd'.'WU'.'=','','',''.'YWxs'.'b3dlZF9j'.'bGF'.'zc2Vz','Z'.'Q'.'==',''.'Zg==','Z'.'Q'.'==','R'.'g==','WA==','Zg==','b'.'WFpbg==','fmNwZl'.'9'.'tY'.'XB'.'f'.'dm'.'FsdWU'.'=','UG'.'9'.'ydGFs','Rg==','Z'.'Q'.'==',''.'ZQ==','WA==','Rg==','RA==','RA==','b'.'Q'.'==','ZA'.'==',''.'WQ='.'=','Z'.'g='.'=','Zg==','Zg==','Zg'.'==','UG9'.'ydG'.'Fs','Rg'.'==','ZQ==',''.'ZQ'.'==',''.'WA'.'==','R'.'g'.'==','R'.'A='.'=','RA==','bQ==','ZA==','WQ==','bWFpb'.'g'.'==','T24=','U2V0'.'dG'.'luZ3NDaG'.'FuZ2U=','Zg='.'=','Zg==','Zg='.'=','Zg==','bWFp'.'b'.'g='.'=',''.'fmN'.'wZl'.'9tYXBf'.'dmFsd'.'W'.'U=','ZQ==',''.'ZQ'.'==','RA='.'=',''.'ZQ==','Z'.'Q==','Z'.'g==','Zg==','Z'.'g='.'=',''.'ZQ==','bWFpbg==',''.'fmNwZl9'.'t'.'Y'.'XBf'.'dm'.'FsdW'.'U'.'=',''.'ZQ'.'==','Zg==','Z'.'g='.'=',''.'Zg==','Zg==','bWFpbg==','fmNwZl9tYXBfdmFsd'.'WU'.'=','ZQ==','Z'.'g==','UG9y'.'dGFs','UG9ydGF'.'s',''.'ZQ='.'=','ZQ==','UG9ydGFs','Rg'.'==','WA==','Rg='.'=','RA==',''.'ZQ==','ZQ==','RA==','bQ'.'='.'=','Z'.'A==','W'.'Q==','ZQ='.'=','WA'.'==',''.'ZQ'.'==',''.'Rg==','ZQ'.'==','RA==','Zg==','Z'.'Q'.'==','RA==',''.'Z'.'Q==','bQ==','ZA==','WQ==','Zg='.'=',''.'Zg'.'==','Zg==','Z'.'g='.'=','Zg==','Z'.'g='.'=','Zg==',''.'Zg==','bWFpbg'.'==','f'.'mNwZl'.'9tYXBf'.'dmFsdWU=','ZQ==','ZQ==','UG9y'.'dGFs','R'.'g='.'=','W'.'A==',''.'VFl'.'QRQ==','REFU'.'RQ==','R'.'kV'.'B'.'VFV'.'SRV'.'M=','RVhQSVJFRA='.'=','VF'.'lQRQ==','R'.'A==','VFJ'.'ZX0RBWVNfQ09VTlQ=','R'.'EFUR'.'Q==','VFJZX'.'0R'.'B'.'WVNfQ'.'09VTlQ=',''.'RV'.'h'.'QSV'.'J'.'FR'.'A==','RkVBVFVSR'.'V'.'M=','Zg==','Zg'.'='.'=',''.'RE9DV'.'U1FTlRf'.'Uk'.'9PV'.'A==','L2JpdHJpe'.'C9'.'tb2'.'R1bG'.'VzL'.'w==','L'.'2lu'.'c3RhbGw'.'vaW'.'5kZXgucGhw',''.'L'.'g==','Xw==','c2Vhc'.'m'.'No','T'.'g'.'='.'=','','','QUN'.'USVZF','WQ==',''.'c'.'29ja'.'WFsbm'.'V0d29yaw='.'=','YW'.'xsb'.'3df'.'Z'.'nJpZW'.'xkcw='.'=','W'.'Q==','S'.'UQ'.'=','c29j'.'aW'.'FsbmV0d29yaw='.'=','YWxsb3d'.'fZnJpZWxkcw==',''.'SUQ=','c29'.'jaWFsbm'.'V'.'0d2'.'9yaw'.'==','Y'.'Wxs'.'b3'.'df'.'Z'.'n'.'JpZWx'.'kcw==',''.'Tg==','','','QUNUSVZF',''.'WQ==',''.'c29jaWFsbmV0d2'.'9yaw==',''.'YW'.'x'.'sb3'.'dfbWljc'.'m9ib'.'G9nX3V'.'zZ'.'XI=','WQ==',''.'SU'.'Q=',''.'c'.'29jaWFsb'.'mV0d29y'.'aw==','YW'.'xsb3dfbW'.'ljcm9ibG9nX3'.'VzZXI=','SUQ=','c'.'2'.'9jaWFs'.'bmV0d29ya'.'w==','YWxsb3'.'d'.'fbWljcm9ibG9nX3VzZXI=','c29jaWFsb'.'m'.'V0d29ya'.'w'.'==','Y'.'Wxsb3df'.'bWljc'.'m9ibG'.'9nX2'.'dyb3V'.'w','WQ==','SUQ'.'=','c29ja'.'WF'.'s'.'bmV0d29yaw'.'==','YWx'.'sb3dfbWljcm'.'9ibG9n'.'X2dyb3Vw',''.'SUQ=',''.'c29jaWF'.'sbm'.'V0d'.'29y'.'aw==','Y'.'Wxs'.'b3df'.'b'.'Wlj'.'cm'.'9ib'.'G9nX2dyb'.'3V'.'w','T'.'g='.'=','','','QUN'.'USVZF',''.'W'.'Q==','c29'.'ja'.'WFsbmV'.'0d2'.'9yaw'.'='.'=',''.'Y'.'Wxsb3'.'df'.'Zm'.'ls'.'ZX'.'Nf'.'dX'.'N'.'lcg==','WQ==','SU'.'Q=','c29jaWFsbm'.'V'.'0d29ya'.'w==','YW'.'xs'.'b3dfZmlsZX'.'Nfd'.'XNlcg==','SU'.'Q=',''.'c2'.'9jaWF'.'sbmV0'.'d29yaw==','YWxsb3dfZml'.'sZ'.'X'.'NfdXN'.'l'.'cg==','Tg'.'==','','','QUNUS'.'VZF',''.'WQ'.'==','c29'.'jaWF'.'sbmV0'.'d29ya'.'w'.'==','YW'.'xsb3dfY'.'mxvZ'.'191c2Vy','WQ==','SUQ=','c29jaWFs'.'b'.'mV0d'.'29yaw==',''.'Y'.'Wx'.'sb3dfYm'.'x'.'vZ19'.'1'.'c2Vy','SUQ'.'=',''.'c2'.'9'.'jaWFsbm'.'V0d29ya'.'w'.'==','YWxsb3dfYmxvZ'.'191c2Vy','Tg==','','',''.'QUNUSVZF','WQ==','c29ja'.'W'.'FsbmV'.'0d'.'2'.'9y'.'a'.'w='.'=','YWxsb3dfc'.'GhvdG9fdX'.'Nlcg='.'=','WQ==','SUQ=',''.'c2'.'9jaW'.'F'.'sbmV'.'0d29yaw==','YWxsb'.'3d'.'fcGhvdG9'.'fdXNlcg='.'=','SUQ=',''.'c2'.'9jaWFsbmV0'.'d29y'.'aw==','YWxs'.'b'.'3df'.'cGh'.'vdG9fd'.'XNlc'.'g==','Tg==','','','QUN'.'US'.'V'.'ZF',''.'WQ==','c29jaWF'.'sb'.'mV0d29ya'.'w==','YW'.'x'.'sb3dfZm9'.'yd'.'W'.'1fdX'.'N'.'lcg'.'==','WQ==','SUQ=',''.'c29jaWFsbm'.'V'.'0d2'.'9'.'y'.'a'.'w='.'=','YWxsb3'.'dfZ'.'m9y'.'dW'.'1'.'fdXNlcg==','SU'.'Q=','c'.'29jaW'.'FsbmV0d'.'29'.'yaw==','YW'.'x'.'sb3dfZm9'.'y'.'d'.'W'.'1f'.'dXNlcg='.'=',''.'T'.'g==','','','QUNU'.'SVZ'.'F',''.'WQ==','c2'.'9ja'.'WF'.'sbmV0d2'.'9'.'yaw='.'=',''.'YWxsb3dfdGF'.'za3Nf'.'dXNl'.'c'.'g==','WQ='.'=','SU'.'Q=','c29jaWFsbmV'.'0d29'.'yaw==','YW'.'xs'.'b'.'3dfd'.'GFza'.'3NfdXNlcg'.'==','SUQ=','c29jaWFs'.'bm'.'V0'.'d'.'29yaw='.'=','YW'.'xsb3'.'dfdG'.'Fza3NfdXNlcg==','c'.'29'.'ja'.'WFsbmV0d29'.'ya'.'w==','YWxsb3d'.'fd'.'GFza3N'.'fZ'.'3Jv'.'dXA=',''.'WQ'.'==','SUQ'.'=','c'.'29jaWFsbmV0'.'d29ya'.'w==','YWxsb3dfdGFza3N'.'fZ3Jv'.'dXA=','SUQ=','c29jaWFs'.'bmV0d29ya'.'w='.'=','YW'.'xsb'.'3dfdGFza3NfZ3'.'JvdXA=',''.'dG'.'F'.'za3M=','Tg==','','','QUNUSVZ'.'F',''.'W'.'Q'.'='.'=','c29ja'.'WFsbmV0'.'d29yaw'.'==','YWxsb'.'3dfY2'.'Fs'.'Z'.'W5k'.'YXJfd'.'XNlcg==',''.'WQ='.'=','S'.'UQ=','c'.'29j'.'a'.'WFsbmV0d29'.'yaw='.'=','Y'.'Wxsb'.'3dfY2'.'FsZW5kY'.'XJ'.'fdXNlcg==','SUQ=',''.'c29'.'ja'.'WFsbmV'.'0d'.'2'.'9yaw'.'==','YWxsb3dfY'.'2FsZW'.'5k'.'YXJ'.'fdXNl'.'cg==','c29ja'.'WFs'.'bmV0d29ya'.'w==','YWxs'.'b3'.'d'.'f'.'Y2FsZW5kY'.'XJfZ'.'3'.'JvdXA=',''.'WQ='.'=',''.'SUQ=','c29jaWFs'.'b'.'mV0d29y'.'aw==','YW'.'xs'.'b3dfY2FsZW5kYXJfZ3Jvd'.'X'.'A=','SUQ=',''.'c2'.'9jaW'.'FsbmV0'.'d'.'2'.'9'.'ya'.'w==','YW'.'x'.'s'.'b3'.'df'.'Y2FsZW5kYX'.'JfZ3JvdXA=','Q'.'UN'.'USVZF','W'.'Q==','Tg==',''.'ZXh0cmFuZ'.'XQ=','aWJs'.'b'.'2N'.'r',''.'T'.'2'.'5BZn'.'RlcklCbG9ja'.'0VsZW1'.'lb'.'nRV'.'cGRhdGU=','aW50cmFuZXQ=','Q0ludH'.'Jhb'.'mV0RXZlbnRIYW5k'.'bGVy'.'cw==','U1BSZWd'.'p'.'c3Rl'.'c'.'lVwZ'.'GF0'.'Z'.'WR'.'JdGVt','Q0lu'.'dHJ'.'h'.'bm'.'V0U2hh'.'cmV'.'wb2l'.'udDo6QWd'.'lbn'.'RMaXN0cygp'.'Ow==','aW50cmFu'.'ZXQ=',''.'Tg'.'==','Q0'.'ludHJhb'.'mV'.'0U2h'.'hcm'.'Vwb'.'2'.'lu'.'d'.'Do6Q'.'Wdlb'.'n'.'R'.'RdWV1ZSgpOw='.'=','aW5'.'0c'.'mFuZXQ=','Tg==','Q0'.'ludH'.'JhbmV'.'0U2hh'.'cmV'.'wb2l'.'udDo'.'6QW'.'dlbnRVcGRhdGUoKTs=','a'.'W50cmF'.'uZ'.'XQ=','T'.'g==',''.'aWJs'.'b2Nr','T'.'25BZnRlcklC'.'bG9'.'ja0VsZW1lbnRB'.'ZG'.'Q=',''.'aW50cm'.'F'.'uZXQ=','Q'.'0ludHJh'.'bmV0RXZl'.'b'.'nRIY'.'W'.'5'.'kbGVycw==','U1BSZWdpc3RlclVwZG'.'F0Z'.'WRJdGVt',''.'a'.'W'.'J'.'sb2Nr',''.'T25'.'BZnRlck'.'lCbG9ja0'.'VsZ'.'W1lb'.'nRV'.'cG'.'RhdG'.'U'.'=','a'.'W50cmF'.'uZXQ=','Q0'.'lud'.'HJh'.'bm'.'V0RXZ'.'lb'.'n'.'RIYW5k'.'b'.'GVycw==','U1'.'BSZWdpc3Rlc'.'lV'.'wZGF'.'0'.'ZWRJdG'.'Vt','Q0ludHJ'.'hbmV0U2hhcmV'.'wb2'.'ludDo'.'6QWd'.'lbnRMaXN0cygpOw'.'==','aW5'.'0'.'cmFuZXQ=','Q0ludHJhb'.'m'.'V0'.'U2hh'.'cmVwb2lu'.'d'.'Do6'.'QW'.'dlbnRRdWV1ZSgpOw='.'=','a'.'W5'.'0cmFuZXQ=','Q0lu'.'d'.'HJ'.'h'.'bmV0U2hhcm'.'Vwb2ludDo6QWd'.'lb'.'nRVc'.'GRhdGU'.'oKTs=','aW50cm'.'F'.'uZXQ=','Y'.'3Jt','b'.'W'.'Fpbg'.'==','T25'.'C'.'ZWZ'.'vcmV'.'Qcm9sb'.'2c=','b'.'W'.'Fpbg==','Q'.'1dpem'.'FyZFNvb'.'FBh'.'bmV'.'sSW50cm'.'Fu'.'ZXQ=','U2'.'hvd1'.'Bhb'.'mVs','L21vZHVsZXMvaW50c'.'mFuZ'.'XQvcGF'.'uZWxfYnV'.'0d'.'G9'.'uL'.'nBocA='.'=','R'.'U5DT'.'0'.'R'.'F','WQ'.'==');return base64_decode($_1658914827[$_1509653832]);}};$GLOBALS['____504656571'][0](___506759864(0), ___506759864(1));class CBXFeatures{ private static $_1925455375= 30; private static $_1069216426= array( "Portal" => array( "CompanyCalendar", "CompanyPhoto", "CompanyVideo", "CompanyCareer", "StaffChanges", "StaffAbsence", "CommonDocuments", "MeetingRoomBookingSystem", "Wiki", "Learning", "Vote", "WebLink", "Subscribe", "Friends", "PersonalFiles", "PersonalBlog", "PersonalPhoto", "PersonalForum", "Blog", "Forum", "Gallery", "Board", "MicroBlog", "WebMessenger",), "Communications" => array( "Tasks", "Calendar", "Workgroups", "Jabber", "VideoConference", "Extranet", "SMTP", "Requests", "DAV", "intranet_sharepoint", "timeman", "Idea", "Meeting", "EventList", "Salary", "XDImport",), "Enterprise" => array( "BizProc", "Lists", "Support", "Analytics", "crm", "Controller", "LdapUnlimitedUsers",), "Holding" => array( "Cluster", "MultiSites",),); private static $_1256320429= null; private static $_466094264= null; private static function __1054825780(){ if(self::$_1256320429 === null){ self::$_1256320429= array(); foreach(self::$_1069216426 as $_406565250 => $_1385720725){ foreach($_1385720725 as $_633133680) self::$_1256320429[$_633133680]= $_406565250;}} if(self::$_466094264 === null){ self::$_466094264= array(); $_522956989= COption::GetOptionString(___506759864(2), ___506759864(3), ___506759864(4)); if($_522956989 != ___506759864(5)){ $_522956989= $GLOBALS['____504656571'][1]($_522956989); $_522956989= $GLOBALS['____504656571'][2]($_522956989,[___506759864(6) => false]); if($GLOBALS['____504656571'][3]($_522956989)){ self::$_466094264= $_522956989;}} if(empty(self::$_466094264)){ self::$_466094264= array(___506759864(7) => array(), ___506759864(8) => array());}}} public static function InitiateEditionsSettings($_866308695){ self::__1054825780(); $_1544496016= array(); foreach(self::$_1069216426 as $_406565250 => $_1385720725){ $_1708035863= $GLOBALS['____504656571'][4]($_406565250, $_866308695); self::$_466094264[___506759864(9)][$_406565250]=($_1708035863? array(___506759864(10)): array(___506759864(11))); foreach($_1385720725 as $_633133680){ self::$_466094264[___506759864(12)][$_633133680]= $_1708035863; if(!$_1708035863) $_1544496016[]= array($_633133680, false);}} $_4672331= $GLOBALS['____504656571'][5](self::$_466094264); $_4672331= $GLOBALS['____504656571'][6]($_4672331); COption::SetOptionString(___506759864(13), ___506759864(14), $_4672331); foreach($_1544496016 as $_579437355) self::__1341075125($_579437355[(1032/2-516)], $_579437355[round(0+0.5+0.5)]);} public static function IsFeatureEnabled($_633133680){ if($_633133680 == '') return true; self::__1054825780(); if(!isset(self::$_1256320429[$_633133680])) return true; if(self::$_1256320429[$_633133680] == ___506759864(15)) $_1596045771= array(___506759864(16)); elseif(isset(self::$_466094264[___506759864(17)][self::$_1256320429[$_633133680]])) $_1596045771= self::$_466094264[___506759864(18)][self::$_1256320429[$_633133680]]; else $_1596045771= array(___506759864(19)); if($_1596045771[min(74,0,24.666666666667)] != ___506759864(20) && $_1596045771[(242*2-484)] != ___506759864(21)){ return false;} elseif($_1596045771[min(170,0,56.666666666667)] == ___506759864(22)){ if($_1596045771[round(0+0.33333333333333+0.33333333333333+0.33333333333333)]< $GLOBALS['____504656571'][7]((820-2*410),(249*2-498),(198*2-396), Date(___506759864(23)), $GLOBALS['____504656571'][8](___506759864(24))- self::$_1925455375, $GLOBALS['____504656571'][9](___506759864(25)))){ if(!isset($_1596045771[round(0+0.4+0.4+0.4+0.4+0.4)]) ||!$_1596045771[round(0+1+1)]) self::__661141408(self::$_1256320429[$_633133680]); return false;}} return!isset(self::$_466094264[___506759864(26)][$_633133680]) || self::$_466094264[___506759864(27)][$_633133680];} public static function IsFeatureInstalled($_633133680){ if($GLOBALS['____504656571'][10]($_633133680) <= 0) return true; self::__1054825780(); return(isset(self::$_466094264[___506759864(28)][$_633133680]) && self::$_466094264[___506759864(29)][$_633133680]);} public static function IsFeatureEditable($_633133680){ if($_633133680 == '') return true; self::__1054825780(); if(!isset(self::$_1256320429[$_633133680])) return true; if(self::$_1256320429[$_633133680] == ___506759864(30)) $_1596045771= array(___506759864(31)); elseif(isset(self::$_466094264[___506759864(32)][self::$_1256320429[$_633133680]])) $_1596045771= self::$_466094264[___506759864(33)][self::$_1256320429[$_633133680]]; else $_1596045771= array(___506759864(34)); if($_1596045771[(980-2*490)] != ___506759864(35) && $_1596045771[(151*2-302)] != ___506759864(36)){ return false;} elseif($_1596045771[(234*2-468)] == ___506759864(37)){ if($_1596045771[round(0+0.5+0.5)]< $GLOBALS['____504656571'][11]((890-2*445),(1080/2-540), min(20,0,6.6666666666667), Date(___506759864(38)), $GLOBALS['____504656571'][12](___506759864(39))- self::$_1925455375, $GLOBALS['____504656571'][13](___506759864(40)))){ if(!isset($_1596045771[round(0+0.4+0.4+0.4+0.4+0.4)]) ||!$_1596045771[round(0+0.4+0.4+0.4+0.4+0.4)]) self::__661141408(self::$_1256320429[$_633133680]); return false;}} return true;} private static function __1341075125($_633133680, $_822694892){ if($GLOBALS['____504656571'][14]("CBXFeatures", "On".$_633133680."SettingsChange")) $GLOBALS['____504656571'][15](array("CBXFeatures", "On".$_633133680."SettingsChange"), array($_633133680, $_822694892)); $_1668696011= $GLOBALS['_____114593584'][0](___506759864(41), ___506759864(42).$_633133680.___506759864(43)); while($_976855925= $_1668696011->Fetch()) $GLOBALS['_____114593584'][1]($_976855925, array($_633133680, $_822694892));} public static function SetFeatureEnabled($_633133680, $_822694892= true, $_1735074978= true){ if($GLOBALS['____504656571'][16]($_633133680) <= 0) return; if(!self::IsFeatureEditable($_633133680)) $_822694892= false; $_822694892= (bool)$_822694892; self::__1054825780(); $_1372401629=(!isset(self::$_466094264[___506759864(44)][$_633133680]) && $_822694892 || isset(self::$_466094264[___506759864(45)][$_633133680]) && $_822694892 != self::$_466094264[___506759864(46)][$_633133680]); self::$_466094264[___506759864(47)][$_633133680]= $_822694892; $_4672331= $GLOBALS['____504656571'][17](self::$_466094264); $_4672331= $GLOBALS['____504656571'][18]($_4672331); COption::SetOptionString(___506759864(48), ___506759864(49), $_4672331); if($_1372401629 && $_1735074978) self::__1341075125($_633133680, $_822694892);} private static function __661141408($_406565250){ if($GLOBALS['____504656571'][19]($_406565250) <= 0 || $_406565250 == "Portal") return; self::__1054825780(); if(!isset(self::$_466094264[___506759864(50)][$_406565250]) || self::$_466094264[___506759864(51)][$_406565250][(144*2-288)] != ___506759864(52)) return; if(isset(self::$_466094264[___506759864(53)][$_406565250][round(0+0.5+0.5+0.5+0.5)]) && self::$_466094264[___506759864(54)][$_406565250][round(0+0.66666666666667+0.66666666666667+0.66666666666667)]) return; $_1544496016= array(); if(isset(self::$_1069216426[$_406565250]) && $GLOBALS['____504656571'][20](self::$_1069216426[$_406565250])){ foreach(self::$_1069216426[$_406565250] as $_633133680){ if(isset(self::$_466094264[___506759864(55)][$_633133680]) && self::$_466094264[___506759864(56)][$_633133680]){ self::$_466094264[___506759864(57)][$_633133680]= false; $_1544496016[]= array($_633133680, false);}} self::$_466094264[___506759864(58)][$_406565250][round(0+2)]= true;} $_4672331= $GLOBALS['____504656571'][21](self::$_466094264); $_4672331= $GLOBALS['____504656571'][22]($_4672331); COption::SetOptionString(___506759864(59), ___506759864(60), $_4672331); foreach($_1544496016 as $_579437355) self::__1341075125($_579437355[(982-2*491)], $_579437355[round(0+0.2+0.2+0.2+0.2+0.2)]);} public static function ModifyFeaturesSettings($_866308695, $_1385720725){ self::__1054825780(); foreach($_866308695 as $_406565250 => $_1103431352) self::$_466094264[___506759864(61)][$_406565250]= $_1103431352; $_1544496016= array(); foreach($_1385720725 as $_633133680 => $_822694892){ if(!isset(self::$_466094264[___506759864(62)][$_633133680]) && $_822694892 || isset(self::$_466094264[___506759864(63)][$_633133680]) && $_822694892 != self::$_466094264[___506759864(64)][$_633133680]) $_1544496016[]= array($_633133680, $_822694892); self::$_466094264[___506759864(65)][$_633133680]= $_822694892;} $_4672331= $GLOBALS['____504656571'][23](self::$_466094264); $_4672331= $GLOBALS['____504656571'][24]($_4672331); COption::SetOptionString(___506759864(66), ___506759864(67), $_4672331); self::$_466094264= false; foreach($_1544496016 as $_579437355) self::__1341075125($_579437355[(1368/2-684)], $_579437355[round(0+0.25+0.25+0.25+0.25)]);} public static function SaveFeaturesSettings($_569080718, $_324949133){ self::__1054825780(); $_648519342= array(___506759864(68) => array(), ___506759864(69) => array()); if(!$GLOBALS['____504656571'][25]($_569080718)) $_569080718= array(); if(!$GLOBALS['____504656571'][26]($_324949133)) $_324949133= array(); if(!$GLOBALS['____504656571'][27](___506759864(70), $_569080718)) $_569080718[]= ___506759864(71); foreach(self::$_1069216426 as $_406565250 => $_1385720725){ if(isset(self::$_466094264[___506759864(72)][$_406565250])){ $_1823523504= self::$_466094264[___506759864(73)][$_406565250];} else{ $_1823523504=($_406565250 == ___506759864(74)? array(___506759864(75)): array(___506759864(76)));} if($_1823523504[(1196/2-598)] == ___506759864(77) || $_1823523504[(207*2-414)] == ___506759864(78)){ $_648519342[___506759864(79)][$_406565250]= $_1823523504;} else{ if($GLOBALS['____504656571'][28]($_406565250, $_569080718)) $_648519342[___506759864(80)][$_406565250]= array(___506759864(81), $GLOBALS['____504656571'][29]((228*2-456),(201*2-402),(764-2*382), $GLOBALS['____504656571'][30](___506759864(82)), $GLOBALS['____504656571'][31](___506759864(83)), $GLOBALS['____504656571'][32](___506759864(84)))); else $_648519342[___506759864(85)][$_406565250]= array(___506759864(86));}} $_1544496016= array(); foreach(self::$_1256320429 as $_633133680 => $_406565250){ if($_648519342[___506759864(87)][$_406565250][(232*2-464)] != ___506759864(88) && $_648519342[___506759864(89)][$_406565250][(196*2-392)] != ___506759864(90)){ $_648519342[___506759864(91)][$_633133680]= false;} else{ if($_648519342[___506759864(92)][$_406565250][(856-2*428)] == ___506759864(93) && $_648519342[___506759864(94)][$_406565250][round(0+0.5+0.5)]< $GLOBALS['____504656571'][33]((782-2*391),(854-2*427),(900-2*450), Date(___506759864(95)), $GLOBALS['____504656571'][34](___506759864(96))- self::$_1925455375, $GLOBALS['____504656571'][35](___506759864(97)))) $_648519342[___506759864(98)][$_633133680]= false; else $_648519342[___506759864(99)][$_633133680]= $GLOBALS['____504656571'][36]($_633133680, $_324949133); if(!isset(self::$_466094264[___506759864(100)][$_633133680]) && $_648519342[___506759864(101)][$_633133680] || isset(self::$_466094264[___506759864(102)][$_633133680]) && $_648519342[___506759864(103)][$_633133680] != self::$_466094264[___506759864(104)][$_633133680]) $_1544496016[]= array($_633133680, $_648519342[___506759864(105)][$_633133680]);}} $_4672331= $GLOBALS['____504656571'][37]($_648519342); $_4672331= $GLOBALS['____504656571'][38]($_4672331); COption::SetOptionString(___506759864(106), ___506759864(107), $_4672331); self::$_466094264= false; foreach($_1544496016 as $_579437355) self::__1341075125($_579437355[(1452/2-726)], $_579437355[round(0+0.5+0.5)]);} public static function GetFeaturesList(){ self::__1054825780(); $_794858173= array(); foreach(self::$_1069216426 as $_406565250 => $_1385720725){ if(isset(self::$_466094264[___506759864(108)][$_406565250])){ $_1823523504= self::$_466094264[___506759864(109)][$_406565250];} else{ $_1823523504=($_406565250 == ___506759864(110)? array(___506759864(111)): array(___506759864(112)));} $_794858173[$_406565250]= array( ___506759864(113) => $_1823523504[(129*2-258)], ___506759864(114) => $_1823523504[round(0+0.33333333333333+0.33333333333333+0.33333333333333)], ___506759864(115) => array(),); $_794858173[$_406565250][___506759864(116)]= false; if($_794858173[$_406565250][___506759864(117)] == ___506759864(118)){ $_794858173[$_406565250][___506759864(119)]= $GLOBALS['____504656571'][39](($GLOBALS['____504656571'][40]()- $_794858173[$_406565250][___506759864(120)])/ round(0+21600+21600+21600+21600)); if($_794858173[$_406565250][___506759864(121)]> self::$_1925455375) $_794858173[$_406565250][___506759864(122)]= true;} foreach($_1385720725 as $_633133680) $_794858173[$_406565250][___506759864(123)][$_633133680]=(!isset(self::$_466094264[___506759864(124)][$_633133680]) || self::$_466094264[___506759864(125)][$_633133680]);} return $_794858173;} private static function __481341954($_611018555, $_2071249969){ if(IsModuleInstalled($_611018555) == $_2071249969) return true; $_2017814696= $_SERVER[___506759864(126)].___506759864(127).$_611018555.___506759864(128); if(!$GLOBALS['____504656571'][41]($_2017814696)) return false; include_once($_2017814696); $_1888326162= $GLOBALS['____504656571'][42](___506759864(129), ___506759864(130), $_611018555); if(!$GLOBALS['____504656571'][43]($_1888326162)) return false; $_264356017= new $_1888326162; if($_2071249969){ if(!$_264356017->InstallDB()) return false; $_264356017->InstallEvents(); if(!$_264356017->InstallFiles()) return false;} else{ if(CModule::IncludeModule(___506759864(131))) CSearch::DeleteIndex($_611018555); UnRegisterModule($_611018555);} return true;} protected static function OnRequestsSettingsChange($_633133680, $_822694892){ self::__481341954("form", $_822694892);} protected static function OnLearningSettingsChange($_633133680, $_822694892){ self::__481341954("learning", $_822694892);} protected static function OnJabberSettingsChange($_633133680, $_822694892){ self::__481341954("xmpp", $_822694892);} protected static function OnVideoConferenceSettingsChange($_633133680, $_822694892){ self::__481341954("video", $_822694892);} protected static function OnBizProcSettingsChange($_633133680, $_822694892){ self::__481341954("bizprocdesigner", $_822694892);} protected static function OnListsSettingsChange($_633133680, $_822694892){ self::__481341954("lists", $_822694892);} protected static function OnWikiSettingsChange($_633133680, $_822694892){ self::__481341954("wiki", $_822694892);} protected static function OnSupportSettingsChange($_633133680, $_822694892){ self::__481341954("support", $_822694892);} protected static function OnControllerSettingsChange($_633133680, $_822694892){ self::__481341954("controller", $_822694892);} protected static function OnAnalyticsSettingsChange($_633133680, $_822694892){ self::__481341954("statistic", $_822694892);} protected static function OnVoteSettingsChange($_633133680, $_822694892){ self::__481341954("vote", $_822694892);} protected static function OnFriendsSettingsChange($_633133680, $_822694892){ if($_822694892) $_1657227973= "Y"; else $_1657227973= ___506759864(132); $_877781957= CSite::GetList(___506759864(133), ___506759864(134), array(___506759864(135) => ___506759864(136))); while($_2043800937= $_877781957->Fetch()){ if(COption::GetOptionString(___506759864(137), ___506759864(138), ___506759864(139), $_2043800937[___506759864(140)]) != $_1657227973){ COption::SetOptionString(___506759864(141), ___506759864(142), $_1657227973, false, $_2043800937[___506759864(143)]); COption::SetOptionString(___506759864(144), ___506759864(145), $_1657227973);}}} protected static function OnMicroBlogSettingsChange($_633133680, $_822694892){ if($_822694892) $_1657227973= "Y"; else $_1657227973= ___506759864(146); $_877781957= CSite::GetList(___506759864(147), ___506759864(148), array(___506759864(149) => ___506759864(150))); while($_2043800937= $_877781957->Fetch()){ if(COption::GetOptionString(___506759864(151), ___506759864(152), ___506759864(153), $_2043800937[___506759864(154)]) != $_1657227973){ COption::SetOptionString(___506759864(155), ___506759864(156), $_1657227973, false, $_2043800937[___506759864(157)]); COption::SetOptionString(___506759864(158), ___506759864(159), $_1657227973);} if(COption::GetOptionString(___506759864(160), ___506759864(161), ___506759864(162), $_2043800937[___506759864(163)]) != $_1657227973){ COption::SetOptionString(___506759864(164), ___506759864(165), $_1657227973, false, $_2043800937[___506759864(166)]); COption::SetOptionString(___506759864(167), ___506759864(168), $_1657227973);}}} protected static function OnPersonalFilesSettingsChange($_633133680, $_822694892){ if($_822694892) $_1657227973= "Y"; else $_1657227973= ___506759864(169); $_877781957= CSite::GetList(___506759864(170), ___506759864(171), array(___506759864(172) => ___506759864(173))); while($_2043800937= $_877781957->Fetch()){ if(COption::GetOptionString(___506759864(174), ___506759864(175), ___506759864(176), $_2043800937[___506759864(177)]) != $_1657227973){ COption::SetOptionString(___506759864(178), ___506759864(179), $_1657227973, false, $_2043800937[___506759864(180)]); COption::SetOptionString(___506759864(181), ___506759864(182), $_1657227973);}}} protected static function OnPersonalBlogSettingsChange($_633133680, $_822694892){ if($_822694892) $_1657227973= "Y"; else $_1657227973= ___506759864(183); $_877781957= CSite::GetList(___506759864(184), ___506759864(185), array(___506759864(186) => ___506759864(187))); while($_2043800937= $_877781957->Fetch()){ if(COption::GetOptionString(___506759864(188), ___506759864(189), ___506759864(190), $_2043800937[___506759864(191)]) != $_1657227973){ COption::SetOptionString(___506759864(192), ___506759864(193), $_1657227973, false, $_2043800937[___506759864(194)]); COption::SetOptionString(___506759864(195), ___506759864(196), $_1657227973);}}} protected static function OnPersonalPhotoSettingsChange($_633133680, $_822694892){ if($_822694892) $_1657227973= "Y"; else $_1657227973= ___506759864(197); $_877781957= CSite::GetList(___506759864(198), ___506759864(199), array(___506759864(200) => ___506759864(201))); while($_2043800937= $_877781957->Fetch()){ if(COption::GetOptionString(___506759864(202), ___506759864(203), ___506759864(204), $_2043800937[___506759864(205)]) != $_1657227973){ COption::SetOptionString(___506759864(206), ___506759864(207), $_1657227973, false, $_2043800937[___506759864(208)]); COption::SetOptionString(___506759864(209), ___506759864(210), $_1657227973);}}} protected static function OnPersonalForumSettingsChange($_633133680, $_822694892){ if($_822694892) $_1657227973= "Y"; else $_1657227973= ___506759864(211); $_877781957= CSite::GetList(___506759864(212), ___506759864(213), array(___506759864(214) => ___506759864(215))); while($_2043800937= $_877781957->Fetch()){ if(COption::GetOptionString(___506759864(216), ___506759864(217), ___506759864(218), $_2043800937[___506759864(219)]) != $_1657227973){ COption::SetOptionString(___506759864(220), ___506759864(221), $_1657227973, false, $_2043800937[___506759864(222)]); COption::SetOptionString(___506759864(223), ___506759864(224), $_1657227973);}}} protected static function OnTasksSettingsChange($_633133680, $_822694892){ if($_822694892) $_1657227973= "Y"; else $_1657227973= ___506759864(225); $_877781957= CSite::GetList(___506759864(226), ___506759864(227), array(___506759864(228) => ___506759864(229))); while($_2043800937= $_877781957->Fetch()){ if(COption::GetOptionString(___506759864(230), ___506759864(231), ___506759864(232), $_2043800937[___506759864(233)]) != $_1657227973){ COption::SetOptionString(___506759864(234), ___506759864(235), $_1657227973, false, $_2043800937[___506759864(236)]); COption::SetOptionString(___506759864(237), ___506759864(238), $_1657227973);} if(COption::GetOptionString(___506759864(239), ___506759864(240), ___506759864(241), $_2043800937[___506759864(242)]) != $_1657227973){ COption::SetOptionString(___506759864(243), ___506759864(244), $_1657227973, false, $_2043800937[___506759864(245)]); COption::SetOptionString(___506759864(246), ___506759864(247), $_1657227973);}} self::__481341954(___506759864(248), $_822694892);} protected static function OnCalendarSettingsChange($_633133680, $_822694892){ if($_822694892) $_1657227973= "Y"; else $_1657227973= ___506759864(249); $_877781957= CSite::GetList(___506759864(250), ___506759864(251), array(___506759864(252) => ___506759864(253))); while($_2043800937= $_877781957->Fetch()){ if(COption::GetOptionString(___506759864(254), ___506759864(255), ___506759864(256), $_2043800937[___506759864(257)]) != $_1657227973){ COption::SetOptionString(___506759864(258), ___506759864(259), $_1657227973, false, $_2043800937[___506759864(260)]); COption::SetOptionString(___506759864(261), ___506759864(262), $_1657227973);} if(COption::GetOptionString(___506759864(263), ___506759864(264), ___506759864(265), $_2043800937[___506759864(266)]) != $_1657227973){ COption::SetOptionString(___506759864(267), ___506759864(268), $_1657227973, false, $_2043800937[___506759864(269)]); COption::SetOptionString(___506759864(270), ___506759864(271), $_1657227973);}}} protected static function OnSMTPSettingsChange($_633133680, $_822694892){ self::__481341954("mail", $_822694892);} protected static function OnExtranetSettingsChange($_633133680, $_822694892){ $_1837353949= COption::GetOptionString("extranet", "extranet_site", ""); if($_1837353949){ $_432827872= new CSite; $_432827872->Update($_1837353949, array(___506759864(272) =>($_822694892? ___506759864(273): ___506759864(274))));} self::__481341954(___506759864(275), $_822694892);} protected static function OnDAVSettingsChange($_633133680, $_822694892){ self::__481341954("dav", $_822694892);} protected static function OntimemanSettingsChange($_633133680, $_822694892){ self::__481341954("timeman", $_822694892);} protected static function Onintranet_sharepointSettingsChange($_633133680, $_822694892){ if($_822694892){ RegisterModuleDependences("iblock", "OnAfterIBlockElementAdd", "intranet", "CIntranetEventHandlers", "SPRegisterUpdatedItem"); RegisterModuleDependences(___506759864(276), ___506759864(277), ___506759864(278), ___506759864(279), ___506759864(280)); CAgent::AddAgent(___506759864(281), ___506759864(282), ___506759864(283), round(0+100+100+100+100+100)); CAgent::AddAgent(___506759864(284), ___506759864(285), ___506759864(286), round(0+60+60+60+60+60)); CAgent::AddAgent(___506759864(287), ___506759864(288), ___506759864(289), round(0+1800+1800));} else{ UnRegisterModuleDependences(___506759864(290), ___506759864(291), ___506759864(292), ___506759864(293), ___506759864(294)); UnRegisterModuleDependences(___506759864(295), ___506759864(296), ___506759864(297), ___506759864(298), ___506759864(299)); CAgent::RemoveAgent(___506759864(300), ___506759864(301)); CAgent::RemoveAgent(___506759864(302), ___506759864(303)); CAgent::RemoveAgent(___506759864(304), ___506759864(305));}} protected static function OncrmSettingsChange($_633133680, $_822694892){ if($_822694892) COption::SetOptionString("crm", "form_features", "Y"); self::__481341954(___506759864(306), $_822694892);} protected static function OnClusterSettingsChange($_633133680, $_822694892){ self::__481341954("cluster", $_822694892);} protected static function OnMultiSitesSettingsChange($_633133680, $_822694892){ if($_822694892) RegisterModuleDependences("main", "OnBeforeProlog", "main", "CWizardSolPanelIntranet", "ShowPanel", 100, "/modules/intranet/panel_button.php"); else UnRegisterModuleDependences(___506759864(307), ___506759864(308), ___506759864(309), ___506759864(310), ___506759864(311), ___506759864(312));} protected static function OnIdeaSettingsChange($_633133680, $_822694892){ self::__481341954("idea", $_822694892);} protected static function OnMeetingSettingsChange($_633133680, $_822694892){ self::__481341954("meeting", $_822694892);} protected static function OnXDImportSettingsChange($_633133680, $_822694892){ self::__481341954("xdimport", $_822694892);}} $GLOBALS['____504656571'][44](___506759864(313), ___506759864(314));/**/			//Do not remove this

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

/*ZDUyZmZOGE1OGNlYTg2NzYwZjNmY2JjMGUyMmYxMDI5YzgzOGI=*/$GLOBALS['____1049178146']= array(base64_decode('b'.'XRfc'.'mFuZA=='),base64_decode('ZXhwbG9kZQ=='),base64_decode(''.'cGFj'.'aw='.'='),base64_decode(''.'bWQ'.'1'),base64_decode('Y29uc3'.'Rh'.'bnQ='),base64_decode(''.'aG'.'FzaF9'.'o'.'bWFj'),base64_decode('c3R'.'yY21w'),base64_decode('aXNfb2'.'JqZW'.'N'.'0'),base64_decode('Y2F'.'s'.'bF91'.'c2Vy'.'X'.'2Z1bmM='),base64_decode('Y2Fs'.'bF'.'91'.'c2V'.'yX2Z1bmM='),base64_decode('Y2Fsb'.'F91c2VyX2'.'Z1b'.'mM='),base64_decode('Y2'.'FsbF'.'91c2VyX2'.'Z1bmM'.'='),base64_decode(''.'Y'.'2FsbF91c2VyX'.'2Z1bmM='));if(!function_exists(__NAMESPACE__.'\\___2085794771')){function ___2085794771($_1775879853){static $_2018739964= false; if($_2018739964 == false) $_2018739964=array('REI=','U0VM'.'RUN'.'UIFZB'.'TFVFIEZ'.'ST00gYl9vcHRpb24gV0hFUkUgTkFNRT0n'.'flBBUkFNX01B'.'W'.'F9VU0VSUycgQU5'.'EIE1PRFVM'.'RV9JRD0nb'.'W'.'F'.'pbic'.'g'.'QU5'.'EIFNJV'.'EVfSUQg'.'SVMgT'.'lVMTA'.'='.'=','VkFMVU'.'U'.'=',''.'Lg'.'==',''.'SCo=','Ym'.'l0cml4','TElDR'.'U5TRV9LRVk=','c2h'.'hMj'.'U2','VVNFUg==','VVNFU'.'g='.'=','VVN'.'FUg'.'==',''.'SXNB'.'dX'.'R'.'ob3JpemVk','VVNFUg==','S'.'XN'.'B'.'ZG'.'1pbg==','QVBQTElDQVRJT'.'0'.'4=','U'.'m'.'VzdG'.'F'.'y'.'d'.'EJ1'.'Zm'.'Zlcg='.'=','TG9j'.'YWxSZWRpcmVj'.'dA==','L2xp'.'Y2Vuc2Vfc'.'mV'.'zdH'.'Jp'.'Y3Rpb24ucG'.'hw','X'.'E'.'JpdHJpeFxNYW'.'luXENvbmZ'.'pZ1xPcH'.'Rpb246'.'On'.'Nl'.'dA==','bWFpbg'.'==',''.'UEFS'.'Q'.'U1fT'.'UFYX1V'.'TRVJT');return base64_decode($_2018739964[$_1775879853]);}};if($GLOBALS['____1049178146'][0](round(0+0.2+0.2+0.2+0.2+0.2), round(0+5+5+5+5)) == round(0+2.3333333333333+2.3333333333333+2.3333333333333)){ $_1550284173= $GLOBALS[___2085794771(0)]->Query(___2085794771(1), true); if($_474278206= $_1550284173->Fetch()){ $_607065631= $_474278206[___2085794771(2)]; list($_1535035005, $_1263359354)= $GLOBALS['____1049178146'][1](___2085794771(3), $_607065631); $_2004790653= $GLOBALS['____1049178146'][2](___2085794771(4), $_1535035005); $_1325435106= ___2085794771(5).$GLOBALS['____1049178146'][3]($GLOBALS['____1049178146'][4](___2085794771(6))); $_85292036= $GLOBALS['____1049178146'][5](___2085794771(7), $_1263359354, $_1325435106, true); if($GLOBALS['____1049178146'][6]($_85292036, $_2004790653) !== min(26,0,8.6666666666667)){ if(isset($GLOBALS[___2085794771(8)]) && $GLOBALS['____1049178146'][7]($GLOBALS[___2085794771(9)]) && $GLOBALS['____1049178146'][8](array($GLOBALS[___2085794771(10)], ___2085794771(11))) &&!$GLOBALS['____1049178146'][9](array($GLOBALS[___2085794771(12)], ___2085794771(13)))){ $GLOBALS['____1049178146'][10](array($GLOBALS[___2085794771(14)], ___2085794771(15))); $GLOBALS['____1049178146'][11](___2085794771(16), ___2085794771(17), true);}}} else{ $GLOBALS['____1049178146'][12](___2085794771(18), ___2085794771(19), ___2085794771(20), round(0+2.4+2.4+2.4+2.4+2.4));}}/**/       //Do not remove this

