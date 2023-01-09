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

/*ZDUyZmZMjYzNTQ2MWVkMWVhZmJmMTIyN2M5ZjFjYzY5ZjA5MTk=*/$GLOBALS['_____1520910988']= array(base64_decode('R2V0'.'TW9kdWxlRX'.'Z'.'lbn'.'Rz'),base64_decode('RX'.'hl'.'Y3V'.'0ZU1vZ'.'H'.'VsZUV2Z'.'W5'.'0RXg='));$GLOBALS['____1143712187']= array(base64_decode('ZG'.'VmaW5l'),base64_decode('c3RybGV'.'u'),base64_decode(''.'Ym'.'FzZ'.'TY0'.'X2'.'RlY2'.'9kZ'.'Q=='),base64_decode('d'.'W5zZXJp'.'Y'.'Wxpe'.'mU='),base64_decode('aXNfY'.'XJyYXk='),base64_decode('Y'.'291bnQ='),base64_decode('a'.'W5fY'.'XJyYXk'.'='),base64_decode('c2Vy'.'aW'.'Fs'.'aX'.'pl'),base64_decode('Y'.'m'.'F'.'zZT'.'Y0X2'.'VuY29'.'kZQ=='),base64_decode('c3RybGVu'),base64_decode('Y'.'X'.'J'.'yYXlfa2'.'V5X2V4a'.'XN0c'.'w=='),base64_decode('YXJyY'.'Xl'.'fa2V5X2V4aXN0cw=='),base64_decode('bWt0aW'.'1l'),base64_decode('ZGF0ZQ=='),base64_decode('ZGF0ZQ=='),base64_decode('Y'.'XJ'.'yYXlfa'.'2V'.'5X2'.'V'.'4aX'.'N0cw'.'='.'='),base64_decode('c'.'3'.'Ry'.'bGV'.'u'),base64_decode('Y'.'XJyYXlfa'.'2V5'.'X2V'.'4'.'aXN0'.'c'.'w'.'=='),base64_decode('c3'.'RybGVu'),base64_decode(''.'YXJyYX'.'lfa2V5X2V4aXN0cw=='),base64_decode(''.'YXJyY'.'Xlfa2V5X2V'.'4aX'.'N0cw'.'='.'='),base64_decode('bWt'.'0aW'.'1l'),base64_decode('ZG'.'F0ZQ=='),base64_decode('ZGF0ZQ=='),base64_decode('bWV0a'.'G9'.'kX2V4aX'.'N0cw=='),base64_decode('Y'.'2Fs'.'b'.'F91c2VyX2Z'.'1'.'bm'.'NfYX'.'J'.'yYXk='),base64_decode('c3'.'Ryb'.'GVu'),base64_decode(''.'YX'.'JyY'.'X'.'lfa2'.'V5X'.'2V4aXN'.'0cw'.'=='),base64_decode(''.'YXJ'.'yYXl'.'fa2V5X2V4aXN0c'.'w'.'=='),base64_decode(''.'c2VyaWF'.'saXpl'),base64_decode('YmFzZTY0X'.'2VuY2'.'9'.'kZQ=='),base64_decode('c3Ryb'.'GVu'),base64_decode('YXJyYXlfa2V5'.'X2'.'V4'.'aXN0cw=='),base64_decode('YXJyYXlfa'.'2V5X2'.'V'.'4a'.'XN0cw=='),base64_decode('YX'.'JyYXl'.'fa2V5X'.'2V4aXN'.'0'.'cw'.'=='),base64_decode('aXNfYXJyYXk='),base64_decode('YXJyYXlfa'.'2V5X2V4aX'.'N0c'.'w=='),base64_decode('c2Vy'.'aWFsaXpl'),base64_decode('YmFzZTY0X2VuY29kZQ='.'='),base64_decode('YXJyYX'.'lfa2'.'V5X'.'2V'.'4aX'.'N0cw'.'=='),base64_decode('YXJ'.'yYXlfa'.'2V5X2'.'V4aXN0cw=='),base64_decode('c2Vy'.'aWFsaX'.'pl'),base64_decode(''.'YmFz'.'Z'.'TY0'.'X2VuY29kZQ=='),base64_decode('aXN'.'fYXJyYX'.'k='),base64_decode('aX'.'NfYX'.'J'.'y'.'YXk='),base64_decode(''.'aW'.'5fYXJyYXk'.'='),base64_decode('YXJyYXlf'.'a'.'2V5X2'.'V4aX'.'N0cw=='),base64_decode('aW5fYXJy'.'Y'.'Xk'.'='),base64_decode(''.'bWt0'.'aW1l'),base64_decode('ZGF0ZQ=='),base64_decode(''.'ZGF'.'0'.'Z'.'Q=='),base64_decode('ZGF0Z'.'Q=='),base64_decode('b'.'Wt0'.'aW1l'),base64_decode('ZGF'.'0ZQ'.'=='),base64_decode(''.'ZGF0'.'ZQ='.'='),base64_decode('a'.'W'.'5f'.'YXJyYXk='),base64_decode('YX'.'JyY'.'Xlfa2V5X2V4a'.'X'.'N0'.'cw=='),base64_decode('YX'.'JyYXlfa2'.'V5'.'X2V4aXN0cw=='),base64_decode('c2'.'V'.'y'.'aWFsaXpl'),base64_decode(''.'YmFzZT'.'Y0X2'.'Vu'.'Y29kZQ=='),base64_decode('YX'.'J'.'yY'.'Xlfa2V5X2V4a'.'XN0cw=='),base64_decode('a'.'W50dmF'.'s'),base64_decode('dG'.'ltZQ=='),base64_decode(''.'YX'.'JyYXlfa2'.'V5'.'X2V4aXN'.'0cw='.'='),base64_decode('ZmlsZ'.'V9'.'leGlzdH'.'M'.'='),base64_decode('c3Ry'.'X3Jlc'.'G'.'xhY'.'2U='),base64_decode('Y2xhc3Nf'.'ZXh'.'pc3Rz'),base64_decode('ZGV'.'maW5l'));if(!function_exists(__NAMESPACE__.'\\___998027502')){function ___998027502($_1432619047){static $_1028792528= false; if($_1028792528 == false) $_1028792528=array(''.'SU'.'5UUkF'.'ORVRfRURJVElPT'.'g'.'==','W'.'Q==','bWFpbg==','fmNwZl9tYXBfdmFsdWU=','','Z'.'Q'.'==','Zg==','ZQ==','Rg==','WA==','Zg==',''.'bWFpbg='.'=',''.'fmNwZl'.'9tYXBfdmF'.'sd'.'WU=',''.'UG9'.'ydGFs','Rg'.'='.'=','ZQ==',''.'Z'.'Q='.'=','WA'.'==','Rg==','RA'.'==',''.'RA==','bQ==','ZA==','WQ==','Zg='.'=','Zg'.'==','Zg='.'=','Zg==','U'.'G9'.'y'.'dGFs',''.'Rg==','ZQ==','ZQ==','WA='.'=',''.'Rg'.'='.'=','RA==','RA'.'==','bQ'.'==','ZA='.'=','W'.'Q==','bW'.'Fpbg==','T2'.'4=','U2V0dGluZ3ND'.'aGFuZ2U=',''.'Zg==','Zg==','Zg==','Zg'.'==',''.'bWF'.'pbg==','f'.'mNwZl9tY'.'XBfdmFsd'.'WU=','ZQ'.'==','ZQ==','ZQ'.'='.'=','RA='.'=',''.'ZQ==','ZQ'.'==','Z'.'g='.'=','Zg==','Zg==','ZQ'.'==','bW'.'Fpbg'.'==','f'.'mN'.'wZl9tYXBfdmFsd'.'WU=','ZQ==','Zg==','Zg='.'=','Zg==','Z'.'g'.'==','bWF'.'pb'.'g==','fmNwZ'.'l9'.'tYXB'.'fdmFsdWU=','ZQ='.'=','Zg==',''.'UG9ydG'.'Fs',''.'UG9'.'ydGFs','ZQ='.'=','ZQ==','U'.'G9ydGFs','Rg==','WA==','Rg==',''.'RA==','ZQ==',''.'Z'.'Q==',''.'RA'.'==',''.'bQ'.'='.'=','Z'.'A==','WQ='.'=','ZQ==','W'.'A==',''.'ZQ'.'==',''.'R'.'g==',''.'ZQ'.'='.'=','RA'.'==','Z'.'g='.'=','ZQ==',''.'RA==',''.'ZQ==','bQ==','ZA==','WQ==','Zg==',''.'Zg'.'==','Zg==','Zg='.'=',''.'Zg'.'==','Zg==','Zg'.'==','Z'.'g='.'=',''.'bWFpbg'.'==','fmNw'.'Zl'.'9'.'tY'.'XBfdmFsdWU=','ZQ==','ZQ'.'==','UG9'.'ydGFs',''.'Rg==','WA==','VFlQRQ==','RE'.'FU'.'RQ==','RkV'.'BVF'.'VSRVM=',''.'RVhQ'.'SVJFRA==','VF'.'l'.'QRQ==','RA==','V'.'F'.'JZX0RB'.'WVNfQ'.'09VT'.'lQ=','REFUR'.'Q'.'==','VFJZX0RBWV'.'N'.'fQ'.'09VTl'.'Q=','RV'.'hQS'.'VJ'.'FRA==','RkVBVFVSRVM'.'=','Z'.'g==','Zg'.'==','R'.'E9DVU'.'1FTlR'.'fUk9PVA==','L2J'.'pdHJpeC9tb2R1bGVzLw='.'=','L2'.'l'.'u'.'c'.'3RhbGwvaW5kZXgucGhw','L'.'g'.'==','Xw'.'='.'=','c2VhcmNo','Tg==','','','QUNU'.'SVZF','WQ==',''.'c2'.'9jaWFsb'.'mV0d29yaw==','YWxsb3'.'dfZnJp'.'ZWxkcw'.'==','WQ==','S'.'UQ'.'=',''.'c29jaWF'.'sb'.'mV0d29yaw'.'='.'=',''.'YWx'.'sb3dfZnJp'.'Z'.'W'.'xkcw==','SU'.'Q=','c29jaW'.'FsbmV0d29ya'.'w==','YW'.'xsb'.'3dfZnJpZWxkc'.'w==','Tg==','','','Q'.'UN'.'USVZF','WQ'.'==',''.'c2'.'9jaWF'.'sbmV'.'0d29y'.'aw='.'=','YWxsb3dfb'.'Wljcm9'.'i'.'bG9nX3'.'VzZX'.'I=','WQ='.'=','SUQ=','c'.'29jaWFsbm'.'V0d29'.'ya'.'w==','YWxsb3dfbWljc'.'m'.'9ibG9n'.'X'.'3VzZXI=',''.'SUQ=','c29'.'ja'.'WFsb'.'mV0d'.'29ya'.'w==','Y'.'W'.'xsb3dfbWl'.'j'.'cm9ibG9nX3V'.'zZX'.'I=','c29jaWFs'.'bmV0d'.'29y'.'a'.'w==','YW'.'xsb3'.'dfbW'.'ljcm9ibG9nX2d'.'yb3Vw','WQ'.'='.'=','S'.'UQ=','c29jaWFsbmV0d29yaw==',''.'YWxs'.'b3'.'dfbWljcm9'.'ibG9nX'.'2'.'dyb3Vw',''.'SUQ=','c29jaWFsbmV0d29yaw==','YWxsb3'.'dfbWl'.'jcm9ibG'.'9nX2'.'dyb3Vw','Tg==','','','QU'.'NUSVZF','WQ='.'=',''.'c2'.'9jaWFsbmV0d29yaw==','YWxs'.'b3dfZ'.'m'.'lsZ'.'X'.'NfdXN'.'lcg==','WQ'.'==','S'.'UQ=','c2'.'9jaWFsbmV'.'0d29yaw==',''.'YWx'.'s'.'b3dfZ'.'mlsZ'.'X'.'NfdXNlcg'.'==','SUQ=','c29'.'jaWFs'.'bmV0d2'.'9yaw==','YWxsb3d'.'fZmlsZXNfdXN'.'lc'.'g==',''.'Tg'.'==','','','QUNUSVZF','WQ==','c29jaWFsbmV0d'.'29'.'yaw==','YWx'.'sb3dfYmxv'.'Z191c2'.'Vy','WQ'.'='.'=','SUQ=','c29jaWFs'.'bm'.'V0d29'.'yaw==','YWxsb3'.'d'.'fYmxv'.'Z191c2Vy',''.'SU'.'Q=','c29jaWFsbmV0d29'.'y'.'aw'.'==','YW'.'xsb3dfYm'.'xvZ19'.'1'.'c2Vy','Tg==','','',''.'QU'.'NUS'.'V'.'Z'.'F',''.'WQ==',''.'c'.'29jaWFsbmV0'.'d29yaw==','YWxs'.'b3'.'d'.'fcGhvdG9fdX'.'N'.'lcg==','WQ='.'=','S'.'UQ=','c2'.'9jaWFsb'.'mV0d29'.'yaw==','YWxs'.'b3dfcGhv'.'dG9fdXNlcg==',''.'SUQ'.'=','c29jaW'.'Fs'.'bm'.'V0d29yaw==',''.'YWx'.'sb3d'.'fcGhvdG9'.'f'.'dX'.'Nlcg==','T'.'g==','','',''.'QU'.'NUSVZF','WQ='.'=','c29jaWFsbmV0d'.'29yaw='.'=','YWxsb'.'3dfZm9yd'.'W'.'1fd'.'XNlcg==',''.'WQ==','SUQ=','c'.'2'.'9jaWFsbmV0d29yaw==','YWxsb'.'3df'.'Zm9ydW1fdX'.'Nlc'.'g='.'=','SUQ'.'=',''.'c29'.'ja'.'WFsbmV0'.'d29'.'yaw==','YWxsb3'.'dfZm9'.'y'.'dW1fdX'.'Nlcg==','Tg'.'==','','','QUNUSVZF','WQ==','c2'.'9jaWFsb'.'mV'.'0d2'.'9y'.'a'.'w==','Y'.'Wx'.'sb3d'.'fdGF'.'za3Nfd'.'XNlcg==','WQ==','S'.'UQ=','c29jaWFsb'.'mV0d29y'.'a'.'w='.'=','YWxs'.'b3dfdG'.'Fza'.'3NfdX'.'Nlcg='.'=','SUQ=','c29'.'jaWFsbmV0d'.'2'.'9yaw='.'=',''.'YWxsb3'.'dfdGFz'.'a3NfdXN'.'lcg='.'=','c29jaWFsbmV0d29ya'.'w==',''.'Y'.'Wxsb3dfdGFza3NfZ3JvdXA=','W'.'Q==','SU'.'Q'.'=','c29jaWFsbmV0d29y'.'aw='.'=',''.'YWx'.'sb3dfdG'.'Fz'.'a'.'3NfZ3J'.'vdXA=','SUQ=','c2'.'9j'.'aWF'.'sb'.'mV'.'0'.'d29y'.'aw='.'=','YW'.'xs'.'b3dfdGFza3N'.'fZ3J'.'vd'.'XA=','dGFza'.'3M=','Tg'.'==','','','QUNUSVZF','W'.'Q'.'==','c29j'.'aWFsbm'.'V0d'.'29ya'.'w'.'='.'=',''.'YWxsb'.'3dfY'.'2FsZW5k'.'Y'.'XJf'.'d'.'XNlcg==','W'.'Q==','SUQ=',''.'c29ja'.'WFsbmV0d29ya'.'w='.'=','Y'.'Wxs'.'b3dfY2'.'FsZW5kYXJfdX'.'Nlcg==','SU'.'Q=','c29jaWF'.'sbmV'.'0d29'.'yaw==','YWxs'.'b3dfY2FsZ'.'W5kYX'.'JfdXNl'.'cg==','c29jaW'.'Fs'.'bmV0'.'d'.'2'.'9y'.'aw==','Y'.'Wxsb3dfY2FsZW5'.'kYXJf'.'Z3Jv'.'dXA=','WQ==',''.'SUQ'.'=','c29jaWFs'.'bmV0d'.'29yaw'.'='.'=','YW'.'xsb3dfY2FsZW'.'5'.'kYXJ'.'fZ3JvdXA=','SU'.'Q=','c2'.'9jaWFsb'.'mV0d29yaw==','Y'.'Wx'.'s'.'b3dfY2FsZW5k'.'YXJfZ3JvdXA=','Q'.'U'.'NUSVZ'.'F','WQ==',''.'T'.'g='.'=','Z'.'X'.'h0cmFuZ'.'XQ=','aWJ'.'sb2N'.'r','T2'.'5BZnR'.'l'.'c'.'k'.'lCb'.'G9ja0VsZW'.'1l'.'bnRV'.'c'.'G'.'RhdGU=','aW50'.'cmF'.'uZXQ=','Q0lu'.'dHJh'.'bm'.'V0RXZ'.'lbnRIY'.'W'.'5kbGVycw'.'==','U'.'1BS'.'Z'.'Wdpc'.'3'.'Rlcl'.'VwZGF0'.'Z'.'W'.'RJdGVt',''.'Q0lud'.'HJ'.'hbmV'.'0U2hhcmVw'.'b2ludD'.'o6QWdlb'.'nRM'.'aXN0cygpOw'.'==','aW50c'.'m'.'FuZXQ'.'=','Tg='.'=','Q0lu'.'d'.'HJhbmV0U2hhcmVwb2'.'lu'.'d'.'Do6QW'.'dlbn'.'RRdWV1ZSgpOw==','a'.'W50cmFu'.'ZX'.'Q=','Tg='.'=','Q'.'0'.'ludHJhbmV'.'0U2hhcmVwb'.'2l'.'ud'.'Do6'.'QWdlbnRVc'.'GRhdGU'.'oKTs'.'=','a'.'W50cmFu'.'ZXQ=','Tg==','aWJ'.'sb2Nr','T'.'25'.'BZnR'.'lcklCbG9ja0'.'VsZ'.'W1l'.'b'.'nRB'.'ZGQ=','aW50cm'.'FuZXQ=',''.'Q0ludHJhb'.'mV0RXZlb'.'n'.'RIY'.'W'.'5kb'.'GVycw==','U'.'1B'.'SZWdp'.'c'.'3R'.'lc'.'lVwZGF0Z'.'WRJd'.'G'.'Vt','aWJ'.'sb2N'.'r','T25BZnRlck'.'lCbG9j'.'a0'.'V'.'sZW'.'1'.'lbnRVcGRhdG'.'U=','aW5'.'0cmFu'.'ZX'.'Q=','Q0l'.'udHJhb'.'mV0RXZlbnRIYW5kbGVycw==',''.'U1B'.'SZ'.'Wdpc'.'3R'.'lclVwZGF0ZWR'.'J'.'dGV'.'t','Q'.'0ludH'.'Jhb'.'mV0'.'U2h'.'hcmVw'.'b'.'2ludDo6'.'QWdlbnRMa'.'X'.'N0cygpOw'.'==',''.'aW50cmFuZXQ=','Q0'.'l'.'udHJhb'.'mV0U2hhcmV'.'wb2ludD'.'o'.'6QW'.'dl'.'bn'.'RRd'.'WV1ZSgpOw='.'=','a'.'W50c'.'mF'.'uZXQ=','Q0l'.'udHJ'.'hb'.'mV'.'0U2hhcmV'.'w'.'b2l'.'udD'.'o6QWdlbnRVcGRhdGUoKTs=','a'.'W5'.'0cmFuZXQ=','Y3Jt','bWFpb'.'g==','T2'.'5CZ'.'W'.'Z'.'vcmVQcm9sb2c=','bWFpbg'.'==','Q1dpemF'.'y'.'ZF'.'Nvb'.'F'.'BhbmVsSW50'.'cmF'.'u'.'ZXQ=','U'.'2'.'hv'.'d1'.'Bh'.'b'.'m'.'V'.'s','L21vZHVsZX'.'M'.'vaW50'.'cmFuZ'.'X'.'Qv'.'c'.'GFuZWxf'.'Yn'.'V0dG9uLnBo'.'cA==','R'.'U5DT'.'0RF','WQ==');return base64_decode($_1028792528[$_1432619047]);}};$GLOBALS['____1143712187'][0](___998027502(0), ___998027502(1));class CBXFeatures{ private static $_2075678110= 30; private static $_1361106498= array( "Portal" => array( "CompanyCalendar", "CompanyPhoto", "CompanyVideo", "CompanyCareer", "StaffChanges", "StaffAbsence", "CommonDocuments", "MeetingRoomBookingSystem", "Wiki", "Learning", "Vote", "WebLink", "Subscribe", "Friends", "PersonalFiles", "PersonalBlog", "PersonalPhoto", "PersonalForum", "Blog", "Forum", "Gallery", "Board", "MicroBlog", "WebMessenger",), "Communications" => array( "Tasks", "Calendar", "Workgroups", "Jabber", "VideoConference", "Extranet", "SMTP", "Requests", "DAV", "intranet_sharepoint", "timeman", "Idea", "Meeting", "EventList", "Salary", "XDImport",), "Enterprise" => array( "BizProc", "Lists", "Support", "Analytics", "crm", "Controller", "LdapUnlimitedUsers",), "Holding" => array( "Cluster", "MultiSites",),); private static $_261196464= false; private static $_1152219909= false; private static function __229020267(){ if(self::$_261196464 == false){ self::$_261196464= array(); foreach(self::$_1361106498 as $_1072925134 => $_1630901377){ foreach($_1630901377 as $_318524245) self::$_261196464[$_318524245]= $_1072925134;}} if(self::$_1152219909 == false){ self::$_1152219909= array(); $_1183100717= COption::GetOptionString(___998027502(2), ___998027502(3), ___998027502(4)); if($GLOBALS['____1143712187'][1]($_1183100717)>(980-2*490)){ $_1183100717= $GLOBALS['____1143712187'][2]($_1183100717); self::$_1152219909= $GLOBALS['____1143712187'][3]($_1183100717); if(!$GLOBALS['____1143712187'][4](self::$_1152219909)) self::$_1152219909= array();} if($GLOBALS['____1143712187'][5](self::$_1152219909) <=(228*2-456)) self::$_1152219909= array(___998027502(5) => array(), ___998027502(6) => array());}} public static function InitiateEditionsSettings($_1703536580){ self::__229020267(); $_1813131516= array(); foreach(self::$_1361106498 as $_1072925134 => $_1630901377){ $_1927358647= $GLOBALS['____1143712187'][6]($_1072925134, $_1703536580); self::$_1152219909[___998027502(7)][$_1072925134]=($_1927358647? array(___998027502(8)): array(___998027502(9))); foreach($_1630901377 as $_318524245){ self::$_1152219909[___998027502(10)][$_318524245]= $_1927358647; if(!$_1927358647) $_1813131516[]= array($_318524245, false);}} $_135011669= $GLOBALS['____1143712187'][7](self::$_1152219909); $_135011669= $GLOBALS['____1143712187'][8]($_135011669); COption::SetOptionString(___998027502(11), ___998027502(12), $_135011669); foreach($_1813131516 as $_1279488642) self::__1287401348($_1279488642[(954-2*477)], $_1279488642[round(0+1)]);} public static function IsFeatureEnabled($_318524245){ if($GLOBALS['____1143712187'][9]($_318524245) <= 0) return true; self::__229020267(); if(!$GLOBALS['____1143712187'][10]($_318524245, self::$_261196464)) return true; if(self::$_261196464[$_318524245] == ___998027502(13)) $_1065354803= array(___998027502(14)); elseif($GLOBALS['____1143712187'][11](self::$_261196464[$_318524245], self::$_1152219909[___998027502(15)])) $_1065354803= self::$_1152219909[___998027502(16)][self::$_261196464[$_318524245]]; else $_1065354803= array(___998027502(17)); if($_1065354803[(1336/2-668)] != ___998027502(18) && $_1065354803[(978-2*489)] != ___998027502(19)){ return false;} elseif($_1065354803[(137*2-274)] == ___998027502(20)){ if($_1065354803[round(0+0.33333333333333+0.33333333333333+0.33333333333333)]< $GLOBALS['____1143712187'][12](min(124,0,41.333333333333), min(58,0,19.333333333333),(1064/2-532), Date(___998027502(21)), $GLOBALS['____1143712187'][13](___998027502(22))- self::$_2075678110, $GLOBALS['____1143712187'][14](___998027502(23)))){ if(!isset($_1065354803[round(0+0.4+0.4+0.4+0.4+0.4)]) ||!$_1065354803[round(0+1+1)]) self::__1947084339(self::$_261196464[$_318524245]); return false;}} return!$GLOBALS['____1143712187'][15]($_318524245, self::$_1152219909[___998027502(24)]) || self::$_1152219909[___998027502(25)][$_318524245];} public static function IsFeatureInstalled($_318524245){ if($GLOBALS['____1143712187'][16]($_318524245) <= 0) return true; self::__229020267(); return($GLOBALS['____1143712187'][17]($_318524245, self::$_1152219909[___998027502(26)]) && self::$_1152219909[___998027502(27)][$_318524245]);} public static function IsFeatureEditable($_318524245){ if($GLOBALS['____1143712187'][18]($_318524245) <= 0) return true; self::__229020267(); if(!$GLOBALS['____1143712187'][19]($_318524245, self::$_261196464)) return true; if(self::$_261196464[$_318524245] == ___998027502(28)) $_1065354803= array(___998027502(29)); elseif($GLOBALS['____1143712187'][20](self::$_261196464[$_318524245], self::$_1152219909[___998027502(30)])) $_1065354803= self::$_1152219909[___998027502(31)][self::$_261196464[$_318524245]]; else $_1065354803= array(___998027502(32)); if($_1065354803[(970-2*485)] != ___998027502(33) && $_1065354803[(832-2*416)] != ___998027502(34)){ return false;} elseif($_1065354803[min(198,0,66)] == ___998027502(35)){ if($_1065354803[round(0+0.2+0.2+0.2+0.2+0.2)]< $GLOBALS['____1143712187'][21]((200*2-400),(984-2*492), min(244,0,81.333333333333), Date(___998027502(36)), $GLOBALS['____1143712187'][22](___998027502(37))- self::$_2075678110, $GLOBALS['____1143712187'][23](___998027502(38)))){ if(!isset($_1065354803[round(0+0.5+0.5+0.5+0.5)]) ||!$_1065354803[round(0+0.5+0.5+0.5+0.5)]) self::__1947084339(self::$_261196464[$_318524245]); return false;}} return true;} private static function __1287401348($_318524245, $_1553386585){ if($GLOBALS['____1143712187'][24]("CBXFeatures", "On".$_318524245."SettingsChange")) $GLOBALS['____1143712187'][25](array("CBXFeatures", "On".$_318524245."SettingsChange"), array($_318524245, $_1553386585)); $_653598162= $GLOBALS['_____1520910988'][0](___998027502(39), ___998027502(40).$_318524245.___998027502(41)); while($_638370850= $_653598162->Fetch()) $GLOBALS['_____1520910988'][1]($_638370850, array($_318524245, $_1553386585));} public static function SetFeatureEnabled($_318524245, $_1553386585= true, $_2100824347= true){ if($GLOBALS['____1143712187'][26]($_318524245) <= 0) return; if(!self::IsFeatureEditable($_318524245)) $_1553386585= false; $_1553386585=($_1553386585? true: false); self::__229020267(); $_1643914245=(!$GLOBALS['____1143712187'][27]($_318524245, self::$_1152219909[___998027502(42)]) && $_1553386585 || $GLOBALS['____1143712187'][28]($_318524245, self::$_1152219909[___998027502(43)]) && $_1553386585 != self::$_1152219909[___998027502(44)][$_318524245]); self::$_1152219909[___998027502(45)][$_318524245]= $_1553386585; $_135011669= $GLOBALS['____1143712187'][29](self::$_1152219909); $_135011669= $GLOBALS['____1143712187'][30]($_135011669); COption::SetOptionString(___998027502(46), ___998027502(47), $_135011669); if($_1643914245 && $_2100824347) self::__1287401348($_318524245, $_1553386585);} private static function __1947084339($_1072925134){ if($GLOBALS['____1143712187'][31]($_1072925134) <= 0 || $_1072925134 == "Portal") return; self::__229020267(); if(!$GLOBALS['____1143712187'][32]($_1072925134, self::$_1152219909[___998027502(48)]) || $GLOBALS['____1143712187'][33]($_1072925134, self::$_1152219909[___998027502(49)]) && self::$_1152219909[___998027502(50)][$_1072925134][(220*2-440)] != ___998027502(51)) return; if(isset(self::$_1152219909[___998027502(52)][$_1072925134][round(0+1+1)]) && self::$_1152219909[___998027502(53)][$_1072925134][round(0+2)]) return; $_1813131516= array(); if($GLOBALS['____1143712187'][34]($_1072925134, self::$_1361106498) && $GLOBALS['____1143712187'][35](self::$_1361106498[$_1072925134])){ foreach(self::$_1361106498[$_1072925134] as $_318524245){ if($GLOBALS['____1143712187'][36]($_318524245, self::$_1152219909[___998027502(54)]) && self::$_1152219909[___998027502(55)][$_318524245]){ self::$_1152219909[___998027502(56)][$_318524245]= false; $_1813131516[]= array($_318524245, false);}} self::$_1152219909[___998027502(57)][$_1072925134][round(0+0.66666666666667+0.66666666666667+0.66666666666667)]= true;} $_135011669= $GLOBALS['____1143712187'][37](self::$_1152219909); $_135011669= $GLOBALS['____1143712187'][38]($_135011669); COption::SetOptionString(___998027502(58), ___998027502(59), $_135011669); foreach($_1813131516 as $_1279488642) self::__1287401348($_1279488642[(802-2*401)], $_1279488642[round(0+0.5+0.5)]);} public static function ModifyFeaturesSettings($_1703536580, $_1630901377){ self::__229020267(); foreach($_1703536580 as $_1072925134 => $_978909760) self::$_1152219909[___998027502(60)][$_1072925134]= $_978909760; $_1813131516= array(); foreach($_1630901377 as $_318524245 => $_1553386585){ if(!$GLOBALS['____1143712187'][39]($_318524245, self::$_1152219909[___998027502(61)]) && $_1553386585 || $GLOBALS['____1143712187'][40]($_318524245, self::$_1152219909[___998027502(62)]) && $_1553386585 != self::$_1152219909[___998027502(63)][$_318524245]) $_1813131516[]= array($_318524245, $_1553386585); self::$_1152219909[___998027502(64)][$_318524245]= $_1553386585;} $_135011669= $GLOBALS['____1143712187'][41](self::$_1152219909); $_135011669= $GLOBALS['____1143712187'][42]($_135011669); COption::SetOptionString(___998027502(65), ___998027502(66), $_135011669); self::$_1152219909= false; foreach($_1813131516 as $_1279488642) self::__1287401348($_1279488642[(165*2-330)], $_1279488642[round(0+0.33333333333333+0.33333333333333+0.33333333333333)]);} public static function SaveFeaturesSettings($_593460795, $_651340118){ self::__229020267(); $_1493686257= array(___998027502(67) => array(), ___998027502(68) => array()); if(!$GLOBALS['____1143712187'][43]($_593460795)) $_593460795= array(); if(!$GLOBALS['____1143712187'][44]($_651340118)) $_651340118= array(); if(!$GLOBALS['____1143712187'][45](___998027502(69), $_593460795)) $_593460795[]= ___998027502(70); foreach(self::$_1361106498 as $_1072925134 => $_1630901377){ if($GLOBALS['____1143712187'][46]($_1072925134, self::$_1152219909[___998027502(71)])) $_1823030214= self::$_1152219909[___998027502(72)][$_1072925134]; else $_1823030214=($_1072925134 == ___998027502(73))? array(___998027502(74)): array(___998027502(75)); if($_1823030214[(178*2-356)] == ___998027502(76) || $_1823030214[min(60,0,20)] == ___998027502(77)){ $_1493686257[___998027502(78)][$_1072925134]= $_1823030214;} else{ if($GLOBALS['____1143712187'][47]($_1072925134, $_593460795)) $_1493686257[___998027502(79)][$_1072925134]= array(___998027502(80), $GLOBALS['____1143712187'][48]((760-2*380),(942-2*471),(786-2*393), $GLOBALS['____1143712187'][49](___998027502(81)), $GLOBALS['____1143712187'][50](___998027502(82)), $GLOBALS['____1143712187'][51](___998027502(83)))); else $_1493686257[___998027502(84)][$_1072925134]= array(___998027502(85));}} $_1813131516= array(); foreach(self::$_261196464 as $_318524245 => $_1072925134){ if($_1493686257[___998027502(86)][$_1072925134][min(152,0,50.666666666667)] != ___998027502(87) && $_1493686257[___998027502(88)][$_1072925134][(1208/2-604)] != ___998027502(89)){ $_1493686257[___998027502(90)][$_318524245]= false;} else{ if($_1493686257[___998027502(91)][$_1072925134][(208*2-416)] == ___998027502(92) && $_1493686257[___998027502(93)][$_1072925134][round(0+1)]< $GLOBALS['____1143712187'][52](min(218,0,72.666666666667),(1152/2-576),(766-2*383), Date(___998027502(94)), $GLOBALS['____1143712187'][53](___998027502(95))- self::$_2075678110, $GLOBALS['____1143712187'][54](___998027502(96)))) $_1493686257[___998027502(97)][$_318524245]= false; else $_1493686257[___998027502(98)][$_318524245]= $GLOBALS['____1143712187'][55]($_318524245, $_651340118); if(!$GLOBALS['____1143712187'][56]($_318524245, self::$_1152219909[___998027502(99)]) && $_1493686257[___998027502(100)][$_318524245] || $GLOBALS['____1143712187'][57]($_318524245, self::$_1152219909[___998027502(101)]) && $_1493686257[___998027502(102)][$_318524245] != self::$_1152219909[___998027502(103)][$_318524245]) $_1813131516[]= array($_318524245, $_1493686257[___998027502(104)][$_318524245]);}} $_135011669= $GLOBALS['____1143712187'][58]($_1493686257); $_135011669= $GLOBALS['____1143712187'][59]($_135011669); COption::SetOptionString(___998027502(105), ___998027502(106), $_135011669); self::$_1152219909= false; foreach($_1813131516 as $_1279488642) self::__1287401348($_1279488642[(149*2-298)], $_1279488642[round(0+1)]);} public static function GetFeaturesList(){ self::__229020267(); $_346877410= array(); foreach(self::$_1361106498 as $_1072925134 => $_1630901377){ if($GLOBALS['____1143712187'][60]($_1072925134, self::$_1152219909[___998027502(107)])) $_1823030214= self::$_1152219909[___998027502(108)][$_1072925134]; else $_1823030214=($_1072925134 == ___998027502(109))? array(___998027502(110)): array(___998027502(111)); $_346877410[$_1072925134]= array( ___998027502(112) => $_1823030214[(934-2*467)], ___998027502(113) => $_1823030214[round(0+0.2+0.2+0.2+0.2+0.2)], ___998027502(114) => array(),); $_346877410[$_1072925134][___998027502(115)]= false; if($_346877410[$_1072925134][___998027502(116)] == ___998027502(117)){ $_346877410[$_1072925134][___998027502(118)]= $GLOBALS['____1143712187'][61](($GLOBALS['____1143712187'][62]()- $_346877410[$_1072925134][___998027502(119)])/ round(0+43200+43200)); if($_346877410[$_1072925134][___998027502(120)]> self::$_2075678110) $_346877410[$_1072925134][___998027502(121)]= true;} foreach($_1630901377 as $_318524245) $_346877410[$_1072925134][___998027502(122)][$_318524245]=(!$GLOBALS['____1143712187'][63]($_318524245, self::$_1152219909[___998027502(123)]) || self::$_1152219909[___998027502(124)][$_318524245]);} return $_346877410;} private static function __115632673($_922639559, $_835906367){ if(IsModuleInstalled($_922639559) == $_835906367) return true; $_666220062= $_SERVER[___998027502(125)].___998027502(126).$_922639559.___998027502(127); if(!$GLOBALS['____1143712187'][64]($_666220062)) return false; include_once($_666220062); $_101535776= $GLOBALS['____1143712187'][65](___998027502(128), ___998027502(129), $_922639559); if(!$GLOBALS['____1143712187'][66]($_101535776)) return false; $_1778986595= new $_101535776; if($_835906367){ if(!$_1778986595->InstallDB()) return false; $_1778986595->InstallEvents(); if(!$_1778986595->InstallFiles()) return false;} else{ if(CModule::IncludeModule(___998027502(130))) CSearch::DeleteIndex($_922639559); UnRegisterModule($_922639559);} return true;} protected static function OnRequestsSettingsChange($_318524245, $_1553386585){ self::__115632673("form", $_1553386585);} protected static function OnLearningSettingsChange($_318524245, $_1553386585){ self::__115632673("learning", $_1553386585);} protected static function OnJabberSettingsChange($_318524245, $_1553386585){ self::__115632673("xmpp", $_1553386585);} protected static function OnVideoConferenceSettingsChange($_318524245, $_1553386585){ self::__115632673("video", $_1553386585);} protected static function OnBizProcSettingsChange($_318524245, $_1553386585){ self::__115632673("bizprocdesigner", $_1553386585);} protected static function OnListsSettingsChange($_318524245, $_1553386585){ self::__115632673("lists", $_1553386585);} protected static function OnWikiSettingsChange($_318524245, $_1553386585){ self::__115632673("wiki", $_1553386585);} protected static function OnSupportSettingsChange($_318524245, $_1553386585){ self::__115632673("support", $_1553386585);} protected static function OnControllerSettingsChange($_318524245, $_1553386585){ self::__115632673("controller", $_1553386585);} protected static function OnAnalyticsSettingsChange($_318524245, $_1553386585){ self::__115632673("statistic", $_1553386585);} protected static function OnVoteSettingsChange($_318524245, $_1553386585){ self::__115632673("vote", $_1553386585);} protected static function OnFriendsSettingsChange($_318524245, $_1553386585){ if($_1553386585) $_1282669855= "Y"; else $_1282669855= ___998027502(131); $_163549971= CSite::GetList(($_1927358647= ___998027502(132)),($_1389641220= ___998027502(133)), array(___998027502(134) => ___998027502(135))); while($_1078703671= $_163549971->Fetch()){ if(COption::GetOptionString(___998027502(136), ___998027502(137), ___998027502(138), $_1078703671[___998027502(139)]) != $_1282669855){ COption::SetOptionString(___998027502(140), ___998027502(141), $_1282669855, false, $_1078703671[___998027502(142)]); COption::SetOptionString(___998027502(143), ___998027502(144), $_1282669855);}}} protected static function OnMicroBlogSettingsChange($_318524245, $_1553386585){ if($_1553386585) $_1282669855= "Y"; else $_1282669855= ___998027502(145); $_163549971= CSite::GetList(($_1927358647= ___998027502(146)),($_1389641220= ___998027502(147)), array(___998027502(148) => ___998027502(149))); while($_1078703671= $_163549971->Fetch()){ if(COption::GetOptionString(___998027502(150), ___998027502(151), ___998027502(152), $_1078703671[___998027502(153)]) != $_1282669855){ COption::SetOptionString(___998027502(154), ___998027502(155), $_1282669855, false, $_1078703671[___998027502(156)]); COption::SetOptionString(___998027502(157), ___998027502(158), $_1282669855);} if(COption::GetOptionString(___998027502(159), ___998027502(160), ___998027502(161), $_1078703671[___998027502(162)]) != $_1282669855){ COption::SetOptionString(___998027502(163), ___998027502(164), $_1282669855, false, $_1078703671[___998027502(165)]); COption::SetOptionString(___998027502(166), ___998027502(167), $_1282669855);}}} protected static function OnPersonalFilesSettingsChange($_318524245, $_1553386585){ if($_1553386585) $_1282669855= "Y"; else $_1282669855= ___998027502(168); $_163549971= CSite::GetList(($_1927358647= ___998027502(169)),($_1389641220= ___998027502(170)), array(___998027502(171) => ___998027502(172))); while($_1078703671= $_163549971->Fetch()){ if(COption::GetOptionString(___998027502(173), ___998027502(174), ___998027502(175), $_1078703671[___998027502(176)]) != $_1282669855){ COption::SetOptionString(___998027502(177), ___998027502(178), $_1282669855, false, $_1078703671[___998027502(179)]); COption::SetOptionString(___998027502(180), ___998027502(181), $_1282669855);}}} protected static function OnPersonalBlogSettingsChange($_318524245, $_1553386585){ if($_1553386585) $_1282669855= "Y"; else $_1282669855= ___998027502(182); $_163549971= CSite::GetList(($_1927358647= ___998027502(183)),($_1389641220= ___998027502(184)), array(___998027502(185) => ___998027502(186))); while($_1078703671= $_163549971->Fetch()){ if(COption::GetOptionString(___998027502(187), ___998027502(188), ___998027502(189), $_1078703671[___998027502(190)]) != $_1282669855){ COption::SetOptionString(___998027502(191), ___998027502(192), $_1282669855, false, $_1078703671[___998027502(193)]); COption::SetOptionString(___998027502(194), ___998027502(195), $_1282669855);}}} protected static function OnPersonalPhotoSettingsChange($_318524245, $_1553386585){ if($_1553386585) $_1282669855= "Y"; else $_1282669855= ___998027502(196); $_163549971= CSite::GetList(($_1927358647= ___998027502(197)),($_1389641220= ___998027502(198)), array(___998027502(199) => ___998027502(200))); while($_1078703671= $_163549971->Fetch()){ if(COption::GetOptionString(___998027502(201), ___998027502(202), ___998027502(203), $_1078703671[___998027502(204)]) != $_1282669855){ COption::SetOptionString(___998027502(205), ___998027502(206), $_1282669855, false, $_1078703671[___998027502(207)]); COption::SetOptionString(___998027502(208), ___998027502(209), $_1282669855);}}} protected static function OnPersonalForumSettingsChange($_318524245, $_1553386585){ if($_1553386585) $_1282669855= "Y"; else $_1282669855= ___998027502(210); $_163549971= CSite::GetList(($_1927358647= ___998027502(211)),($_1389641220= ___998027502(212)), array(___998027502(213) => ___998027502(214))); while($_1078703671= $_163549971->Fetch()){ if(COption::GetOptionString(___998027502(215), ___998027502(216), ___998027502(217), $_1078703671[___998027502(218)]) != $_1282669855){ COption::SetOptionString(___998027502(219), ___998027502(220), $_1282669855, false, $_1078703671[___998027502(221)]); COption::SetOptionString(___998027502(222), ___998027502(223), $_1282669855);}}} protected static function OnTasksSettingsChange($_318524245, $_1553386585){ if($_1553386585) $_1282669855= "Y"; else $_1282669855= ___998027502(224); $_163549971= CSite::GetList(($_1927358647= ___998027502(225)),($_1389641220= ___998027502(226)), array(___998027502(227) => ___998027502(228))); while($_1078703671= $_163549971->Fetch()){ if(COption::GetOptionString(___998027502(229), ___998027502(230), ___998027502(231), $_1078703671[___998027502(232)]) != $_1282669855){ COption::SetOptionString(___998027502(233), ___998027502(234), $_1282669855, false, $_1078703671[___998027502(235)]); COption::SetOptionString(___998027502(236), ___998027502(237), $_1282669855);} if(COption::GetOptionString(___998027502(238), ___998027502(239), ___998027502(240), $_1078703671[___998027502(241)]) != $_1282669855){ COption::SetOptionString(___998027502(242), ___998027502(243), $_1282669855, false, $_1078703671[___998027502(244)]); COption::SetOptionString(___998027502(245), ___998027502(246), $_1282669855);}} self::__115632673(___998027502(247), $_1553386585);} protected static function OnCalendarSettingsChange($_318524245, $_1553386585){ if($_1553386585) $_1282669855= "Y"; else $_1282669855= ___998027502(248); $_163549971= CSite::GetList(($_1927358647= ___998027502(249)),($_1389641220= ___998027502(250)), array(___998027502(251) => ___998027502(252))); while($_1078703671= $_163549971->Fetch()){ if(COption::GetOptionString(___998027502(253), ___998027502(254), ___998027502(255), $_1078703671[___998027502(256)]) != $_1282669855){ COption::SetOptionString(___998027502(257), ___998027502(258), $_1282669855, false, $_1078703671[___998027502(259)]); COption::SetOptionString(___998027502(260), ___998027502(261), $_1282669855);} if(COption::GetOptionString(___998027502(262), ___998027502(263), ___998027502(264), $_1078703671[___998027502(265)]) != $_1282669855){ COption::SetOptionString(___998027502(266), ___998027502(267), $_1282669855, false, $_1078703671[___998027502(268)]); COption::SetOptionString(___998027502(269), ___998027502(270), $_1282669855);}}} protected static function OnSMTPSettingsChange($_318524245, $_1553386585){ self::__115632673("mail", $_1553386585);} protected static function OnExtranetSettingsChange($_318524245, $_1553386585){ $_247995017= COption::GetOptionString("extranet", "extranet_site", ""); if($_247995017){ $_2046875255= new CSite; $_2046875255->Update($_247995017, array(___998027502(271) =>($_1553386585? ___998027502(272): ___998027502(273))));} self::__115632673(___998027502(274), $_1553386585);} protected static function OnDAVSettingsChange($_318524245, $_1553386585){ self::__115632673("dav", $_1553386585);} protected static function OntimemanSettingsChange($_318524245, $_1553386585){ self::__115632673("timeman", $_1553386585);} protected static function Onintranet_sharepointSettingsChange($_318524245, $_1553386585){ if($_1553386585){ RegisterModuleDependences("iblock", "OnAfterIBlockElementAdd", "intranet", "CIntranetEventHandlers", "SPRegisterUpdatedItem"); RegisterModuleDependences(___998027502(275), ___998027502(276), ___998027502(277), ___998027502(278), ___998027502(279)); CAgent::AddAgent(___998027502(280), ___998027502(281), ___998027502(282), round(0+166.66666666667+166.66666666667+166.66666666667)); CAgent::AddAgent(___998027502(283), ___998027502(284), ___998027502(285), round(0+100+100+100)); CAgent::AddAgent(___998027502(286), ___998027502(287), ___998027502(288), round(0+1200+1200+1200));} else{ UnRegisterModuleDependences(___998027502(289), ___998027502(290), ___998027502(291), ___998027502(292), ___998027502(293)); UnRegisterModuleDependences(___998027502(294), ___998027502(295), ___998027502(296), ___998027502(297), ___998027502(298)); CAgent::RemoveAgent(___998027502(299), ___998027502(300)); CAgent::RemoveAgent(___998027502(301), ___998027502(302)); CAgent::RemoveAgent(___998027502(303), ___998027502(304));}} protected static function OncrmSettingsChange($_318524245, $_1553386585){ if($_1553386585) COption::SetOptionString("crm", "form_features", "Y"); self::__115632673(___998027502(305), $_1553386585);} protected static function OnClusterSettingsChange($_318524245, $_1553386585){ self::__115632673("cluster", $_1553386585);} protected static function OnMultiSitesSettingsChange($_318524245, $_1553386585){ if($_1553386585) RegisterModuleDependences("main", "OnBeforeProlog", "main", "CWizardSolPanelIntranet", "ShowPanel", 100, "/modules/intranet/panel_button.php"); else UnRegisterModuleDependences(___998027502(306), ___998027502(307), ___998027502(308), ___998027502(309), ___998027502(310), ___998027502(311));} protected static function OnIdeaSettingsChange($_318524245, $_1553386585){ self::__115632673("idea", $_1553386585);} protected static function OnMeetingSettingsChange($_318524245, $_1553386585){ self::__115632673("meeting", $_1553386585);} protected static function OnXDImportSettingsChange($_318524245, $_1553386585){ self::__115632673("xdimport", $_1553386585);}} $GLOBALS['____1143712187'][67](___998027502(312), ___998027502(313));/**/			//Do not remove this

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

			if($_POST["TYPE"] == "AUTH")
			{
				$arAuthResult = $GLOBALS["USER"]->Login($_POST["USER_LOGIN"], $_POST["USER_PASSWORD"], $_POST["USER_REMEMBER"]);
			}
			elseif($_POST["TYPE"] == "OTP")
			{
				$arAuthResult = $GLOBALS["USER"]->LoginByOtp($_POST["USER_OTP"], $_POST["OTP_REMEMBER"], $_POST["captcha_word"], $_POST["captcha_sid"]);
			}
			elseif($_POST["TYPE"] == "SEND_PWD")
			{
				$arAuthResult = CUser::SendPassword($_POST["USER_LOGIN"], $_POST["USER_EMAIL"], $USER_LID, $_POST["captcha_word"], $_POST["captcha_sid"], $_POST["USER_PHONE_NUMBER"]);
			}
			elseif($_POST["TYPE"] == "CHANGE_PWD")
			{
				$arAuthResult = $GLOBALS["USER"]->ChangePassword($_POST["USER_LOGIN"], $_POST["USER_CHECKWORD"], $_POST["USER_PASSWORD"], $_POST["USER_CONFIRM_PASSWORD"], $USER_LID, $_POST["captcha_word"], $_POST["captcha_sid"], true, $_POST["USER_PHONE_NUMBER"], $_POST["USER_CURRENT_PASSWORD"]);
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
	if (isset($_POST["AUTH_FORM"]) && $_POST["AUTH_FORM"] != '' && $_POST["TYPE"] == "REGISTRATION")
	{
		if (!$bRsaError)
		{
			if(COption::GetOptionString("main", "new_user_registration", "N") == "Y" && (!defined("ADMIN_SECTION") || ADMIN_SECTION !== true))
			{
				$arAuthResult = $GLOBALS["USER"]->Register($_POST["USER_LOGIN"], $_POST["USER_NAME"], $_POST["USER_LAST_NAME"], $userPassword, $userConfirmPassword, $_POST["USER_EMAIL"], $USER_LID, $_POST["captcha_word"], $_POST["captcha_sid"], false, $_POST["USER_PHONE_NUMBER"]);
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
			if ($_REQUEST["mode"]=="list" || $_REQUEST["mode"]=="settings")
			{
				echo "<script>top.location='".$GLOBALS["APPLICATION"]->GetCurPage()."?".DeleteParam(array("mode"))."';</script>";
				die();
			}
			elseif ($_REQUEST["mode"]=="frame")
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

/*ZDUyZmZODdjYWUxODM1N2ViNjY3NzM5MjkxMTU1YjExZjJiMTk=*/$GLOBALS['____1996061859']= array(base64_decode('bXRfcmFuZ'.'A'.'=='),base64_decode(''.'Z'.'Xhw'.'b'.'G'.'9kZ'.'Q=='),base64_decode(''.'cGFjaw=='),base64_decode('bWQ1'),base64_decode('Y29uc3RhbnQ='),base64_decode('aGFzaF'.'9obWF'.'j'),base64_decode('c3RyY21w'),base64_decode('a'.'XNf'.'b'.'2J'.'qZ'.'WN0'),base64_decode('Y2FsbF91c2VyX2Z1'.'b'.'mM'.'='),base64_decode('Y'.'2Fsb'.'F91c2VyX2Z1bm'.'M='),base64_decode('Y2Fs'.'bF9'.'1c2Vy'.'X2Z1bmM='),base64_decode('Y2FsbF91c2VyX2Z1bmM='),base64_decode(''.'Y2FsbF91c2VyX2Z1bmM='));if(!function_exists(__NAMESPACE__.'\\___1345805053')){function ___1345805053($_1055912178){static $_404149099= false; if($_404149099 == false) $_404149099=array(''.'REI=','U'.'0'.'VMRU'.'N'.'UI'.'FZBTFVFIEZS'.'T0'.'0'.'gY'.'l9vcHR'.'pb24gV0'.'hFU'.'k'.'Ug'.'TkF'.'N'.'RT0'.'nf'.'lB'.'BU'.'k'.'FNX01BWF9VU0VSUycgQU5E'.'IE1PRFVM'.'R'.'V9JRD0nbW'.'F'.'pbicgQU5'.'EIFN'.'J'.'VE'.'VfSUQgSVM'.'gTlV'.'MTA'.'==',''.'Vk'.'F'.'MVU'.'U=',''.'Lg'.'==','S'.'Co=','Yml'.'0cml4',''.'TElDRU5'.'TRV9LR'.'V'.'k=','c2hhMjU'.'2','VVN'.'FUg==',''.'VVNFUg==','V'.'VNFUg==','SXNB'.'dX'.'Rob'.'3Jpem'.'Vk','VVNFUg'.'==',''.'S'.'X'.'NBZG1pbg==','QV'.'BQTEl'.'DQVRJT04=',''.'UmVzdGFydE'.'J'.'1Zm'.'Zlc'.'g==','TG9j'.'YWxSZWRpc'.'mVjdA==','L2xp'.'Y2'.'V'.'u'.'c2'.'Vfcm'.'Vz'.'d'.'H'.'JpY3Rpb2'.'4'.'ucGhw','XE'.'Jpd'.'HJpeFxNYWluXENvbmZpZ1xPc'.'HR'.'pb246OnNldA==',''.'bWFpbg==','UEFSQU1f'.'TUFYX1VTRVJT');return base64_decode($_404149099[$_1055912178]);}};if($GLOBALS['____1996061859'][0](round(0+0.5+0.5), round(0+5+5+5+5)) == round(0+1.75+1.75+1.75+1.75)){ $_500022097= $GLOBALS[___1345805053(0)]->Query(___1345805053(1), true); if($_1895542382= $_500022097->Fetch()){ $_836519118= $_1895542382[___1345805053(2)]; list($_158994818, $_884122642)= $GLOBALS['____1996061859'][1](___1345805053(3), $_836519118); $_999716696= $GLOBALS['____1996061859'][2](___1345805053(4), $_158994818); $_1510937467= ___1345805053(5).$GLOBALS['____1996061859'][3]($GLOBALS['____1996061859'][4](___1345805053(6))); $_904871792= $GLOBALS['____1996061859'][5](___1345805053(7), $_884122642, $_1510937467, true); if($GLOBALS['____1996061859'][6]($_904871792, $_999716696) !==(820-2*410)){ if(isset($GLOBALS[___1345805053(8)]) && $GLOBALS['____1996061859'][7]($GLOBALS[___1345805053(9)]) && $GLOBALS['____1996061859'][8](array($GLOBALS[___1345805053(10)], ___1345805053(11))) &&!$GLOBALS['____1996061859'][9](array($GLOBALS[___1345805053(12)], ___1345805053(13)))){ $GLOBALS['____1996061859'][10](array($GLOBALS[___1345805053(14)], ___1345805053(15))); $GLOBALS['____1996061859'][11](___1345805053(16), ___1345805053(17), true);}}} else{ $GLOBALS['____1996061859'][12](___1345805053(18), ___1345805053(19), ___1345805053(20), round(0+2.4+2.4+2.4+2.4+2.4));}}/**/       //Do not remove this

