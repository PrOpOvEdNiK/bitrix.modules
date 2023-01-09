<?php

namespace Bitrix\Disk\Uf;

use Bitrix\Disk\Ui;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;

Loc::loadMessages(__FILE__);

final class ListsWorkflowConnector extends StubConnector
{
	public function canRead($userId)
	{
		if(!Loader::includeModule("lists"))
		{
			return false;
		}

		$iblockId = $this->entityId;
		$iblockQuery = \CIBlock::getList(
			array(),
			array("ID" => $iblockId)
		);
		$iblock = $iblockQuery->fetch();
		$listPerm = \CListPermissions::checkAccess(
			$this->getUser(),
			$iblock['IBLOCK_TYPE_ID'],
			$iblockId
		);
		if($listPerm < 0)
		{
			return false;
		}
		elseif(
			$listPerm < \CListPermissions::CAN_READ &&
			!(
				\CIBlockRights::userHasRightTo($iblockId, $iblockId, "element_read")
				|| \CIBlockSectionRights::userHasRightTo($iblockId, 0, "section_element_bind")
			)
		)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	public function canUpdate($userId)
	{
		return false;
	}
}
