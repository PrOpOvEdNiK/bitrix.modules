<?php
namespace Bitrix\Landing\Hook\Page;

use \Bitrix\Landing\Field;
use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class CustomCSS extends \Bitrix\Landing\Hook\Page
{
	/**
	 * Map of the field.
	 * @return array
	 */
	protected function getMap()
	{
		return array(
			'CSS_CODE' => new Field\Textarea('CSS_CODE', array(
				'title' => Loc::getMessage('LANDING_HOOK_CUSTOM_CSS_CODE'),
				'placeholder' => '* {display: none;}'
			)),
			'CSS_URL' => new Field\Text('CSS_URL', array(
				'title' => Loc::getMessage('LANDING_HOOK_CUSTOM_CSS_URL'),
				'placeholder' => Loc::getMessage('LANDING_HOOK_CUSTOM_CSS_URL_PLACEHOLDER')
			))
		);
	}

	/**
	 * Get sort of block (execute order).
	 * @return int
	 */
	public function getSort()
	{
		return 500;
	}

	/**
	 * Enable or not the hook.
	 * @return boolean
	 */
	public function enabled()
	{
		return trim($this->fields['CSS_CODE']) != '' ||
				trim($this->fields['CSS_URL']) != '';
	}

	/**
	 * Exec hook.
	 * @return void
	 */
	public function exec()
	{
		$cssCode = \htmlspecialcharsbx(trim($this->fields['CSS_CODE']));
		$cssUrl = \htmlspecialcharsbx(trim($this->fields['CSS_URL']));

		if ($cssCode != '')
		{
			echo '<style type="text/css">' . $cssCode . '</style>';
		}

		if ($cssUrl != '')
		{
			echo '<link href="' . $cssUrl .'" type="text/css"  rel="stylesheet" />';
		}
	}
}