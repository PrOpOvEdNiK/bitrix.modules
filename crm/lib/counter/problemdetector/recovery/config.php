<?php

namespace Bitrix\Crm\Counter\ProblemDetector\Recovery;

use Bitrix\Crm\Traits\Singleton;
use Bitrix\Main\Config\Option;

class Config
{
	use Singleton;

	private const DEFAULT_FIX_LIMIT = 10;

	public function getLimit(): int
	{
		return (int)Option::get('crm', 'CounterProblemDetectorRecoveryLimit', self::DEFAULT_FIX_LIMIT);
	}
}