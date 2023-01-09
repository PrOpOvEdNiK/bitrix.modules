<?php
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage crm
 * @copyright 2001-2013 Bitrix
 */
namespace Bitrix\Crm;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

/**
 * Class UserActivityTable
 *
 * DO NOT WRITE ANYTHING BELOW THIS
 *
 * <<< ORMENTITYANNOTATION
 * @method static EO_UserActivity_Query query()
 * @method static EO_UserActivity_Result getByPrimary($primary, array $parameters = array())
 * @method static EO_UserActivity_Result getById($id)
 * @method static EO_UserActivity_Result getList(array $parameters = array())
 * @method static EO_UserActivity_Entity getEntity()
 * @method static \Bitrix\Crm\EO_UserActivity createObject($setDefaultValues = true)
 * @method static \Bitrix\Crm\EO_UserActivity_Collection createCollection()
 * @method static \Bitrix\Crm\EO_UserActivity wakeUpObject($row)
 * @method static \Bitrix\Crm\EO_UserActivity_Collection wakeUpCollection($rows)
 */
class UserActivityTable extends Entity\DataManager
{
	public static function getTableName()
	{
		return 'b_crm_usr_act';
	}

	public static function getMap()
	{
		return array(
			'USER_ID' => array(
				'data_type' => 'integer',
				'primary' => true
			),
			'OWNER_ID' => array(
				'data_type' => 'integer',
				'primary' => true
			),
			'OWNER_TYPE_ID' => array(
				'data_type' => 'integer',
				'primary' => true
			),
			'ACTIVITY_TIME' => array(
				'data_type' => 'datetime'
			),
			'ACTIVITY_ID' => array(
				'data_type' => 'integer'
			),
			'DEPARTMENT_ID' => array(
				'data_type' => 'integer'
			),
			'SORT' => array(
				'data_type' => 'integer'
			),
		);
	}
}
