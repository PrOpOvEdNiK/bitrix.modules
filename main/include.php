<?php

/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2022 Bitrix
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
define('SITE_SERVER_NAME', ($site ? $site->getServerName() : ''));
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

if(!defined("BX_COMP_MANAGED_CACHE") && COption::GetOptionString("main", "component_managed_cache_on", "Y") <> "N")
{
	define("BX_COMP_MANAGED_CACHE", true);
}

// global functions
require_once(__DIR__."/filter_tools.php");

define('BX_AJAX_PARAM_ID', 'bxajaxid');

/*ZDUyZmZYTZlMGM5Yjc5ZDI0OTMyOGJkOTMxOGU3ZjdkODA4NTI=*/$GLOBALS['_____1648448249']= array(base64_decode('R'.'2'.'V0T'.'W'.'9'.'kd'.'WxlR'.'XZlb'.'nRz'),base64_decode(''.'RXhlY'.'3'.'V0Z'.'U1vZHVsZUV'.'2ZW'.'50RXg='));$GLOBALS['____1759358239']= array(base64_decode('ZGVmaW5l'),base64_decode('YmFzZ'.'T'.'Y0X2Rl'.'Y29'.'k'.'ZQ=='),base64_decode('dW5zZ'.'XJpY'.'WxpemU='),base64_decode('a'.'XN'.'f'.'YXJyYXk='),base64_decode(''.'a'.'W5fYXJ'.'y'.'Y'.'X'.'k='),base64_decode(''.'c'.'2V'.'yaW'.'Fsa'.'Xpl'),base64_decode('YmFzZTY0X2VuY'.'29'.'kZQ='.'='),base64_decode('bWt0aW1l'),base64_decode('Z'.'GF0Z'.'Q'.'=='),base64_decode('ZG'.'F0ZQ=='),base64_decode('c3Ry'.'bGVu'),base64_decode(''.'bWt0a'.'W1l'),base64_decode('ZGF0Z'.'Q=='),base64_decode('ZGF0Z'.'Q=='),base64_decode(''.'bWV0aG9k'.'X2V4'.'aXN0cw=='),base64_decode('Y2'.'FsbF91c2'.'VyX'.'2'.'Z1bmNfYXJyYXk='),base64_decode('c'.'3R'.'y'.'bG'.'Vu'),base64_decode(''.'c'.'2VyaW'.'F'.'sa'.'Xpl'),base64_decode('Ym'.'FzZ'.'T'.'Y0X2VuY2'.'9k'.'ZQ='.'='),base64_decode('c3RybG'.'V'.'u'),base64_decode(''.'a'.'XN'.'fY'.'XJy'.'YXk='),base64_decode('c2VyaWFsaX'.'pl'),base64_decode('Ym'.'F'.'zZT'.'Y0'.'X2VuY'.'29kZQ=='),base64_decode('c'.'2Vya'.'WFsaXpl'),base64_decode('YmF'.'zZTY0'.'X'.'2VuY29kZQ=='),base64_decode('aXNfY'.'XJy'.'YXk='),base64_decode(''.'aXNfY'.'XJyYX'.'k'.'='),base64_decode('aW5fYXJyYX'.'k'.'='),base64_decode('aW'.'5fYX'.'JyYXk='),base64_decode('bW'.'t0'.'aW'.'1l'),base64_decode('Z'.'G'.'F0'.'ZQ=='),base64_decode('ZGF'.'0ZQ=='),base64_decode(''.'ZGF'.'0Z'.'Q=='),base64_decode('b'.'Wt0aW1l'),base64_decode('Z'.'GF'.'0ZQ=='),base64_decode('ZGF'.'0'.'ZQ=='),base64_decode('aW5fYX'.'Jy'.'YX'.'k='),base64_decode('c2'.'VyaWFsaXpl'),base64_decode('YmFz'.'ZTY0'.'X'.'2Vu'.'Y29kZQ=='),base64_decode('aW'.'50'.'d'.'m'.'Fs'),base64_decode('dGltZQ=='),base64_decode('Zm'.'lsZV9'.'l'.'eGlzdHM='),base64_decode('c3'.'RyX3J'.'lcG'.'xhY'.'2U='),base64_decode('Y'.'2xhc'.'3NfZX'.'hpc3Rz'),base64_decode('Z'.'GVm'.'aW'.'5l'));if(!function_exists(__NAMESPACE__.'\\___1588568084')){function ___1588568084($_543236435){static $_1570699159= false; if($_1570699159 == false) $_1570699159=array(''.'S'.'U5UU'.'k'.'F'.'O'.'RVRfR'.'U'.'RJV'.'El'.'PTg'.'==','WQ==','b'.'WFp'.'bg==','f'.'mN'.'wZl'.'9tYX'.'B'.'f'.'dm'.'FsdWU=','','','YWx'.'sb3dlZF9jbGFzc2V'.'z','ZQ==','Zg'.'==',''.'ZQ==','Rg='.'=','WA==',''.'Zg==','b'.'WFp'.'bg==','fmNwZl9t'.'YXBfdm'.'FsdWU=','U'.'G9ydGF'.'s','Rg==',''.'ZQ'.'==','ZQ==','WA==',''.'Rg==','R'.'A='.'=','RA==','bQ==','ZA==','WQ==','Zg==',''.'Zg==','Z'.'g'.'='.'=','Z'.'g==',''.'UG'.'9ydGFs','Rg==','ZQ==','ZQ'.'==','WA'.'='.'=','R'.'g==','R'.'A'.'==','RA'.'='.'=','bQ==','ZA'.'==','WQ==','b'.'WFpbg==','T24=','U2V'.'0dGluZ'.'3'.'ND'.'aG'.'FuZ2U=','Zg==','Zg==',''.'Zg==','Zg='.'=','bWF'.'pbg==','fmNwZl9tYXBfdmFsdWU'.'=','ZQ'.'==','ZQ==','RA==','Z'.'Q==','ZQ'.'==',''.'Zg==',''.'Z'.'g==','Z'.'g==','ZQ==','bW'.'F'.'p'.'bg'.'==','f'.'mNwZ'.'l'.'9tY'.'XBfdm'.'FsdW'.'U=','ZQ==','Zg==',''.'Zg==',''.'Z'.'g='.'=',''.'Zg='.'=',''.'bWFp'.'b'.'g='.'=','fmNwZ'.'l9tY'.'XB'.'fdmFsdWU=',''.'Z'.'Q==','Zg==','UG9yd'.'GF'.'s','UG9ydGFs','ZQ==','UG9ydGFs',''.'Rg==',''.'WA='.'=','R'.'g='.'=','RA==',''.'ZQ'.'='.'=',''.'ZQ==','RA==',''.'bQ==','ZA'.'==','WQ='.'=','ZQ==','WA='.'=','Z'.'Q='.'=','Rg'.'==','ZQ==',''.'R'.'A='.'=',''.'Zg==','ZQ'.'='.'=','RA='.'=','ZQ='.'=','bQ='.'=','ZA==','WQ='.'=','Zg==',''.'Z'.'g='.'=','Zg='.'=',''.'Zg'.'==',''.'Zg==','Zg==',''.'Zg==',''.'Zg==','bWF'.'p'.'bg'.'==',''.'fmNwZl'.'9tYXB'.'fdmF'.'sdWU'.'=',''.'ZQ==','U'.'G9ydGFs','Rg==','WA='.'=','VFlQ'.'R'.'Q'.'==','REFURQ==','Rk'.'VBVFVSRVM=',''.'RVh'.'QSV'.'JFRA==','VF'.'lQRQ'.'==','R'.'A==','VF'.'JZX0RBWVNfQ09VTl'.'Q=',''.'REFURQ'.'='.'=','VF'.'JZX'.'0RBWVNf'.'Q09'.'VTlQ=',''.'RVhQSVJFR'.'A==','RkVBV'.'FVS'.'RVM=','Z'.'g==','Zg==','R'.'E9D'.'VU1F'.'Tl'.'R'.'fUk'.'9PVA='.'=','L'.'2JpdHJp'.'eC9tb'.'2R1bGVzLw'.'='.'=','L2l'.'uc3Rh'.'bGwvaW5k'.'Z'.'XgucGhw','Lg==','Xw==','c2VhcmN'.'o','Tg==','','','QUNU'.'SVZF','WQ'.'='.'=','c29jaWFs'.'bmV0'.'d29y'.'aw==','YWx'.'sb3'.'dfZnJpZW'.'xkcw='.'=','WQ==','SUQ'.'=','c29jaWFs'.'bmV0d29yaw==',''.'YWxsb3dfZnJpZ'.'W'.'x'.'kcw='.'=','S'.'UQ=','c'.'29jaW'.'Fs'.'bmV0d29yaw==','Y'.'Wxsb'.'3d'.'fZnJpZWxkcw==','Tg==','','',''.'QUNUSVZF','WQ'.'==','c2'.'9'.'j'.'aWFsb'.'m'.'V0d'.'29yaw==',''.'Y'.'Wx'.'sb3'.'dfbW'.'ljcm9ibG'.'9nX'.'3VzZXI=','W'.'Q==','SUQ=','c29jaW'.'FsbmV0d29yaw='.'=','YW'.'xsb3dfb'.'Wl'.'j'.'cm9ibG9'.'nX3Vz'.'ZXI=','SUQ'.'=','c29'.'j'.'aWF'.'sbmV0d'.'29y'.'aw'.'==','YWxsb'.'3dfbWljc'.'m9ibG9nX3VzZXI=','c29jaWFsb'.'mV0d29y'.'aw==','YWxsb3'.'dfbW'.'l'.'jcm9ibG9n'.'X2dy'.'b3Vw','WQ==','S'.'UQ=','c'.'2'.'9jaWFsbmV0d29yaw==','Y'.'Wxsb3dfb'.'Wljcm'.'9'.'ibG'.'9nX2dyb3V'.'w','SUQ=','c29ja'.'W'.'FsbmV0d29yaw='.'=','YWxsb3df'.'b'.'Wl'.'j'.'cm9i'.'bG9nX2dyb3Vw','Tg==','','','QU'.'NUSVZF','WQ==',''.'c29jaWFsbmV0d29y'.'aw==',''.'YW'.'xsb3df'.'ZmlsZXNf'.'dXNl'.'cg='.'=','WQ==','S'.'UQ'.'=',''.'c29jaW'.'F'.'sb'.'m'.'V0'.'d29yaw='.'=',''.'Y'.'Wxs'.'b3dfZml'.'sZXNfdXNlcg='.'=','SU'.'Q=',''.'c2'.'9'.'jaWFs'.'bm'.'V0'.'d29yaw==','YWxsb3dfZ'.'mlsZXN'.'f'.'d'.'XNlcg==','Tg'.'==','','',''.'QUNUSVZF','W'.'Q==',''.'c29jaWFs'.'bmV0d29yaw'.'='.'=',''.'Y'.'Wx'.'sb3dfYm'.'xvZ191c'.'2Vy','WQ==','SUQ'.'=',''.'c'.'29jaW'.'FsbmV0d29yaw==','YWxsb'.'3df'.'Y'.'m'.'xvZ191c2Vy','SUQ'.'=','c29jaWFsb'.'mV0d2'.'9yaw='.'=','YW'.'xsb'.'3'.'d'.'f'.'YmxvZ191c'.'2Vy','T'.'g==','','','QU'.'N'.'USVZF','WQ='.'=','c'.'29'.'jaWFsb'.'mV'.'0d2'.'9'.'yaw'.'==','YWxsb3dfcGh'.'vdG9f'.'dXN'.'lcg='.'=','WQ==','SUQ=','c29ja'.'WFsb'.'mV0d29ya'.'w==',''.'YWxsb3dfcGhvd'.'G9fdXNlc'.'g==','SUQ=',''.'c29jaW'.'F'.'sbmV0d'.'29ya'.'w==','YWxs'.'b3d'.'f'.'cGh'.'vd'.'G'.'9fdXNlcg='.'=','Tg='.'=','','',''.'QU'.'N'.'U'.'SVZF','WQ==','c29ja'.'WFs'.'bmV0d29yaw='.'=','YW'.'x'.'sb3dfZ'.'m9ydW1fdXNlcg='.'=','W'.'Q==','SUQ=','c29jaWFsbmV0d29yaw='.'=','YWxsb3'.'df'.'Zm'.'9'.'y'.'dW1'.'fd'.'XNlcg'.'='.'=','S'.'UQ=','c29jaWFsbmV0d2'.'9y'.'aw='.'=','YWx'.'sb3dfZm9y'.'dW1fd'.'XNlcg==',''.'Tg==','','','QUNU'.'SVZ'.'F','WQ==','c'.'29jaWFsbm'.'V0d29yaw==','YWxsb3d'.'fdGFz'.'a3N'.'fdXN'.'l'.'cg'.'==',''.'WQ'.'==','SUQ'.'=','c'.'29jaWFsbm'.'V'.'0d29'.'ya'.'w==','YWx'.'s'.'b3d'.'f'.'dGFza3'.'N'.'fdXN'.'lcg==','SUQ=','c29ja'.'WF'.'sbmV0d29y'.'aw==','YWxsb3dfdGFza3Nfd'.'XNlcg'.'==','c29'.'j'.'aWFsbmV'.'0d2'.'9'.'yaw==','YWxsb3'.'dfdGF'.'za3NfZ3JvdXA=','WQ==','S'.'U'.'Q=',''.'c2'.'9'.'jaW'.'FsbmV0d'.'29'.'ya'.'w==','Y'.'Wxsb3dfdGF'.'z'.'a'.'3N'.'fZ3Jv'.'dXA=',''.'SUQ=','c29jaWFsbmV0d29y'.'aw==','YWxs'.'b3d'.'f'.'dGF'.'za3NfZ3JvdXA'.'=','dGFz'.'a3M=','Tg==','','','QUNUS'.'VZF','WQ==',''.'c'.'29jaWFs'.'bm'.'V0d'.'2'.'9yaw==',''.'YW'.'xsb3dfY'.'2FsZ'.'W5'.'kY'.'XJfd'.'XNlcg'.'='.'=','W'.'Q==','SU'.'Q=',''.'c29jaWFsbmV0d29y'.'aw==','YWxsb'.'3dfY2F'.'s'.'ZW5kYXJ'.'fdXNlc'.'g==','SUQ=','c29'.'jaWFsbmV0'.'d29yaw==','Y'.'Wxsb3df'.'Y2FsZ'.'W'.'5kY'.'X'.'JfdXNlc'.'g==','c29jaWFsb'.'m'.'V0'.'d29yaw'.'==','YWx'.'sb'.'3dfY2'.'FsZW5kY'.'XJfZ3JvdXA=','WQ==','SUQ=','c29jaWF'.'sbmV0d29yaw='.'=','YWx'.'sb3dfY2'.'FsZW5kYX'.'JfZ3JvdX'.'A=','SUQ=','c29ja'.'WFsbm'.'V0d29yaw==',''.'YWxsb3df'.'Y2F'.'s'.'ZW5'.'kYXJf'.'Z3JvdX'.'A=',''.'Q'.'UN'.'USVZF','WQ'.'==','Tg='.'=',''.'Z'.'Xh0cmFuZXQ=','aWJ'.'sb2N'.'r',''.'T25BZnRlcklCbG9ja0Vs'.'ZW1'.'l'.'bnRV'.'cGRhd'.'G'.'U=','aW50cmFuZXQ=',''.'Q'.'0ludH'.'JhbmV0RXZl'.'bnRIYW5'.'kbGVycw==','U1BSZW'.'dpc3Rlcl'.'VwZGF0ZWRJdGVt','Q0'.'ludH'.'J'.'hbmV'.'0U2'.'hhcmVw'.'b2lu'.'dD'.'o6'.'QWd'.'lb'.'nRMaXN0cygpO'.'w==','aW50cm'.'F'.'uZXQ=','Tg==','Q0l'.'udHJhbmV0U2hhc'.'mVwb2'.'ludDo6QWd'.'lb'.'nR'.'Rd'.'WV'.'1'.'ZS'.'gp'.'Ow==','aW50cmF'.'u'.'Z'.'XQ=',''.'Tg==','Q0ludHJh'.'bm'.'V0U2'.'hhc'.'m'.'Vw'.'b2l'.'udDo6'.'QWd'.'lbnRVcGRh'.'dGUoKTs=','aW50'.'cmF'.'uZXQ=','T'.'g==','aWJs'.'b2Nr',''.'T'.'2'.'5B'.'ZnRlcklCbG'.'9ja0'.'VsZW1lbnRBZGQ'.'=',''.'a'.'W5'.'0cmFuZXQ=','Q0l'.'u'.'dHJhb'.'mV0RXZlb'.'nRIYW5'.'kbGVycw='.'=','U1BSZ'.'Wdpc'.'3RlclVwZGF'.'0Z'.'WRJdGV'.'t','aWJs'.'b2Nr','T25BZ'.'nRlcklCbG9ja0VsZW1lbnRVc'.'GRh'.'dGU'.'=','aW50c'.'mFu'.'ZXQ=','Q0lud'.'HJ'.'hbmV0'.'RXZlbnRIY'.'W5'.'kb'.'GVycw==','U'.'1BSZ'.'Wdpc'.'3'.'Rlc'.'lVwZG'.'F0ZWRJdGV'.'t','Q0'.'ludHJhbmV0U2hh'.'cm'.'Vwb2'.'ludDo6QWdlb'.'nRMaXN0cygpOw==','aW'.'50cmFuZXQ=','Q0lu'.'dHJhbmV0U'.'2'.'hhcmVwb2lud'.'Do6Q'.'WdlbnRR'.'dWV1ZS'.'gpOw'.'==',''.'aW50cmFuZ'.'XQ=','Q0ludHJhbmV0U2h'.'h'.'cmVwb2ludDo6QWdlbnRV'.'cGRh'.'dG'.'UoKTs=','aW5'.'0'.'cm'.'FuZXQ'.'=','Y3'.'Jt',''.'b'.'WFpbg==','T25CZ'.'WZ'.'vcmVQ'.'cm9'.'s'.'b2c'.'=','bWFpbg'.'==','Q'.'1'.'dpe'.'m'.'FyZFNv'.'bFBh'.'bmVsSW'.'5'.'0cmFuZXQ=','U2hvd1BhbmVs',''.'L21v'.'Z'.'HVsZX'.'Mva'.'W50cmFu'.'ZXQvcGFuZWxfYnV0dG9uLn'.'BocA'.'='.'=',''.'R'.'U'.'5DT0RF',''.'WQ==');return base64_decode($_1570699159[$_543236435]);}};$GLOBALS['____1759358239'][0](___1588568084(0), ___1588568084(1));class CBXFeatures{ private static $_1333119591= 30; private static $_436179243= array( "Portal" => array( "CompanyCalendar", "CompanyPhoto", "CompanyVideo", "CompanyCareer", "StaffChanges", "StaffAbsence", "CommonDocuments", "MeetingRoomBookingSystem", "Wiki", "Learning", "Vote", "WebLink", "Subscribe", "Friends", "PersonalFiles", "PersonalBlog", "PersonalPhoto", "PersonalForum", "Blog", "Forum", "Gallery", "Board", "MicroBlog", "WebMessenger",), "Communications" => array( "Tasks", "Calendar", "Workgroups", "Jabber", "VideoConference", "Extranet", "SMTP", "Requests", "DAV", "intranet_sharepoint", "timeman", "Idea", "Meeting", "EventList", "Salary", "XDImport",), "Enterprise" => array( "BizProc", "Lists", "Support", "Analytics", "crm", "Controller", "LdapUnlimitedUsers",), "Holding" => array( "Cluster", "MultiSites",),); private static $_1569472000= null; private static $_1972180197= null; private static function __1138347848(){ if(self::$_1569472000 === null){ self::$_1569472000= array(); foreach(self::$_436179243 as $_1300438267 => $_848205769){ foreach($_848205769 as $_1447553682) self::$_1569472000[$_1447553682]= $_1300438267;}} if(self::$_1972180197 === null){ self::$_1972180197= array(); $_2046741526= COption::GetOptionString(___1588568084(2), ___1588568084(3), ___1588568084(4)); if($_2046741526 != ___1588568084(5)){ $_2046741526= $GLOBALS['____1759358239'][1]($_2046741526); $_2046741526= $GLOBALS['____1759358239'][2]($_2046741526,[___1588568084(6) => false]); if($GLOBALS['____1759358239'][3]($_2046741526)){ self::$_1972180197= $_2046741526;}} if(empty(self::$_1972180197)){ self::$_1972180197= array(___1588568084(7) => array(), ___1588568084(8) => array());}}} public static function InitiateEditionsSettings($_837420792){ self::__1138347848(); $_932183268= array(); foreach(self::$_436179243 as $_1300438267 => $_848205769){ $_1635419484= $GLOBALS['____1759358239'][4]($_1300438267, $_837420792); self::$_1972180197[___1588568084(9)][$_1300438267]=($_1635419484? array(___1588568084(10)): array(___1588568084(11))); foreach($_848205769 as $_1447553682){ self::$_1972180197[___1588568084(12)][$_1447553682]= $_1635419484; if(!$_1635419484) $_932183268[]= array($_1447553682, false);}} $_667267558= $GLOBALS['____1759358239'][5](self::$_1972180197); $_667267558= $GLOBALS['____1759358239'][6]($_667267558); COption::SetOptionString(___1588568084(13), ___1588568084(14), $_667267558); foreach($_932183268 as $_361926824) self::__1304075769($_361926824[min(122,0,40.666666666667)], $_361926824[round(0+0.25+0.25+0.25+0.25)]);} public static function IsFeatureEnabled($_1447553682){ if($_1447553682 == '') return true; self::__1138347848(); if(!isset(self::$_1569472000[$_1447553682])) return true; if(self::$_1569472000[$_1447553682] == ___1588568084(15)) $_1404537294= array(___1588568084(16)); elseif(isset(self::$_1972180197[___1588568084(17)][self::$_1569472000[$_1447553682]])) $_1404537294= self::$_1972180197[___1588568084(18)][self::$_1569472000[$_1447553682]]; else $_1404537294= array(___1588568084(19)); if($_1404537294[min(198,0,66)] != ___1588568084(20) && $_1404537294[(800-2*400)] != ___1588568084(21)){ return false;} elseif($_1404537294[(170*2-340)] == ___1588568084(22)){ if($_1404537294[round(0+1)]< $GLOBALS['____1759358239'][7](min(204,0,68),(1140/2-570),(832-2*416), Date(___1588568084(23)), $GLOBALS['____1759358239'][8](___1588568084(24))- self::$_1333119591, $GLOBALS['____1759358239'][9](___1588568084(25)))){ if(!isset($_1404537294[round(0+0.4+0.4+0.4+0.4+0.4)]) ||!$_1404537294[round(0+2)]) self::__1582063767(self::$_1569472000[$_1447553682]); return false;}} return!isset(self::$_1972180197[___1588568084(26)][$_1447553682]) || self::$_1972180197[___1588568084(27)][$_1447553682];} public static function IsFeatureInstalled($_1447553682){ if($GLOBALS['____1759358239'][10]($_1447553682) <= 0) return true; self::__1138347848(); return(isset(self::$_1972180197[___1588568084(28)][$_1447553682]) && self::$_1972180197[___1588568084(29)][$_1447553682]);} public static function IsFeatureEditable($_1447553682){ if($_1447553682 == '') return true; self::__1138347848(); if(!isset(self::$_1569472000[$_1447553682])) return true; if(self::$_1569472000[$_1447553682] == ___1588568084(30)) $_1404537294= array(___1588568084(31)); elseif(isset(self::$_1972180197[___1588568084(32)][self::$_1569472000[$_1447553682]])) $_1404537294= self::$_1972180197[___1588568084(33)][self::$_1569472000[$_1447553682]]; else $_1404537294= array(___1588568084(34)); if($_1404537294[(1492/2-746)] != ___1588568084(35) && $_1404537294[min(72,0,24)] != ___1588568084(36)){ return false;} elseif($_1404537294[min(26,0,8.6666666666667)] == ___1588568084(37)){ if($_1404537294[round(0+0.2+0.2+0.2+0.2+0.2)]< $GLOBALS['____1759358239'][11]((221*2-442),(1296/2-648),(914-2*457), Date(___1588568084(38)), $GLOBALS['____1759358239'][12](___1588568084(39))- self::$_1333119591, $GLOBALS['____1759358239'][13](___1588568084(40)))){ if(!isset($_1404537294[round(0+0.5+0.5+0.5+0.5)]) ||!$_1404537294[round(0+0.5+0.5+0.5+0.5)]) self::__1582063767(self::$_1569472000[$_1447553682]); return false;}} return true;} private static function __1304075769($_1447553682, $_1139554173){ if($GLOBALS['____1759358239'][14]("CBXFeatures", "On".$_1447553682."SettingsChange")) $GLOBALS['____1759358239'][15](array("CBXFeatures", "On".$_1447553682."SettingsChange"), array($_1447553682, $_1139554173)); $_854359040= $GLOBALS['_____1648448249'][0](___1588568084(41), ___1588568084(42).$_1447553682.___1588568084(43)); while($_1006383783= $_854359040->Fetch()) $GLOBALS['_____1648448249'][1]($_1006383783, array($_1447553682, $_1139554173));} public static function SetFeatureEnabled($_1447553682, $_1139554173= true, $_557113326= true){ if($GLOBALS['____1759358239'][16]($_1447553682) <= 0) return; if(!self::IsFeatureEditable($_1447553682)) $_1139554173= false; $_1139554173= (bool)$_1139554173; self::__1138347848(); $_283681527=(!isset(self::$_1972180197[___1588568084(44)][$_1447553682]) && $_1139554173 || isset(self::$_1972180197[___1588568084(45)][$_1447553682]) && $_1139554173 != self::$_1972180197[___1588568084(46)][$_1447553682]); self::$_1972180197[___1588568084(47)][$_1447553682]= $_1139554173; $_667267558= $GLOBALS['____1759358239'][17](self::$_1972180197); $_667267558= $GLOBALS['____1759358239'][18]($_667267558); COption::SetOptionString(___1588568084(48), ___1588568084(49), $_667267558); if($_283681527 && $_557113326) self::__1304075769($_1447553682, $_1139554173);} private static function __1582063767($_1300438267){ if($GLOBALS['____1759358239'][19]($_1300438267) <= 0 || $_1300438267 == "Portal") return; self::__1138347848(); if(!isset(self::$_1972180197[___1588568084(50)][$_1300438267]) || self::$_1972180197[___1588568084(51)][$_1300438267][(160*2-320)] != ___1588568084(52)) return; if(isset(self::$_1972180197[___1588568084(53)][$_1300438267][round(0+2)]) && self::$_1972180197[___1588568084(54)][$_1300438267][round(0+2)]) return; $_932183268= array(); if(isset(self::$_436179243[$_1300438267]) && $GLOBALS['____1759358239'][20](self::$_436179243[$_1300438267])){ foreach(self::$_436179243[$_1300438267] as $_1447553682){ if(isset(self::$_1972180197[___1588568084(55)][$_1447553682]) && self::$_1972180197[___1588568084(56)][$_1447553682]){ self::$_1972180197[___1588568084(57)][$_1447553682]= false; $_932183268[]= array($_1447553682, false);}} self::$_1972180197[___1588568084(58)][$_1300438267][round(0+0.5+0.5+0.5+0.5)]= true;} $_667267558= $GLOBALS['____1759358239'][21](self::$_1972180197); $_667267558= $GLOBALS['____1759358239'][22]($_667267558); COption::SetOptionString(___1588568084(59), ___1588568084(60), $_667267558); foreach($_932183268 as $_361926824) self::__1304075769($_361926824[(192*2-384)], $_361926824[round(0+0.25+0.25+0.25+0.25)]);} public static function ModifyFeaturesSettings($_837420792, $_848205769){ self::__1138347848(); foreach($_837420792 as $_1300438267 => $_1222370194) self::$_1972180197[___1588568084(61)][$_1300438267]= $_1222370194; $_932183268= array(); foreach($_848205769 as $_1447553682 => $_1139554173){ if(!isset(self::$_1972180197[___1588568084(62)][$_1447553682]) && $_1139554173 || isset(self::$_1972180197[___1588568084(63)][$_1447553682]) && $_1139554173 != self::$_1972180197[___1588568084(64)][$_1447553682]) $_932183268[]= array($_1447553682, $_1139554173); self::$_1972180197[___1588568084(65)][$_1447553682]= $_1139554173;} $_667267558= $GLOBALS['____1759358239'][23](self::$_1972180197); $_667267558= $GLOBALS['____1759358239'][24]($_667267558); COption::SetOptionString(___1588568084(66), ___1588568084(67), $_667267558); self::$_1972180197= false; foreach($_932183268 as $_361926824) self::__1304075769($_361926824[(930-2*465)], $_361926824[round(0+0.5+0.5)]);} public static function SaveFeaturesSettings($_1753590146, $_2137775559){ self::__1138347848(); $_1346538825= array(___1588568084(68) => array(), ___1588568084(69) => array()); if(!$GLOBALS['____1759358239'][25]($_1753590146)) $_1753590146= array(); if(!$GLOBALS['____1759358239'][26]($_2137775559)) $_2137775559= array(); if(!$GLOBALS['____1759358239'][27](___1588568084(70), $_1753590146)) $_1753590146[]= ___1588568084(71); foreach(self::$_436179243 as $_1300438267 => $_848205769){ $_860250003= self::$_1972180197[___1588568084(72)][$_1300438267] ??($_1300438267 == ___1588568084(73)? array(___1588568084(74)): array(___1588568084(75))); if($_860250003[(145*2-290)] == ___1588568084(76) || $_860250003[(956-2*478)] == ___1588568084(77)){ $_1346538825[___1588568084(78)][$_1300438267]= $_860250003;} else{ if($GLOBALS['____1759358239'][28]($_1300438267, $_1753590146)) $_1346538825[___1588568084(79)][$_1300438267]= array(___1588568084(80), $GLOBALS['____1759358239'][29]((958-2*479), min(210,0,70), min(162,0,54), $GLOBALS['____1759358239'][30](___1588568084(81)), $GLOBALS['____1759358239'][31](___1588568084(82)), $GLOBALS['____1759358239'][32](___1588568084(83)))); else $_1346538825[___1588568084(84)][$_1300438267]= array(___1588568084(85));}} $_932183268= array(); foreach(self::$_1569472000 as $_1447553682 => $_1300438267){ if($_1346538825[___1588568084(86)][$_1300438267][(183*2-366)] != ___1588568084(87) && $_1346538825[___1588568084(88)][$_1300438267][(230*2-460)] != ___1588568084(89)){ $_1346538825[___1588568084(90)][$_1447553682]= false;} else{ if($_1346538825[___1588568084(91)][$_1300438267][(934-2*467)] == ___1588568084(92) && $_1346538825[___1588568084(93)][$_1300438267][round(0+1)]< $GLOBALS['____1759358239'][33](min(48,0,16),(218*2-436), min(158,0,52.666666666667), Date(___1588568084(94)), $GLOBALS['____1759358239'][34](___1588568084(95))- self::$_1333119591, $GLOBALS['____1759358239'][35](___1588568084(96)))) $_1346538825[___1588568084(97)][$_1447553682]= false; else $_1346538825[___1588568084(98)][$_1447553682]= $GLOBALS['____1759358239'][36]($_1447553682, $_2137775559); if(!isset(self::$_1972180197[___1588568084(99)][$_1447553682]) && $_1346538825[___1588568084(100)][$_1447553682] || isset(self::$_1972180197[___1588568084(101)][$_1447553682]) && $_1346538825[___1588568084(102)][$_1447553682] != self::$_1972180197[___1588568084(103)][$_1447553682]) $_932183268[]= array($_1447553682, $_1346538825[___1588568084(104)][$_1447553682]);}} $_667267558= $GLOBALS['____1759358239'][37]($_1346538825); $_667267558= $GLOBALS['____1759358239'][38]($_667267558); COption::SetOptionString(___1588568084(105), ___1588568084(106), $_667267558); self::$_1972180197= false; foreach($_932183268 as $_361926824) self::__1304075769($_361926824[min(14,0,4.6666666666667)], $_361926824[round(0+0.33333333333333+0.33333333333333+0.33333333333333)]);} public static function GetFeaturesList(){ self::__1138347848(); $_1805895426= array(); foreach(self::$_436179243 as $_1300438267 => $_848205769){ $_860250003= self::$_1972180197[___1588568084(107)][$_1300438267] ??($_1300438267 == ___1588568084(108)? array(___1588568084(109)): array(___1588568084(110))); $_1805895426[$_1300438267]= array( ___1588568084(111) => $_860250003[min(112,0,37.333333333333)], ___1588568084(112) => $_860250003[round(0+0.2+0.2+0.2+0.2+0.2)], ___1588568084(113) => array(),); $_1805895426[$_1300438267][___1588568084(114)]= false; if($_1805895426[$_1300438267][___1588568084(115)] == ___1588568084(116)){ $_1805895426[$_1300438267][___1588568084(117)]= $GLOBALS['____1759358239'][39](($GLOBALS['____1759358239'][40]()- $_1805895426[$_1300438267][___1588568084(118)])/ round(0+28800+28800+28800)); if($_1805895426[$_1300438267][___1588568084(119)]> self::$_1333119591) $_1805895426[$_1300438267][___1588568084(120)]= true;} foreach($_848205769 as $_1447553682) $_1805895426[$_1300438267][___1588568084(121)][$_1447553682]=(!isset(self::$_1972180197[___1588568084(122)][$_1447553682]) || self::$_1972180197[___1588568084(123)][$_1447553682]);} return $_1805895426;} private static function __850243850($_510285474, $_153950137){ if(IsModuleInstalled($_510285474) == $_153950137) return true; $_1412487723= $_SERVER[___1588568084(124)].___1588568084(125).$_510285474.___1588568084(126); if(!$GLOBALS['____1759358239'][41]($_1412487723)) return false; include_once($_1412487723); $_69115654= $GLOBALS['____1759358239'][42](___1588568084(127), ___1588568084(128), $_510285474); if(!$GLOBALS['____1759358239'][43]($_69115654)) return false; $_1133461219= new $_69115654; if($_153950137){ if(!$_1133461219->InstallDB()) return false; $_1133461219->InstallEvents(); if(!$_1133461219->InstallFiles()) return false;} else{ if(CModule::IncludeModule(___1588568084(129))) CSearch::DeleteIndex($_510285474); UnRegisterModule($_510285474);} return true;} protected static function OnRequestsSettingsChange($_1447553682, $_1139554173){ self::__850243850("form", $_1139554173);} protected static function OnLearningSettingsChange($_1447553682, $_1139554173){ self::__850243850("learning", $_1139554173);} protected static function OnJabberSettingsChange($_1447553682, $_1139554173){ self::__850243850("xmpp", $_1139554173);} protected static function OnVideoConferenceSettingsChange($_1447553682, $_1139554173){ self::__850243850("video", $_1139554173);} protected static function OnBizProcSettingsChange($_1447553682, $_1139554173){ self::__850243850("bizprocdesigner", $_1139554173);} protected static function OnListsSettingsChange($_1447553682, $_1139554173){ self::__850243850("lists", $_1139554173);} protected static function OnWikiSettingsChange($_1447553682, $_1139554173){ self::__850243850("wiki", $_1139554173);} protected static function OnSupportSettingsChange($_1447553682, $_1139554173){ self::__850243850("support", $_1139554173);} protected static function OnControllerSettingsChange($_1447553682, $_1139554173){ self::__850243850("controller", $_1139554173);} protected static function OnAnalyticsSettingsChange($_1447553682, $_1139554173){ self::__850243850("statistic", $_1139554173);} protected static function OnVoteSettingsChange($_1447553682, $_1139554173){ self::__850243850("vote", $_1139554173);} protected static function OnFriendsSettingsChange($_1447553682, $_1139554173){ if($_1139554173) $_810175341= "Y"; else $_810175341= ___1588568084(130); $_1664303388= CSite::GetList(___1588568084(131), ___1588568084(132), array(___1588568084(133) => ___1588568084(134))); while($_436893656= $_1664303388->Fetch()){ if(COption::GetOptionString(___1588568084(135), ___1588568084(136), ___1588568084(137), $_436893656[___1588568084(138)]) != $_810175341){ COption::SetOptionString(___1588568084(139), ___1588568084(140), $_810175341, false, $_436893656[___1588568084(141)]); COption::SetOptionString(___1588568084(142), ___1588568084(143), $_810175341);}}} protected static function OnMicroBlogSettingsChange($_1447553682, $_1139554173){ if($_1139554173) $_810175341= "Y"; else $_810175341= ___1588568084(144); $_1664303388= CSite::GetList(___1588568084(145), ___1588568084(146), array(___1588568084(147) => ___1588568084(148))); while($_436893656= $_1664303388->Fetch()){ if(COption::GetOptionString(___1588568084(149), ___1588568084(150), ___1588568084(151), $_436893656[___1588568084(152)]) != $_810175341){ COption::SetOptionString(___1588568084(153), ___1588568084(154), $_810175341, false, $_436893656[___1588568084(155)]); COption::SetOptionString(___1588568084(156), ___1588568084(157), $_810175341);} if(COption::GetOptionString(___1588568084(158), ___1588568084(159), ___1588568084(160), $_436893656[___1588568084(161)]) != $_810175341){ COption::SetOptionString(___1588568084(162), ___1588568084(163), $_810175341, false, $_436893656[___1588568084(164)]); COption::SetOptionString(___1588568084(165), ___1588568084(166), $_810175341);}}} protected static function OnPersonalFilesSettingsChange($_1447553682, $_1139554173){ if($_1139554173) $_810175341= "Y"; else $_810175341= ___1588568084(167); $_1664303388= CSite::GetList(___1588568084(168), ___1588568084(169), array(___1588568084(170) => ___1588568084(171))); while($_436893656= $_1664303388->Fetch()){ if(COption::GetOptionString(___1588568084(172), ___1588568084(173), ___1588568084(174), $_436893656[___1588568084(175)]) != $_810175341){ COption::SetOptionString(___1588568084(176), ___1588568084(177), $_810175341, false, $_436893656[___1588568084(178)]); COption::SetOptionString(___1588568084(179), ___1588568084(180), $_810175341);}}} protected static function OnPersonalBlogSettingsChange($_1447553682, $_1139554173){ if($_1139554173) $_810175341= "Y"; else $_810175341= ___1588568084(181); $_1664303388= CSite::GetList(___1588568084(182), ___1588568084(183), array(___1588568084(184) => ___1588568084(185))); while($_436893656= $_1664303388->Fetch()){ if(COption::GetOptionString(___1588568084(186), ___1588568084(187), ___1588568084(188), $_436893656[___1588568084(189)]) != $_810175341){ COption::SetOptionString(___1588568084(190), ___1588568084(191), $_810175341, false, $_436893656[___1588568084(192)]); COption::SetOptionString(___1588568084(193), ___1588568084(194), $_810175341);}}} protected static function OnPersonalPhotoSettingsChange($_1447553682, $_1139554173){ if($_1139554173) $_810175341= "Y"; else $_810175341= ___1588568084(195); $_1664303388= CSite::GetList(___1588568084(196), ___1588568084(197), array(___1588568084(198) => ___1588568084(199))); while($_436893656= $_1664303388->Fetch()){ if(COption::GetOptionString(___1588568084(200), ___1588568084(201), ___1588568084(202), $_436893656[___1588568084(203)]) != $_810175341){ COption::SetOptionString(___1588568084(204), ___1588568084(205), $_810175341, false, $_436893656[___1588568084(206)]); COption::SetOptionString(___1588568084(207), ___1588568084(208), $_810175341);}}} protected static function OnPersonalForumSettingsChange($_1447553682, $_1139554173){ if($_1139554173) $_810175341= "Y"; else $_810175341= ___1588568084(209); $_1664303388= CSite::GetList(___1588568084(210), ___1588568084(211), array(___1588568084(212) => ___1588568084(213))); while($_436893656= $_1664303388->Fetch()){ if(COption::GetOptionString(___1588568084(214), ___1588568084(215), ___1588568084(216), $_436893656[___1588568084(217)]) != $_810175341){ COption::SetOptionString(___1588568084(218), ___1588568084(219), $_810175341, false, $_436893656[___1588568084(220)]); COption::SetOptionString(___1588568084(221), ___1588568084(222), $_810175341);}}} protected static function OnTasksSettingsChange($_1447553682, $_1139554173){ if($_1139554173) $_810175341= "Y"; else $_810175341= ___1588568084(223); $_1664303388= CSite::GetList(___1588568084(224), ___1588568084(225), array(___1588568084(226) => ___1588568084(227))); while($_436893656= $_1664303388->Fetch()){ if(COption::GetOptionString(___1588568084(228), ___1588568084(229), ___1588568084(230), $_436893656[___1588568084(231)]) != $_810175341){ COption::SetOptionString(___1588568084(232), ___1588568084(233), $_810175341, false, $_436893656[___1588568084(234)]); COption::SetOptionString(___1588568084(235), ___1588568084(236), $_810175341);} if(COption::GetOptionString(___1588568084(237), ___1588568084(238), ___1588568084(239), $_436893656[___1588568084(240)]) != $_810175341){ COption::SetOptionString(___1588568084(241), ___1588568084(242), $_810175341, false, $_436893656[___1588568084(243)]); COption::SetOptionString(___1588568084(244), ___1588568084(245), $_810175341);}} self::__850243850(___1588568084(246), $_1139554173);} protected static function OnCalendarSettingsChange($_1447553682, $_1139554173){ if($_1139554173) $_810175341= "Y"; else $_810175341= ___1588568084(247); $_1664303388= CSite::GetList(___1588568084(248), ___1588568084(249), array(___1588568084(250) => ___1588568084(251))); while($_436893656= $_1664303388->Fetch()){ if(COption::GetOptionString(___1588568084(252), ___1588568084(253), ___1588568084(254), $_436893656[___1588568084(255)]) != $_810175341){ COption::SetOptionString(___1588568084(256), ___1588568084(257), $_810175341, false, $_436893656[___1588568084(258)]); COption::SetOptionString(___1588568084(259), ___1588568084(260), $_810175341);} if(COption::GetOptionString(___1588568084(261), ___1588568084(262), ___1588568084(263), $_436893656[___1588568084(264)]) != $_810175341){ COption::SetOptionString(___1588568084(265), ___1588568084(266), $_810175341, false, $_436893656[___1588568084(267)]); COption::SetOptionString(___1588568084(268), ___1588568084(269), $_810175341);}}} protected static function OnSMTPSettingsChange($_1447553682, $_1139554173){ self::__850243850("mail", $_1139554173);} protected static function OnExtranetSettingsChange($_1447553682, $_1139554173){ $_89576057= COption::GetOptionString("extranet", "extranet_site", ""); if($_89576057){ $_690949821= new CSite; $_690949821->Update($_89576057, array(___1588568084(270) =>($_1139554173? ___1588568084(271): ___1588568084(272))));} self::__850243850(___1588568084(273), $_1139554173);} protected static function OnDAVSettingsChange($_1447553682, $_1139554173){ self::__850243850("dav", $_1139554173);} protected static function OntimemanSettingsChange($_1447553682, $_1139554173){ self::__850243850("timeman", $_1139554173);} protected static function Onintranet_sharepointSettingsChange($_1447553682, $_1139554173){ if($_1139554173){ RegisterModuleDependences("iblock", "OnAfterIBlockElementAdd", "intranet", "CIntranetEventHandlers", "SPRegisterUpdatedItem"); RegisterModuleDependences(___1588568084(274), ___1588568084(275), ___1588568084(276), ___1588568084(277), ___1588568084(278)); CAgent::AddAgent(___1588568084(279), ___1588568084(280), ___1588568084(281), round(0+100+100+100+100+100)); CAgent::AddAgent(___1588568084(282), ___1588568084(283), ___1588568084(284), round(0+60+60+60+60+60)); CAgent::AddAgent(___1588568084(285), ___1588568084(286), ___1588568084(287), round(0+1200+1200+1200));} else{ UnRegisterModuleDependences(___1588568084(288), ___1588568084(289), ___1588568084(290), ___1588568084(291), ___1588568084(292)); UnRegisterModuleDependences(___1588568084(293), ___1588568084(294), ___1588568084(295), ___1588568084(296), ___1588568084(297)); CAgent::RemoveAgent(___1588568084(298), ___1588568084(299)); CAgent::RemoveAgent(___1588568084(300), ___1588568084(301)); CAgent::RemoveAgent(___1588568084(302), ___1588568084(303));}} protected static function OncrmSettingsChange($_1447553682, $_1139554173){ if($_1139554173) COption::SetOptionString("crm", "form_features", "Y"); self::__850243850(___1588568084(304), $_1139554173);} protected static function OnClusterSettingsChange($_1447553682, $_1139554173){ self::__850243850("cluster", $_1139554173);} protected static function OnMultiSitesSettingsChange($_1447553682, $_1139554173){ if($_1139554173) RegisterModuleDependences("main", "OnBeforeProlog", "main", "CWizardSolPanelIntranet", "ShowPanel", 100, "/modules/intranet/panel_button.php"); else UnRegisterModuleDependences(___1588568084(305), ___1588568084(306), ___1588568084(307), ___1588568084(308), ___1588568084(309), ___1588568084(310));} protected static function OnIdeaSettingsChange($_1447553682, $_1139554173){ self::__850243850("idea", $_1139554173);} protected static function OnMeetingSettingsChange($_1447553682, $_1139554173){ self::__850243850("meeting", $_1139554173);} protected static function OnXDImportSettingsChange($_1447553682, $_1139554173){ self::__850243850("xdimport", $_1139554173);}} $GLOBALS['____1759358239'][44](___1588568084(311), ___1588568084(312));/**/			//Do not remove this

