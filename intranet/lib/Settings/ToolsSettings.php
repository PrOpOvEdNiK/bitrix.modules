<?php

namespace Bitrix\Intranet\Settings;

use Bitrix\Main\Result;

class ToolsSettings extends AbstractSettings
{
	public const TYPE = 'tools';

	private array $baseTools;

	public function __construct(array $data = [])
	{
		parent::__construct($data);
		$this->baseTools = Tools\ToolsManager::getInstance()->getToolList();
	}

	public function save(): Result
	{
		$isChanged = false;

		foreach ($this->baseTools as $tool)
		{
			if (isset($this->data[$tool->getOptionCode()]))
			{
				if ($this->data[$tool->getOptionCode()] === 'Y')
				{
					$tool->enable();
					$isChanged = true;
				}
				elseif ($this->data[$tool->getOptionCode()] === 'N')
				{
					$tool->disable();
					$isChanged = true;

					continue;
				}
			}

			$subgroups = $tool->getSubgroups();

			foreach ($subgroups as $subgroup)
			{
				if (isset($this->data[$subgroup['code']]))
				{
					if ($this->data[$subgroup['code']] === 'Y')
					{
						$tool->enableSubgroup($subgroup['code']);
						$isChanged = true;
					}
					elseif ($this->data[$subgroup['code']] === 'N')
					{
						$tool->disableSubgroup($subgroup['code']);
						$isChanged = true;
					}
				}
			}
		}

		if ($isChanged)
		{
			Tools\ToolsManager::getInstance()->changeFirstPageForAll();
		}

		return new Result();
	}

	public function get(): SettingsInterface
	{
		global $USER;
		$data = [];

		foreach ($this->baseTools as $tool)
		{
			$data['tools'][$tool->getId()] = [
				'enabled' => $tool->isEnabled() && $tool->isEnabledSubgroups(),
				'name' => $tool->getName(),
				'code' => $tool->getOptionCode(),
				'subgroups' => $tool->getSubgroups(),
				'settings-path' => $tool->getSettingsPath() ? str_replace("#USER_ID#", $USER->GetID(), $tool->getSettingsPath()) : null,
				'settings-title' => $tool->getSettingsTitle(),
				'infohelper-slider' => $tool->getInfoHelperSlider(),
				'default' => $tool->isDefault(),
			];
		}

		return new static($data);
	}
}