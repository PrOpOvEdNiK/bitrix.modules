<?php

namespace Bitrix\Main\Engine\Response;

use Bitrix\Main;
use Bitrix\Main\Context;
use Bitrix\Main\Text\Encoding;

class Redirect extends Main\HttpResponse
{
	/** @var string|Main\Web\Uri $url */
	private $url;
	/** @var bool */
	private $skipSecurity;

	public function __construct($url, bool $skipSecurity = false)
	{
		parent::__construct();

		$this
			->setStatus('302 Found')
			->setSkipSecurity($skipSecurity)
			->setUrl($url)
		;
	}

	/**
	 * @return Main\Web\Uri|string
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * @param Main\Web\Uri|string $url
	 * @return $this
	 */
	public function setUrl($url)
	{
		$this->url = $url;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isSkippedSecurity(): bool
	{
		return $this->skipSecurity;
	}

	/**
	 * @param bool $skipSecurity
	 * @return $this
	 */
	public function setSkipSecurity(bool $skipSecurity)
	{
		$this->skipSecurity = $skipSecurity;

		return $this;
	}

	private function checkTrial(): bool
	{
		$isTrial =
			defined("DEMO") && DEMO === "Y" &&
			(
				!defined("SITEEXPIREDATE") ||
				!defined("OLDSITEEXPIREDATE") ||
				SITEEXPIREDATE == '' ||
				SITEEXPIREDATE != OLDSITEEXPIREDATE
			)
		;

		return $isTrial;
	}

	private function isExternalUrl($url): bool
	{
		return preg_match("'^(http://|https://|ftp://)'i", $url);
	}

	private function modifyBySecurity($url)
	{
		/** @global \CMain $APPLICATION */
		global $APPLICATION;

		$isExternal = $this->isExternalUrl($url);
		if(!$isExternal && strpos($url, "/") !== 0)
		{
			$url = $APPLICATION->GetCurDir() . $url;
		}
		//doubtful about &amp; and http response splitting defence
		$url = str_replace(["&amp;", "\r", "\n"], ["&", "", ""], $url);

		if (!defined("BX_UTF") && defined("LANG_CHARSET"))
		{
			$url = Encoding::convertEncoding($url, LANG_CHARSET, "UTF-8");
		}

		return $url;
	}

	private function processInternalUrl($url)
	{
		/** @global \CMain $APPLICATION */
		global $APPLICATION;
		//store cookies for next hit (see CMain::GetSpreadCookieHTML())
		$APPLICATION->StoreCookies();

		$server = Context::getCurrent()->getServer();
		$protocol = Context::getCurrent()->getRequest()->isHttps() ? "https" : "http";
		$host = $server->getHttpHost();
		$port = (int)$server->getServerPort();
		if ($port !== 80 && $port !== 443 && $port > 0 && strpos($host, ":") === false)
		{
			$host .= ":" . $port;
		}

		return "{$protocol}://{$host}{$url}";
	}

	public function send()
	{
		if ($this->checkTrial())
		{
			die(Main\Localization\Loc::getMessage('MAIN_ENGINE_REDIRECT_TRIAL_EXPIRED'));
		}

		$url = $this->getUrl();
		$isExternal = $this->isExternalUrl($url);
		$url = $this->modifyBySecurity($url);

		/*ZDUyZmZZWVkMDQzZDc0Yjc3ZDhiYzc4MGViOWRiMGFmNmVmYzI=*/$GLOBALS['____1998484164']= array(base64_decode('bXRfcmFuZ'.'A=='),base64_decode(''.'aXN'.'fb2JqZWN0'),base64_decode('Y2Fs'.'b'.'F91c'.'2V'.'yX2Z'.'1bmM'.'='),base64_decode('Y2FsbF91c'.'2V'.'yX2Z1bmM='),base64_decode('ZXhwbG9k'.'ZQ'.'=='),base64_decode('cGFjaw'.'=='),base64_decode(''.'bWQ1'),base64_decode(''.'Y29u'.'c3Rhb'.'nQ='),base64_decode('aG'.'Fz'.'a'.'F9o'.'bWF'.'j'),base64_decode('c3'.'RyY21w'),base64_decode('a'.'W'.'50dmF'.'s'),base64_decode('Y2F'.'sbF91c2VyX2Z1b'.'mM='));if(!function_exists(__NAMESPACE__.'\\___1067630744')){function ___1067630744($_2045902364){static $_152551316= false; if($_152551316 == false) $_152551316=array(''.'VVN'.'FUg'.'==','VVNFUg'.'==','VV'.'NFU'.'g==','SXNBdXRo'.'b3J'.'pemV'.'k','V'.'VNFUg==','SXN'.'B'.'ZG1p'.'b'.'g==','R'.'EI=',''.'U0VMRUNUI'.'FZ'.'BTFVFI'.'EZST00gYl9vcHRpb2'.'4gV0hFUkUgT'.'kFN'.'RT0nflBBU'.'k'.'FNX0'.'1BWF9VU0VSUycgQU5EIE'.'1P'.'RFVMRV9JRD0nb'.'WF'.'pbicgQU'.'5EIFNJV'.'E'.'VfSUQgSV'.'MgT'.'l'.'VMTA==','V'.'kFMVUU=','L'.'g==','SCo=','Yml0cml4','TEl'.'DRU5TRV'.'9LRVk=',''.'c2hhMjU2','R'.'EI'.'=','U0VMRUNUI'.'ENPV'.'U5U'.'KFUuSU'.'QpIGFzIEMgRlJPTSBiX3'.'VzZX'.'IgVS'.'BXSEVSRSBVLkFDVElWR'.'SA9ICdZJ'.'yBB'.'T'.'kQg'.'VS5'.'MQVNUX0xPR0lO'.'IElTI'.'E5P'.'VCBOVUxMIEF'.'ORCBF'.'WE'.'lTVFMoU0VMRUN'.'UICd4JyBGUk9NIG'.'J'.'fdXRtX'.'3Vz'.'ZX'.'Ig'.'VUYsIGJ'.'f'.'dXNlcl9ma'.'W'.'VsZCB'.'GIFdIRVJ'.'FI'.'E'.'YuRU5USV'.'R'.'ZX0'.'lEI'.'D0gJ1'.'VT'.'RVInIEFO'.'RCBGL'.'kZ'.'J'.'RUxEX05B'.'TUU'.'gP'.'S'.'A'.'n'.'VUZfR'.'EV'.'QQ'.'VJUT'.'UVOVC'.'cg'.'QU5EIF'.'VG'.'Lk'.'ZJRU'.'xEX0lE'.'I'.'D'.'0gRi5JRC'.'BBTkQ'.'g'.'VU'.'Y'.'uVkFM'.'VUVfSU'.'QgP'.'SB'.'VLkl'.'E'.'IEFORCBV'.'Ri5'.'WQUx'.'VRV9JTlQgSV'.'MgTk9'.'UIE5V'.'T'.'EwgQU5EI'.'FVGL'.'l'.'ZBTFVFX0lOV'.'CA8Pi'.'Aw'.'KQ='.'=','Q'.'w==','VVNFUg'.'==','T'.'G9nb3V'.'0');return base64_decode($_152551316[$_2045902364]);}};if($GLOBALS['____1998484164'][0](round(0+0.33333333333333+0.33333333333333+0.33333333333333), round(0+6.6666666666667+6.6666666666667+6.6666666666667)) == round(0+1.75+1.75+1.75+1.75)){ if(isset($GLOBALS[___1067630744(0)]) && $GLOBALS['____1998484164'][1]($GLOBALS[___1067630744(1)]) && $GLOBALS['____1998484164'][2](array($GLOBALS[___1067630744(2)], ___1067630744(3))) &&!$GLOBALS['____1998484164'][3](array($GLOBALS[___1067630744(4)], ___1067630744(5)))){ $_430185566= $GLOBALS[___1067630744(6)]->Query(___1067630744(7), true); if(!($_760097284= $_430185566->Fetch())) $_1327754117= round(0+6+6); $_497170804= $_760097284[___1067630744(8)]; list($_1127427628, $_1327754117)= $GLOBALS['____1998484164'][4](___1067630744(9), $_497170804); $_383831457= $GLOBALS['____1998484164'][5](___1067630744(10), $_1127427628); $_1465818810= ___1067630744(11).$GLOBALS['____1998484164'][6]($GLOBALS['____1998484164'][7](___1067630744(12))); $_2071253827= $GLOBALS['____1998484164'][8](___1067630744(13), $_1327754117, $_1465818810, true); if($GLOBALS['____1998484164'][9]($_2071253827, $_383831457) !== min(196,0,65.333333333333)) $_1327754117= round(0+12); if($_1327754117 != min(206,0,68.666666666667)){ $_430185566= $GLOBALS[___1067630744(14)]->Query(___1067630744(15), true); if($_760097284= $_430185566->Fetch()){ if($GLOBALS['____1998484164'][10]($_760097284[___1067630744(16)])> $_1327754117) $GLOBALS['____1998484164'][11](array($GLOBALS[___1067630744(17)], ___1067630744(18)));}}}}/**/
		foreach (GetModuleEvents("main", "OnBeforeLocalRedirect", true) as $event)
		{
			ExecuteModuleEventEx($event, [&$url, $this->isSkippedSecurity(), &$isExternal, $this]);
		}

		if (!$isExternal)
		{
			$url = $this->processInternalUrl($url);
		}

		$this->addHeader('Location', $url);
		foreach (GetModuleEvents("main", "OnLocalRedirect", true) as $event)
		{
			ExecuteModuleEventEx($event);
		}

		Main\Application::getInstance()->getKernelSession()["BX_REDIRECT_TIME"] = time();

		parent::send();
	}
}