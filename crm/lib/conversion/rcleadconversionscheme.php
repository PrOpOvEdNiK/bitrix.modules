<?php
namespace Bitrix\Crm\Conversion;

class RCLeadConversionScheme extends LeadConversionScheme
{
	/**
	 * Get default scheme.
	 *
	 * @return int
	 */
	public static function getDefault()
	{
		return self::DEAL;
	}

	/**
	 * Get all descriptions.
	 *
	* @return array Array of strings
	*/
	public static function getAllDescriptions()
	{
		$list = parent::getAllDescriptions();
		$result[self::DEAL] = $list[self::DEAL];

		return $result;
	}

	/**
	 * Get Javascript descriptions.
	 *
	 * @param bool $checkPermissions Check permissions
	* @return array Array of strings
	*/
	public static function getJavaScriptDescriptions($checkPermissions = false)
	{
		$result = array();
		$descriptions = static::getAllDescriptions();

		if(!$checkPermissions)
		{
			$isDealPermitted = true;
		}
		else
		{
			$flags = array();
			\CCrmLead::PrepareConversionPermissionFlags(0, $flags);
			$isDealPermitted = $flags['CAN_CONVERT_TO_DEAL'];
		}

		$schemes = array();
		if($isDealPermitted)
		{
			$schemes[] = self::DEAL;
		}

		foreach($schemes as $schemeID)
		{
			$result[self::resolveName($schemeID)] = $descriptions[$schemeID];
		}

		return $result;
	}
}