require_once(__DIR__."/autoload.php");

// Component 2.0 template engines
$GLOBALS['arCustomTemplateEngines'] = [];

// User fields manager
$GLOBALS['USER_FIELD_MANAGER'] = new CUserTypeManager;

// todo: remove global
$GLOBALS['BX_MENU_CUSTOM'] = CMenuCustom::getInstance();

if(file_exists(($_fname = __DIR__."/classes/general/update_db_updater.php")))
{
	$US_HOST_PROCESS_MAIN = False;
	include($_fname);
}

if(file_exists(($_fname = $_SERVER["DOCUMENT_ROOT"]."/bitrix/init.php")))
	include_once($_fname);

if(($_fname = getLocalPath("php_interface/init.php", BX_PERSONAL_ROOT)) !== false)
	include_once($_SERVER["DOCUMENT_ROOT"].$_fname);

if(($_fname = getLocalPath("php_interface/".SITE_ID."/init.php", BX_PERSONAL_ROOT)) !== false)
	include_once($_SERVER["DOCUMENT_ROOT"].$_fname);

if(!defined("BX_FILE_PERMISSIONS"))
	define("BX_FILE_PERMISSIONS", 0644);
if(!defined("BX_DIR_PERMISSIONS"))
	define("BX_DIR_PERMISSIONS", 0755);

