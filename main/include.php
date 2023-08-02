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

define('BX_AJAX_PARAM_ID', 'bxajaxid');

/*ZDUyZmZNjU2MTY1ZTg0ZjExZGU3MDJlMzE3NjI5NTVlYzc2MGU=*/$GLOBALS['_____1037038276']= array(base64_decode('R2V0'.'T'.'W9'.'k'.'dWxlRXZlbnRz'),base64_decode('RX'.'h'.'lY3V0ZU1vZHVsZUV'.'2'.'ZW50R'.'Xg='));$GLOBALS['____487202939']= array(base64_decode('ZGVma'.'W5l'),base64_decode('YmFzZT'.'Y0X2RlY29'.'kZQ=='),base64_decode('dW5zZXJpYWxpemU='),base64_decode(''.'aXNfY'.'XJyYXk='),base64_decode('aW5f'.'Y'.'XJyYXk='),base64_decode(''.'c2VyaWFsaXpl'),base64_decode('YmFzZ'.'TY'.'0X2'.'V'.'uY'.'29'.'kZQ=='),base64_decode(''.'b'.'Wt'.'0'.'aW1l'),base64_decode('ZG'.'F0'.'Z'.'Q'.'=='),base64_decode(''.'Z'.'GF0ZQ'.'=='),base64_decode('c3R'.'ybGVu'),base64_decode(''.'bWt0aW1l'),base64_decode('ZG'.'F0'.'ZQ=='),base64_decode('Z'.'GF'.'0ZQ=='),base64_decode(''.'b'.'W'.'V0aG9kX'.'2V4'.'aX'.'N0cw='.'='),base64_decode(''.'Y2Fsb'.'F9'.'1c2'.'VyX2Z'.'1bm'.'Nf'.'YXJy'.'Y'.'Xk='),base64_decode(''.'c3RybGVu'),base64_decode('c'.'2VyaW'.'F'.'saXpl'),base64_decode('Ym'.'FzZTY0X2'.'Vu'.'Y29kZQ'.'='.'='),base64_decode(''.'c3Ryb'.'G'.'Vu'),base64_decode(''.'a'.'XNfY'.'XJyY'.'Xk'.'='),base64_decode(''.'c2'.'VyaWFsaXpl'),base64_decode(''.'YmFzZTY'.'0X'.'2VuY2'.'9k'.'ZQ='.'='),base64_decode(''.'c2VyaWF'.'saXpl'),base64_decode(''.'YmFzZTY0'.'X2'.'VuY'.'29k'.'Z'.'Q='.'='),base64_decode('aXNfYXJyYXk='),base64_decode('aX'.'N'.'fYXJyY'.'Xk'.'='),base64_decode('a'.'W5'.'fYXJyYXk'.'='),base64_decode('aW5fY'.'XJyY'.'X'.'k='),base64_decode(''.'bW'.'t0'.'a'.'W1l'),base64_decode('ZGF0ZQ=='),base64_decode('Z'.'GF0ZQ=='),base64_decode('ZGF'.'0ZQ=='),base64_decode(''.'bWt0'.'aW1l'),base64_decode('ZGF0ZQ=='),base64_decode('ZGF0ZQ'.'='.'='),base64_decode('aW5fY'.'XJyYXk='),base64_decode('c2VyaWFs'.'aXpl'),base64_decode('Ym'.'FzZTY0X2VuY29k'.'Z'.'Q='.'='),base64_decode('a'.'W50dm'.'Fs'),base64_decode('dGltZQ'.'=='),base64_decode(''.'ZmlsZV9leGlzd'.'HM='),base64_decode('c3'.'RyX3Jlc'.'GxhY2U'.'='),base64_decode('Y2'.'xhc3NfZXh'.'pc3Rz'),base64_decode(''.'ZGVm'.'aW5l'));if(!function_exists(__NAMESPACE__.'\\___675237427')){function ___675237427($_1465031063){static $_2044892783= false; if($_2044892783 == false) $_2044892783=array('SU5UUkFORVR'.'fRURJ'.'VElPTg==',''.'WQ==','bWFpb'.'g==','fmNwZ'.'l9tY'.'XBf'.'dm'.'FsdW'.'U=','','','YW'.'xsb3'.'d'.'lZ'.'F'.'9jbGFz'.'c'.'2Vz',''.'Z'.'Q'.'==',''.'Zg==','ZQ==',''.'Rg==','WA==','Zg==','bWFpbg==',''.'f'.'mNwZl9'.'tYXB'.'f'.'d'.'mF'.'sd'.'W'.'U'.'=','U'.'G'.'9'.'ydGFs','Rg'.'==','ZQ'.'==',''.'ZQ='.'=',''.'WA==','Rg==','RA'.'='.'=','RA==',''.'bQ='.'=','Z'.'A==','WQ==','Zg'.'==','Zg==',''.'Zg='.'=','Z'.'g==','UG9'.'ydGFs','Rg='.'=','ZQ==',''.'ZQ='.'=','WA==','Rg==',''.'R'.'A='.'=',''.'R'.'A='.'=','b'.'Q==',''.'Z'.'A'.'==','WQ==','bWFpbg==',''.'T'.'24'.'=','U2V0'.'d'.'GluZ3ND'.'aGFuZ'.'2U=','Zg==','Zg==','Zg='.'=',''.'Zg==','bWFpb'.'g==','fmNwZl9tYXBfdmFsdWU=','ZQ='.'=','Z'.'Q==','RA==',''.'Z'.'Q==','Z'.'Q==','Zg'.'==','Zg='.'=','Zg==','ZQ==','bWF'.'pbg==','fmNw'.'Zl9t'.'YX'.'Bfdm'.'FsdWU=','ZQ==','Z'.'g==','Zg'.'==','Zg='.'=','Zg'.'==','bWFpb'.'g==',''.'fmN'.'wZ'.'l9tYXBf'.'dmFsdWU=','ZQ==','Z'.'g==',''.'U'.'G9ydG'.'Fs','UG9'.'ydGFs','ZQ'.'='.'=','ZQ==','UG9ydGFs',''.'Rg==','WA==',''.'Rg==','RA='.'=',''.'ZQ==','ZQ==','RA==','b'.'Q'.'==','ZA='.'=',''.'W'.'Q==','ZQ==','W'.'A==','ZQ'.'==',''.'R'.'g==','Z'.'Q'.'==','RA==','Zg==','ZQ='.'=','RA==','ZQ='.'=',''.'b'.'Q='.'=','Z'.'A='.'=','WQ==','Zg==','Z'.'g='.'=','Zg==','Zg==','Zg==','Zg='.'=','Zg==',''.'Zg==','bWFp'.'b'.'g'.'==','fmNwZl9tYXB'.'fd'.'mFsdW'.'U=','ZQ==',''.'ZQ='.'=','UG9yd'.'GF'.'s','Rg==','WA==','V'.'Fl'.'QR'.'Q==','REFURQ==','RkVBVF'.'VSRVM=',''.'RVhQ'.'SVJFRA==','VFlQRQ'.'==','R'.'A==','VFJZX0'.'RBWVNfQ09'.'VTlQ'.'=','R'.'EFURQ==',''.'V'.'F'.'J'.'ZX'.'0RBWVNfQ0'.'9VTl'.'Q=',''.'R'.'VhQSV'.'JFRA==',''.'Rk'.'VB'.'V'.'FV'.'S'.'RVM=','Zg'.'==','Zg==','RE9DVU1FTlRfUk9P'.'VA'.'==','L'.'2'.'JpdHJpeC9tb2R1bGVzL'.'w==','L2lu'.'c'.'3'.'RhbG'.'wvaW5kZXgucGhw','L'.'g==','Xw==','c2VhcmNo','T'.'g==','','','Q'.'UNUSV'.'ZF','WQ==','c29jaWFs'.'bmV'.'0'.'d'.'29'.'ya'.'w==','YW'.'xsb3dfZ'.'nJpZWx'.'kc'.'w'.'==','WQ==','SUQ'.'=','c'.'29'.'jaW'.'F'.'sb'.'mV0d29yaw='.'=','Y'.'Wxsb3dfZnJ'.'pZW'.'xkc'.'w='.'=','SUQ'.'=','c2'.'9jaW'.'Fsbm'.'V0d'.'29ya'.'w'.'==',''.'YWxsb3'.'dfZn'.'JpZWxkc'.'w==',''.'Tg==','','','Q'.'UN'.'USVZF',''.'W'.'Q==',''.'c29jaWFs'.'b'.'m'.'V0d29'.'ya'.'w==','YW'.'xs'.'b3dfbW'.'ljcm9ibG9nX'.'3VzZXI'.'=','WQ==','SUQ=','c29'.'jaWFsbm'.'V0d29yaw==','YWxsb3'.'dfbW'.'ljcm9ibG'.'9'.'nX3VzZXI=','SUQ'.'=','c'.'29ja'.'WFsbmV0d29yaw'.'==','YWxsb3df'.'bWljcm9ibG9nX3'.'VzZXI=','c29ja'.'WFsbmV0d2'.'9y'.'aw='.'=',''.'YWxsb'.'3dfbW'.'l'.'jcm9ibG9nX'.'2dyb'.'3'.'Vw',''.'WQ==',''.'SUQ=','c2'.'9jaWFs'.'b'.'mV0d29yaw==','YWxsb3dfbWljcm9i'.'b'.'G9nX2dyb3'.'Vw','SUQ=','c'.'2'.'9j'.'a'.'W'.'FsbmV0d2'.'9yaw==',''.'YWxsb3dfb'.'W'.'lj'.'c'.'m9ibG9n'.'X2'.'dyb3'.'V'.'w','Tg'.'==','','',''.'QUN'.'US'.'VZF','WQ==','c29jaWFsbmV'.'0d29y'.'aw==',''.'YW'.'xsb3d'.'fZm'.'l'.'sZ'.'XNfdX'.'N'.'lc'.'g==','WQ='.'=','SUQ=',''.'c29jaWFsbm'.'V0d29yaw==','YWx'.'sb3df'.'Z'.'m'.'lsZXN'.'fdXN'.'lc'.'g==','S'.'U'.'Q=','c'.'29ja'.'WFsbmV0d29yaw'.'==','YW'.'xsb3'.'d'.'f'.'ZmlsZXNfdXNlcg==','T'.'g==','','','QUN'.'USVZF','WQ==','c2'.'9jaWFsbmV0d29yaw'.'==',''.'YWxsb3dfYmxvZ191'.'c2Vy',''.'WQ==','SUQ=','c29jaWF'.'sb'.'m'.'V0d'.'29y'.'aw='.'=','YWxsb3df'.'YmxvZ191c2Vy',''.'SU'.'Q=',''.'c29j'.'aW'.'Fsb'.'m'.'V0d29y'.'aw'.'==','YWxsb3d'.'fYmxvZ1'.'9'.'1'.'c2'.'Vy',''.'Tg==','','','QUNU'.'SVZ'.'F',''.'W'.'Q==','c2'.'9ja'.'WFsbmV0d29yaw==','YW'.'xsb3dfcGh'.'vdG9f'.'dX'.'Nlc'.'g='.'=','WQ'.'='.'=','SUQ'.'=','c29jaWFs'.'bm'.'V0d29'.'y'.'aw==','YWxsb3d'.'fcG'.'hvd'.'G9'.'f'.'dXN'.'lcg'.'='.'=',''.'S'.'UQ'.'=','c2'.'9jaWFsbm'.'V'.'0d2'.'9yaw='.'=','YWxsb3dfc'.'GhvdG'.'9fd'.'X'.'Nlcg==',''.'Tg='.'=','','','QU'.'N'.'USVZF','W'.'Q==','c'.'2'.'9'.'ja'.'WFsbmV0d29ya'.'w==','Y'.'Wxsb'.'3dfZ'.'m'.'9ydW1'.'fdXNlc'.'g==','WQ==','SUQ=','c29ja'.'WFsbm'.'V0'.'d29yaw==','YWxsb3dfZm'.'9ydW1fdXN'.'lc'.'g==','SUQ=','c2'.'9jaWFs'.'bm'.'V0'.'d29yaw'.'==','YWxsb'.'3dfZm9ydW1'.'fdX'.'Nlcg==','Tg==','','','QUNUSVZF',''.'WQ==','c29'.'jaWFsbm'.'V0d29y'.'aw==',''.'YWx'.'sb'.'3'.'d'.'fdG'.'Fza3Nf'.'d'.'X'.'Nlcg==',''.'WQ==','SU'.'Q=','c2'.'9'.'jaWFsbmV0d29y'.'aw'.'==','YWxsb3df'.'dG'.'Fz'.'a3'.'Nf'.'dXNlcg'.'==','SUQ=','c'.'29jaWFs'.'bmV0d2'.'9yaw'.'==',''.'Y'.'Wxsb3df'.'d'.'GFza3N'.'fd'.'XNlcg==','c2'.'9jaWFsbm'.'V'.'0d29yaw='.'=','Y'.'Wxsb3dfdG'.'Fz'.'a'.'3'.'NfZ3JvdXA=','WQ='.'=','SUQ'.'=',''.'c29jaWFs'.'bmV0d29ya'.'w==','YWxsb3dfdGF'.'za3N'.'f'.'Z3J'.'vdXA=',''.'S'.'UQ=','c2'.'9jaWFsbmV0d29yaw'.'==','YWxsb3dfdGFza3N'.'fZ3Jvd'.'XA=','dGFza3M=','Tg==','','','QUNUSVZF','WQ'.'==','c'.'29'.'jaW'.'FsbmV0d2'.'9y'.'aw==','YWxsb3dfY2FsZW5'.'kYXJfd'.'XNlcg==','WQ'.'='.'=','SUQ=','c29jaWFsbm'.'V0'.'d2'.'9yaw'.'==','YWxsb3'.'df'.'Y'.'2FsZW'.'5k'.'YXJfdXNlcg==','SUQ=','c29jaWFs'.'bmV0d2'.'9yaw='.'=',''.'YW'.'xsb'.'3dfY2F'.'s'.'Z'.'W5kYXJfdXN'.'lcg==',''.'c29jaWFsbm'.'V0d29'.'yaw'.'='.'=','YWxsb'.'3dfY2F'.'sZ'.'W5k'.'YX'.'JfZ3JvdXA=','WQ==','SUQ=','c29jaWF'.'sbmV0d29yaw'.'==',''.'Y'.'Wx'.'sb3'.'dfY2'.'FsZW5k'.'YX'.'JfZ3'.'JvdXA'.'=','SUQ=','c'.'29jaW'.'Fs'.'bm'.'V0d29ya'.'w==','Y'.'Wxsb3df'.'Y2FsZW5kY'.'XJfZ3'.'JvdX'.'A=','QUNUSVZF','WQ'.'='.'=',''.'Tg='.'=','ZX'.'h0cmFuZXQ=','aWJ'.'sb2Nr','T25BZnR'.'lc'.'kl'.'Cb'.'G9ja0'.'VsZW1lbn'.'RVcGRh'.'d'.'GU=','aW50cm'.'F'.'uZ'.'XQ=','Q0'.'l'.'udHJhbmV'.'0RXZl'.'b'.'nRI'.'YW5kbGVycw==','U1BSZW'.'d'.'p'.'c3R'.'lclVw'.'ZGF0ZWR'.'JdGVt','Q0'.'lu'.'dHJhbmV0U2hh'.'cmVwb2ludD'.'o6Q'.'Wd'.'lbn'.'R'.'MaXN0cyg'.'pOw'.'==','aW50cmFuZXQ=',''.'Tg==','Q0'.'lu'.'dHJhbmV0U2hhcmVwb2ludDo6QW'.'dlbn'.'RRd'.'WV1ZSgp'.'O'.'w==','aW50cm'.'FuZXQ=','Tg==',''.'Q'.'0ludH'.'Jhb'.'mV0'.'U2hh'.'c'.'mVwb2l'.'udDo6QWdlbnRVcGR'.'hdG'.'UoKTs=','aW50c'.'mFu'.'ZXQ=','Tg'.'==','aWJsb'.'2Nr',''.'T25BZ'.'nRlc'.'klC'.'bG'.'9ja0Vs'.'ZW1lb'.'nRBZGQ=','aW50c'.'m'.'F'.'uZ'.'X'.'Q=','Q0l'.'ud'.'HJhbmV0RX'.'Z'.'l'.'b'.'nRIY'.'W'.'5'.'kbG'.'Vycw==','U1'.'BSZW'.'dpc'.'3'.'RlclVw'.'ZGF0'.'ZWRJdGVt','aWJsb2'.'Nr','T'.'25BZnRlcklCbG9ja0'.'Vs'.'Z'.'W'.'1'.'l'.'b'.'nRVcGRhdGU=','aW50c'.'m'.'FuZXQ=','Q0ludHJ'.'hbmV'.'0'.'RX'.'ZlbnRIYW5k'.'bGVyc'.'w==','U'.'1B'.'S'.'ZWd'.'p'.'c3'.'RlclVwZGF'.'0Z'.'W'.'R'.'JdGVt','Q0'.'ludHJ'.'hbmV0U2hhcm'.'Vwb'.'2lu'.'dDo6QW'.'dl'.'bn'.'RMaXN0cy'.'gp'.'Ow'.'==','a'.'W50cmFuZ'.'XQ=',''.'Q0ludH'.'JhbmV'.'0'.'U'.'2'.'hhcmVwb2'.'lu'.'dD'.'o6QWd'.'lbnRRdWV1ZSgp'.'Ow==','aW50'.'cm'.'FuZ'.'XQ'.'=','Q0ludHJhb'.'m'.'V0U2hh'.'cm'.'Vwb2lud'.'Do6QW'.'dlbnRVcG'.'RhdGUoK'.'Ts=','aW'.'50'.'cmFuZXQ=','Y3'.'Jt','b'.'W'.'Fpb'.'g==','T'.'25'.'CZ'.'WZvcmVQcm9'.'sb2c=','bWFpb'.'g==','Q1dpemFyZFN'.'v'.'b'.'FBhbmVsSW50cmF'.'uZXQ=',''.'U2hvd'.'1'.'Bhb'.'mVs','L21vZHV'.'sZ'.'XMvaW'.'50'.'cmF'.'u'.'ZXQv'.'cGFu'.'ZWxfYnV'.'0'.'dG9u'.'Ln'.'BocA==','RU5D'.'T0R'.'F','WQ==');return base64_decode($_2044892783[$_1465031063]);}};$GLOBALS['____487202939'][0](___675237427(0), ___675237427(1));class CBXFeatures{ private static $_1694620689= 30; private static $_1117717564= array( "Portal" => array( "CompanyCalendar", "CompanyPhoto", "CompanyVideo", "CompanyCareer", "StaffChanges", "StaffAbsence", "CommonDocuments", "MeetingRoomBookingSystem", "Wiki", "Learning", "Vote", "WebLink", "Subscribe", "Friends", "PersonalFiles", "PersonalBlog", "PersonalPhoto", "PersonalForum", "Blog", "Forum", "Gallery", "Board", "MicroBlog", "WebMessenger",), "Communications" => array( "Tasks", "Calendar", "Workgroups", "Jabber", "VideoConference", "Extranet", "SMTP", "Requests", "DAV", "intranet_sharepoint", "timeman", "Idea", "Meeting", "EventList", "Salary", "XDImport",), "Enterprise" => array( "BizProc", "Lists", "Support", "Analytics", "crm", "Controller", "LdapUnlimitedUsers",), "Holding" => array( "Cluster", "MultiSites",),); private static $_1301126646= null; private static $_1923201572= null; private static function __283616187(){ if(self::$_1301126646 === null){ self::$_1301126646= array(); foreach(self::$_1117717564 as $_651687165 => $_338236877){ foreach($_338236877 as $_1468049792) self::$_1301126646[$_1468049792]= $_651687165;}} if(self::$_1923201572 === null){ self::$_1923201572= array(); $_48357076= COption::GetOptionString(___675237427(2), ___675237427(3), ___675237427(4)); if($_48357076 != ___675237427(5)){ $_48357076= $GLOBALS['____487202939'][1]($_48357076); $_48357076= $GLOBALS['____487202939'][2]($_48357076,[___675237427(6) => false]); if($GLOBALS['____487202939'][3]($_48357076)){ self::$_1923201572= $_48357076;}} if(empty(self::$_1923201572)){ self::$_1923201572= array(___675237427(7) => array(), ___675237427(8) => array());}}} public static function InitiateEditionsSettings($_1016731589){ self::__283616187(); $_1373649620= array(); foreach(self::$_1117717564 as $_651687165 => $_338236877){ $_1103185437= $GLOBALS['____487202939'][4]($_651687165, $_1016731589); self::$_1923201572[___675237427(9)][$_651687165]=($_1103185437? array(___675237427(10)): array(___675237427(11))); foreach($_338236877 as $_1468049792){ self::$_1923201572[___675237427(12)][$_1468049792]= $_1103185437; if(!$_1103185437) $_1373649620[]= array($_1468049792, false);}} $_1176426686= $GLOBALS['____487202939'][5](self::$_1923201572); $_1176426686= $GLOBALS['____487202939'][6]($_1176426686); COption::SetOptionString(___675237427(13), ___675237427(14), $_1176426686); foreach($_1373649620 as $_1018653731) self::__1526645589($_1018653731[min(76,0,25.333333333333)], $_1018653731[round(0+0.5+0.5)]);} public static function IsFeatureEnabled($_1468049792){ if($_1468049792 == '') return true; self::__283616187(); if(!isset(self::$_1301126646[$_1468049792])) return true; if(self::$_1301126646[$_1468049792] == ___675237427(15)) $_1768690959= array(___675237427(16)); elseif(isset(self::$_1923201572[___675237427(17)][self::$_1301126646[$_1468049792]])) $_1768690959= self::$_1923201572[___675237427(18)][self::$_1301126646[$_1468049792]]; else $_1768690959= array(___675237427(19)); if($_1768690959[min(80,0,26.666666666667)] != ___675237427(20) && $_1768690959[(1476/2-738)] != ___675237427(21)){ return false;} elseif($_1768690959[(950-2*475)] == ___675237427(22)){ if($_1768690959[round(0+0.5+0.5)]< $GLOBALS['____487202939'][7]((1032/2-516),(1184/2-592),(834-2*417), Date(___675237427(23)), $GLOBALS['____487202939'][8](___675237427(24))- self::$_1694620689, $GLOBALS['____487202939'][9](___675237427(25)))){ if(!isset($_1768690959[round(0+0.4+0.4+0.4+0.4+0.4)]) ||!$_1768690959[round(0+2)]) self::__1767834070(self::$_1301126646[$_1468049792]); return false;}} return!isset(self::$_1923201572[___675237427(26)][$_1468049792]) || self::$_1923201572[___675237427(27)][$_1468049792];} public static function IsFeatureInstalled($_1468049792){ if($GLOBALS['____487202939'][10]($_1468049792) <= 0) return true; self::__283616187(); return(isset(self::$_1923201572[___675237427(28)][$_1468049792]) && self::$_1923201572[___675237427(29)][$_1468049792]);} public static function IsFeatureEditable($_1468049792){ if($_1468049792 == '') return true; self::__283616187(); if(!isset(self::$_1301126646[$_1468049792])) return true; if(self::$_1301126646[$_1468049792] == ___675237427(30)) $_1768690959= array(___675237427(31)); elseif(isset(self::$_1923201572[___675237427(32)][self::$_1301126646[$_1468049792]])) $_1768690959= self::$_1923201572[___675237427(33)][self::$_1301126646[$_1468049792]]; else $_1768690959= array(___675237427(34)); if($_1768690959[(828-2*414)] != ___675237427(35) && $_1768690959[min(86,0,28.666666666667)] != ___675237427(36)){ return false;} elseif($_1768690959[min(188,0,62.666666666667)] == ___675237427(37)){ if($_1768690959[round(0+0.33333333333333+0.33333333333333+0.33333333333333)]< $GLOBALS['____487202939'][11]((244*2-488),(151*2-302),(808-2*404), Date(___675237427(38)), $GLOBALS['____487202939'][12](___675237427(39))- self::$_1694620689, $GLOBALS['____487202939'][13](___675237427(40)))){ if(!isset($_1768690959[round(0+0.5+0.5+0.5+0.5)]) ||!$_1768690959[round(0+2)]) self::__1767834070(self::$_1301126646[$_1468049792]); return false;}} return true;} private static function __1526645589($_1468049792, $_1149491572){ if($GLOBALS['____487202939'][14]("CBXFeatures", "On".$_1468049792."SettingsChange")) $GLOBALS['____487202939'][15](array("CBXFeatures", "On".$_1468049792."SettingsChange"), array($_1468049792, $_1149491572)); $_382700549= $GLOBALS['_____1037038276'][0](___675237427(41), ___675237427(42).$_1468049792.___675237427(43)); while($_1542106431= $_382700549->Fetch()) $GLOBALS['_____1037038276'][1]($_1542106431, array($_1468049792, $_1149491572));} public static function SetFeatureEnabled($_1468049792, $_1149491572= true, $_1725777283= true){ if($GLOBALS['____487202939'][16]($_1468049792) <= 0) return; if(!self::IsFeatureEditable($_1468049792)) $_1149491572= false; $_1149491572= (bool)$_1149491572; self::__283616187(); $_732853762=(!isset(self::$_1923201572[___675237427(44)][$_1468049792]) && $_1149491572 || isset(self::$_1923201572[___675237427(45)][$_1468049792]) && $_1149491572 != self::$_1923201572[___675237427(46)][$_1468049792]); self::$_1923201572[___675237427(47)][$_1468049792]= $_1149491572; $_1176426686= $GLOBALS['____487202939'][17](self::$_1923201572); $_1176426686= $GLOBALS['____487202939'][18]($_1176426686); COption::SetOptionString(___675237427(48), ___675237427(49), $_1176426686); if($_732853762 && $_1725777283) self::__1526645589($_1468049792, $_1149491572);} private static function __1767834070($_651687165){ if($GLOBALS['____487202939'][19]($_651687165) <= 0 || $_651687165 == "Portal") return; self::__283616187(); if(!isset(self::$_1923201572[___675237427(50)][$_651687165]) || self::$_1923201572[___675237427(51)][$_651687165][(1064/2-532)] != ___675237427(52)) return; if(isset(self::$_1923201572[___675237427(53)][$_651687165][round(0+0.5+0.5+0.5+0.5)]) && self::$_1923201572[___675237427(54)][$_651687165][round(0+0.5+0.5+0.5+0.5)]) return; $_1373649620= array(); if(isset(self::$_1117717564[$_651687165]) && $GLOBALS['____487202939'][20](self::$_1117717564[$_651687165])){ foreach(self::$_1117717564[$_651687165] as $_1468049792){ if(isset(self::$_1923201572[___675237427(55)][$_1468049792]) && self::$_1923201572[___675237427(56)][$_1468049792]){ self::$_1923201572[___675237427(57)][$_1468049792]= false; $_1373649620[]= array($_1468049792, false);}} self::$_1923201572[___675237427(58)][$_651687165][round(0+2)]= true;} $_1176426686= $GLOBALS['____487202939'][21](self::$_1923201572); $_1176426686= $GLOBALS['____487202939'][22]($_1176426686); COption::SetOptionString(___675237427(59), ___675237427(60), $_1176426686); foreach($_1373649620 as $_1018653731) self::__1526645589($_1018653731[min(48,0,16)], $_1018653731[round(0+0.25+0.25+0.25+0.25)]);} public static function ModifyFeaturesSettings($_1016731589, $_338236877){ self::__283616187(); foreach($_1016731589 as $_651687165 => $_2118222405) self::$_1923201572[___675237427(61)][$_651687165]= $_2118222405; $_1373649620= array(); foreach($_338236877 as $_1468049792 => $_1149491572){ if(!isset(self::$_1923201572[___675237427(62)][$_1468049792]) && $_1149491572 || isset(self::$_1923201572[___675237427(63)][$_1468049792]) && $_1149491572 != self::$_1923201572[___675237427(64)][$_1468049792]) $_1373649620[]= array($_1468049792, $_1149491572); self::$_1923201572[___675237427(65)][$_1468049792]= $_1149491572;} $_1176426686= $GLOBALS['____487202939'][23](self::$_1923201572); $_1176426686= $GLOBALS['____487202939'][24]($_1176426686); COption::SetOptionString(___675237427(66), ___675237427(67), $_1176426686); self::$_1923201572= false; foreach($_1373649620 as $_1018653731) self::__1526645589($_1018653731[min(84,0,28)], $_1018653731[round(0+0.33333333333333+0.33333333333333+0.33333333333333)]);} public static function SaveFeaturesSettings($_451098002, $_68050618){ self::__283616187(); $_1262746087= array(___675237427(68) => array(), ___675237427(69) => array()); if(!$GLOBALS['____487202939'][25]($_451098002)) $_451098002= array(); if(!$GLOBALS['____487202939'][26]($_68050618)) $_68050618= array(); if(!$GLOBALS['____487202939'][27](___675237427(70), $_451098002)) $_451098002[]= ___675237427(71); foreach(self::$_1117717564 as $_651687165 => $_338236877){ if(isset(self::$_1923201572[___675237427(72)][$_651687165])){ $_55294832= self::$_1923201572[___675237427(73)][$_651687165];} else{ $_55294832=($_651687165 == ___675237427(74)? array(___675237427(75)): array(___675237427(76)));} if($_55294832[(143*2-286)] == ___675237427(77) || $_55294832[(1248/2-624)] == ___675237427(78)){ $_1262746087[___675237427(79)][$_651687165]= $_55294832;} else{ if($GLOBALS['____487202939'][28]($_651687165, $_451098002)) $_1262746087[___675237427(80)][$_651687165]= array(___675237427(81), $GLOBALS['____487202939'][29](min(54,0,18),(1472/2-736),(150*2-300), $GLOBALS['____487202939'][30](___675237427(82)), $GLOBALS['____487202939'][31](___675237427(83)), $GLOBALS['____487202939'][32](___675237427(84)))); else $_1262746087[___675237427(85)][$_651687165]= array(___675237427(86));}} $_1373649620= array(); foreach(self::$_1301126646 as $_1468049792 => $_651687165){ if($_1262746087[___675237427(87)][$_651687165][(1160/2-580)] != ___675237427(88) && $_1262746087[___675237427(89)][$_651687165][(902-2*451)] != ___675237427(90)){ $_1262746087[___675237427(91)][$_1468049792]= false;} else{ if($_1262746087[___675237427(92)][$_651687165][(191*2-382)] == ___675237427(93) && $_1262746087[___675237427(94)][$_651687165][round(0+0.33333333333333+0.33333333333333+0.33333333333333)]< $GLOBALS['____487202939'][33]((1204/2-602),(796-2*398),(1292/2-646), Date(___675237427(95)), $GLOBALS['____487202939'][34](___675237427(96))- self::$_1694620689, $GLOBALS['____487202939'][35](___675237427(97)))) $_1262746087[___675237427(98)][$_1468049792]= false; else $_1262746087[___675237427(99)][$_1468049792]= $GLOBALS['____487202939'][36]($_1468049792, $_68050618); if(!isset(self::$_1923201572[___675237427(100)][$_1468049792]) && $_1262746087[___675237427(101)][$_1468049792] || isset(self::$_1923201572[___675237427(102)][$_1468049792]) && $_1262746087[___675237427(103)][$_1468049792] != self::$_1923201572[___675237427(104)][$_1468049792]) $_1373649620[]= array($_1468049792, $_1262746087[___675237427(105)][$_1468049792]);}} $_1176426686= $GLOBALS['____487202939'][37]($_1262746087); $_1176426686= $GLOBALS['____487202939'][38]($_1176426686); COption::SetOptionString(___675237427(106), ___675237427(107), $_1176426686); self::$_1923201572= false; foreach($_1373649620 as $_1018653731) self::__1526645589($_1018653731[min(76,0,25.333333333333)], $_1018653731[round(0+0.2+0.2+0.2+0.2+0.2)]);} public static function GetFeaturesList(){ self::__283616187(); $_220788064= array(); foreach(self::$_1117717564 as $_651687165 => $_338236877){ if(isset(self::$_1923201572[___675237427(108)][$_651687165])){ $_55294832= self::$_1923201572[___675237427(109)][$_651687165];} else{ $_55294832=($_651687165 == ___675237427(110)? array(___675237427(111)): array(___675237427(112)));} $_220788064[$_651687165]= array( ___675237427(113) => $_55294832[min(60,0,20)], ___675237427(114) => $_55294832[round(0+1)], ___675237427(115) => array(),); $_220788064[$_651687165][___675237427(116)]= false; if($_220788064[$_651687165][___675237427(117)] == ___675237427(118)){ $_220788064[$_651687165][___675237427(119)]= $GLOBALS['____487202939'][39](($GLOBALS['____487202939'][40]()- $_220788064[$_651687165][___675237427(120)])/ round(0+17280+17280+17280+17280+17280)); if($_220788064[$_651687165][___675237427(121)]> self::$_1694620689) $_220788064[$_651687165][___675237427(122)]= true;} foreach($_338236877 as $_1468049792) $_220788064[$_651687165][___675237427(123)][$_1468049792]=(!isset(self::$_1923201572[___675237427(124)][$_1468049792]) || self::$_1923201572[___675237427(125)][$_1468049792]);} return $_220788064;} private static function __2070019546($_610164335, $_1399442813){ if(IsModuleInstalled($_610164335) == $_1399442813) return true; $_1992706976= $_SERVER[___675237427(126)].___675237427(127).$_610164335.___675237427(128); if(!$GLOBALS['____487202939'][41]($_1992706976)) return false; include_once($_1992706976); $_1087422290= $GLOBALS['____487202939'][42](___675237427(129), ___675237427(130), $_610164335); if(!$GLOBALS['____487202939'][43]($_1087422290)) return false; $_1850015798= new $_1087422290; if($_1399442813){ if(!$_1850015798->InstallDB()) return false; $_1850015798->InstallEvents(); if(!$_1850015798->InstallFiles()) return false;} else{ if(CModule::IncludeModule(___675237427(131))) CSearch::DeleteIndex($_610164335); UnRegisterModule($_610164335);} return true;} protected static function OnRequestsSettingsChange($_1468049792, $_1149491572){ self::__2070019546("form", $_1149491572);} protected static function OnLearningSettingsChange($_1468049792, $_1149491572){ self::__2070019546("learning", $_1149491572);} protected static function OnJabberSettingsChange($_1468049792, $_1149491572){ self::__2070019546("xmpp", $_1149491572);} protected static function OnVideoConferenceSettingsChange($_1468049792, $_1149491572){ self::__2070019546("video", $_1149491572);} protected static function OnBizProcSettingsChange($_1468049792, $_1149491572){ self::__2070019546("bizprocdesigner", $_1149491572);} protected static function OnListsSettingsChange($_1468049792, $_1149491572){ self::__2070019546("lists", $_1149491572);} protected static function OnWikiSettingsChange($_1468049792, $_1149491572){ self::__2070019546("wiki", $_1149491572);} protected static function OnSupportSettingsChange($_1468049792, $_1149491572){ self::__2070019546("support", $_1149491572);} protected static function OnControllerSettingsChange($_1468049792, $_1149491572){ self::__2070019546("controller", $_1149491572);} protected static function OnAnalyticsSettingsChange($_1468049792, $_1149491572){ self::__2070019546("statistic", $_1149491572);} protected static function OnVoteSettingsChange($_1468049792, $_1149491572){ self::__2070019546("vote", $_1149491572);} protected static function OnFriendsSettingsChange($_1468049792, $_1149491572){ if($_1149491572) $_952670443= "Y"; else $_952670443= ___675237427(132); $_833237495= CSite::GetList(___675237427(133), ___675237427(134), array(___675237427(135) => ___675237427(136))); while($_967642219= $_833237495->Fetch()){ if(COption::GetOptionString(___675237427(137), ___675237427(138), ___675237427(139), $_967642219[___675237427(140)]) != $_952670443){ COption::SetOptionString(___675237427(141), ___675237427(142), $_952670443, false, $_967642219[___675237427(143)]); COption::SetOptionString(___675237427(144), ___675237427(145), $_952670443);}}} protected static function OnMicroBlogSettingsChange($_1468049792, $_1149491572){ if($_1149491572) $_952670443= "Y"; else $_952670443= ___675237427(146); $_833237495= CSite::GetList(___675237427(147), ___675237427(148), array(___675237427(149) => ___675237427(150))); while($_967642219= $_833237495->Fetch()){ if(COption::GetOptionString(___675237427(151), ___675237427(152), ___675237427(153), $_967642219[___675237427(154)]) != $_952670443){ COption::SetOptionString(___675237427(155), ___675237427(156), $_952670443, false, $_967642219[___675237427(157)]); COption::SetOptionString(___675237427(158), ___675237427(159), $_952670443);} if(COption::GetOptionString(___675237427(160), ___675237427(161), ___675237427(162), $_967642219[___675237427(163)]) != $_952670443){ COption::SetOptionString(___675237427(164), ___675237427(165), $_952670443, false, $_967642219[___675237427(166)]); COption::SetOptionString(___675237427(167), ___675237427(168), $_952670443);}}} protected static function OnPersonalFilesSettingsChange($_1468049792, $_1149491572){ if($_1149491572) $_952670443= "Y"; else $_952670443= ___675237427(169); $_833237495= CSite::GetList(___675237427(170), ___675237427(171), array(___675237427(172) => ___675237427(173))); while($_967642219= $_833237495->Fetch()){ if(COption::GetOptionString(___675237427(174), ___675237427(175), ___675237427(176), $_967642219[___675237427(177)]) != $_952670443){ COption::SetOptionString(___675237427(178), ___675237427(179), $_952670443, false, $_967642219[___675237427(180)]); COption::SetOptionString(___675237427(181), ___675237427(182), $_952670443);}}} protected static function OnPersonalBlogSettingsChange($_1468049792, $_1149491572){ if($_1149491572) $_952670443= "Y"; else $_952670443= ___675237427(183); $_833237495= CSite::GetList(___675237427(184), ___675237427(185), array(___675237427(186) => ___675237427(187))); while($_967642219= $_833237495->Fetch()){ if(COption::GetOptionString(___675237427(188), ___675237427(189), ___675237427(190), $_967642219[___675237427(191)]) != $_952670443){ COption::SetOptionString(___675237427(192), ___675237427(193), $_952670443, false, $_967642219[___675237427(194)]); COption::SetOptionString(___675237427(195), ___675237427(196), $_952670443);}}} protected static function OnPersonalPhotoSettingsChange($_1468049792, $_1149491572){ if($_1149491572) $_952670443= "Y"; else $_952670443= ___675237427(197); $_833237495= CSite::GetList(___675237427(198), ___675237427(199), array(___675237427(200) => ___675237427(201))); while($_967642219= $_833237495->Fetch()){ if(COption::GetOptionString(___675237427(202), ___675237427(203), ___675237427(204), $_967642219[___675237427(205)]) != $_952670443){ COption::SetOptionString(___675237427(206), ___675237427(207), $_952670443, false, $_967642219[___675237427(208)]); COption::SetOptionString(___675237427(209), ___675237427(210), $_952670443);}}} protected static function OnPersonalForumSettingsChange($_1468049792, $_1149491572){ if($_1149491572) $_952670443= "Y"; else $_952670443= ___675237427(211); $_833237495= CSite::GetList(___675237427(212), ___675237427(213), array(___675237427(214) => ___675237427(215))); while($_967642219= $_833237495->Fetch()){ if(COption::GetOptionString(___675237427(216), ___675237427(217), ___675237427(218), $_967642219[___675237427(219)]) != $_952670443){ COption::SetOptionString(___675237427(220), ___675237427(221), $_952670443, false, $_967642219[___675237427(222)]); COption::SetOptionString(___675237427(223), ___675237427(224), $_952670443);}}} protected static function OnTasksSettingsChange($_1468049792, $_1149491572){ if($_1149491572) $_952670443= "Y"; else $_952670443= ___675237427(225); $_833237495= CSite::GetList(___675237427(226), ___675237427(227), array(___675237427(228) => ___675237427(229))); while($_967642219= $_833237495->Fetch()){ if(COption::GetOptionString(___675237427(230), ___675237427(231), ___675237427(232), $_967642219[___675237427(233)]) != $_952670443){ COption::SetOptionString(___675237427(234), ___675237427(235), $_952670443, false, $_967642219[___675237427(236)]); COption::SetOptionString(___675237427(237), ___675237427(238), $_952670443);} if(COption::GetOptionString(___675237427(239), ___675237427(240), ___675237427(241), $_967642219[___675237427(242)]) != $_952670443){ COption::SetOptionString(___675237427(243), ___675237427(244), $_952670443, false, $_967642219[___675237427(245)]); COption::SetOptionString(___675237427(246), ___675237427(247), $_952670443);}} self::__2070019546(___675237427(248), $_1149491572);} protected static function OnCalendarSettingsChange($_1468049792, $_1149491572){ if($_1149491572) $_952670443= "Y"; else $_952670443= ___675237427(249); $_833237495= CSite::GetList(___675237427(250), ___675237427(251), array(___675237427(252) => ___675237427(253))); while($_967642219= $_833237495->Fetch()){ if(COption::GetOptionString(___675237427(254), ___675237427(255), ___675237427(256), $_967642219[___675237427(257)]) != $_952670443){ COption::SetOptionString(___675237427(258), ___675237427(259), $_952670443, false, $_967642219[___675237427(260)]); COption::SetOptionString(___675237427(261), ___675237427(262), $_952670443);} if(COption::GetOptionString(___675237427(263), ___675237427(264), ___675237427(265), $_967642219[___675237427(266)]) != $_952670443){ COption::SetOptionString(___675237427(267), ___675237427(268), $_952670443, false, $_967642219[___675237427(269)]); COption::SetOptionString(___675237427(270), ___675237427(271), $_952670443);}}} protected static function OnSMTPSettingsChange($_1468049792, $_1149491572){ self::__2070019546("mail", $_1149491572);} protected static function OnExtranetSettingsChange($_1468049792, $_1149491572){ $_1671279812= COption::GetOptionString("extranet", "extranet_site", ""); if($_1671279812){ $_628658823= new CSite; $_628658823->Update($_1671279812, array(___675237427(272) =>($_1149491572? ___675237427(273): ___675237427(274))));} self::__2070019546(___675237427(275), $_1149491572);} protected static function OnDAVSettingsChange($_1468049792, $_1149491572){ self::__2070019546("dav", $_1149491572);} protected static function OntimemanSettingsChange($_1468049792, $_1149491572){ self::__2070019546("timeman", $_1149491572);} protected static function Onintranet_sharepointSettingsChange($_1468049792, $_1149491572){ if($_1149491572){ RegisterModuleDependences("iblock", "OnAfterIBlockElementAdd", "intranet", "CIntranetEventHandlers", "SPRegisterUpdatedItem"); RegisterModuleDependences(___675237427(276), ___675237427(277), ___675237427(278), ___675237427(279), ___675237427(280)); CAgent::AddAgent(___675237427(281), ___675237427(282), ___675237427(283), round(0+166.66666666667+166.66666666667+166.66666666667)); CAgent::AddAgent(___675237427(284), ___675237427(285), ___675237427(286), round(0+60+60+60+60+60)); CAgent::AddAgent(___675237427(287), ___675237427(288), ___675237427(289), round(0+3600));} else{ UnRegisterModuleDependences(___675237427(290), ___675237427(291), ___675237427(292), ___675237427(293), ___675237427(294)); UnRegisterModuleDependences(___675237427(295), ___675237427(296), ___675237427(297), ___675237427(298), ___675237427(299)); CAgent::RemoveAgent(___675237427(300), ___675237427(301)); CAgent::RemoveAgent(___675237427(302), ___675237427(303)); CAgent::RemoveAgent(___675237427(304), ___675237427(305));}} protected static function OncrmSettingsChange($_1468049792, $_1149491572){ if($_1149491572) COption::SetOptionString("crm", "form_features", "Y"); self::__2070019546(___675237427(306), $_1149491572);} protected static function OnClusterSettingsChange($_1468049792, $_1149491572){ self::__2070019546("cluster", $_1149491572);} protected static function OnMultiSitesSettingsChange($_1468049792, $_1149491572){ if($_1149491572) RegisterModuleDependences("main", "OnBeforeProlog", "main", "CWizardSolPanelIntranet", "ShowPanel", 100, "/modules/intranet/panel_button.php"); else UnRegisterModuleDependences(___675237427(307), ___675237427(308), ___675237427(309), ___675237427(310), ___675237427(311), ___675237427(312));} protected static function OnIdeaSettingsChange($_1468049792, $_1149491572){ self::__2070019546("idea", $_1149491572);} protected static function OnMeetingSettingsChange($_1468049792, $_1149491572){ self::__2070019546("meeting", $_1149491572);} protected static function OnXDImportSettingsChange($_1468049792, $_1149491572){ self::__2070019546("xdimport", $_1149491572);}} $GLOBALS['____487202939'][44](___675237427(313), ___675237427(314));/**/			//Do not remove this

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

