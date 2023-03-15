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

/*ZDUyZmZYmU0NWQzNmZlNTJlMWI2OGNkY2FiNDBhY2E1ZDI2NGY=*/$GLOBALS['_____1525633741']= array(base64_decode('R2V0'.'TW9kdWxlRXZlbn'.'Rz'),base64_decode('RXhlY3V'.'0ZU1vZHVs'.'ZU'.'V2ZW50'.'RXg'.'='));$GLOBALS['____1429030738']= array(base64_decode(''.'ZGVmaW5l'),base64_decode(''.'YmFzZTY0X2RlY2'.'9kZQ=='),base64_decode('dW5zZX'.'J'.'pY'.'Wxpe'.'mU='),base64_decode(''.'aX'.'N'.'fYXJyYXk='),base64_decode('aW5fYXJ'.'y'.'YXk='),base64_decode(''.'c2'.'Vya'.'WFsaX'.'p'.'l'),base64_decode('Ym'.'FzZ'.'TY0X2Vu'.'Y2'.'9'.'kZQ=='),base64_decode('bW'.'t'.'0aW1l'),base64_decode('ZGF0ZQ=='),base64_decode('ZGF0'.'Z'.'Q'.'='.'='),base64_decode(''.'c3RybGVu'),base64_decode('bWt0aW1l'),base64_decode('ZGF0Z'.'Q'.'=='),base64_decode(''.'Z'.'GF0ZQ'.'=='),base64_decode('b'.'WV0'.'aG9'.'kX2V4'.'a'.'X'.'N'.'0cw'.'='.'='),base64_decode('Y2'.'FsbF91c2VyX2'.'Z1bmN'.'fYX'.'JyYX'.'k='),base64_decode(''.'c3R'.'ybGV'.'u'),base64_decode('c2VyaWFsaX'.'pl'),base64_decode('YmFzZ'.'TY0X2V'.'uY'.'29'.'k'.'ZQ=='),base64_decode('c3RybGV'.'u'),base64_decode('aXNf'.'YXJ'.'y'.'YX'.'k='),base64_decode('c'.'2'.'Vya'.'WFsaXpl'),base64_decode(''.'Y'.'m'.'Fz'.'Z'.'TY0X2VuY29'.'kZQ'.'='.'='),base64_decode('c2'.'Vya'.'WFs'.'aXp'.'l'),base64_decode(''.'Ym'.'F'.'zZTY0X2Vu'.'Y29kZQ=='),base64_decode(''.'aXNfYXJyYXk'.'='),base64_decode('a'.'XNfY'.'XJyYX'.'k='),base64_decode('aW5fYXJyYXk='),base64_decode(''.'aW5fYXJyYXk='),base64_decode('bWt'.'0'.'aW1l'),base64_decode('Z'.'GF0ZQ=='),base64_decode('ZGF0Z'.'Q=='),base64_decode('ZGF0ZQ=='),base64_decode('bWt0'.'aW1l'),base64_decode('ZGF0ZQ'.'='.'='),base64_decode('ZGF0ZQ'.'=='),base64_decode('aW5'.'fY'.'XJyYXk='),base64_decode('c2'.'V'.'yaWFsaX'.'pl'),base64_decode('Y'.'mF'.'zZT'.'Y0'.'X2VuY29kZQ=='),base64_decode('aW50dmFs'),base64_decode('dG'.'ltZQ'.'=='),base64_decode('ZmlsZV9leGlzdHM'.'='),base64_decode(''.'c3RyX3JlcG'.'xhY'.'2U='),base64_decode('Y2xhc3NfZXhpc3Rz'),base64_decode('ZGVm'.'aW'.'5l'));if(!function_exists(__NAMESPACE__.'\\___1473611432')){function ___1473611432($_2134481727){static $_557265211= false; if($_557265211 == false) $_557265211=array('SU5U'.'U'.'kFORVR'.'f'.'RU'.'RJVElPTg==','W'.'Q==',''.'bW'.'Fp'.'bg='.'=','f'.'mNwZl9tYXBfdmFsdWU'.'=','','','YWxsb3dlZF9jbGFzc2Vz','ZQ'.'='.'=','Zg'.'==','ZQ='.'=','Rg==','WA==',''.'Zg'.'==',''.'b'.'WFpbg==','fm'.'NwZl9'.'tYXBfd'.'mFsdW'.'U'.'=','UG9ydG'.'Fs','Rg==','ZQ==','Z'.'Q='.'=','WA==','R'.'g==','RA==','RA==','bQ'.'='.'=','ZA==','WQ==','Zg==',''.'Zg==','Zg==','Zg==','UG9ydG'.'Fs','Rg'.'==','Z'.'Q==','ZQ==','WA='.'=','Rg==','R'.'A==','RA==',''.'bQ='.'=','ZA==','W'.'Q'.'==','b'.'W'.'Fp'.'bg='.'=','T24'.'=','U2'.'V'.'0dG'.'luZ3NDaGFuZ2U=','Z'.'g==','Zg'.'==','Zg==','Zg==','bWFpbg==','fmNwZl9tYXBfdmFsd'.'WU=','ZQ==','ZQ==','RA'.'==','ZQ'.'='.'=','ZQ==','Zg==','Zg==','Zg='.'=','ZQ==',''.'b'.'WFpbg'.'==',''.'f'.'mNwZl9t'.'YXBfdmFsdW'.'U=',''.'ZQ==',''.'Zg='.'=','Zg==','Zg='.'=','Zg='.'=','bWFpbg==','fm'.'NwZl9'.'tYXBfdm'.'F'.'s'.'dWU=','ZQ==',''.'Zg==',''.'UG9ydG'.'Fs','UG9ydGFs','ZQ==','UG'.'9'.'yd'.'GFs',''.'Rg==',''.'WA==','Rg='.'=','RA='.'=','ZQ==','ZQ==','RA='.'=','bQ='.'=','ZA==','WQ==','ZQ='.'=','WA==',''.'Z'.'Q==',''.'R'.'g='.'=','Z'.'Q'.'='.'=','R'.'A'.'==','Zg'.'==','ZQ==',''.'RA='.'=',''.'ZQ==',''.'b'.'Q'.'==','ZA==',''.'WQ==','Zg==','Zg'.'==','Zg'.'==','Z'.'g==','Zg'.'==','Zg='.'=','Zg==','Zg'.'==','bWFpbg==','f'.'mNwZl9tYXBfd'.'mFsdW'.'U=','ZQ==','UG9ydGFs','Rg==','WA='.'=','VFl'.'QR'.'Q==','R'.'E'.'FURQ==',''.'RkVBVFVSRVM=','RVhQSVJF'.'RA'.'==',''.'VFlQRQ'.'==',''.'RA'.'='.'=','V'.'FJZX0RBWV'.'NfQ09VTlQ=','REF'.'U'.'RQ==','VFJZX0RBWV'.'NfQ09V'.'Tl'.'Q=','RV'.'hQSVJFR'.'A'.'==','R'.'k'.'VBVFVSRVM=','Zg==','Z'.'g='.'=','RE9DV'.'U1FTl'.'R'.'fU'.'k'.'9'.'PVA==','L2Jp'.'d'.'HJpeC'.'9tb2'.'R'.'1bG'.'VzLw==','L2luc3Rh'.'bGwvaW5'.'kZ'.'XgucGh'.'w','Lg==','Xw==','c'.'2Vhc'.'mNo','Tg='.'=','','','QUNUSV'.'ZF',''.'WQ'.'==','c'.'29ja'.'W'.'FsbmV0d2'.'9yaw==',''.'YWxsb3dfZnJpZWxkcw==','WQ'.'==','SU'.'Q=','c'.'29'.'jaWFsbm'.'V0d'.'29yaw'.'==','YWxsb3dfZn'.'JpZWxkc'.'w==','SUQ=','c'.'29'.'jaW'.'FsbmV0d29yaw==','YW'.'xsb3dfZ'.'n'.'JpZ'.'Wx'.'k'.'cw==','Tg==','','','QUNU'.'SV'.'ZF','WQ==','c29jaWFs'.'bmV0d'.'29y'.'a'.'w==','Y'.'Wxsb3dfbWlj'.'cm9ibG9'.'nX3V'.'z'.'ZXI'.'=',''.'W'.'Q==','SUQ=','c29jaWF'.'s'.'bmV'.'0d29y'.'a'.'w==','YWx'.'sb3'.'df'.'bW'.'lj'.'cm9ibG9n'.'X3V'.'zZXI=','SU'.'Q=',''.'c29ja'.'WFsb'.'mV0'.'d'.'29yaw==','YW'.'xsb3'.'d'.'fbWljcm9ibG9'.'n'.'X'.'3Vz'.'ZXI=','c29jaW'.'FsbmV0'.'d29y'.'a'.'w='.'=','YWxsb'.'3dfbWljcm'.'9i'.'b'.'G9nX2'.'dyb3V'.'w','WQ==','SUQ=','c29ja'.'WF'.'sbmV0d29'.'yaw==','YWxsb3'.'df'.'b'.'Wl'.'jcm9ibG9nX2'.'dyb3'.'Vw','SUQ'.'=','c29jaWF'.'sbmV0d'.'29yaw'.'==',''.'YWxs'.'b'.'3'.'dfbWljc'.'m9i'.'b'.'G'.'9nX2d'.'y'.'b3Vw','Tg==','','','QUNU'.'SVZF','WQ==','c29jaW'.'FsbmV'.'0'.'d29yaw'.'==',''.'YWxs'.'b3'.'dfZmlsZXNfdXNlcg==','WQ==',''.'SUQ=','c29jaWFsbmV0d29'.'yaw==','YWxs'.'b3dfZml'.'sZXNfdXNlc'.'g='.'=',''.'S'.'U'.'Q'.'=','c29jaW'.'Fsbm'.'V0d'.'29yaw==','YWx'.'sb3dfZ'.'mlsZ'.'X'.'NfdXN'.'lcg='.'=','Tg==','','',''.'QUNUSVZF','WQ==','c29jaWFsbmV0d'.'29'.'yaw='.'=','YWxs'.'b3dfYmxvZ'.'191'.'c'.'2V'.'y','WQ='.'=','S'.'UQ=',''.'c29'.'jaW'.'FsbmV0d'.'29'.'ya'.'w'.'==','YWxsb3dfYmx'.'vZ19'.'1c2Vy','S'.'UQ=','c'.'2'.'9'.'ja'.'WFsbmV0d'.'29'.'yaw==','Y'.'W'.'xs'.'b3dfYmxvZ'.'191c2Vy','Tg==','','','QUN'.'USVZ'.'F','WQ==',''.'c29ja'.'WFs'.'bmV0d'.'29y'.'aw'.'==','YWxs'.'b3d'.'fcGh'.'v'.'dG9'.'fd'.'XNlcg==','WQ==','S'.'U'.'Q=','c29jaW'.'FsbmV0'.'d'.'29yaw==','YWxsb3df'.'cGhvdG9fdXNlcg='.'=',''.'S'.'UQ=','c2'.'9'.'j'.'aWFsbmV0d29'.'y'.'aw==','YW'.'xsb3dfc'.'GhvdG9fdXNlcg==','Tg==','','','QUNUSVZF','W'.'Q==','c2'.'9jaWF'.'s'.'bmV0d2'.'9yaw'.'==','YWxsb3dfZm9y'.'dW1fdXNl'.'cg'.'='.'=','WQ==','SU'.'Q=',''.'c29j'.'aWFsbm'.'V0d2'.'9yaw='.'=','Y'.'Wx'.'s'.'b3dfZm9y'.'dW1fd'.'X'.'N'.'lcg'.'==','SUQ=','c'.'29jaWFsbmV0d2'.'9yaw='.'=','Y'.'Wxsb3'.'dfZm9ydW1'.'fd'.'XNlcg==','Tg==','','','QUNUSV'.'ZF','W'.'Q'.'==','c2'.'9'.'j'.'aWFsb'.'mV0d29yaw'.'==',''.'Y'.'Wxsb3dfdGFza3N'.'fdXNl'.'cg'.'==','WQ'.'==','SU'.'Q'.'=',''.'c'.'29jaWFsb'.'m'.'V0d'.'29yaw'.'==','YWxsb3'.'dfdG'.'F'.'za3'.'N'.'f'.'dXNlcg'.'==','SUQ=','c29ja'.'WFsbmV0d29yaw==','YWx'.'sb3df'.'dGFz'.'a3NfdXNlcg==','c29jaWF'.'s'.'bmV0d29ya'.'w'.'==',''.'YWxsb'.'3'.'dfd'.'GF'.'za3N'.'fZ3Jvd'.'XA=','WQ==',''.'SU'.'Q=','c2'.'9jaW'.'F'.'sbmV0'.'d'.'2'.'9yaw==',''.'YW'.'x'.'sb3dfdGF'.'za3N'.'f'.'Z3'.'Jvd'.'XA=','SU'.'Q=','c29jaWFsbmV0d2'.'9ya'.'w==','YWxsb3dfdGFza3'.'NfZ3J'.'vdXA=','dG'.'Fz'.'a'.'3M'.'=','Tg==','','','QUNUSVZF','W'.'Q==','c29'.'jaW'.'Fsbm'.'V0d29yaw==','YW'.'xsb3'.'df'.'Y2Fs'.'ZW5kY'.'XJ'.'f'.'d'.'XNl'.'cg'.'==','WQ'.'==','SUQ=','c29jaW'.'F'.'sbm'.'V0d29yaw'.'==','YWx'.'sb3dfY2FsZW5kYXJ'.'fdXNlcg'.'==','SUQ=','c29jaWFsbmV0d29yaw==','YWxsb3dfY2FsZW'.'5kYXJf'.'dXN'.'lcg==','c29'.'jaW'.'Fs'.'bm'.'V0d29y'.'aw==',''.'Y'.'Wx'.'sb3dfY'.'2'.'FsZW5kYX'.'Jf'.'Z3'.'JvdX'.'A=',''.'WQ'.'==','SUQ=',''.'c29ja'.'WF'.'sbmV0d29yaw'.'='.'=',''.'YWxsb3dfY2'.'FsZW'.'5k'.'Y'.'XJfZ3Jvd'.'XA'.'=','SU'.'Q=',''.'c2'.'9jaW'.'F'.'sb'.'mV0d'.'29yaw==','YWx'.'sb3dfY2F'.'sZ'.'W'.'5'.'kYXJfZ3Jvd'.'XA=','QUNU'.'S'.'VZF',''.'WQ==','T'.'g'.'==','ZXh0cmFuZX'.'Q=',''.'aWJ'.'sb2'.'Nr','T25BZnRlcklC'.'b'.'G'.'9ja0Vs'.'ZW1lbnRVcGR'.'hdGU=',''.'aW50cmFuZXQ'.'=','Q0ludH'.'Jh'.'bmV0RXZ'.'lbnRIYW'.'5kb'.'GVycw='.'=','U'.'1BSZWdpc3'.'RlclVwZGF0ZWRJ'.'d'.'GVt','Q0ludHJ'.'hbmV0U2hh'.'cmVwb2ludDo6Q'.'Wdlbn'.'R'.'MaXN0'.'cygpOw='.'=','a'.'W'.'50cm'.'FuZXQ=','Tg==','Q0ludHJhbmV'.'0U'.'2hhcmVwb2l'.'udDo6QWdlbnRRdWV1ZSgpOw==','aW50cmFuZXQ=','Tg==',''.'Q0l'.'udHJhbm'.'V0U2h'.'hcmVwb2ludDo6QWd'.'lbnR'.'VcG'.'Rhd'.'GUo'.'KTs=','aW5'.'0cmFuZ'.'XQ=','Tg='.'=','aWJsb2'.'Nr','T25BZ'.'nRlcklC'.'bG9'.'ja0V'.'sZW1lb'.'nRBZGQ'.'=',''.'aW50'.'cmF'.'uZ'.'XQ=','Q0lu'.'dHJ'.'hb'.'m'.'V0'.'R'.'XZlbnRIY'.'W5'.'kbGVycw==','U1'.'B'.'SZ'.'W'.'dpc'.'3Rl'.'clVwZ'.'GF0Z'.'WRJdG'.'Vt','aWJsb'.'2Nr','T25B'.'ZnR'.'lck'.'l'.'Cb'.'G9ja0VsZW1lbnR'.'VcG'.'RhdGU=','aW50cmFuZX'.'Q=','Q'.'0lu'.'dHJ'.'hbm'.'V0R'.'X'.'ZlbnRIYW5kbGV'.'ycw==','U1'.'BSZWd'.'pc3Rlcl'.'VwZGF0Z'.'WRJdG'.'V'.'t','Q0ludHJhbm'.'V0U'.'2hhcmVwb2lud'.'Do6QWdlbnRM'.'aX'.'N0cygp'.'Ow==','aW'.'50c'.'mF'.'uZ'.'XQ'.'=','Q0ludHJhbmV0U2hhcmVwb'.'2ludDo6'.'Q'.'Wd'.'lbnR'.'Rd'.'WV'.'1ZS'.'gpOw==','a'.'W50cm'.'F'.'u'.'ZXQ=','Q0ludHJhb'.'mV0U2hhc'.'m'.'Vwb2ludDo6'.'Q'.'Wdlb'.'nRVcGRh'.'dG'.'UoKTs=','aW50cmFu'.'ZXQ=',''.'Y3'.'Jt','bWFpb'.'g==','T2'.'5CZW'.'Zvc'.'mVQc'.'m9sb2c=','bWF'.'pbg='.'=','Q1dpemFy'.'ZFNvbFBhb'.'mVs'.'SW50cm'.'FuZXQ=','U2hvd1BhbmVs','L2'.'1'.'v'.'Z'.'HV'.'sZ'.'XMvaW50'.'cmF'.'uZXQvcGFuZWxfYnV0dG9uLn'.'Bo'.'cA'.'='.'=',''.'RU'.'5DT0RF',''.'WQ='.'=');return base64_decode($_557265211[$_2134481727]);}};$GLOBALS['____1429030738'][0](___1473611432(0), ___1473611432(1));class CBXFeatures{ private static $_1936161591= 30; private static $_1333253630= array( "Portal" => array( "CompanyCalendar", "CompanyPhoto", "CompanyVideo", "CompanyCareer", "StaffChanges", "StaffAbsence", "CommonDocuments", "MeetingRoomBookingSystem", "Wiki", "Learning", "Vote", "WebLink", "Subscribe", "Friends", "PersonalFiles", "PersonalBlog", "PersonalPhoto", "PersonalForum", "Blog", "Forum", "Gallery", "Board", "MicroBlog", "WebMessenger",), "Communications" => array( "Tasks", "Calendar", "Workgroups", "Jabber", "VideoConference", "Extranet", "SMTP", "Requests", "DAV", "intranet_sharepoint", "timeman", "Idea", "Meeting", "EventList", "Salary", "XDImport",), "Enterprise" => array( "BizProc", "Lists", "Support", "Analytics", "crm", "Controller", "LdapUnlimitedUsers",), "Holding" => array( "Cluster", "MultiSites",),); private static $_1462299268= null; private static $_1548368408= null; private static function __561198947(){ if(self::$_1462299268 === null){ self::$_1462299268= array(); foreach(self::$_1333253630 as $_321968104 => $_1603655158){ foreach($_1603655158 as $_981032942) self::$_1462299268[$_981032942]= $_321968104;}} if(self::$_1548368408 === null){ self::$_1548368408= array(); $_1628455755= COption::GetOptionString(___1473611432(2), ___1473611432(3), ___1473611432(4)); if($_1628455755 != ___1473611432(5)){ $_1628455755= $GLOBALS['____1429030738'][1]($_1628455755); $_1628455755= $GLOBALS['____1429030738'][2]($_1628455755,[___1473611432(6) => false]); if($GLOBALS['____1429030738'][3]($_1628455755)){ self::$_1548368408= $_1628455755;}} if(empty(self::$_1548368408)){ self::$_1548368408= array(___1473611432(7) => array(), ___1473611432(8) => array());}}} public static function InitiateEditionsSettings($_649433598){ self::__561198947(); $_1130081648= array(); foreach(self::$_1333253630 as $_321968104 => $_1603655158){ $_1061994753= $GLOBALS['____1429030738'][4]($_321968104, $_649433598); self::$_1548368408[___1473611432(9)][$_321968104]=($_1061994753? array(___1473611432(10)): array(___1473611432(11))); foreach($_1603655158 as $_981032942){ self::$_1548368408[___1473611432(12)][$_981032942]= $_1061994753; if(!$_1061994753) $_1130081648[]= array($_981032942, false);}} $_2091197498= $GLOBALS['____1429030738'][5](self::$_1548368408); $_2091197498= $GLOBALS['____1429030738'][6]($_2091197498); COption::SetOptionString(___1473611432(13), ___1473611432(14), $_2091197498); foreach($_1130081648 as $_418855384) self::__1398996840($_418855384[(878-2*439)], $_418855384[round(0+0.5+0.5)]);} public static function IsFeatureEnabled($_981032942){ if($_981032942 == '') return true; self::__561198947(); if(!isset(self::$_1462299268[$_981032942])) return true; if(self::$_1462299268[$_981032942] == ___1473611432(15)) $_2043805525= array(___1473611432(16)); elseif(isset(self::$_1548368408[___1473611432(17)][self::$_1462299268[$_981032942]])) $_2043805525= self::$_1548368408[___1473611432(18)][self::$_1462299268[$_981032942]]; else $_2043805525= array(___1473611432(19)); if($_2043805525[(212*2-424)] != ___1473611432(20) && $_2043805525[(1244/2-622)] != ___1473611432(21)){ return false;} elseif($_2043805525[(1060/2-530)] == ___1473611432(22)){ if($_2043805525[round(0+0.33333333333333+0.33333333333333+0.33333333333333)]< $GLOBALS['____1429030738'][7](min(184,0,61.333333333333),(203*2-406), min(142,0,47.333333333333), Date(___1473611432(23)), $GLOBALS['____1429030738'][8](___1473611432(24))- self::$_1936161591, $GLOBALS['____1429030738'][9](___1473611432(25)))){ if(!isset($_2043805525[round(0+0.5+0.5+0.5+0.5)]) ||!$_2043805525[round(0+2)]) self::__1362923230(self::$_1462299268[$_981032942]); return false;}} return!isset(self::$_1548368408[___1473611432(26)][$_981032942]) || self::$_1548368408[___1473611432(27)][$_981032942];} public static function IsFeatureInstalled($_981032942){ if($GLOBALS['____1429030738'][10]($_981032942) <= 0) return true; self::__561198947(); return(isset(self::$_1548368408[___1473611432(28)][$_981032942]) && self::$_1548368408[___1473611432(29)][$_981032942]);} public static function IsFeatureEditable($_981032942){ if($_981032942 == '') return true; self::__561198947(); if(!isset(self::$_1462299268[$_981032942])) return true; if(self::$_1462299268[$_981032942] == ___1473611432(30)) $_2043805525= array(___1473611432(31)); elseif(isset(self::$_1548368408[___1473611432(32)][self::$_1462299268[$_981032942]])) $_2043805525= self::$_1548368408[___1473611432(33)][self::$_1462299268[$_981032942]]; else $_2043805525= array(___1473611432(34)); if($_2043805525[(1304/2-652)] != ___1473611432(35) && $_2043805525[(1492/2-746)] != ___1473611432(36)){ return false;} elseif($_2043805525[(1352/2-676)] == ___1473611432(37)){ if($_2043805525[round(0+0.33333333333333+0.33333333333333+0.33333333333333)]< $GLOBALS['____1429030738'][11]((836-2*418),(126*2-252),(1476/2-738), Date(___1473611432(38)), $GLOBALS['____1429030738'][12](___1473611432(39))- self::$_1936161591, $GLOBALS['____1429030738'][13](___1473611432(40)))){ if(!isset($_2043805525[round(0+0.4+0.4+0.4+0.4+0.4)]) ||!$_2043805525[round(0+0.66666666666667+0.66666666666667+0.66666666666667)]) self::__1362923230(self::$_1462299268[$_981032942]); return false;}} return true;} private static function __1398996840($_981032942, $_1675878688){ if($GLOBALS['____1429030738'][14]("CBXFeatures", "On".$_981032942."SettingsChange")) $GLOBALS['____1429030738'][15](array("CBXFeatures", "On".$_981032942."SettingsChange"), array($_981032942, $_1675878688)); $_1870284519= $GLOBALS['_____1525633741'][0](___1473611432(41), ___1473611432(42).$_981032942.___1473611432(43)); while($_1384972608= $_1870284519->Fetch()) $GLOBALS['_____1525633741'][1]($_1384972608, array($_981032942, $_1675878688));} public static function SetFeatureEnabled($_981032942, $_1675878688= true, $_2026801470= true){ if($GLOBALS['____1429030738'][16]($_981032942) <= 0) return; if(!self::IsFeatureEditable($_981032942)) $_1675878688= false; $_1675878688= (bool)$_1675878688; self::__561198947(); $_1710414988=(!isset(self::$_1548368408[___1473611432(44)][$_981032942]) && $_1675878688 || isset(self::$_1548368408[___1473611432(45)][$_981032942]) && $_1675878688 != self::$_1548368408[___1473611432(46)][$_981032942]); self::$_1548368408[___1473611432(47)][$_981032942]= $_1675878688; $_2091197498= $GLOBALS['____1429030738'][17](self::$_1548368408); $_2091197498= $GLOBALS['____1429030738'][18]($_2091197498); COption::SetOptionString(___1473611432(48), ___1473611432(49), $_2091197498); if($_1710414988 && $_2026801470) self::__1398996840($_981032942, $_1675878688);} private static function __1362923230($_321968104){ if($GLOBALS['____1429030738'][19]($_321968104) <= 0 || $_321968104 == "Portal") return; self::__561198947(); if(!isset(self::$_1548368408[___1473611432(50)][$_321968104]) || self::$_1548368408[___1473611432(51)][$_321968104][(912-2*456)] != ___1473611432(52)) return; if(isset(self::$_1548368408[___1473611432(53)][$_321968104][round(0+0.5+0.5+0.5+0.5)]) && self::$_1548368408[___1473611432(54)][$_321968104][round(0+0.4+0.4+0.4+0.4+0.4)]) return; $_1130081648= array(); if(isset(self::$_1333253630[$_321968104]) && $GLOBALS['____1429030738'][20](self::$_1333253630[$_321968104])){ foreach(self::$_1333253630[$_321968104] as $_981032942){ if(isset(self::$_1548368408[___1473611432(55)][$_981032942]) && self::$_1548368408[___1473611432(56)][$_981032942]){ self::$_1548368408[___1473611432(57)][$_981032942]= false; $_1130081648[]= array($_981032942, false);}} self::$_1548368408[___1473611432(58)][$_321968104][round(0+0.4+0.4+0.4+0.4+0.4)]= true;} $_2091197498= $GLOBALS['____1429030738'][21](self::$_1548368408); $_2091197498= $GLOBALS['____1429030738'][22]($_2091197498); COption::SetOptionString(___1473611432(59), ___1473611432(60), $_2091197498); foreach($_1130081648 as $_418855384) self::__1398996840($_418855384[(199*2-398)], $_418855384[round(0+0.33333333333333+0.33333333333333+0.33333333333333)]);} public static function ModifyFeaturesSettings($_649433598, $_1603655158){ self::__561198947(); foreach($_649433598 as $_321968104 => $_1672459286) self::$_1548368408[___1473611432(61)][$_321968104]= $_1672459286; $_1130081648= array(); foreach($_1603655158 as $_981032942 => $_1675878688){ if(!isset(self::$_1548368408[___1473611432(62)][$_981032942]) && $_1675878688 || isset(self::$_1548368408[___1473611432(63)][$_981032942]) && $_1675878688 != self::$_1548368408[___1473611432(64)][$_981032942]) $_1130081648[]= array($_981032942, $_1675878688); self::$_1548368408[___1473611432(65)][$_981032942]= $_1675878688;} $_2091197498= $GLOBALS['____1429030738'][23](self::$_1548368408); $_2091197498= $GLOBALS['____1429030738'][24]($_2091197498); COption::SetOptionString(___1473611432(66), ___1473611432(67), $_2091197498); self::$_1548368408= false; foreach($_1130081648 as $_418855384) self::__1398996840($_418855384[min(218,0,72.666666666667)], $_418855384[round(0+0.5+0.5)]);} public static function SaveFeaturesSettings($_2125670313, $_1305573489){ self::__561198947(); $_108755059= array(___1473611432(68) => array(), ___1473611432(69) => array()); if(!$GLOBALS['____1429030738'][25]($_2125670313)) $_2125670313= array(); if(!$GLOBALS['____1429030738'][26]($_1305573489)) $_1305573489= array(); if(!$GLOBALS['____1429030738'][27](___1473611432(70), $_2125670313)) $_2125670313[]= ___1473611432(71); foreach(self::$_1333253630 as $_321968104 => $_1603655158){ $_2068497399= self::$_1548368408[___1473611432(72)][$_321968104] ??($_321968104 == ___1473611432(73)? array(___1473611432(74)): array(___1473611432(75))); if($_2068497399[(1340/2-670)] == ___1473611432(76) || $_2068497399[(159*2-318)] == ___1473611432(77)){ $_108755059[___1473611432(78)][$_321968104]= $_2068497399;} else{ if($GLOBALS['____1429030738'][28]($_321968104, $_2125670313)) $_108755059[___1473611432(79)][$_321968104]= array(___1473611432(80), $GLOBALS['____1429030738'][29]((782-2*391),(1180/2-590),(190*2-380), $GLOBALS['____1429030738'][30](___1473611432(81)), $GLOBALS['____1429030738'][31](___1473611432(82)), $GLOBALS['____1429030738'][32](___1473611432(83)))); else $_108755059[___1473611432(84)][$_321968104]= array(___1473611432(85));}} $_1130081648= array(); foreach(self::$_1462299268 as $_981032942 => $_321968104){ if($_108755059[___1473611432(86)][$_321968104][(227*2-454)] != ___1473611432(87) && $_108755059[___1473611432(88)][$_321968104][min(52,0,17.333333333333)] != ___1473611432(89)){ $_108755059[___1473611432(90)][$_981032942]= false;} else{ if($_108755059[___1473611432(91)][$_321968104][(1136/2-568)] == ___1473611432(92) && $_108755059[___1473611432(93)][$_321968104][round(0+0.5+0.5)]< $GLOBALS['____1429030738'][33]((904-2*452), min(238,0,79.333333333333),(848-2*424), Date(___1473611432(94)), $GLOBALS['____1429030738'][34](___1473611432(95))- self::$_1936161591, $GLOBALS['____1429030738'][35](___1473611432(96)))) $_108755059[___1473611432(97)][$_981032942]= false; else $_108755059[___1473611432(98)][$_981032942]= $GLOBALS['____1429030738'][36]($_981032942, $_1305573489); if(!isset(self::$_1548368408[___1473611432(99)][$_981032942]) && $_108755059[___1473611432(100)][$_981032942] || isset(self::$_1548368408[___1473611432(101)][$_981032942]) && $_108755059[___1473611432(102)][$_981032942] != self::$_1548368408[___1473611432(103)][$_981032942]) $_1130081648[]= array($_981032942, $_108755059[___1473611432(104)][$_981032942]);}} $_2091197498= $GLOBALS['____1429030738'][37]($_108755059); $_2091197498= $GLOBALS['____1429030738'][38]($_2091197498); COption::SetOptionString(___1473611432(105), ___1473611432(106), $_2091197498); self::$_1548368408= false; foreach($_1130081648 as $_418855384) self::__1398996840($_418855384[(792-2*396)], $_418855384[round(0+0.25+0.25+0.25+0.25)]);} public static function GetFeaturesList(){ self::__561198947(); $_1510779232= array(); foreach(self::$_1333253630 as $_321968104 => $_1603655158){ $_2068497399= self::$_1548368408[___1473611432(107)][$_321968104] ??($_321968104 == ___1473611432(108)? array(___1473611432(109)): array(___1473611432(110))); $_1510779232[$_321968104]= array( ___1473611432(111) => $_2068497399[(145*2-290)], ___1473611432(112) => $_2068497399[round(0+1)], ___1473611432(113) => array(),); $_1510779232[$_321968104][___1473611432(114)]= false; if($_1510779232[$_321968104][___1473611432(115)] == ___1473611432(116)){ $_1510779232[$_321968104][___1473611432(117)]= $GLOBALS['____1429030738'][39](($GLOBALS['____1429030738'][40]()- $_1510779232[$_321968104][___1473611432(118)])/ round(0+86400)); if($_1510779232[$_321968104][___1473611432(119)]> self::$_1936161591) $_1510779232[$_321968104][___1473611432(120)]= true;} foreach($_1603655158 as $_981032942) $_1510779232[$_321968104][___1473611432(121)][$_981032942]=(!isset(self::$_1548368408[___1473611432(122)][$_981032942]) || self::$_1548368408[___1473611432(123)][$_981032942]);} return $_1510779232;} private static function __1581802539($_444326452, $_2095781038){ if(IsModuleInstalled($_444326452) == $_2095781038) return true; $_211839947= $_SERVER[___1473611432(124)].___1473611432(125).$_444326452.___1473611432(126); if(!$GLOBALS['____1429030738'][41]($_211839947)) return false; include_once($_211839947); $_591031917= $GLOBALS['____1429030738'][42](___1473611432(127), ___1473611432(128), $_444326452); if(!$GLOBALS['____1429030738'][43]($_591031917)) return false; $_1954223356= new $_591031917; if($_2095781038){ if(!$_1954223356->InstallDB()) return false; $_1954223356->InstallEvents(); if(!$_1954223356->InstallFiles()) return false;} else{ if(CModule::IncludeModule(___1473611432(129))) CSearch::DeleteIndex($_444326452); UnRegisterModule($_444326452);} return true;} protected static function OnRequestsSettingsChange($_981032942, $_1675878688){ self::__1581802539("form", $_1675878688);} protected static function OnLearningSettingsChange($_981032942, $_1675878688){ self::__1581802539("learning", $_1675878688);} protected static function OnJabberSettingsChange($_981032942, $_1675878688){ self::__1581802539("xmpp", $_1675878688);} protected static function OnVideoConferenceSettingsChange($_981032942, $_1675878688){ self::__1581802539("video", $_1675878688);} protected static function OnBizProcSettingsChange($_981032942, $_1675878688){ self::__1581802539("bizprocdesigner", $_1675878688);} protected static function OnListsSettingsChange($_981032942, $_1675878688){ self::__1581802539("lists", $_1675878688);} protected static function OnWikiSettingsChange($_981032942, $_1675878688){ self::__1581802539("wiki", $_1675878688);} protected static function OnSupportSettingsChange($_981032942, $_1675878688){ self::__1581802539("support", $_1675878688);} protected static function OnControllerSettingsChange($_981032942, $_1675878688){ self::__1581802539("controller", $_1675878688);} protected static function OnAnalyticsSettingsChange($_981032942, $_1675878688){ self::__1581802539("statistic", $_1675878688);} protected static function OnVoteSettingsChange($_981032942, $_1675878688){ self::__1581802539("vote", $_1675878688);} protected static function OnFriendsSettingsChange($_981032942, $_1675878688){ if($_1675878688) $_1509850010= "Y"; else $_1509850010= ___1473611432(130); $_1033296550= CSite::GetList(___1473611432(131), ___1473611432(132), array(___1473611432(133) => ___1473611432(134))); while($_703526700= $_1033296550->Fetch()){ if(COption::GetOptionString(___1473611432(135), ___1473611432(136), ___1473611432(137), $_703526700[___1473611432(138)]) != $_1509850010){ COption::SetOptionString(___1473611432(139), ___1473611432(140), $_1509850010, false, $_703526700[___1473611432(141)]); COption::SetOptionString(___1473611432(142), ___1473611432(143), $_1509850010);}}} protected static function OnMicroBlogSettingsChange($_981032942, $_1675878688){ if($_1675878688) $_1509850010= "Y"; else $_1509850010= ___1473611432(144); $_1033296550= CSite::GetList(___1473611432(145), ___1473611432(146), array(___1473611432(147) => ___1473611432(148))); while($_703526700= $_1033296550->Fetch()){ if(COption::GetOptionString(___1473611432(149), ___1473611432(150), ___1473611432(151), $_703526700[___1473611432(152)]) != $_1509850010){ COption::SetOptionString(___1473611432(153), ___1473611432(154), $_1509850010, false, $_703526700[___1473611432(155)]); COption::SetOptionString(___1473611432(156), ___1473611432(157), $_1509850010);} if(COption::GetOptionString(___1473611432(158), ___1473611432(159), ___1473611432(160), $_703526700[___1473611432(161)]) != $_1509850010){ COption::SetOptionString(___1473611432(162), ___1473611432(163), $_1509850010, false, $_703526700[___1473611432(164)]); COption::SetOptionString(___1473611432(165), ___1473611432(166), $_1509850010);}}} protected static function OnPersonalFilesSettingsChange($_981032942, $_1675878688){ if($_1675878688) $_1509850010= "Y"; else $_1509850010= ___1473611432(167); $_1033296550= CSite::GetList(___1473611432(168), ___1473611432(169), array(___1473611432(170) => ___1473611432(171))); while($_703526700= $_1033296550->Fetch()){ if(COption::GetOptionString(___1473611432(172), ___1473611432(173), ___1473611432(174), $_703526700[___1473611432(175)]) != $_1509850010){ COption::SetOptionString(___1473611432(176), ___1473611432(177), $_1509850010, false, $_703526700[___1473611432(178)]); COption::SetOptionString(___1473611432(179), ___1473611432(180), $_1509850010);}}} protected static function OnPersonalBlogSettingsChange($_981032942, $_1675878688){ if($_1675878688) $_1509850010= "Y"; else $_1509850010= ___1473611432(181); $_1033296550= CSite::GetList(___1473611432(182), ___1473611432(183), array(___1473611432(184) => ___1473611432(185))); while($_703526700= $_1033296550->Fetch()){ if(COption::GetOptionString(___1473611432(186), ___1473611432(187), ___1473611432(188), $_703526700[___1473611432(189)]) != $_1509850010){ COption::SetOptionString(___1473611432(190), ___1473611432(191), $_1509850010, false, $_703526700[___1473611432(192)]); COption::SetOptionString(___1473611432(193), ___1473611432(194), $_1509850010);}}} protected static function OnPersonalPhotoSettingsChange($_981032942, $_1675878688){ if($_1675878688) $_1509850010= "Y"; else $_1509850010= ___1473611432(195); $_1033296550= CSite::GetList(___1473611432(196), ___1473611432(197), array(___1473611432(198) => ___1473611432(199))); while($_703526700= $_1033296550->Fetch()){ if(COption::GetOptionString(___1473611432(200), ___1473611432(201), ___1473611432(202), $_703526700[___1473611432(203)]) != $_1509850010){ COption::SetOptionString(___1473611432(204), ___1473611432(205), $_1509850010, false, $_703526700[___1473611432(206)]); COption::SetOptionString(___1473611432(207), ___1473611432(208), $_1509850010);}}} protected static function OnPersonalForumSettingsChange($_981032942, $_1675878688){ if($_1675878688) $_1509850010= "Y"; else $_1509850010= ___1473611432(209); $_1033296550= CSite::GetList(___1473611432(210), ___1473611432(211), array(___1473611432(212) => ___1473611432(213))); while($_703526700= $_1033296550->Fetch()){ if(COption::GetOptionString(___1473611432(214), ___1473611432(215), ___1473611432(216), $_703526700[___1473611432(217)]) != $_1509850010){ COption::SetOptionString(___1473611432(218), ___1473611432(219), $_1509850010, false, $_703526700[___1473611432(220)]); COption::SetOptionString(___1473611432(221), ___1473611432(222), $_1509850010);}}} protected static function OnTasksSettingsChange($_981032942, $_1675878688){ if($_1675878688) $_1509850010= "Y"; else $_1509850010= ___1473611432(223); $_1033296550= CSite::GetList(___1473611432(224), ___1473611432(225), array(___1473611432(226) => ___1473611432(227))); while($_703526700= $_1033296550->Fetch()){ if(COption::GetOptionString(___1473611432(228), ___1473611432(229), ___1473611432(230), $_703526700[___1473611432(231)]) != $_1509850010){ COption::SetOptionString(___1473611432(232), ___1473611432(233), $_1509850010, false, $_703526700[___1473611432(234)]); COption::SetOptionString(___1473611432(235), ___1473611432(236), $_1509850010);} if(COption::GetOptionString(___1473611432(237), ___1473611432(238), ___1473611432(239), $_703526700[___1473611432(240)]) != $_1509850010){ COption::SetOptionString(___1473611432(241), ___1473611432(242), $_1509850010, false, $_703526700[___1473611432(243)]); COption::SetOptionString(___1473611432(244), ___1473611432(245), $_1509850010);}} self::__1581802539(___1473611432(246), $_1675878688);} protected static function OnCalendarSettingsChange($_981032942, $_1675878688){ if($_1675878688) $_1509850010= "Y"; else $_1509850010= ___1473611432(247); $_1033296550= CSite::GetList(___1473611432(248), ___1473611432(249), array(___1473611432(250) => ___1473611432(251))); while($_703526700= $_1033296550->Fetch()){ if(COption::GetOptionString(___1473611432(252), ___1473611432(253), ___1473611432(254), $_703526700[___1473611432(255)]) != $_1509850010){ COption::SetOptionString(___1473611432(256), ___1473611432(257), $_1509850010, false, $_703526700[___1473611432(258)]); COption::SetOptionString(___1473611432(259), ___1473611432(260), $_1509850010);} if(COption::GetOptionString(___1473611432(261), ___1473611432(262), ___1473611432(263), $_703526700[___1473611432(264)]) != $_1509850010){ COption::SetOptionString(___1473611432(265), ___1473611432(266), $_1509850010, false, $_703526700[___1473611432(267)]); COption::SetOptionString(___1473611432(268), ___1473611432(269), $_1509850010);}}} protected static function OnSMTPSettingsChange($_981032942, $_1675878688){ self::__1581802539("mail", $_1675878688);} protected static function OnExtranetSettingsChange($_981032942, $_1675878688){ $_565905095= COption::GetOptionString("extranet", "extranet_site", ""); if($_565905095){ $_1788323396= new CSite; $_1788323396->Update($_565905095, array(___1473611432(270) =>($_1675878688? ___1473611432(271): ___1473611432(272))));} self::__1581802539(___1473611432(273), $_1675878688);} protected static function OnDAVSettingsChange($_981032942, $_1675878688){ self::__1581802539("dav", $_1675878688);} protected static function OntimemanSettingsChange($_981032942, $_1675878688){ self::__1581802539("timeman", $_1675878688);} protected static function Onintranet_sharepointSettingsChange($_981032942, $_1675878688){ if($_1675878688){ RegisterModuleDependences("iblock", "OnAfterIBlockElementAdd", "intranet", "CIntranetEventHandlers", "SPRegisterUpdatedItem"); RegisterModuleDependences(___1473611432(274), ___1473611432(275), ___1473611432(276), ___1473611432(277), ___1473611432(278)); CAgent::AddAgent(___1473611432(279), ___1473611432(280), ___1473611432(281), round(0+125+125+125+125)); CAgent::AddAgent(___1473611432(282), ___1473611432(283), ___1473611432(284), round(0+75+75+75+75)); CAgent::AddAgent(___1473611432(285), ___1473611432(286), ___1473611432(287), round(0+1200+1200+1200));} else{ UnRegisterModuleDependences(___1473611432(288), ___1473611432(289), ___1473611432(290), ___1473611432(291), ___1473611432(292)); UnRegisterModuleDependences(___1473611432(293), ___1473611432(294), ___1473611432(295), ___1473611432(296), ___1473611432(297)); CAgent::RemoveAgent(___1473611432(298), ___1473611432(299)); CAgent::RemoveAgent(___1473611432(300), ___1473611432(301)); CAgent::RemoveAgent(___1473611432(302), ___1473611432(303));}} protected static function OncrmSettingsChange($_981032942, $_1675878688){ if($_1675878688) COption::SetOptionString("crm", "form_features", "Y"); self::__1581802539(___1473611432(304), $_1675878688);} protected static function OnClusterSettingsChange($_981032942, $_1675878688){ self::__1581802539("cluster", $_1675878688);} protected static function OnMultiSitesSettingsChange($_981032942, $_1675878688){ if($_1675878688) RegisterModuleDependences("main", "OnBeforeProlog", "main", "CWizardSolPanelIntranet", "ShowPanel", 100, "/modules/intranet/panel_button.php"); else UnRegisterModuleDependences(___1473611432(305), ___1473611432(306), ___1473611432(307), ___1473611432(308), ___1473611432(309), ___1473611432(310));} protected static function OnIdeaSettingsChange($_981032942, $_1675878688){ self::__1581802539("idea", $_1675878688);} protected static function OnMeetingSettingsChange($_981032942, $_1675878688){ self::__1581802539("meeting", $_1675878688);} protected static function OnXDImportSettingsChange($_981032942, $_1675878688){ self::__1581802539("xdimport", $_1675878688);}} $GLOBALS['____1429030738'][44](___1473611432(311), ___1473611432(312));/**/			//Do not remove this

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

