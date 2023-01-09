<?php
namespace Bitrix\Crm\Requisite;
use Bitrix\Main;
class InvoiceRequisiteConvertionError
{
	const NONE = 0;
	const GENERAL = 10;
	const PERSON_TYPE_NOT_FOUND = 20;
	const PROPERTY_NOT_FOUND = 30;
	const PRESET_NOT_BOUND = 40;

	/** @var array */
	private static $descriptions = array();
	/** @var bool */
	private static $langIncluded = false;

	/**
	 * Get error description
	 * @param int $error Error code.
	 * @return string
	 */
	public static function getDescription($error)
	{
		$all = self::getAllDescriptions();
		return isset($all[$error]) ? $all[$error] : (string)$error;
	}

	/**
	 * Get all error descriptions
	 * @return array
	 */
	public static function getAllDescriptions()
	{
		if(!self::$descriptions[LANGUAGE_ID])
		{
			self::includeLangFile();
			self::$descriptions[LANGUAGE_ID] = array(
				self::GENERAL => GetMessage('CRM_INV_RQ_CONV_ERROR_GENERAL'),
				self::PERSON_TYPE_NOT_FOUND => GetMessage('CRM_INV_RQ_CONV_ERROR_PERSON_TYPE_NOT_FOUND'),
				self::PROPERTY_NOT_FOUND => GetMessage('CRM_INV_RQ_CONV_ERROR_PROPERTY_NOT_FOUND'),
				self::PRESET_NOT_BOUND => GetMessage('CRM_INV_RQ_CONV_ERROR_PRESET_NOT_BOUND')
			);
		}

		return self::$descriptions[LANGUAGE_ID];
	}

	/**
	 * Include language file
	 * @return void
	 */
	private static function includeLangFile()
	{
		if(!self::$langIncluded)
		{
			self::$langIncluded = IncludeModuleLangFile(__FILE__);
		}
	}
}