//global var, is used somewhere
$GLOBALS["sDocPath"] = $GLOBALS["APPLICATION"]->GetCurPage();

if((!(defined("STATISTIC_ONLY") && STATISTIC_ONLY && mb_substr($GLOBALS["APPLICATION"]->GetCurPage(), 0, mb_strlen(BX_ROOT."/admin/")) != BX_ROOT."/admin/")) && COption::GetOptionString("main", "include_charset", "Y")=="Y" && LANG_CHARSET <> '')
	header("Content-Type: text/html; charset=".LANG_CHARSET);

if(COption::GetOptionString("main", "set_p3p_header", "Y")=="Y")
	header("P3P: policyref=\"/bitrix/p3p.xml\", CP=\"NON DSP COR CUR ADM DEV PSA PSD OUR UNR BUS UNI COM NAV INT DEM STA\"");

header("X-Powered-CMS: Bitrix Site Manager (".(LICENSE_KEY == "DEMO"? "DEMO" : md5("BITRIX".LICENSE_KEY."LICENCE")).")");
if (COption::GetOptionString("main", "update_devsrv", "") == "Y")
	header("X-DevSrv-CMS: Bitrix");

if (!defined("BX_CRONTAB_SUPPORT"))
{
	define("BX_CRONTAB_SUPPORT", defined("BX_CRONTAB"));
}

