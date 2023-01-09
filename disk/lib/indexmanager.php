<?php

namespace Bitrix\Disk;

use Bitrix\Disk\Internals\Error\ErrorCollection;
use Bitrix\Disk\Internals\SimpleRightTable;
use Bitrix\Disk\ProxyType\Group;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;
use CFile;
use CSearch;

final class IndexManager
{
	/** @var  ErrorCollection */
	protected $errorCollection;

	/**
	 * Constructor IndexManager.
	 */
	public function __construct()
	{
		$this->errorCollection = new ErrorCollection;
	}

	/**
	 * Runs index by file.
	 * @param File $file Target file.
	 * @throws \Bitrix\Main\ArgumentNullException
	 * @throws \Bitrix\Main\LoaderException
	 * @return void
	 */
	public function indexFile(File $file)
	{
		if(!Loader::includeModule('search'))
		{
			return;
		}
		//here we place configuration by Module (Options). Example, we can deactivate index for big files in Disk.
		if(!Configuration::allowIndexFiles())
		{
			return;
		}
		$storage = $file->getStorage();
		if(!$storage)
		{
			return;
		}
		if(!$storage->getProxyType()->canIndexBySearch())
		{
			return;
		}

		$searchData = array(
			'LAST_MODIFIED' => $file->getUpdateTime()?: $file->getCreateTime(),
			'TITLE' => $file->getName(),
			'PARAM1' => $file->getStorageId(),
			'PARAM2' => $file->getParentId(),
			'SITE_ID' => $storage->getSiteId()?: SITE_ID,
			'URL' => $this->getDetailUrl($file),
			'PERMISSIONS' => $this->getSimpleRights($file),
			//CSearch::killTags
			'BODY' => $this->getFileContent($file),
		);
		if($storage->getProxyType() instanceof Group)
		{
			$searchData['PARAMS'] = array(
				'socnet_group' => $storage->getEntityId(),
				'entity' => 'socnet_group',
			);
		}

		/** @noinspection PhpDynamicAsStaticMethodCallInspection */
		CSearch::index(Driver::INTERNAL_MODULE_ID, $this->getItemId($file), $searchData, true);
	}

	/**
	 * Runs index by folder.
	 * @param Folder $folder Target folder.
	 * @throws \Bitrix\Main\LoaderException
	 * @return void
	 */
	public function indexFolder(Folder $folder)
	{
		if(!Loader::includeModule('search'))
		{
			return;
		}
		//here we place configuration by Module (Options). Example, we can deactivate index for big files in Disk.
		if(!Configuration::allowIndexFiles())
		{
			return;
		}
		$storage = $folder->getStorage();
		if(!$storage)
		{
			return;
		}
		if(!$storage->getProxyType()->canIndexBySearch())
		{
			return;
		}

		$searchData = array(
			'LAST_MODIFIED' => $folder->getUpdateTime()?: $folder->getCreateTime(),
			'TITLE' => $folder->getName(),
			'PARAM1' => $folder->getStorageId(),
			'PARAM2' => $folder->getParentId(),
			'SITE_ID' => $storage->getSiteId()?: SITE_ID,
			'URL' => $this->getDetailUrl($folder),
			'PERMISSIONS' => $this->getSimpleRights($folder),
			//CSearch::killTags
			'BODY' => $this->getFolderContent($folder),
		);
		if($storage->getProxyType() instanceof Group)
		{
			$searchData['PARAMS'] = array(
				'socnet_group' => $storage->getEntityId(),
				'entity' => 'socnet_group',
			);
		}

		/** @noinspection PhpDynamicAsStaticMethodCallInspection */
		CSearch::index(Driver::INTERNAL_MODULE_ID, $this->getItemId($folder), $searchData, true);
	}

