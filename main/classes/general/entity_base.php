<?php
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2012 1C-Bitrix
 */

/**
 * Base entity
 * @package bitrix
 * @subpackage main
 */
abstract class CBaseEntity
{
	protected
		$className,
		$name,
		$dbTableName,
		$primary;

	protected
		$uf_id;

	protected
		$fieldsMap,
		$fields,
		$u_fields;

	protected
		$references;

	protected
		$filePath;

	protected static
		$instances;


	/**
	 * @static
	 *
	 * @param string $entityName
	 *
	 * @return CBaseEntity
	 */
	public static function GetInstance($entityName)
	{
		return self::getInstanceDirect('C' . $entityName . 'Entity');
	}


	protected static function GetInstanceDirect($className)
	{
		if (empty(self::$instances[$className]))
		{
			self::$instances[$className] = new $className;
			self::$instances[$className]->Initialize();
			self::$instances[$className]->PostInitialize();
		}

		return self::$instances[$className];
	}

	/**
	 * Fields factory
	 * @param string $fieldName
	 * @param array  $fieldInfo
	 *
	 * @return CBooleanEntityField|CScalarEntityField|CExpressionEntityField|CReferenceEntityField|CUEntityField
	 */
	public function initializeField($fieldName, $fieldInfo)
	{
		if (!empty($fieldInfo['reference']))
		{
			$refEntity = CBaseEntity::getInstance($fieldInfo['data_type']);
			$field = new CReferenceEntityField($fieldName, $this, $refEntity, $fieldInfo['reference'], $fieldInfo);
		}
		elseif (!empty($fieldInfo['expression']))
		{
			$field = new CExpressionEntityField($fieldName, $fieldInfo['data_type'], $this, $fieldInfo['expression'], $fieldInfo);
		}
		elseif (!empty($fieldInfo['USER_TYPE_ID']))
		{
			$field = new CUEntityField($fieldInfo, $this);
		}
		else
		{
			if ($fieldInfo['data_type'] === 'boolean')
			{
				$field = new CBooleanEntityField($fieldName, $fieldInfo['data_type'], $this, $fieldInfo);
			}
			else
			{
				$field = new CScalarEntityField($fieldName, $fieldInfo['data_type'], $this, $fieldInfo);
			}
		}

		return $field;
	}


	public function PostInitialize()
	{
		// базовые свойства
		$this->name = substr($this->className, 1, -6);
		//$this->dbTableName = strtolower($this->name);
		$this->dbTableName = empty($this->dbTableName)
			? 'b_' . self::camel2snake($this->name)
			: $this->dbTableName;

		$this->primary = array();
		$this->references = array();

		if (empty($this->filePath))
		{
			throw new Exception(sprintf(
				'Parameter `filePath` required for `%s` Entity', $this->name
			));
		}

		// инициализация атрибутов
		foreach ($this->fieldsMap as $fieldName => &$fieldInfo)
		{
			$field = $this->initializeField($fieldName, $fieldInfo);

			if ($field instanceof CReferenceEntityField)
			{
				// references cache
				$this->references[strtolower($fieldInfo['data_type'])][] = $field;
			}

			$this->fields[$fieldName] = $field;

			if ($field instanceof CScalarEntityField && $field->isPrimary())
			{
				$this->primary[] = $fieldName;
			}

			// add reference field for UField iblock_section
			if ($field instanceof CUEntityField && $field->getTypeId() == 'iblock_section')
			{
				$refFieldName = $field->GetName().'_BY';

				if ($field->isMultiple())
				{
					$localFieldName = $field->getValueFieldName();
				}
				else
				{
					$localFieldName = $field->GetName();
				}

				$newFieldInfo = array(
					'data_type' => 'IblockSection',
					'reference' => array($localFieldName, 'ID')
				);

				$refEntity = CBaseEntity::getInstance($newFieldInfo['data_type']);
				$newRefField = new CReferenceEntityField($refFieldName, $this, $refEntity, $newFieldInfo['reference'][0], $newFieldInfo['reference'][1]);

				$this->fields[$refFieldName] = $newRefField;
			}
		}

		if (empty($this->primary))
		{
			throw new Exception(sprintf('Primary not found for %s Entity', $this->name));
		}
	}

	public function GetList($select, $filter = array(), $group = array(), $order = array(), $limit = array(), $options = array(), $runtime = array())
	{
		$query = new CEntityQuery($this);

		$query->setSelect($select);
		$query->setFilter($filter);
		$query->setGroup($group);
		$query->setOrder($order);
		$query->setLimit($limit);
		$query->setOptions($options);

		foreach ($runtime as $name => $fieldInfo)
		{
			$query->registerRuntimeField($name, $fieldInfo);
		}

		return $query->exec();
	}


	// получение информации о ссылках на другие сущности
	public function GetReferencesCountTo($refEntityName)
	{
		if (array_key_exists($key = strtolower($refEntityName), $this->references))
		{
			return count($this->references[$key]);
		}

		return 0;
	}


	public function GetReferencesTo($refEntityName)
	{
		if (array_key_exists($key = strtolower($refEntityName), $this->references))
		{
			return $this->references[$key];
		}

		return array();
	}


	// getters
	public function GetFields()
	{
		return $this->fields;
	}


	public function GetField($name)
	{
		if ($this->HasField($name))
		{
			return $this->fields[$name];
		}

		throw new Exception(sprintf(
			'%s Entity has no `%s` field.', $this->GetName(), $name
		));
	}


	public function HasField($name)
	{
		return isset($this->fields[$name]);
	}


	public function getUField($name)
	{
		if ($this->hasUField($name))
		{
			return $this->u_fields[$name];
		}

		throw new Exception(sprintf(
			'%s Entity has no `%s` userfield.', $this->GetName(), $name
		));
	}


	public function hasUField($name)
	{
		if (is_null($this->u_fields))
		{
			$this->u_fields = array();

			if (strlen($this->uf_id))
			{
				/**
				 * @var $USER_FIELD_MANAGER CAllUserTypeManager
				 */
				global $USER_FIELD_MANAGER;

				foreach ($USER_FIELD_MANAGER->GetUserFields($this->uf_id) as $info)
				{
					$this->u_fields[$info['FIELD_NAME']] = new CUEntityField($info, $this);

					// add references for ufield (UF_DEPARTMENT_BY)
					if ($info['USER_TYPE_ID'] == 'iblock_section')
					{
						$info['FIELD_NAME'] .= '_BY';
						$this->u_fields[$info['FIELD_NAME']] = new CUEntityField($info, $this);
					}
				}
			}
		}

		return isset($this->u_fields[$name]);
	}


	public function GetName()
	{
		return $this->name;
	}


	public function GetFilePath()
	{
		return $this->filePath;
	}


	public function GetDBTableName()
	{
		return $this->dbTableName;
	}


	public function GetPrimary()
	{
		return count($this->primary) == 1 ? $this->primary[0] : $this->primary;
	}


	public function GetPrimaryArray()
	{
		return $this->primary;
	}

	public function IsUts()
	{
		return false;
	}


	public function IsUtm()
	{
		return false;
	}


	public static function IsExists($name)
	{
		return class_exists('C' . $name . 'Entity');
	}


	public static function camel2snake($str)
	{
		return strtolower(preg_replace('/(.)([A-Z])(.*?)/', '$1_$2$3', $str));
	}


	public static function snake2camel($str)
	{
		$str = str_replace('_', ' ', strtolower($str));
		return str_replace(' ', '', ucwords($str));
	}

}

