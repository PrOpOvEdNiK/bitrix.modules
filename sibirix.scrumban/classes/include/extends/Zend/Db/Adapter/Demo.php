<?php
require_once 'Zend/Db/Adapter/Mysqli.php';

class Zend_Db_Adapter_Demo extends Zend_Db_Adapter_Mysqli
{
    public function __construct($config)
    {
        parent::__construct($config);
        $this->_config['dbname'] = "demo_" . str_replace("-","_", implode("", array_slice( explode('.', $_SERVER['SERVER_NAME']), 0, 1 )));
    }
}
