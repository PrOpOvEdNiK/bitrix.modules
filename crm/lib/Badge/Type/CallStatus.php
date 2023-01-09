<?php

namespace Bitrix\Crm\Badge\Type;

use Bitrix\Crm\Badge\Badge;
use Bitrix\Crm\Badge\ValueItem;
use Bitrix\Main\Localization\Loc;

class CallStatus extends Badge
{
	protected const TYPE = 'call_status';

	public const MISSED_CALL_VALUE = 'missed_call';

	public function getFieldName(): string
	{
		return Loc::getMessage('CRM_BADGE_CALL_STATUS_FIELD_NAME');
	}

	public function getValuesMap(): array
	{
		return [
			new ValueItem(
				self::MISSED_CALL_VALUE,
				Loc::getMessage('CRM_BADGE_CALL_STATUS_MISSED_CALL_VALUE'),
				'#dd4e5f',
				'#f3d5d3'
			),
		];
	}

	public function getType(): string
	{
		return self::TYPE;
	}
}
