<?php

namespace Bitrix\Tasks\Member\Role;

use Bitrix\Tasks\Access\Role\RoleDictionary;
use Bitrix\Tasks\Member\MemberManager;

class Directors extends MemberManager
{
	public function getRole(): string
	{
		return RoleDictionary::ROLE_DIRECTOR;
	}
}