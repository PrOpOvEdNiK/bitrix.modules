<?php
/**
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.
 *
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to kontakt@beberlei.de so we can send you a copy immediately.
 *
 * @author     Benjamin Eberlei (kontakt@beberlei.de)
 * @copyright  Copyright (c) 2009 Benjamin Eberlei
 * @license    New BSD License
 * @package    Whitewashing
 * @subpackage Db
 */

/**
 * @see Zend_Db_Adapter_Abstract
 */
require_once "Zend/Db/Adapter/Mysqli.php";

/**
 * @see Whitewashing_Db_Statement_Mysqli
 */
require_once "Whitewashing/Db/Statement/Mysqli.php";

class Whitewashing_Db_Adapter_Mysqli extends Zend_Db_Adapter_Mysqli
{

    public function setConnectionResource($connection)
    {
        $this->_connection = $connection;
    }

    /**
     * Prepare a statement and return a PDOStatement-like object.
     *
     * @param string|Zend_Db_Select $sql SQL query
     * @return Zend_Db_Statement|PDOStatement
     */
    public function prepare($sql)
    {
        return new Whitewashing_Db_Statement_Mysqli($this, $sql);
    }
}
