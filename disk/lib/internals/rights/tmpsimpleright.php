<?php


namespace Bitrix\Disk\Internals\Rights;

use Bitrix\Disk\Internals;

final class TmpSimpleRight extends Internals\Model
{
	/** @var int */
	protected $objectId;
	/** @var string */
	protected $accessCode;
	/** @var int */
	protected $sessionId;

	/**
	 * Gets the fully qualified name of table class which belongs to current model.
	 * @throws \Bitrix\Main\NotImplementedException
	 * @return string
	 */
	public static function getTableClassName()
	{
		return Table\TmpSimpleRightTable::className();
	}

	/**
	 * @return string
	 */
	public function getAccessCode()
	{
		return $this->accessCode;
	}

	/**
	 * @return int
	 */
	public function getObjectId()
	{
		return $this->objectId;
	}

	/**
	 * @return int
	 */
	public function getSessionId()
	{
		return $this->sessionId;
	}

	/**
	 * @return array
	 */
	public static function getMapAttributes()
	{
		return array(
			'ID' => 'id',
			'OBJECT_ID' => 'objectId',
			'ACCESS_CODE' => 'accessCode',
			'SESSION_ID' => 'sessionId',
		);
	}

} 