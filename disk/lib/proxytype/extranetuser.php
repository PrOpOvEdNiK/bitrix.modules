<?php

namespace Bitrix\Disk\ProxyType;

use Bitrix\Main\Localization\Loc;
use CExtranet;

Loc::loadMessages(__FILE__);

class ExtranetUser extends User
{
	/**
	 * Get name of entity (ex. user last name + first name, group name, etc)
	 * By default: get title
	 * @return string
	 */
	public function getEntityUrl()
	{
		/** @noinspection PhpDynamicAsStaticMethodCallInspection */
		$userPage = \COption::getOptionString("socialnetwork", "user_page", false, CExtranet::getExtranetSiteID());
		if(!$userPage)
		{
			$userPage = '/extranet/contacts/personal/';
		}

		return $userPage . 'user/' .  $this->entityId . '/';
	}
}