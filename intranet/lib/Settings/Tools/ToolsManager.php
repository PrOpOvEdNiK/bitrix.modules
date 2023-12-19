<?php

namespace Bitrix\Intranet\Settings\Tools;

use Bitrix\Intranet\UI\LeftMenu\Preset\Manager;
use Bitrix\Main\Config\Option;
use Bitrix\Main\ModuleManager;

class ToolsManager
{
	private static ToolsManager $instance;
	/**
	 * @var Tool[]|null
	 */
	private ?array $baseTools = null;
	/**
	 * @var string[]|null
	 */
	private ?array $disabledMenuItemListId = null;

	public static function getInstance(): static
	{
		if (!isset(static::$instance))
		{
			static::$instance = new static();
		}

		return static::$instance;
	}

	protected function init(): void
	{
		$activePreset = Manager::getPreset()->getStructure()['shown'];

		foreach ($activePreset as $key => $value)
		{
			if (is_array($value))
			{
				$activePreset[$key] = $key;
			}
		}

		$sitesTool = new Sites();
		$menuItems = [
			$sitesTool->getMenuItemId() => $sitesTool,
			'menu_tasks' => new Tasks(),
			'menu_crm_favorite' => new Crm(),
			'menu_teamwork' => new TeamWork(),
			'menu_automation' => new Automation(),
			'menu_sign' => new Sign(),
			'menu_crm_store' => new Inventory(),
			'menu_company' => new Company(),
		];

		foreach ($menuItems as $id => $item)
		{
			if (!$item->isAvailable())
			{
				unset($menuItems[$id]);
			}
		}

		$sortedMenuItems = array_merge(array_flip($activePreset), $menuItems);

		$this->baseTools = array_intersect_key($sortedMenuItems, $menuItems);
	}

	/**
	 * @return Tool[]
	 */
	public function getToolList(): array
	{
		if (!is_array($this->baseTools))
		{
			$this->init();
		}

		return $this->baseTools;
	}

	public function checkAvailabilityByMenuId(string $menuItemId): bool
	{
		if ($menuItemId === 'menu_company')
		{
			return true;
		}

		$listDisabledIdMenuItem = $this->getDisabledMenuItemListId();

		$menuItemId = $this->checkCustomMenuId($menuItemId);

		if (in_array($menuItemId, $listDisabledIdMenuItem, true))
		{
			return false;
		}

		return true;
	}

	public function checkCustomMenuId(string $menuItemId): string
	{
		return match ($menuItemId) {
			'ANALYTICS_SALES_FUNNEL', 'ANALYTICS_MANAGERS', 'ANALYTICS_DIALOGS', 'ANALYTICS_CALLS' => 'analytics',
			'SMART_INVOICE' => 'INVOICE',
			default => $menuItemId,
		};
	}

	public function checkAvailabilityByToolId(string $toolId): bool
	{
		$listDisabledIdMenuItem = $this->getDisabledMenuItemListId();

		if (array_key_exists($toolId, $listDisabledIdMenuItem))
		{
			return false;
		}

		return true;
	}

	public function getDisabledMenuItemListId(): array
	{
		if (is_array($this->disabledMenuItemListId))
		{
			return $this->disabledMenuItemListId;
		}

		$this->disabledMenuItemListId = [];
		$toolList = $this->getToolList();

		foreach ($toolList as $tool)
		{
			if (!$tool->isEnabled() && $tool->getMenuItemId())
			{
				$this->disabledMenuItemListId[$tool->getId()] = $tool->getMenuItemId();
			}

			$subgroups = $tool->getSubgroups();

			foreach ($subgroups as $id => $subgroup)
			{
				if (isset($subgroup['menu_item_id'], $subgroup['enabled']) && !$subgroup['enabled'])
				{
					$this->disabledMenuItemListId[$id] = $subgroup['menu_item_id'];
				}
			}
		}

		return $this->disabledMenuItemListId;
	}