//agents
if(COption::GetOptionString("main", "check_agents", "Y") == "Y")
{
	$application->addBackgroundJob(["CAgent", "CheckAgents"], [], \Bitrix\Main\Application::JOB_PRIORITY_LOW);
}

//send email events
if(COption::GetOptionString("main", "check_events", "Y") !== "N")
{
	$application->addBackgroundJob(['\Bitrix\Main\Mail\EventManager', 'checkEvents'], [], \Bitrix\Main\Application::JOB_PRIORITY_LOW-1);
}

$healerOfEarlySessionStart = new HealerEarlySessionStart();
$healerOfEarlySessionStart->process($application->getKernelSession());

$kernelSession = $application->getKernelSession();
$kernelSession->start();
$application->getSessionLocalStorageManager()->setUniqueId($kernelSession->getId());

foreach (GetModuleEvents("main", "OnPageStart", true) as $arEvent)
	ExecuteModuleEventEx($arEvent);

//define global user object
$GLOBALS["USER"] = new CUser;

//session control from group policy
$arPolicy = $GLOBALS["USER"]->GetSecurityPolicy();
$currTime = time();
if(
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
if(!isset($kernelSession["BX_SESSION_SIGN"]))
{
	$kernelSession["BX_SESSION_SIGN"] = bitrix_sess_sign();
}

//session control from security module
if(
	(COption::GetOptionString("main", "use_session_id_ttl", "N") == "Y")
	&& (COption::GetOptionInt("main", "session_id_ttl", 0) > 0)
	&& !defined("BX_SESSION_ID_CHANGE")
)
{
	if(!isset($kernelSession['SESS_ID_TIME']))
	{
		$kernelSession['SESS_ID_TIME'] = $currTime;
	}
	elseif(($kernelSession['SESS_ID_TIME'] + COption::GetOptionInt("main", "session_id_ttl")) < $kernelSession['SESS_TIME'])
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

if(!defined("NOT_CHECK_PERMISSIONS") || NOT_CHECK_PERMISSIONS!==true)
{
	$doLogout = isset($_REQUEST["logout"]) && (strtolower($_REQUEST["logout"]) == "yes");

	if($doLogout && $GLOBALS["USER"]->IsAuthorized())
	{
		$secureLogout = (\Bitrix\Main\Config\Option::get("main", "secure_logout", "N") == "Y");

		if(!$secureLogout || check_bitrix_sessid())
		{
			$GLOBALS["USER"]->Logout();
			LocalRedirect($GLOBALS["APPLICATION"]->GetCurPageParam('', array('logout', 'sessid')));
		}
	}

	// authorize by cookies
	if(!$GLOBALS["USER"]->IsAuthorized())
	{
		$GLOBALS["USER"]->LoginByCookies();
	}

	$arAuthResult = false;

	//http basic and digest authorization
	if(($httpAuth = $GLOBALS["USER"]->LoginByHttpAuth()) !== null)
	{
		$arAuthResult = $httpAuth;
		$GLOBALS["APPLICATION"]->SetAuthResult($arAuthResult);
	}

	//Authorize user from authorization html form
	//Only POST is accepted
	if(isset($_POST["AUTH_FORM"]) && $_POST["AUTH_FORM"] <> '')
	{
		if(COption::GetOptionString('main', 'use_encrypted_auth', 'N') == 'Y')
		{
			//possible encrypted user password
			$sec = new CRsaSecurity();
			if(($arKeys = $sec->LoadKeys()))
			{
				$sec->SetKeys($arKeys);
				$errno = $sec->AcceptFromForm(['USER_PASSWORD', 'USER_CONFIRM_PASSWORD', 'USER_CURRENT_PASSWORD']);
				if($errno == CRsaSecurity::ERROR_SESS_CHECK)
					$arAuthResult = array("MESSAGE"=>GetMessage("main_include_decode_pass_sess"), "TYPE"=>"ERROR");
				elseif($errno < 0)
					$arAuthResult = array("MESSAGE"=>GetMessage("main_include_decode_pass_err", array("#ERRCODE#"=>$errno)), "TYPE"=>"ERROR");

				if($errno < 0)
					$bRsaError = true;
			}
		}

		if (!$bRsaError)
		{
			if(!defined("ADMIN_SECTION") || ADMIN_SECTION !== true)
			{
				$USER_LID = SITE_ID;
			}

			$_POST["TYPE"] = $_POST["TYPE"] ?? null;
			if($_POST["TYPE"] == "AUTH")
			{
				$arAuthResult = $GLOBALS["USER"]->Login(
					$_POST["USER_LOGIN"] ?? '',
					$_POST["USER_PASSWORD"] ?? '',
					$_POST["USER_REMEMBER"] ?? ''
				);
			}
			elseif($_POST["TYPE"] == "OTP")
			{
				$arAuthResult = $GLOBALS["USER"]->LoginByOtp(
					$_POST["USER_OTP"] ?? '',
					$_POST["OTP_REMEMBER"] ?? '',
					$_POST["captcha_word"] ?? '',
					$_POST["captcha_sid"] ?? ''
				);
			}
			elseif($_POST["TYPE"] == "SEND_PWD")
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
			elseif($_POST["TYPE"] == "CHANGE_PWD")
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

			if($_POST["TYPE"] == "AUTH" || $_POST["TYPE"] == "OTP")
			{
				//special login form in the control panel
				if($arAuthResult === true && defined('ADMIN_SECTION') && ADMIN_SECTION === true)
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
	elseif(!$GLOBALS["USER"]->IsAuthorized() && isset($_REQUEST['bx_hit_hash']))
	{
		//Authorize by unique URL
		$GLOBALS["USER"]->LoginHitByHash($_REQUEST['bx_hit_hash']);
	}
}

//logout or re-authorize the user if something importand has changed
$GLOBALS["USER"]->CheckAuthActions();

//magic short URI
if(defined("BX_CHECK_SHORT_URI") && BX_CHECK_SHORT_URI && CBXShortUri::CheckUri())
{
	//local redirect inside
	die();
}

//application password scope control
if(($applicationID = $GLOBALS["USER"]->getContext()->getApplicationId()) !== null)
{
	$appManager = Main\Authentication\ApplicationManager::getInstance();
	if($appManager->checkScope($applicationID) !== true)
	{
		$event = new Main\Event("main", "onApplicationScopeError", Array('APPLICATION_ID' => $applicationID));
		$event->send();

		$context->getResponse()->setStatus("403 Forbidden");
		$application->end();
	}
}

//define the site template
if(!defined("ADMIN_SECTION") || ADMIN_SECTION !== true)
{
	$siteTemplate = "";
	if(isset($_REQUEST["bitrix_preview_site_template"]) && is_string($_REQUEST["bitrix_preview_site_template"]) && $_REQUEST["bitrix_preview_site_template"] <> "" && $GLOBALS["USER"]->CanDoOperation('view_other_settings'))
	{
		//preview of site template
		$signer = new Bitrix\Main\Security\Sign\Signer();
		try
		{
			//protected by a sign
			$requestTemplate = $signer->unsign($_REQUEST["bitrix_preview_site_template"], "template_preview".bitrix_sessid());

			$aTemplates = CSiteTemplate::GetByID($requestTemplate);
			if($template = $aTemplates->Fetch())
			{
				$siteTemplate = $template["ID"];

				//preview of unsaved template
				if(isset($_GET['bx_template_preview_mode']) && $_GET['bx_template_preview_mode'] == 'Y' && $GLOBALS["USER"]->CanDoOperation('edit_other_settings'))
				{
					define("SITE_TEMPLATE_PREVIEW_MODE", true);
				}
			}
		}
		catch(\Bitrix\Main\Security\Sign\BadSignatureException $e)
		{
		}
	}
	if($siteTemplate == "")
	{
		$siteTemplate = CSite::GetCurTemplate();
	}
	define("SITE_TEMPLATE_ID", $siteTemplate);
	define("SITE_TEMPLATE_PATH", getLocalPath('templates/'.SITE_TEMPLATE_ID, BX_PERSONAL_ROOT));
}
else
{
	// prevents undefined constants
	define('SITE_TEMPLATE_ID', '.default');
	define('SITE_TEMPLATE_PATH', '/bitrix/templates/.default');
}

//magic parameters: show page creation time
if(isset($_GET["show_page_exec_time"]))
{
	if($_GET["show_page_exec_time"]=="Y" || $_GET["show_page_exec_time"]=="N")
		$kernelSession["SESS_SHOW_TIME_EXEC"] = $_GET["show_page_exec_time"];
}

//magic parameters: show included file processing time
if(isset($_GET["show_include_exec_time"]))
{
	if($_GET["show_include_exec_time"]=="Y" || $_GET["show_include_exec_time"]=="N")
		$kernelSession["SESS_SHOW_INCLUDE_TIME_EXEC"] = $_GET["show_include_exec_time"];
}

//magic parameters: show include areas
if(isset($_GET["bitrix_include_areas"]) && $_GET["bitrix_include_areas"] <> "")
	$GLOBALS["APPLICATION"]->SetShowIncludeAreas($_GET["bitrix_include_areas"]=="Y");

//magic sound
if($GLOBALS["USER"]->IsAuthorized())
{
	$cookie_prefix = COption::GetOptionString('main', 'cookie_name', 'BITRIX_SM');
	if(!isset($_COOKIE[$cookie_prefix.'_SOUND_LOGIN_PLAYED']))
		$GLOBALS["APPLICATION"]->set_cookie('SOUND_LOGIN_PLAYED', 'Y', 0);
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
			if(COption::GetOptionString("main", "new_user_registration", "N") == "Y" && (!defined("ADMIN_SECTION") || ADMIN_SECTION !== true))
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

if((!defined("NOT_CHECK_PERMISSIONS") || NOT_CHECK_PERMISSIONS!==true) && (!defined("NOT_CHECK_FILE_PERMISSIONS") || NOT_CHECK_FILE_PERMISSIONS!==true))
{
	$real_path = $context->getRequest()->getScriptFile();

	if(!$GLOBALS["USER"]->CanDoFileOperation('fm_view_file', array(SITE_ID, $real_path)) || (defined("NEED_AUTH") && NEED_AUTH && !$GLOBALS["USER"]->IsAuthorized()))
	{
		/** @noinspection PhpUndefinedVariableInspection */
		if($GLOBALS["USER"]->IsAuthorized() && $arAuthResult["MESSAGE"] == '')
		{
			$arAuthResult = array("MESSAGE"=>GetMessage("ACCESS_DENIED").' '.GetMessage("ACCESS_DENIED_FILE", array("#FILE#"=>$real_path)), "TYPE"=>"ERROR");

			if(COption::GetOptionString("main", "event_log_permissions_fail", "N") === "Y")
			{
				CEventLog::Log("SECURITY", "USER_PERMISSIONS_FAIL", "main", $GLOBALS["USER"]->GetID(), $real_path);
			}
		}

		if(defined("ADMIN_SECTION") && ADMIN_SECTION==true)
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
			elseif(defined("MOBILE_APP_ADMIN") && MOBILE_APP_ADMIN==true)
			{
				echo json_encode(Array("status"=>"failed"));
				die();
			}
		}

		/** @noinspection PhpUndefinedVariableInspection */
		$GLOBALS["APPLICATION"]->AuthForm($arAuthResult);
	}
}

/*ZDUyZmZNDA4OTFiZDczOTVkYzk0Yzk4NjM3ZWUzNjhmM2YyNmI=*/$GLOBALS['____1388259816']= array(base64_decode('bXRf'.'cmFuZ'.'A=='),base64_decode('ZXh'.'w'.'bG'.'9'.'kZQ=='),base64_decode('cGFja'.'w'.'=='),base64_decode('b'.'WQ1'),base64_decode('Y29uc3RhbnQ='),base64_decode('aGFzaF9ob'.'W'.'Fj'),base64_decode('c3Ry'.'Y21w'),base64_decode('aXNfb2JqZWN0'),base64_decode('Y2'.'FsbF'.'91c2VyX2Z1b'.'mM='),base64_decode('Y2'.'Fs'.'bF'.'91'.'c'.'2Vy'.'X2Z1bmM='),base64_decode('Y2FsbF'.'9'.'1c'.'2'.'VyX2Z1bmM'.'='),base64_decode(''.'Y'.'2FsbF91'.'c2V'.'yX'.'2Z1'.'b'.'mM'.'='),base64_decode('Y2'.'FsbF'.'91c'.'2VyX'.'2Z1bmM='));if(!function_exists(__NAMESPACE__.'\\___1021236109')){function ___1021236109($_1409789735){static $_840787088= false; if($_840787088 == false) $_840787088=array(''.'REI'.'=',''.'U0VM'.'R'.'UNUI'.'FZBTFVFI'.'EZST0'.'0'.'gYl'.'9vcHRpb24gV0hFUkUgTkFNRT0nfl'.'BBUkF'.'N'.'X01'.'BW'.'F9'.'V'.'U'.'0VSUycgQU'.'5EIE1'.'P'.'RFVMRV9JRD0n'.'bWFpbicgQU5EIFN'.'JVE'.'V'.'fSUQgSVM'.'gTl'.'VMTA==',''.'VkF'.'MVUU=','Lg==','SC'.'o=','Yml0c'.'ml4','T'.'ElD'.'R'.'U5T'.'RV9LR'.'V'.'k'.'=','c2hhMjU2','VV'.'NFUg==','VVNFUg==','VV'.'NFUg==',''.'SXN'.'BdXRob3J'.'pemV'.'k',''.'V'.'VNFUg==','SXNBZG1p'.'bg==','Q'.'VB'.'QT'.'ElDQ'.'VRJT'.'04=','UmVzdGFydEJ1'.'ZmZlcg==','TG9jYWxSZW'.'Rpcm'.'Vjd'.'A==','L2x'.'pY2Vu'.'c2'.'V'.'fcmVzdH'.'JpY3R'.'pb2'.'4ucGhw',''.'XEJpdHJpeF'.'xNY'.'Wl'.'uX'.'ENv'.'bmZ'.'pZ1'.'xP'.'cH'.'Rpb246On'.'Nl'.'dA==',''.'bWFpbg==','U'.'EF'.'SQU'.'1fTUFYX1'.'VTRVJT');return base64_decode($_840787088[$_1409789735]);}};if($GLOBALS['____1388259816'][0](round(0+0.33333333333333+0.33333333333333+0.33333333333333), round(0+5+5+5+5)) == round(0+2.3333333333333+2.3333333333333+2.3333333333333)){ $_179261041= $GLOBALS[___1021236109(0)]->Query(___1021236109(1), true); if($_897517775= $_179261041->Fetch()){ $_1848012008= $_897517775[___1021236109(2)]; list($_1297107918, $_1359084392)= $GLOBALS['____1388259816'][1](___1021236109(3), $_1848012008); $_813001652= $GLOBALS['____1388259816'][2](___1021236109(4), $_1297107918); $_213740464= ___1021236109(5).$GLOBALS['____1388259816'][3]($GLOBALS['____1388259816'][4](___1021236109(6))); $_378637481= $GLOBALS['____1388259816'][5](___1021236109(7), $_1359084392, $_213740464, true); if($GLOBALS['____1388259816'][6]($_378637481, $_813001652) !==(1376/2-688)){ if(isset($GLOBALS[___1021236109(8)]) && $GLOBALS['____1388259816'][7]($GLOBALS[___1021236109(9)]) && $GLOBALS['____1388259816'][8](array($GLOBALS[___1021236109(10)], ___1021236109(11))) &&!$GLOBALS['____1388259816'][9](array($GLOBALS[___1021236109(12)], ___1021236109(13)))){ $GLOBALS['____1388259816'][10](array($GLOBALS[___1021236109(14)], ___1021236109(15))); $GLOBALS['____1388259816'][11](___1021236109(16), ___1021236109(17), true);}}} else{ $GLOBALS['____1388259816'][12](___1021236109(18), ___1021236109(19), ___1021236109(20), round(0+3+3+3+3));}}/**/       //Do not remove this

