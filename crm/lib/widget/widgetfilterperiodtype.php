<?php
namespace Bitrix\Crm\Widget;

class WidgetFilterPeriodType
{
	const UNDEFINED = 0;
	const YEAR = 1;
	const QUARTER = 2;
	const MONTH = 3;

	const YEAR_NAME = 'Y';
	const QUARTER_NAME = 'Q';
	const MONTH_NAME = 'M';

	const FIRST = 1;
	const LAST = 3;

	public static function resolveByName($name)
	{
		$name = strtoupper($name);
		switch($name)
		{
			case self::YEAR_NAME:
				return self::YEAR;
			case self::QUARTER_NAME:
				return self::QUARTER;
			case self::MONTH_NAME:
				return self::MONTH;
			default:
				return self::UNDEFINED;
		}
	}

	public static function isDefined($typeID)
	{
		if(!is_numeric($typeID))
		{
			return false;
		}

		$typeID = (int)$typeID;
		return $typeID >= self::FIRST && $typeID <= self::LAST;
	}
}