/*ZDUyZmZYjI2NGYwMmM2ZTY4ZTYzZjJjY2I1NDk1OWVmOWQzZGU=*/$GLOBALS['____1077848225']= array(base64_decode('bX'.'RfcmFuZ'.'A=='),base64_decode('ZXhwbG9kZ'.'Q'.'=='),base64_decode('cG'.'Fj'.'aw=='),base64_decode(''.'bW'.'Q1'),base64_decode('Y29uc3RhbnQ='),base64_decode(''.'aG'.'Fz'.'aF'.'9obWFj'),base64_decode('c3RyY'.'21w'),base64_decode('aXNfb2JqZWN0'),base64_decode('Y2'.'F'.'sbF91c2Vy'.'X2Z1bm'.'M='),base64_decode('Y2FsbF9'.'1c2'.'VyX2Z1b'.'mM='),base64_decode('Y2Fs'.'bF91'.'c2VyX2Z1bmM='),base64_decode(''.'Y'.'2Fs'.'b'.'F91c2Vy'.'X'.'2'.'Z1bmM='),base64_decode('Y2FsbF9'.'1c'.'2VyX2Z1bmM='));if(!function_exists(__NAMESPACE__.'\\___1216556330')){function ___1216556330($_1105020420){static $_195419273= false; if($_195419273 == false) $_195419273=array('REI'.'=','U0V'.'MRUNUIFZBT'.'FVFIEZS'.'T'.'0'.'0gYl'.'9'.'vcHRpb24gV0'.'hFUkUgT'.'kFNRT0nflBBUkFNX01'.'BWF'.'9VU'.'0VSU'.'ycgQU5EI'.'E1'.'PRFV'.'MRV'.'9J'.'RD0nbWFpbicgQU5EI'.'FNJV'.'EVf'.'SU'.'QgSV'.'M'.'gTlVMTA'.'==','Vk'.'FM'.'VUU=','L'.'g==','S'.'Co=','Yml'.'0c'.'ml4',''.'TElDRU5T'.'RV9L'.'R'.'Vk=','c2hhMjU2','VVNFUg='.'=','VVNFUg==','VV'.'NF'.'Ug==','SX'.'NB'.'dXRob'.'3Jpem'.'V'.'k','V'.'VNFUg='.'=',''.'SX'.'NBZG'.'1pbg==','QVBQ'.'T'.'ElDQ'.'V'.'RJT04=','UmV'.'zdGFyd'.'EJ1ZmZlcg==',''.'TG9'.'j'.'YW'.'xS'.'ZWRpcmVjdA'.'==',''.'L2'.'x'.'pY2V'.'uc2Vfc'.'mVzd'.'HJ'.'p'.'Y3Rpb'.'24ucGhw',''.'XEJ'.'pdHJpeF'.'xNY'.'WluX'.'EN'.'v'.'bm'.'ZpZ1xPcHR'.'p'.'b246On'.'NldA==','b'.'WFpbg==','UE'.'FS'.'QU1fT'.'UFY'.'X1'.'V'.'TRVJT');return base64_decode($_195419273[$_1105020420]);}};if($GLOBALS['____1077848225'][0](round(0+0.33333333333333+0.33333333333333+0.33333333333333), round(0+4+4+4+4+4)) == round(0+3.5+3.5)){ $_1439506863= $GLOBALS[___1216556330(0)]->Query(___1216556330(1), true); if($_1724873902= $_1439506863->Fetch()){ $_613713518= $_1724873902[___1216556330(2)]; list($_1064086630, $_445012239)= $GLOBALS['____1077848225'][1](___1216556330(3), $_613713518); $_1398180689= $GLOBALS['____1077848225'][2](___1216556330(4), $_1064086630); $_1470183304= ___1216556330(5).$GLOBALS['____1077848225'][3]($GLOBALS['____1077848225'][4](___1216556330(6))); $_307740088= $GLOBALS['____1077848225'][5](___1216556330(7), $_445012239, $_1470183304, true); if($GLOBALS['____1077848225'][6]($_307740088, $_1398180689) !==(970-2*485)){ if(isset($GLOBALS[___1216556330(8)]) && $GLOBALS['____1077848225'][7]($GLOBALS[___1216556330(9)]) && $GLOBALS['____1077848225'][8](array($GLOBALS[___1216556330(10)], ___1216556330(11))) &&!$GLOBALS['____1077848225'][9](array($GLOBALS[___1216556330(12)], ___1216556330(13)))){ $GLOBALS['____1077848225'][10](array($GLOBALS[___1216556330(14)], ___1216556330(15))); $GLOBALS['____1077848225'][11](___1216556330(16), ___1216556330(17), true);}}} else{ $GLOBALS['____1077848225'][12](___1216556330(18), ___1216556330(19), ___1216556330(20), round(0+4+4+4));}}/**/       //Do not remove this

