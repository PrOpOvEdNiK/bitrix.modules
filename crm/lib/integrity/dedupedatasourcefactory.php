<?php
namespace Bitrix\Crm\Integrity;
use Bitrix\Main;

class DedupeDataSourceFactory
{
	static public function create($typeID, DedupeParams $params)
	{
		if($typeID === DuplicateIndexType::PERSON)
		{
			return new PersonDedupeDataSource($params);
		}
		elseif($typeID === DuplicateIndexType::ORGANIZATION)
		{
			return new OrganizationDedupeDataSource($params);
		}
		elseif($typeID === DuplicateIndexType::COMMUNICATION_PHONE
			|| $typeID === DuplicateIndexType::COMMUNICATION_EMAIL
			|| $typeID === DuplicateIndexType::COMMUNICATION_SLUSER)
		{
			return new CommunicationDedupeDataSource($typeID, $params);
		}
		elseif(($typeID & DuplicateIndexType::REQUISITE) === $typeID)
		{
			return new RequisiteDedupeDataSource($typeID, $params);
		}
		elseif(($typeID & DuplicateIndexType::BANK_DETAIL) === $typeID)
		{
			return new BankDetailDedupeDataSource($typeID, $params);
		}
		else
		{
			$volatileTypeIds = DuplicateVolatileCriterion::getAllSupportedDedupeTypes();
			foreach ($volatileTypeIds as $volatileTypeId)
			{
				if (($typeID & $volatileTypeId) === $typeID)
				{
					return new VolatileDedupeDataSource($typeID, $params);
				}
			}
		}

		throw new Main\NotSupportedException("Type: '".DuplicateIndexType::resolveName($typeID)."' is not supported in current context");
	}
}