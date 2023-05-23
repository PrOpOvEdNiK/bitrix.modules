<?

use Sibirix\Keyrights\AesCtr\AES;
use Sibirix\Keyrights\AesCtr\CTR;

/**
 * класс модуля
 * класс комбайн
 *    запускает зенд
 *    обрабатывает хуки битрикса
 */
class CKeyrights {
    private $_zend;
    private $_params;

    const MODULE_ID = "sibirix.keyrights";
	public const DIRECTOR_ID = 524;

    public static function getInstance($params = array()) {
        static $_instance;
        if (!isset($_instance)) {
            $_instance = new self($params);
        }
        return $_instance;
    }

    /**
     *
     */
    private function __clone() {
        // do nothing
    }

    /**
     *
     */
    /** @noinspection PhpUnusedPrivateMethodInspection */
    private function __wakeup() {
        // do nothing
    }

    final private function __construct($params) {
//        set_time_limit(30);
//        error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
//        error_reporting(-1);

        if (!isset($params['APPLICATION_PATH']) || empty($params['APPLICATION_PATH'])) {
            $params['APPLICATION_PATH'] = realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'application');
        }

        if (!isset($params['BASE_PATH']) || empty($params['BASE_PATH'])) {
            $params['BASE_PATH'] = dirname(__FILE__);
        }

