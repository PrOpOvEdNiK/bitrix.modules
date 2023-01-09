<?php
/** Zend_Loader_PluginLoader_Interface */
require_once 'Zend/Loader/Autoloader/Interface.php';

/** Zend_Loader */
require_once 'Zend/Loader.php';

/**
 * User: Денис Песковацков
 * Date: 06.09.12
 */
class Zend_Loader_Bitrix implements Zend_Loader_Autoloader_Interface {

    private $_APP_PATH;

    public function __construct($path) {
	    $this->_APP_PATH = $path;
    }

    public function autoload($class) {
        if (strpos($class, 'Model_Db_Backend') === 0) {
            require_once ($this->getClassPath($class));
        } else {
            $module = new CModule();
            $module->RequireAutoloadClass($class);
        }
    }

    public function getClassPath($class) {
        return $this->_APP_PATH . DS . str_replace("_", DS, str_replace('Model_Db_Backend', 'models_Db_Bitrix', $class)) . ".php";
    }
}
