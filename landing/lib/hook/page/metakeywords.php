<?php
namespace Bitrix\Landing\Hook\Page;

use \Bitrix\Landing\Field;
use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class MetaKeywords extends \Bitrix\Landing\Hook\Page
{
	/**
	 * Map of the field.
	 * @return array
	 */
	protected function getMap()
	{
		return array(
			'KEYWORDS' => new Field\Text('KEYWORDS', array(
				'title' => Loc::getMessage('LANDING_HOOK_METAKEYWORDS'),
				'maxlength' => 250
			))
		);
	}

	/**
	 * Enable or not the hook.
	 * @return boolean
	 */
	public function enabled()
	{
		return trim($this->fields['KEYWORDS']) != '';
	}

	/**
	 * Exec hook.
	 * @return void
	 */
	public function exec()
	{
		$keywords = \htmlspecialcharsbx(trim($this->fields['KEYWORDS']));
		\Bitrix\Main\Page\Asset::getInstance()->addString(
			'<meta name="keywords" content="' . $keywords . '" />'
		);
	}
}
