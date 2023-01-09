<?php
namespace Bitrix\Crm;
use Bitrix\Main;

class RequisiteAddress extends EntityAddress
{
	private static $messagesLoaded = false;

	private static $fieldMaps = array();
	private static $invertedFieldMaps = array();

	private static $typeInfos = null;

	/**
	* @return int
	*/
	protected static function getEntityTypeID()
	{
		return \CCrmOwnerType::Requisite;
	}

	/**
	* @param int $typeID type of address
	* @return array
	*/
	protected static function getFieldMap($typeID)
	{
		if(!isset(self::$fieldMaps[$typeID]))
		{
			$requisite = new EntityRequisite();
			self::$fieldMaps[$typeID] = $requisite->getAddressFieldMap($typeID);
		}

		return self::$fieldMaps[$typeID];
	}

	/**
	* @return array
	*/
	protected static function getInvertedFieldMap($typeID)
	{
		if(!isset(self::$invertedFieldMaps[$typeID]))
		{
			self::$invertedFieldMaps[$typeID] = array_flip(self::getFieldMap($typeID));
		}
		return self::$invertedFieldMaps[$typeID];
	}

	/**
	 * @param $fieldName
	 * @param array|null $aliases
	 * @return int
	 *
	 * @deprecated Use methods of EntityAddressType and EntityAddress
	 */
	public static function resolveEntityFieldTypeID($fieldName, array $aliases = null)
	{
		return EntityAddressType::Primary;
	}

	/**
	 * Remove entity addresses
	 * @param array $entityID Entity ID.
	 * @return void
	*/
	public static function deleteByEntityId($entityID)
	{
		EntityAddress::deleteByEntity(\CCrmOwnerType::Requisite, $entityID);
	}

	/** @deprecated Use methods of EntityAddressType and EntityAddress */
	public static function getTypeInfos()
	{
		if(self::$typeInfos === null)
		{
			self::$typeInfos = self::getTypesList();

			$defaultId = static::getDefaultTypeId();
			foreach (self::$typeInfos as $id => $typeInfo)
			{
				self::$typeInfos[$id]['IS_DEFAULT'] = ($id === $defaultId);
			}
		}
		return self::$typeInfos;
	}

	/** @deprecated Use methods of EntityAddressType and EntityAddress */
	public static function getTypesList()
	{
		static $addressTypes;
		if($addressTypes === null)
		{
			$addressTypes = [];
			$descriptions = EntityAddressType::getDescriptions(EntityAddressType::getAvailableIds());
			foreach ($descriptions as $typeId => $description)
			{
				$addressTypes[$typeId] = [
					'ID' => $typeId,
					'DESCRIPTION' => $description
				];
			}
		}

		return $addressTypes;
	}

	/** @deprecated Use methods of EntityAddressType and EntityAddress */
	public static function getDefaultTypeId()
	{
		$veryDefaultId = EntityAddressType::getDefaultIdByZone(EntityAddress::getZoneId());
		$defaultId = Main\Config\Option::get('crm', 'requisite_default_address_type', $veryDefaultId);
		$addressTypeMap = array_fill_keys(EntityAddressType::getAllIDs(), true);

		return (isset($addressTypeMap[$defaultId]) ? $defaultId : $veryDefaultId);
	}

	/** @deprecated Use methods of EntityAddressType and EntityAddress */
	public static function getClientTypeInfos()
	{
		self::includeModuleFile();
		return array_merge(
			array(
				array('id' => self::Delivery, 'name' => GetMessage('CRM_REQUISITE_ADDRESS_TYPE_DELIVERY')),
			),
			parent::getClientTypeInfos(),
			array(
				array('id' => self::Home, 'name' => GetMessage('CRM_REQUISITE_ADDRESS_TYPE_HOME')),
				array('id' => self::Beneficiary, 'name' => GetMessage('CRM_REQUISITE_ADDRESS_TYPE_BENEFICIARY'))
			)
		);
	}

	/** @deprecated Use methods of EntityAddressType and EntityAddress */
	public static function getTypeDescription($typeID)
	{
		if(!is_int($typeID))
		{
			$typeID = (int)$typeID;
		}

		if(!EntityAddressType::isDefined($typeID))
		{
			$typeID = EntityAddressType::getDefaultIdByZone(EntityAddress::getZoneId());
		}

		$typeInfos = self::getTypeInfos();
		return $typeInfos[$typeID]['DESCRIPTION'];
	}

	protected static function includeModuleFile()
	{
		if(self::$messagesLoaded)
		{
			return;
		}

		Main\Localization\Loc::loadMessages(__FILE__);
		self::$messagesLoaded = true;
	}

	/**
	 * Returns the addresses of the specified entities.
	 * @param int $entityTypeId Entity type ID (Company and Contact are supported only).
	 * @param array $entityIds List of entities IDs.
	 * @return array
	 */
	public static function getByEntities($entityTypeId, $entityIds)
	{
		$result = array();

		if (EntityRequisite::checkEntityType($entityTypeId) && is_array($entityIds) && !empty($entityIds))
		{
			foreach ($entityIds as $k => $v)
				$entityIds[$k] = (int)$v;

			$query = new Main\Entity\Query(AddressTable::getEntity());
			$query->registerRuntimeField('',
				new Main\Entity\ReferenceField('REF_RQ',
					RequisiteTable::getEntity(),
					array('=this.ENTITY_ID' => 'ref.ID', '=this.ENTITY_TYPE_ID' => array('?', \CCrmOwnerType::Requisite)),
					array('join_type' => 'INNER')
				)
			);
			$query->setSelect(
				array(
					'ENTITY_ID',
					'REQUISITE_ENTITY_ID' => 'REF_RQ.ENTITY_ID',
					'TYPE_ID',
					'ADDRESS_1',
					'ADDRESS_2',
					'CITY',
					'POSTAL_CODE',
					'REGION',
					'PROVINCE',
					'COUNTRY',
					'COUNTRY_CODE',
					'LOC_ADDR_ID'
				)
			);
			$query->setFilter(array('=REF_RQ.ENTITY_TYPE_ID' => $entityTypeId, '@REF_RQ.ENTITY_ID' => $entityIds));
			$res = $query->exec();
			while ($row = $res->fetch())
			{
				$entityId = (int)$row['REQUISITE_ENTITY_ID'];
				$requisiteId = (int)$row['ENTITY_ID'];
				$typeId = (int)$row['TYPE_ID'];
				$result[$entityId][$requisiteId][$typeId] = array(
					'ADDRESS_1' => isset($row['ADDRESS_1']) ? $row['ADDRESS_1'] : '',
					'ADDRESS_2' => isset($row['ADDRESS_2']) ? $row['ADDRESS_2'] : '',
					'CITY' => isset($row['CITY']) ? $row['CITY'] : '',
					'POSTAL_CODE' => isset($row['POSTAL_CODE']) ? $row['POSTAL_CODE'] : '',
					'REGION' => isset($row['REGION']) ? $row['REGION'] : '',
					'PROVINCE' => isset($row['PROVINCE']) ? $row['PROVINCE'] : '',
					'COUNTRY' => isset($row['COUNTRY']) ? $row['COUNTRY'] : '',
					'COUNTRY_CODE' => isset($row['COUNTRY_CODE']) ? $row['COUNTRY_CODE'] : '',
					'LOC_ADDR_ID' => isset($row['LOC_ADDR_ID']) ? (int)$row['LOC_ADDR_ID'] : 0
				);
			}
		}

		return $result;
	}
}