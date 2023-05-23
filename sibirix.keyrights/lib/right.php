<?php

namespace Sibirix\Keyrights;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\DatetimeField;
use Bitrix\Main\ORM\Fields\IntegerField;

class RightTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'sib_kr_right';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 * @throws \Bitrix\Main\SystemException
	 */
	public static function getMap()
	{
		return [
			'id'      => (new IntegerField(
				'id', []
			))->configurePrimary(true)
			  ->configureAutocomplete(true),
			'item_id' => (new IntegerField(
				'item_id', []
			))->configureRequired(true),
			'edit'    => (new IntegerField(
				'edit', []
			))->configureRequired(true),
			'blocked' => (new IntegerField(
				'blocked', []
			))->configureRequired(true),
			'timed'   => (new DatetimeField(
				'timed',
				[]
			)),
			'user'    => (new IntegerField(
				'user', []
			)),
			'group'   => (new IntegerField(
				'group', []
			)),
		];
	}
}