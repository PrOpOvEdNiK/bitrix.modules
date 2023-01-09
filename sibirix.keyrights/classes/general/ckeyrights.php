<?
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
    final private function __clone() {
        // do nothing
    }

    /**
     *
     */
    /** @noinspection PhpUnusedPrivateMethodInspection */
    final private function __wakeup() {
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
}
