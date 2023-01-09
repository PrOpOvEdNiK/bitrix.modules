<?php
namespace Bitrix\Crm\Conversion;
use Bitrix\Main;
class RCLeadConversionConfig extends LeadConversionConfig
{
	const OPTION_NAME = 'crm_lead_rc_conversion';

	public static function getDefault()
	{
		$config = new static();
		$item = $config->getItem(\CCrmOwnerType::Deal);
		/** @var EntityConversionConfigItem $item */
		if ($item)
		{
			$item->setActive(true);
			$item->enableSynchronization(true);
		}

		return $config;
	}

	public function getSchemeID()
	{
		$dealConfig = $this->getItem(\CCrmOwnerType::Deal);
		if($dealConfig->isActive())
		{
			return LeadConversionScheme::DEAL;
		}
		return LeadConversionScheme::UNDEFINED;
	}

	public static function getCurrentSchemeID()
	{
		$config = static::load();
		if($config === null)
		{
			$config = static::getDefault();
		}

		$schemeID = $config->getSchemeID();
		if($schemeID === RCLeadConversionScheme::UNDEFINED)
		{
			$schemeID = RCLeadConversionScheme::getDefault();
		}

		return $schemeID;
	}
}