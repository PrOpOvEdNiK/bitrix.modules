<?

namespace Bitrix\Crm\Preview;
class Lead
{
	/**
	 * Returns HTML code for preview of the lead entity.
	 *
	 * @param array $parameters Parameters that will be passed to the component.
	 * @return string HTML code of the preview.
	 */
	public static function buildPreview($parameters)
	{
		global $APPLICATION;
		if(empty($parameters['NAME_TEMPLATE']))
			$parameters['NAME_TEMPLATE'] =  \CSite::GetNameFormat(false);
		else
			$parameters['NAME_TEMPLATE'] = str_replace(array("#NOBR#","#/NOBR#"), array("",""), $parameters["NAME_TEMPLATE"]);

		ob_start();
		$APPLICATION->IncludeComponent(
			'bitrix:crm.lead.preview',
			'',
			$parameters
		);
		return ob_get_clean();
	}

	/**
	 * Checks for current user's read access to the lead.
	 *
	 * @param array $parameters Allowed key: leadId.
	 * @return bool True if current user has access to the lead.
	 */
	public static function checkUserReadAccess($parameters)
	{
		return \CCrmLead::CheckReadPermission($parameters['leadId'], \CCrmPerms::GetCurrentUserPermissions());
	}
}