	public function changeFirstPageForAll(): void
	{
		$presetId = Option::get('intranet', 'left_menu_preset', '', SITE_ID);
		$structure = Manager::getPreset($presetId)->getStructure();
		$firstPage = $this->getAvailableFirstPage($structure);

		if ($firstPage)
		{
			Option::set('intranet', 'left_menu_first_page', $firstPage, SITE_ID);
			\CUserOptions::DeleteOptionsByName('intranet', 'left_menu_first_page_changed_' . SITE_ID);
		}
	}

	public function changeFirstPage($structure): void
	{
		$firstPage = '';

		foreach ($structure as $menuItem)
		{
			if ($menuItem['ID'] && $this->checkAvailabilityByMenuId($menuItem['ID']))
			{
				if (isset($menuItem['PARAMS']['real_link']) && is_string($menuItem['PARAMS']['real_link']))
				{
					$firstPage = $menuItem['PARAMS']['real_link'];

					break;
				}

				if (!$firstPage && isset($menuItem['LINK']) && is_string($menuItem['LINK']))
				{
					$firstPage = $menuItem['LINK'];

					break;
				}
			}
		}

		if ($firstPage)
		{
			\CUserOptions::SetOption('intranet', 'left_menu_first_page_' . SITE_ID, $firstPage);
			\CUserOptions::SetOption('intranet', 'left_menu_first_page_changed_' . SITE_ID, 'Y');
		}
	}

	public function isNeedCheckFirstPage(): bool
	{
		$isFirstPageChanged = \CUserOptions::GetOption('intranet', 'left_menu_first_page_changed_' . SITE_ID, 'N') === 'Y';
		$userSortedItems = \CUserOptions::GetOption('intranet', 'left_menu_sorted_items_' . SITE_ID, 'N') !== 'N';
		$userPreset = \CUserOptions::GetOption('intranet', 'left_menu_preset_' . SITE_ID, '');
		$sitePreset = Option::get('intranet', 'left_menu_preset', '', SITE_ID);

		return !$isFirstPageChanged && ($userSortedItems || ($userPreset && $userPreset !== $sitePreset));
	}

	public function getAvailableFirstPage($structure): ?string
	{
		$menuId = $this->getAvailableMenuIdFromStructure($structure['shown']);
		$availableUrl = $this->getUrlByMenuId($menuId);

		if (!$availableUrl)
		{
			$menuUser = new \Bitrix\Intranet\UI\LeftMenu\User();

			foreach (Manager::getPreset()->getItems() as $item)
			{
				$customItem = $item->prepareData($menuUser);

				if (isset($customItem['ID']) && is_string($customItem['LINK']) && $this->checkAvailabilityByMenuId($customItem['ID']))
				{
					$availableUrl = $customItem['LINK'];

					break;
				}
			}
		}

		return $availableUrl;
	}

	public function getUrlByMenuId(string $menuItemId): ?string
	{
		$tools = $this->getToolList();

		foreach ($tools as $id => $tool)
		{
			if ($tool->getMenuItemId() === $menuItemId || $id === $menuItemId)
			{
				return $tool->getLeftMenuPath();
			}

			$subgroupIds = $tool->getSubgroupsIds();
			$subgroupPaths = $tool->getSubgroupSettingsPath();

			foreach ($subgroupIds as $subgroupId => $subgroupMenuId)
			{
				if ($subgroupMenuId === $menuItemId)
				{
					return $subgroupPaths[$subgroupId];
				}
			}
		}

		return null;
	}

	private function getAvailableMenuIdFromStructure(array $structure): ?string
	{
		foreach ($structure as $key => $menuItem)
		{
			if (is_array($menuItem))
			{
				if (is_string($key) && $this->checkAvailabilityByMenuId($key))
				{
					return $key;
				}
			}
			elseif (is_string($menuItem) && $this->checkAvailabilityByMenuId($menuItem))
			{
				return $menuItem;
			}
		}

		return null;
	}
}