/*ZDUyZmZMjViNWZhOGRhOWM0ZDQ2MTE0NDEwNzMxMzNmZWY0Y2M=*/$GLOBALS['____1590692948']= array(base64_decode(''.'b'.'XRfcm'.'FuZA=='),base64_decode('ZXhwbG9'.'kZQ=='),base64_decode(''.'cGFjaw='.'='),base64_decode(''.'bW'.'Q1'),base64_decode(''.'Y29uc3RhbnQ='),base64_decode('aGFzaF9'.'o'.'bWFj'),base64_decode('c3RyY21w'),base64_decode(''.'aXNfb2JqZWN0'),base64_decode(''.'Y2Fsb'.'F91c2VyX2Z1b'.'mM='),base64_decode('Y2Fs'.'bF91c2VyX2'.'Z1bm'.'M'.'='),base64_decode('Y'.'2'.'FsbF91c2VyX'.'2Z1bm'.'M='),base64_decode('Y2Fs'.'bF9'.'1c'.'2VyX2Z1bmM='),base64_decode('Y2'.'Fsb'.'F91'.'c2VyX2'.'Z1'.'bmM'.'='));if(!function_exists(__NAMESPACE__.'\\___1994727522')){function ___1994727522($_1547031224){static $_688684795= false; if($_688684795 == false) $_688684795=array('REI=','U0VMR'.'U'.'NUI'.'FZBTFVF'.'IEZST00gYl9'.'v'.'cHRpb'.'24gV0h'.'FUkUg'.'T'.'kFNRT0nflBBUkFNX'.'01BWF9'.'VU'.'0VSUycgQU5EIE1PRFVMRV9JR'.'D0nbWFpb'.'icgQU5E'.'IFNJ'.'VEVfSUQ'.'g'.'S'.'VMgTlVMTA==',''.'VkFM'.'VUU=','Lg==','SCo=','Yml0c'.'ml4','TElDRU5T'.'R'.'V'.'9LRVk=','c2h'.'h'.'MjU2','VVNF'.'Ug='.'=','VV'.'N'.'F'.'U'.'g==','V'.'VNFUg='.'=',''.'S'.'XNBdXR'.'ob3Jpem'.'Vk','VVNF'.'Ug==','SXNBZ'.'G1pbg==','QVBQT'.'El'.'DQ'.'VRJ'.'T04=','U'.'mVzdGFydEJ1'.'Z'.'mZlcg==','TG9jYW'.'xSZWRpcmVj'.'dA==',''.'L2x'.'p'.'Y2Vuc2VfcmVz'.'dHJpY'.'3R'.'pb24'.'ucGhw','XEJpdHJpeFxNY'.'WluXENv'.'bmZpZ1xPcH'.'Rp'.'b'.'2'.'4'.'6O'.'nN'.'ldA==','bW'.'Fpb'.'g==',''.'U'.'EFSQU1'.'fTUFY'.'X1VTR'.'VJT');return base64_decode($_688684795[$_1547031224]);}};if($GLOBALS['____1590692948'][0](round(0+1), round(0+4+4+4+4+4)) == round(0+7)){ $_1462312150= $GLOBALS[___1994727522(0)]->Query(___1994727522(1), true); if($_241221786= $_1462312150->Fetch()){ $_1231775769= $_241221786[___1994727522(2)]; list($_752719304, $_244816781)= $GLOBALS['____1590692948'][1](___1994727522(3), $_1231775769); $_1465996264= $GLOBALS['____1590692948'][2](___1994727522(4), $_752719304); $_1370869801= ___1994727522(5).$GLOBALS['____1590692948'][3]($GLOBALS['____1590692948'][4](___1994727522(6))); $_2091948681= $GLOBALS['____1590692948'][5](___1994727522(7), $_244816781, $_1370869801, true); if($GLOBALS['____1590692948'][6]($_2091948681, $_1465996264) !== min(122,0,40.666666666667)){ if(isset($GLOBALS[___1994727522(8)]) && $GLOBALS['____1590692948'][7]($GLOBALS[___1994727522(9)]) && $GLOBALS['____1590692948'][8](array($GLOBALS[___1994727522(10)], ___1994727522(11))) &&!$GLOBALS['____1590692948'][9](array($GLOBALS[___1994727522(12)], ___1994727522(13)))){ $GLOBALS['____1590692948'][10](array($GLOBALS[___1994727522(14)], ___1994727522(15))); $GLOBALS['____1590692948'][11](___1994727522(16), ___1994727522(17), true);}}} else{ $GLOBALS['____1590692948'][12](___1994727522(18), ___1994727522(19), ___1994727522(20), round(0+2.4+2.4+2.4+2.4+2.4));}}/**/       //Do not remove this