        $this->_params = $params;
    }

    public function run() {
        defined('APPLICATION_PATH') || define('APPLICATION_PATH', $this->_params['APPLICATION_PATH']);
        defined('BASE_PATH') || define('BASE_PATH', $this->_params['BASE_PATH']);
        defined('APPLICATION_ENV') || define('APPLICATION_ENV', $this->_params['APPLICATION_ENV']);

        defined('BASE_DOMAIN') || define('BASE_DOMAIN', $_SERVER['SERVER_NAME']);
        define('KEYRIGHTS_VIEW_ENCODING', ToUpper(LANG_CHARSET));

        $path = $_SERVER['REAL_FILE_PATH'];
        if (empty($path)) {
            $path = strlen($_SERVER['PHP_SELF']) < strlen($_SERVER['SCRIPT_NAME']) ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
        }
        defined("KEYRIGHTS_BASE_URL") || define("KEYRIGHTS_BASE_URL", dirname($path));
        defined('KEYRIGHTS_PATH_STATIC') || define('KEYRIGHTS_PATH_STATIC', '/bitrix/components/sibirix/keyrights/static');

        define('APPLICATION_BACKEND', 'bitrix');

        set_include_path(implode(PATH_SEPARATOR, array(
            realpath(
                dirname(__FILE__)
                    . DIRECTORY_SEPARATOR . '..'
                    . DIRECTORY_SEPARATOR . 'include/extends'
            ),
            realpath(
                dirname(__FILE__)
                    . DIRECTORY_SEPARATOR . '..'
                    . DIRECTORY_SEPARATOR . 'include/library'
            ),
            get_include_path(),
        )));

        require_once 'Zend/Application.php';

        $this->_zend = new Zend_Application(
            APPLICATION_ENV,
            APPLICATION_PATH . DIRECTORY_SEPARATOR . 'backends' . DIRECTORY_SEPARATOR . APPLICATION_BACKEND . DIRECTORY_SEPARATOR . 'configs' . DIRECTORY_SEPARATOR . 'application.ini'
        );

        $this->_zend->bootstrap();
        $this->_zend->run();
    }

    /**
     * @return string
     */
    public static function getClientCypherKey() {
        return COption::GetOptionString(static::MODULE_ID, 'clientPassphrase', '');
    }

    /**
     * @return string
     */
    public static function getServerCypherKey() {
        return COption::GetOptionString(static::MODULE_ID, 'serverPassphrase', '');
    }

    public static function onIblockSectionDelete($arFields) {
        static $departmentIblockId;
        if (is_null($departmentIblockId)) {
            $departmentIblockId = COption::GetOptionInt('intranet', 'iblock_structure', 0);
            if (!$departmentIblockId) {
                $bxIblock = new CIBlock();
                $res = $bxIblock->GetList(array(), array('CODE' => 'departments'));
                $iblock = $res->Fetch();
                $departmentIblockId = is_array($iblock) ? $iblock['ID'] : 0;
            }
        }

        if ($departmentIblockId && $arFields['IBLOCK_ID'] == $departmentIblockId) {
            global $DB;
            $DB->Query('DELETE FROM `sib_kr_right` where `group` = ' . $arFields['ID'] . ' AND `user` IS NULL;');
        }
    }

    public static function onUserDelete($userId) {
        global $DB;
        $DB->Query('DELETE FROM `sib_kr_right` where `user` = ' . $userId . ' AND `group` IS NULL;');
        $DB->Query(sprintf('UPDATE `sib_kr_item` SET `owner` = 1 WHERE `owner` = %d;', intval($userId)));
    }

    public static function onUserDeactivate($userId) {
        global $DB;
        $DB->Query('DELETE FROM `sib_kr_right` where `user` = ' . $userId . ' AND `group` IS NULL;');
        $DB->Query(sprintf('UPDATE `sib_kr_item` SET `owner` = ' . self::DIRECTOR_ID . ' WHERE `owner` = %d;', intval($userId)));

	}

	public static function getIblockIdItem() {
		return COption::GetOptionString(CKeyrights::MODULE_ID, 'iblockId', -1);
	}

	public static function getIblockIdHistory() {
		return COption::GetOptionString(CKeyrights::MODULE_ID, 'historyIblockId', -1);
	}

	public static function getServerPassPhrase() {
		return COption::GetOptionString(CKeyrights::MODULE_ID, 'serverPassphrase');
	}

	public static function backEncrypt($string) {
		$password = self::getClientCypherKey();
		$method = "AES-256-CBC";
		$key = hash('sha256', $password, true);
		$iv = openssl_random_pseudo_bytes(16);

		$ciphertext = openssl_encrypt($string, $method, $key, OPENSSL_RAW_DATA, $iv);
		$hash = hash_hmac('sha256', $ciphertext . $iv, $key, true);

		return $iv . $hash . $ciphertext;
	}

	public static function backDecrypt($crypted) {
		$password = self::getClientCypherKey();
		$method = "AES-256-CBC";
		$iv = substr($crypted, 0, 16);
		$hash = substr($crypted, 16, 32);
		$ciphertext = substr($crypted, 48);
		$key = hash('sha256', $password, true);

		if (!hash_equals(hash_hmac('sha256', $ciphertext . $iv, $key, true), $hash)) return null;

		return openssl_decrypt($ciphertext, $method, $key, OPENSSL_RAW_DATA, $iv);
	}

	public static function processPublicLinks($content)
	{
		$linkRegexp = '/(http|ftp|https):\/\/([\w_-]+(?:(?:\.[\w_-]+)+))([\w.,@?^=%&:\/~+#-]*[\w@?^=%&\/~+#-])/m';
		preg_match_all($linkRegexp, $content, $arLinks, PREG_SET_ORDER, 0);
		foreach ($arLinks as $arLink) {
			$fullLink   = $arLink[0];
			$searchPart = "/keyrights/#/";
			if (mb_substr_count($fullLink, $searchPart) > 0) {
				[$sectionId, $elementId] = explode('/', str_replace($searchPart, '', $arLink[3]));
				if ($sectionId && $elementId && \Bitrix\Main\Engine\CurrentUser::get()->isAdmin()) {
					//dtf([$sectionId, $elementId]);
					$arItem = CIBlockElement::GetList(
						[],
						['IBLOCK_ID' => self::getIblockIdItem()],
						false,
						false,
						['ID', 'IBLOCK_ID', 'PROPERTY_CRYPTED']
					)->Fetch();
					$result = \Sibirix\Keyrights\Model\Crypt::decrypt($arItem['PROPERTY_CRYPTED_VALUE']['TEXT']);
					// @todo: aes-256-ctr ??? decrypt
				}
			}
		}
	}
}
