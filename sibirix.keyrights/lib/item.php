<?php

namespace Sibirix\Keyrights;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;

class ItemTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'sib_kr_item';
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
			'id'         => (new IntegerField('id', []))
				->configurePrimary(true)
				->configureAutocomplete(true),
			'entity_id'  => (new IntegerField('entity_id', [])),
			'section_id' => (new IntegerField('section_id', [])),
			'owner'      => (new IntegerField('owner', []))
				->configureRequired(true),
		];
	}
}