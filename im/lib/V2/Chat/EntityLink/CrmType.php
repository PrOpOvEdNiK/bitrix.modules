<?php

namespace Bitrix\Im\V2\Chat\EntityLink;

use Bitrix\Im\V2\Chat\EntityLink;
use Bitrix\Main\Loader;

class CrmType extends EntityLink
{
	protected const HAS_URL = true;

	protected string $crmType = '';
	protected int $crmId = 0;

	protected function __construct(string $entityId)
	{
		parent::__construct();
		if (Loader::includeModule('crm'))
		{
			$this->extractCrmData($entityId);
		}
		$this->type = $this->crmType;
	}

	protected function getUrl(): string
	{
		if($this->crmType === '' || $this->crmId === 0 || !Loader::includeModule('crm'))
		{
			return '';
		}

		return \Bitrix\Im\Integration\Crm\Common::getLink($this->crmType, $this->crmId);
	}

	protected function extractCrmData(string $rawCrmData): void
	{
		$separatedEntityId = explode('|', $rawCrmData);
		$this->crmType = $separatedEntityId[0] ?? '';
		$this->crmId = (int)($separatedEntityId[1] ?? 0);
	}
}