<?php

/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage tasks
 * @copyright 2001-2021 Bitrix
 */
namespace Bitrix\Tasks\Internals\Task\Result;

use Bitrix\Main\Entity\DataManager;

/**
 * Class ResultTable
 *
 * DO NOT WRITE ANYTHING BELOW THIS
 *
 * <<< ORMENTITYANNOTATION
 * @method static EO_Result_Query query()
 * @method static EO_Result_Result getByPrimary($primary, array $parameters = [])
 * @method static EO_Result_Result getById($id)
 * @method static EO_Result_Result getList(array $parameters = [])
 * @method static EO_Result_Entity getEntity()
 * @method static \Bitrix\Tasks\Internals\Task\Result\Result createObject($setDefaultValues = true)
 * @method static \Bitrix\Tasks\Internals\Task\Result\EO_Result_Collection createCollection()
 * @method static \Bitrix\Tasks\Internals\Task\Result\Result wakeUpObject($row)
 * @method static \Bitrix\Tasks\Internals\Task\Result\EO_Result_Collection wakeUpCollection($rows)
 */
class ResultTable extends DataManager
{
	public const UF_FILE_NAME = 'UF_RESULT_FILES';
	public const UF_PREVIEW_NAME = 'UF_RESULT_PREVIEW';

	public const STATUS_OPENED = 0;
	public const STATUS_CLOSED = 1;

	public static function getTableName()
	{
		return 'b_tasks_result';
	}

	public static function getUfId()
	{
		return 'TASKS_TASK_RESULT';
	}

	public static function getClass()
	{
		return get_called_class();
	}

	public static function getObjectClass()
	{
		return Result::class;
	}

	public static function getMap()
	{
		return [
			'ID' => [
				'data_type' => 'integer',
				'primary' => true,
				'autocomplete' => true,
			],
			'TASK_ID' => [
				'data_type' => 'integer',
				'required' => true,
			],
			'COMMENT_ID' => [
				'data_type' => 'integer',
				'required' => true,
			],
			'CREATED_BY' => [
				'data_type' => 'integer',
				'required' => true,
			],
			'CREATED_AT' => [
				'data_type' => 'datetime',
			],
			'UPDATED_AT' => [
				'data_type' => 'datetime',
			],
			'TEXT' => [
				'data_type' => 'text',
				'required' => true,
			],
			'STATUS' => [
				'data_type' => 'integer',
			],

			// references
			'USER' => [
				'data_type' => 'Bitrix\Main\UserTable',
				'reference' => ['=this.CREATED_BY' => 'ref.ID'],
				'join_type' => 'inner',
			],
			'TASK' => [
				'data_type' => 'Bitrix\Tasks\Internals\TaskTable',
				'reference' => ['=this.TASK_ID' => 'ref.ID']
			],
		];
	}
}