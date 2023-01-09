<?php
/**
 * Bitrix Framework
 * @package    bitrix
 * @subpackage main
 * @copyright  2001-2017 Bitrix
 */

namespace Bitrix\Crm\UserField;
use Bitrix\Crm\LeadTable;
use Bitrix\Main\EventResult;

/**
 * UserType ENTITY_ID mapping to ORM entities.
 * @package    bitrix
 * @subpackage crm
 */
class OrmMap
{
	/**
	 * @return EventResult
	 */
	public static function onUserTypeEntityOrmMap()
	{
		return new \Bitrix\Main\EventResult(EventResult::SUCCESS, [
			'CRM_LEAD' => LeadTable::class
		]);
	}
}
