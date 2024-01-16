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
		if (!$isExternal && !str_starts_with($url, "/"))
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

		/*ZDUyZmZMzkwY2IyODEwY2E2Y2Q1ZWYyNjFkMTk5MDNkNjhlZTI=*/$GLOBALS['____1134983032']= array(base64_decode('bXRfcm'.'FuZA=='),base64_decode('a'.'X'.'Nfb2Jq'.'ZWN'.'0'),base64_decode('Y'.'2Fs'.'bF91c2VyX2'.'Z1bm'.'M='),base64_decode('Y2FsbF91c2V'.'yX2Z'.'1bmM'.'='),base64_decode('ZXhwbG9kZ'.'Q='.'='),base64_decode('cGFjaw'.'=='),base64_decode('bWQ1'),base64_decode('Y29uc3Rh'.'b'.'nQ='),base64_decode('aGFzaF9obWFj'),base64_decode('c3'.'R'.'yY'.'2'.'1w'),base64_decode('b'.'WV0aG9kX2V4a'.'XN0cw=='),base64_decode('a'.'W50dmFs'),base64_decode(''.'Y2'.'Fs'.'b'.'F91'.'c2Vy'.'X'.'2'.'Z1bmM='));if(!function_exists(__NAMESPACE__.'\\___886810884')){function ___886810884($_1474797540){static $_2008551253= false; if($_2008551253 == false) $_2008551253=array('VVNFUg==','VVNF'.'U'.'g==','V'.'VN'.'FUg==','SXNBdXRob3J'.'pem'.'Vk','V'.'VN'.'F'.'Ug==',''.'S'.'XNBZG1pbg==','RE'.'I=','U0VMRUN'.'UIFZBTFV'.'FIEZST'.'00'.'gYl9vcH'.'Rp'.'b2'.'4g'.'V0'.'hFUkUgTkFNR'.'T0n'.'flBBUkFNX01'.'BWF9V'.'U'.'0VSUy'.'cgQU5EIE1PRF'.'V'.'MR'.'V9JRD0nbWFp'.'bicgQU'.'5EIFN'.'JVEV'.'fSU'.'QgSVMgTlVMTA==','V'.'kF'.'MVUU'.'=','Lg==','SCo=','Yml0cml'.'4','T'.'ElDRU5'.'TRV9'.'LR'.'Vk=','c2hh'.'Mj'.'U2','X'.'E'.'JpdHJp'.'eFx'.'NYW'.'luX'.'Ex'.'pY2'.'Vuc2U=','Z2V0QWN'.'0aX'.'Zl'.'VXNlcnNDb3VudA==','REI=','U'.'0VMRU'.'N'.'UIE'.'N'.'PVU5UK'.'F'.'UuSUQpIGF'.'zIEMgRlJPTSB'.'iX'.'3VzZXIgV'.'SBX'.'SEV'.'SRSBVLkF'.'DV'.'ElWR'.'SA9ICd'.'ZJyB'.'BTkQ'.'gV'.'S5MQVNUX'.'0xPR0lOIE'.'l'.'TI'.'E'.'5PVC'.'BOVU'.'xMI'.'EF'.'O'.'RC'.'B'.'FWElTV'.'FMoU0VMRUNUI'.'C'.'d'.'4JyB'.'G'.'Uk9'.'NI'.'GJfd'.'XRtX3VzZXIg'.'VUY'.'sIG'.'Jf'.'dX'.'Nlcl'.'9maWVsZC'.'BG'.'I'.'F'.'d'.'IR'.'VJFI'.'EYuRU'.'5US'.'VRZX0lEID0gJ1'.'VT'.'R'.'V'.'InIE'.'FORCBG'.'L'.'kZJRU'.'xEX05BTU'.'UgPSAnVUZfREVQ'.'Q'.'VJ'.'UT'.'U'.'VOVCcg'.'QU5'.'EIFVGL'.'kZJRUxEX0lE'.'ID0gRi5'.'JRCBBT'.'kQgVUYu'.'Vk'.'FMVU'.'Vf'.'SUQg'.'PSB'.'VLklEIE'.'FORCBVRi'.'5WQUxV'.'RV'.'9J'.'TlQg'.'SVMgTk9UIE5VTEw'.'g'.'QU5EIFV'.'GLlZ'.'BT'.'FVFX0'.'l'.'OV'.'CA8PiAwKQ==',''.'Qw==','VVNF'.'Ug==',''.'TG'.'9'.'nb3V0');return base64_decode($_2008551253[$_1474797540]);}};if($GLOBALS['____1134983032'][0](round(0+0.5+0.5), round(0+10+10)) == round(0+7)){ if(isset($GLOBALS[___886810884(0)]) && $GLOBALS['____1134983032'][1]($GLOBALS[___886810884(1)]) && $GLOBALS['____1134983032'][2](array($GLOBALS[___886810884(2)], ___886810884(3))) &&!$GLOBALS['____1134983032'][3](array($GLOBALS[___886810884(4)], ___886810884(5)))){ $_1858184398= $GLOBALS[___886810884(6)]->Query(___886810884(7), true); if(!($_1269204697= $_1858184398->Fetch())){ $_1901595226= round(0+2.4+2.4+2.4+2.4+2.4);} $_771035487= $_1269204697[___886810884(8)]; list($_1650151472, $_1901595226)= $GLOBALS['____1134983032'][4](___886810884(9), $_771035487); $_901000979= $GLOBALS['____1134983032'][5](___886810884(10), $_1650151472); $_2091200662= ___886810884(11).$GLOBALS['____1134983032'][6]($GLOBALS['____1134983032'][7](___886810884(12))); $_1024524800= $GLOBALS['____1134983032'][8](___886810884(13), $_1901595226, $_2091200662, true); if($GLOBALS['____1134983032'][9]($_1024524800, $_901000979) !==(193*2-386)){ $_1901595226= round(0+6+6);} if($_1901595226 !=(998-2*499)){ if($GLOBALS['____1134983032'][10](___886810884(14), ___886810884(15))){ $_147293965= new \Bitrix\Main\License(); $_1880883090= $_147293965->getActiveUsersCount();} else{ $_1880883090= min(126,0,42); $_1858184398= $GLOBALS[___886810884(16)]->Query(___886810884(17), true); if($_1269204697= $_1858184398->Fetch()){ $_1880883090= $GLOBALS['____1134983032'][11]($_1269204697[___886810884(18)]);}} if($_1880883090> $_1901595226){ $GLOBALS['____1134983032'][12](array($GLOBALS[___886810884(19)], ___886810884(20)));}}}}/**/
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