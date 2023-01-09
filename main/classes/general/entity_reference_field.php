<?php
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2012 1C-Bitrix
 */

/**
 * Reference field describes relation 1-to-1 or 1-to-many between two entities
 * @package bitrix
 * @subpackage main
 */
class CReferenceEntityField extends CEntityField
{
	protected $refEntity;

	protected $reference;

	protected $join_type = 'LEFT';


	public function __construct($name, CBaseEntity $entity, CBaseEntity $refEntity, $reference, $parameters = array())
	{
		parent::__construct($name, $refEntity->getName(), $entity);

		$this->refEntity = $refEntity;

		$this->reference = $reference;

		if (isset($parameters['join_type']))
		{
			$join_type = strtoupper($parameters['join_type']);

			if (in_array($join_type, array('LEFT', 'INNER', 'RIGHT'), true))
			{
				$this->join_type = $join_type;
			}
		}
	}

	public function getRefEntity()
	{
		return $this->refEntity;
	}

	public function getReference()
	{
		return $this->reference;
	}

	public function getJoinType()
	{
		return $this->join_type;
	}
}


