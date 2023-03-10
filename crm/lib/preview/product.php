<?

namespace Bitrix\Crm\Preview;
class Product
{
	/**
	 * Returns HTML code for preview of the product entity.
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
			'bitrix:crm.product.preview',
			'',
			$parameters
		);
		return ob_get_clean();
	}

	/**
	 * Checks for current user's read access to the product.
	 *
	 * @param array $parameters Allowed key: productId.
	 * @return bool True if current user has access to the product.
	 */
	public static function checkUserReadAccess($parameters)
	{
		return \CCrmProduct::CheckReadPermission($parameters['productId']);
	}
}