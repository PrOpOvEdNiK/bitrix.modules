<? namespace Bitrix\Main\UpdateSystem;$GLOBALS['____1284510468']= array(base64_decode('YmFzZTY0X2R'.'lY29'.'kZQ=='),base64_decode(''.'dW5zZXJ'.'pYWxpemU='),base64_decode('b'.'3BlbnNzbF92ZX'.'Jp'.'Zn'.'k='),base64_decode('d'.'W5zZXJpYWxpe'.'mU='));if(!function_exists(__NAMESPACE__.'\\___882667260')){function ___882667260($_927520020){static $_389097882= false; if($_389097882 == false) $_389097882=array(''.'YW'.'xsb'.'3dl'.'ZF9'.'jbGF'.'zc2Vz','aW5mbw==','c2l'.'nb'.'mF0dXJl','c2hhMjU2'.'V'.'2l0'.'aFJTQUVuY'.'3J5cHRpb'.'24'.'=','aW5mbw'.'='.'=','YW'.'xsb3dlZF'.'9jbGF'.'zc2Vz','RXJyb3'.'IgdmVyaWZ'.'5IG9wZ'.'W5zc2'.'wgW'.'0'.'hDU'.'FAwMV'.'0=','LS0tL'.'S'.'1'.'CRUdJTi'.'BQVUJM'.'SUMgS0'.'VZ'.'LS'.'0tLS'.'0'.'K'.'TUlJ'.'Q'.'klq'.'Q'.'U5CZ2txaGtpRz'.'l3MEJBUU'.'V'.'G'.'Q'.'UFPQ0FROE'.'FNSUlCQ2dLQ'.'0FR'.'RUE2'.'aGN4SXFp'.'a'.'XRVWlJNd1'.'lpdWt'.'TVQpoOX'.'hhN'.'WZ'.'FRFlsY2N'.'iVzN'.'2ajh'.'Bd'.'mEzNXZLcVZON'.'GlCOXRxQ'.'1g3alU'.'4Nn'.'FB'.'YT'.'J2MzdtY'.'lRGNn'.'BjW'.'TZIR1B'.'BaF'.'JGCmJwbndYT1'.'k3WUd4Q'.'jFu'.'U0tadkU'.'ra'.'kFS'.'Y'.'mlMTEJn'.'WjFjR'.'zZaMGR1dT'.'VpMVhocElSTDFjTjB'.'I'.'aD'.'VmZX'.'pwalh'.'DNk8KWXh'.'ZcTB'.'u'.'VG9IV'.'Gp5UmIxeWN6d'.'3Rta'.'VJ3WXF1'.'ZFhnL3hX'.'eHBwc'.'XdGMHRVbGQ'.'zUUJy'.'M2k2OEI4anFN'.'bStU'.'amRlQQ'.'p1L2ZnMUowSkd'.'0UjQv'.'e'.'ks0'.'Rz'.'d'.'ZSk52'.'a'.'G'.'11a'.'HJS'.'R2t5QVFWMF'.'R'.'WdTV'.'MR'.'XVnU3h'.'qQ'.'XBSbU'.'lKUU'.'5IUU1L'.'M'.'EVoOTN3C'.'k'.'1ab0ZvUHA'.'5U2dKN0dhRlU'.'4a'.'3pTK0V'.'RY2'.'50WXhiMU5IV'.'Up'.'VSXZUZGl'.'1U'.'lV'.'lRk'.'ts'.'eVRkeElySD'.'ZD'.'TC8'.'v'.'YXBN'.'S'.'DM'.'KRn'.'dJRE'.'FR'.'QU'.'IKL'.'S0tLS1FT'.'kQgUFV'.'CTElDIEt'.'FW'.'S0tLS0t');return base64_decode($_389097882[$_927520020]);}}; use Bitrix\Main\Application; use Bitrix\Main\Security\Cipher; use Bitrix\Main\Security\SecurityException; class HashCodeParser{ private string $_302796720; public function __construct(string $_302796720){ $this->_302796720= $_302796720;}  public function parse(){ $_1656858370= $GLOBALS['____1284510468'][0]($this->_302796720); $_1656858370= $GLOBALS['____1284510468'][1]($_1656858370,[___882667260(0) => false]); if($GLOBALS['____1284510468'][2]($_1656858370[___882667260(1)], $_1656858370[___882667260(2)], $this->__267072922(), ___882667260(3)) == round(0+0.33333333333333+0.33333333333333+0.33333333333333)){ $_1975691958= Application::getInstance()->getLicense()->getHashLicenseKey(); $_1652341896= new Cipher(); $_1587132572= $_1652341896->decrypt($_1656858370[___882667260(4)], $_1975691958); return $GLOBALS['____1284510468'][3]($_1587132572,[___882667260(5) => false]);} throw new SecurityException(___882667260(6));} private function __267072922(): string{ return ___882667260(7);}}?>