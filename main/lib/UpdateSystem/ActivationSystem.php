<? namespace Bitrix\Main\UpdateSystem;$GLOBALS['____792436554']= array(base64_decode('aXNf'.'d'.'3Jp'.'d'.'GF'.'ibGU='),base64_decode('Zm9wZW'.'4='),base64_decode(''.'Z'.'ndyaXRl'),base64_decode('ZmNsb3N'.'l'),base64_decode(''.'aW50d'.'mF'.'s'),base64_decode('aW'.'50dmFs'),base64_decode('a'.'XNfd3JpdG'.'FibG'.'U='),base64_decode('Zm9'.'wZW4='),base64_decode(''.'ZnB1dHM'.'='),base64_decode('ZmNs'.'b3'.'N'.'l'));if(!function_exists(__NAMESPACE__.'\\___2013433870')){function ___2013433870($_331054993){static $_1085146380= false; if($_1085146380 == false) $_1085146380=array('RVJST1I=','R'.'V'.'JST1I=','X1ZBT'.'FVF','VW'.'5rbm'.'93'.'bi'.'Blcn'.'Jvcg'.'==','IFt'.'BU1'.'IwMV0=',''.'UkVOVA==','Tm90IGZvd'.'W5'.'kIGxpY2Vuc2UgaW5'.'mb'.'yBbQ'.'VN'.'SMD'.'J'.'d',''.'VjE=','VjI=','Vj'.'E'.'=','VjI'.'=','U2Vyd'.'mVy'.'I'.'HJ'.'lc3'.'Bvbn'.'NlI'.'GlzIG5vdCByZ'.'WN'.'v'.'Z25p'.'emV'.'kIFtBU0F'.'MSTAxX'.'Q='.'=','bW'.'F'.'pbg==','YWRta'.'W5fcGFzc3dvcmRo','RE9'.'DVU1'.'FTlRfUk9PVA==',''.'L'.'2Jpd'.'HJpe'.'C'.'9tb2R1bGVzL21ha'.'W4vYW'.'RtaW'.'4=','RE9DVU1F'.'TlRfU'.'k9PVA==','L2JpdHJpeC9t'.'b2R1bGVz'.'L21ha'.'W4vYWR'.'taW4vZ'.'GVma'.'W5lLnBocA='.'=','d'.'w==',''.'PA==','P0RlZmluZS'.'gi'.'VEVNUE9SQ'.'V'.'JZX0N'.'BQ'.'0hFIiwgIg==',''.'I'.'ik7Pw==','Pg==','RmlsZSBvcGV'.'uIGZ'.'haW'.'xzIFt'.'B'.'U0FMSTAy'.'XQ'.'='.'=','Rm'.'9s'.'ZGVy'.'IGlzIG5vdCB3'.'cml0YWJ'.'sZSBbQ'.'V'.'NBTEkwM'.'10=','REF'.'U'.'RV9UT1'.'9TT1VSQ0U=','bWFpbg==',''.'fn'.'N1cHBvcnRfZmlua'.'XN'.'oX'.'2'.'Rhd'.'G'.'U=','REFURV9UT19TT1VSQ0U=','TUFYX1NJVEVT',''.'b'.'WFp'.'bg==','UEFSQU1f'.'T'.'UFYX'.'1NJ'.'VEVT','TUFYX1NJVEVT','TUFYX1VTRVJT','bWF'.'pbg==','UEFSQ'.'U1f'.'TUFY'.'X1VT'.'RVJT',''.'T'.'UFYX1'.'VT'.'RVJT','TUFYX'.'1V'.'T'.'RVJTX1N'.'UUklOR'.'w==','bWFpbg==','flBBUkFNX'.'01'.'BW'.'F9'.'VU0VSUw='.'=','TUF'.'YX1VTRVJT'.'X1'.'NU'.'Ukl'.'ORw==','REFUR'.'V9U'.'T19TT1VS'.'Q0V'.'fU1RSS'.'U5H','bWFpbg'.'='.'=','flB'.'BUkF'.'N'.'X0ZJTklTSF9EQV'.'RF','REFURV9U'.'T'.'1'.'9TT1V'.'S'.'Q0VfU1RSSU5H','S'.'VN'.'MQw==','RE9D'.'V'.'U1FTlRfU'.'k9PVA==',''.'L2JpdHJ'.'peA='.'=','RE'.'9'.'DVU1FTlRfUk9'.'PVA==',''.'L2Jp'.'dHJpe'.'C'.'9s'.'aWNlbnNlX2'.'tl'.'eS5'.'wa'.'HA=',''.'d'.'2I'.'=','PA='.'=','PyR'.'M'.'SUN'.'F'.'TlNFX0'.'tFWSA9I'.'CI'.'=','Ijs'.'/','Pg='.'=','RmlsZS'.'BvcGVuIGZ'.'h'.'a'.'WxzIFtBU'.'0FMST'.'A0XQ='.'=','Rm9'.'sZGVyIGlzIG5vdCB'.'3'.'cml0YW'.'Js'.'ZSB'.'b'.'QVNBTEkwNV0=','Tm90IGZ'.'vdW5kIGxpY2'.'Vuc2UgaW'.'5'.'mbyBbQV'.'NBSDAxXQ==','c'.'mVzdWx'.'0','cm'.'Vz'.'dWx'.'0','ZXJyb3I'.'=','bWVzc'.'2FnZQ==','RXJy'.'b3'.'I'.'gc'.'2VuZCBwYXJ0bmVyIGluZm8'.'gW0FTU'.'0lUUDAx'.'X'.'Q==','cmVz'.'c'.'G'.'9u'.'c2U=','cmVx'.'d'.'WV'.'zdA'.'==','ZX'.'Jyb3I=',''.'VW5rbm'.'9'.'3b'.'iBl'.'cnJvcg==','IFtBU1NJVFA'.'wMV'.'0=');return base64_decode($_1085146380[$_331054993]);}}; use Bitrix\Main\Application; use Bitrix\Main\Result; use Bitrix\Main\Security\SecurityException; use Bitrix\Main\SystemException; use Bitrix\Main\Web\Json; class ActivationSystem{  public function reincarnate(Coupon $_2065574824): Result{  $_1483103523= new ReincarnationRequestBuilder($_2065574824); $_2020159685=(new RequestFactory($_1483103523))->build();  $_1255731206= $_2020159685->send();  $_10966988= new UpdateServerDataParser($_1255731206); $_1766860829= $_10966988->parse(); if(isset($_1766860829[___2013433870(0)])){ throw new SystemException(($_1766860829[___2013433870(1)][___2013433870(2)] ?? ___2013433870(3)).___2013433870(4));} $_1766860829= $_1766860829[___2013433870(5)] ??[]; if(empty($_1766860829)){ throw new SystemException(___2013433870(6));} $this->applyLicenseInfo($_1766860829, $_2065574824->getKey()); $_1463721050= new Result(); return $_1463721050->setData($_1766860829);}  protected function applyLicenseInfo(array $_1766860829, string $_126889415): void{ if(isset($_1766860829[___2013433870(7)], $_1766860829[___2013433870(8)])){ $_645478033= $_1766860829[___2013433870(9)]; $_1219569903= $_1766860829[___2013433870(10)]; if(empty($_645478033) || empty($_1219569903)){ throw new SystemException(___2013433870(11));} \COption::SetOptionString(___2013433870(12), ___2013433870(13), $_645478033); if($GLOBALS['____792436554'][0]($_SERVER[___2013433870(14)].___2013433870(15))){ if($_1220742563= $GLOBALS['____792436554'][1]($_SERVER[___2013433870(16)].___2013433870(17), ___2013433870(18))){ $GLOBALS['____792436554'][2]($_1220742563, ___2013433870(19).___2013433870(20).$_1219569903.___2013433870(21).___2013433870(22)); $GLOBALS['____792436554'][3]($_1220742563);} else{ throw new SystemException(___2013433870(23));}} else{ throw new SystemException(___2013433870(24));}} if(isset($_1766860829[___2013433870(25)])){ \COption::SetOptionString(___2013433870(26), ___2013433870(27), $_1766860829[___2013433870(28)]);} if(isset($_1766860829[___2013433870(29)])){ \COption::SetOptionString(___2013433870(30), ___2013433870(31), $GLOBALS['____792436554'][4]($_1766860829[___2013433870(32)]));} if(isset($_1766860829[___2013433870(33)])){ \COption::SetOptionString(___2013433870(34), ___2013433870(35), $GLOBALS['____792436554'][5]($_1766860829[___2013433870(36)]));} if(isset($_1766860829[___2013433870(37)])){ \COption::SetOptionString(___2013433870(38), ___2013433870(39), $_1766860829[___2013433870(40)]);} if(isset($_1766860829[___2013433870(41)])){ \COption::SetOptionString(___2013433870(42), ___2013433870(43), $_1766860829[___2013433870(44)]);} if(isset($_1766860829[___2013433870(45)])){ if($GLOBALS['____792436554'][6]($_SERVER[___2013433870(46)].___2013433870(47))){ if($_1220742563= $GLOBALS['____792436554'][7]($_SERVER[___2013433870(48)].___2013433870(49), ___2013433870(50))){ $GLOBALS['____792436554'][8]($_1220742563, ___2013433870(51).___2013433870(52).EscapePHPString($_126889415).___2013433870(53).___2013433870(54)); $GLOBALS['____792436554'][9]($_1220742563);} else{ throw new SystemException(___2013433870(55));}} else{ throw new SystemException(___2013433870(56));}}}  public function activateByHash(string $_703514065): Result{ $_10966988= new HashCodeParser($_703514065); $_1766860829= $_10966988->parse(); if(empty($_1766860829)){ throw new SystemException(___2013433870(57));} $_126889415= Application::getInstance()->getLicense()->getKey(); $this->applyLicenseInfo($_1766860829, $_126889415); $_1463721050= new Result(); return $_1463721050->setData($_1766860829);}  public function sendInfoToPartner(string $_1048624174, string $_1268384616, string $_963144092): Result{ $_1483103523= new PartnerInfoRequestBuilder($_1048624174, $_1268384616, $_963144092); $_2020159685=(new RequestFactory($_1483103523))->build();  $_1255731206= $_2020159685->send(); $_1255731206= Json::decode($_1255731206); if(!isset($_1255731206[___2013433870(58)]) || $_1255731206[___2013433870(59)] === ___2013433870(60)){ $_208776664=[ ___2013433870(61) => ___2013433870(62), ___2013433870(63) => $_1255731206, ___2013433870(64) => $_2020159685]; throw new SystemException(($_1255731206[___2013433870(65)] ?? ___2013433870(66)).___2013433870(67));} return(new Result())->setData($_1255731206);}}?>