	/**
	 * Changes index after rename.
	 * @param BaseObject $object Target file or folder.
	 * @throws \Bitrix\Main\LoaderException
	 * @return void
	 */
	public function changeName(BaseObject $object)
	{
		if(!Loader::includeModule('search'))
		{
			return;
		}
		//here we place configuration by Module (Options). Example, we can deactivate index for big files in Disk.
		if(!Configuration::allowIndexFiles())
		{
			return;
		}
		$storage = $object->getStorage();
		if(!$storage)
		{
			return;
		}
		if(!$storage->getProxyType()->canIndexBySearch())
		{
			return;
		}

		if($object instanceof Folder)
		{
			$this->indexFolder($object);
		}
		elseif($object instanceof File)
		{
			$this->indexFile($object);
		}
	}

	/**
	 * Delete information from Search by concrete file or folder.
	 * @param BaseObject $object Target object.
	 * @throws \Bitrix\Main\LoaderException
	 */
	public function dropIndex(BaseObject $object)
	{
		if(!Loader::includeModule('search'))
		{
			return;
		}
		/** @noinspection PhpDynamicAsStaticMethodCallInspection */
		CSearch::deleteIndex(Driver::INTERNAL_MODULE_ID, $this->getItemId($object));
	}

	/**
	 * Recalculate rights in Search if it needs.
	 * @param BaseObject $object Target object (can be folder or file).
	 * @throws \Bitrix\Main\LoaderException
	 * @return void
	 */
	public function recalculateRights(BaseObject $object)
	{
		if(!Loader::includeModule('search'))
		{
			return;
		}
		if($object instanceof File)
		{
			/** @noinspection PhpDynamicAsStaticMethodCallInspection */
			CSearch::changePermission(
				Driver::INTERNAL_MODULE_ID,
				$this->getSimpleRights($object),
				$this->getItemId($object)
			);
		}
		elseif($object instanceof Folder)
		{
			/** @noinspection PhpDynamicAsStaticMethodCallInspection */
			CSearch::changePermission(
				Driver::INTERNAL_MODULE_ID,
				$this->getSimpleRights($object),
				false,
				$object->getStorageId(),
				$object->getId()
			);
			/** @noinspection PhpDynamicAsStaticMethodCallInspection */
			CSearch::changePermission(
				Driver::INTERNAL_MODULE_ID,
				$this->getSimpleRights($object),
				$this->getItemId($object)
			);
		}
	}

	/**
	 * Event listener which return url for resource by fields.
	 * @param array $fields Fields from search module.
	 * @return string
	 */
	public static function onSearchGetUrl($fields)
	{
		if(!is_array($fields))
		{
			return '';
		}
		if($fields["MODULE_ID"] !== "disk" || substr($fields["URL"], 0, 1) !== "=")
		{
			return $fields["URL"];
		}

		parse_str(ltrim($fields["URL"], "="), $data);
		if(empty($data['ID']))
		{
			return '';
		}
		$object = BaseObject::loadById($data['ID']);
		if(!$object)
		{
			return '';
		}
		$pathFileDetail = self::getDetailUrl($object);
		\CSearch::update($fields['ID'], array('URL' => $pathFileDetail));

		return $pathFileDetail;
	}


	/**
	 * Search re-index handler.
	 * @param array  $nextStepData Array with data about step.
	 * @param null   $searchObject Search object.
	 * @param string $method Method.
	 * @return array|bool
	 */
	public static function onSearchReindex($nextStepData = array(), $searchObject = null, $method = "")
	{
		$result = array();
		$filter = array(
			'!PARENT_ID' => null,
		);

		if(isset($nextStepData['MODULE']) && ($nextStepData['MODULE'] === 'disk') && !empty($nextStepData['ID']))
		{
			$filter['>ID'] = self::getObjectIdFromItemId($nextStepData['ID']);
		}
		else
		{
			$filter['>ID'] = 0;
		}

		static $self = null;
		if($self === null)
		{
			$self = Driver::getInstance()->getIndexManager();
		}

		$query = BaseObject::getList(array('filter' => $filter, 'order' => array('ID' => 'ASC')));
		while($fileData = $query->fetch())
		{
			/** @var BaseObject $object */
			$object = BaseObject::buildFromArray($fileData);
			if(!$object->getStorage())
			{
				continue;
			}

			$searchData = array(
				'ID' => self::getItemId($object),
				'LAST_MODIFIED' => $object->getUpdateTime() ?: $object->getCreateTime(),
				'TITLE' => $object->getName(),
				'PARAM1' => $object->getStorageId(),
				'PARAM2' => $object->getParentId(),
				'SITE_ID' => $object->getStorage()->getSiteId()?: SITE_ID,
				'URL' => self::getDetailUrl($object),
				'PERMISSIONS' => $self->getSimpleRights($object),
				//CSearch::killTags
				'BODY' => $self->getObjectContent($object),
			);

			if($searchObject)
			{
				$indexResult = call_user_func(array($searchObject, $method), $searchData);
				if(!$indexResult)
				{
					return $searchData["ID"];
				}
			}
			else
			{
				$result[] = $searchData;
			}
		}

		if($searchObject)
		{
			return false;
		}

		return $result;
	}

