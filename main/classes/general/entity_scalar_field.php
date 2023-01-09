<?php
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2012 1C-Bitrix
 */

/**
 * Scalar entity field class for non-array and non-object data types
 * @package bitrix
 * @subpackage main
 */
class CScalarEntityField extends CEntityField
{
	protected $is_primary;

	public function __construct($name, $dataType, CBaseEntity $entity, $parameters = array())
	{
		parent::__construct($name, $dataType, $entity, $parameters);

		$this->is_primary = (isset($parameters['primary']) && $parameters['primary']);
	}

	public function isPrimary()
	{
		return $this->is_primary;
	}
}
