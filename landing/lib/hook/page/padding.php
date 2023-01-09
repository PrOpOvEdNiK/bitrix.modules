<?php
namespace Bitrix\Landing\Hook\Page;

use \Bitrix\Landing\Field;
use \Bitrix\Landing\Manager;
use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class Padding extends \Bitrix\Landing\Hook\Page
{
	/**
	 * Map of the field.
	 * @return array
	 */
	protected function getMap()
	{
		return array(
			'TOPBOTTOM' => new Field\Select('TOPBOTTOM', array(
				'title' => Loc::getMessage('LANDING_HOOK_PD_TOPBOTTOM'),
				'options' => array(
					'N' => Loc::getMessage('LANDING_HOOK_PD_NO'),
					'u-outer-space-v1' => Loc::getMessage('LANDING_HOOK_PD_SEMI'),
					'u-outer-space-v2' => Loc::getMessage('LANDING_HOOK_PD_FULL')
				)
			)),
			'LEFTRIGHT' => new Field\Select('LEFTRIGHT', array(
				'title' => Loc::getMessage('LANDING_HOOK_PD_LEFTRIGHT'),
				'options' => array(
					'N' => Loc::getMessage('LANDING_HOOK_PD_NO'),
					'g-layout-semiboxed' => Loc::getMessage('LANDING_HOOK_PD_SEMI'),
					'g-layout-boxed' => Loc::getMessage('LANDING_HOOK_PD_FULL')
				)
			))
		);
	}

	/**
	 * Enable or not the hook.
	 * @return boolean
	 */
	public function enabled()
	{
		return trim($this->fields['LEFTRIGHT']) != ''
				|| trim($this->fields['TOPBOTTOM']) != '';
	}

	/**
	 * Exec hook.
	 * @return void
	 */
	public function exec()
	{
		$leftright = \htmlspecialcharsbx(trim($this->fields['LEFTRIGHT']));
		$topbottom = \htmlspecialcharsbx(trim($this->fields['TOPBOTTOM']));
		if ($topbottom != '')
		{
			Manager::setPageClass(
				'HtmlClass',
				$topbottom != 'N' ? $topbottom : ''
			);
		}
		if ($leftright != '')
		{
			Manager::setPageClass(
				'BodyClass',
				$leftright != 'N' ? $leftright : ''
			);
		}
	}
}