	private function getObjectContent(BaseObject $object)
	{
		if($object instanceof File)
		{
			return $this->getFileContent($object);
		}
		if($object instanceof Folder)
		{
			return $this->getFolderContent($object);
		}

		return '';
	}

	private function getFolderContent(Folder $folder)
	{
		return strip_tags($folder->getName()) . "\r\n";
	}

	private function getFileContent(File $file)
	{
		static $maxFileSize = null;
		if(!isset($maxFileSize))
		{
			$maxFileSize = Option::get("search", "max_file_size", 0) * 1024;
		}

		$searchData = '';
		$searchData .= strip_tags($file->getName()) . "\r\n";
		$searchData .= strip_tags($file->getCreateUser()->getFormattedName()) . "\r\n";


		if($maxFileSize > 0 && $file->getSize() > $maxFileSize)
		{
			return $searchData;
		}

		$searchDataFile = array();
		$fileArray = null;

		//improve work with s3
		if(!ModuleManager::isModuleInstalled('bitrix24') || TypeFile::isDocument($file))
		{
			$fileArray = CFile::makeFileArray($file->getFileId());
		}

		if($fileArray && $fileArray['tmp_name'])
		{
			$fileAbsPath = \CBXVirtualIo::getInstance()->getLogicalName($fileArray['tmp_name']);
			foreach(GetModuleEvents('search', 'OnSearchGetFileContent', true) as $event)
			{
				if($searchDataFile = executeModuleEventEx($event, array($fileAbsPath, getFileExtension($fileArray['name']))))
				{
					break;
				}
			}

			return is_array($searchDataFile)? $searchData  . "\r\n" . $searchDataFile['CONTENT'] : $searchData;
		}

		return $searchData;
	}

	private function getSimpleRights(BaseObject $object)
	{
		$query = SimpleRightTable::getList(array(
			'select' => array('ACCESS_CODE'),
			'filter' => array(
				'OBJECT_ID' => $object->getId(),
			)
		));
		$permissions = array();
		while($row = $query->fetch())
		{
			$permissions[] = $row['ACCESS_CODE'];
		}

		return $permissions;
	}

	/**
	 * Getting id for module search.
	 * @param BaseObject $object
	 * @return string
	 */
	private static function getItemId(BaseObject $object)
	{
		if($object instanceof File)
		{
			return 'FILE_' . $object->getId();
		}
		return 'FOLDER_' . $object->getId();
	}

	private static function getObjectIdFromItemId($itemId)
	{
		if(substr($itemId, 0, 5) === 'FILE_')
		{
			return substr($itemId, 5);
		}
		return substr($itemId, 7);
	}

	private static function getDetailUrl(BaseObject $object)
	{
		$detailUrl = '';
		$urlManager = Driver::getInstance()->getUrlManager();
		if($object instanceof File)
		{
			$detailUrl = $urlManager->getUrlFocusController('openFileDetail', array('fileId' => $object->getId()));
		}
		elseif($object instanceof Folder)
		{
			$detailUrl = $urlManager->getUrlFocusController('openFolderList', array('folderId' => $object->getId()));
		}

		return $detailUrl;
	}
} 