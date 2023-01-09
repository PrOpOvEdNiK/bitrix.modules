<?php
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2012 1C-Bitrix
 */

/**
 * Entity field class for user field
 * @package bitrix
 * @subpackage main
 */
class CUEntityField extends CEntityField
{
	protected
		$is_multiple,
		$type_id,
		$base_type,
		$field_id;

	public function __construct(array $info, CBaseEntity $entity)
	{
		global $USER_FIELD_MANAGER;

		$user_type = $USER_FIELD_MANAGER->GetUserType($info['USER_TYPE_ID']);

		$this->base_type = $user_type['BASE_TYPE'];

		if (in_array($this->base_type, array('int', 'enum', 'file'), true))
		{
			$data_type = 'integer';
		}
		elseif ($this->base_type == 'double')
		{
			$data_type = 'float';
		}
		elseif ($this->base_type == 'string')
		{
			$data_type = 'string';
		}
		elseif (in_array($this->base_type, array('date', 'datetime'), true))
		{
			$data_type = 'datetime';
		}
		else
		{
			$data_type = 'string';
		}

		parent::__construct($info['FIELD_NAME'], $data_type, $entity);

		$this->is_multiple = $info['MULTIPLE'] === 'Y';
		$this->type_id = $info['USER_TYPE_ID'];
		$this->field_id = $info['ID'];
	}

	public function getTypeId()
	{
		return $this->type_id;
	}

	public function isMultiple()
	{
		return $this->is_multiple;
	}

	public function getBaseType()
	{
		return $this->base_type;
	}

	public function getFieldId()
	{
		return $this->field_id;
	}

	public function getValueFieldName()
	{
		if ($this->isMultiple())
		{
			$utm_fname = 'VALUE';

			if ($this->GetDataType() == 'integer')
			{
				$utm_fname .= '_INT';
			}
			elseif ($this->GetDataType() == 'float')
			{
				$utm_fname .= '_DOUBLE';
			}
			elseif ($this->GetDataType() == 'datetime')
			{
				$utm_fname .= '_DATE';
			}

			return $utm_fname;
		}
		else
		{
			return $this->getName();
		}
	}
}


