<?php
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2012 1C-Bitrix
 */

/**
 * Base entity field class
 * @package bitrix
 * @subpackage main
 */
abstract class CEntityField
{
	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $dataType;

	/**
	 * @var CBaseEntity
	 */
	protected $entity;

	/**
	 * @param string      $name
	 * @param string      $dataType    scalar type or class name
	 * @param CBaseEntity $entity
	 * @param array       $parameters
	 * @throws Exception
	 */
	public function __construct($name, $dataType, CBaseEntity $entity, $parameters = array())
	{
		if (!strlen($name))
		{
			throw new Exception('Field name required');
		}

		$this->name = $name;
		$this->dataType = $dataType;
		$this->entity = $entity;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getDataType()
	{
		return $this->dataType;
	}

	public function getEntity()
	{
		return $this->entity;
	}
}


