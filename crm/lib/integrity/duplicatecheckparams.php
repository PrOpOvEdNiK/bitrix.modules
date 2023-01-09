<?php
namespace Bitrix\Crm\Integrity;
use Bitrix\Main;
//IncludeModuleLangFile(__FILE__);
class DuplicateCheckParams
{
	protected $fieldNames = array();
	protected $userID = 0;
	protected $enablePermissionCheck = false;

	public function __construct($fieldNames = array(), $userID = 0, $enablePermissionCheck = false)
	{
		$this->setFieldNames($fieldNames);
		$this->setUserID($userID);
		$this->enablePermissionCheck($enablePermissionCheck);
	}

	public function setFieldNames(array $fieldNames)
	{
		$this->fieldNames = $fieldNames;
	}
	public function getUserID()
	{
		return $this->userID;
	}
	public function setUserID($userID)
	{
		if(!is_int($userID))
		{
			throw new Main\ArgumentTypeException('userID', 'integer');
		}
		$this->userID = $userID > 0 ? $userID : 0;
	}
	public function isPermissionCheckEnabled()
	{
		return $this->enablePermissionCheck;
	}
	public function enablePermissionCheck($enable)
	{
		$this->enablePermissionCheck = (bool)$enable;
	}
	public function getFieldNames()
	{
		return $this->fieldNames;
	}
}