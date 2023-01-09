<?php

namespace Bitrix\Disk\Shortcut;

final class Url
{
	const URL_TYPE_SHOW = 'show';
	const URL_TYPE_PREVIEW = 'preview';
	const URL_TYPE_DOWNLOAD = 'download';

	/**
	 * Returns internal url to doanload, show full or show preview file.
	 *
	 * @param string               $type Result type (download, show full or show preview).
	 * @param \Bitrix\Disk\File    $fileModel File to process.
	 * @return string
	 */
	public static function get($type, \Bitrix\Disk\File $fileModel)
	{
		$result = '';

		if (!in_array($type, array(self::URL_TYPE_DOWNLOAD, self::URL_TYPE_SHOW, self::URL_TYPE_PREVIEW)))
			return $result;

		$urlManager = \Bitrix\Main\Engine\UrlManager::getInstance();

		$isImage = \Bitrix\Disk\TypeFile::isImage($fileModel->getName());

		if ($type == self::URL_TYPE_SHOW)
		{
			if ($isImage)
			{
				$result = $urlManager->create('disk.api.file.showImage', [
					'humanRE' => 1,
					'fileId' => $fileModel->getId(),
					'fileName' => $fileModel->getName()
				])->getUri();
			}
			else
			{
				$result = $urlManager->create('disk.api.file.download', [
					'humanRE' => 1,
					'fileId' => $fileModel->getId(),
					'fileName' => $fileModel->getName()
				])->getUri();
			}
		}
		else if ($type == self::URL_TYPE_PREVIEW)
		{
			if (!($isImage || $fileModel->getPreviewId()))
			{
				return $result;
			}

			if ($fileModel->getPreviewId())
			{
				$linkType = 'disk.api.file.showPreview';
				$fileName = 'preview.jpg';
			}
			else
			{
				$linkType = 'disk.api.file.showImage';
				$fileName = $fileModel->getName();
			}

			$result = $urlManager->create($linkType, [
				'humanRE' => 1,
				'width' => 640,
				'height' => 640,
				'signature' => \Bitrix\Disk\Security\ParameterSigner::getImageSignature($fileModel->getId(), 640, 640),
				'fileId' => $fileModel->getId(),
				'fileName' => $fileName
			])->getUri();
		}
		else if ($type == self::URL_TYPE_DOWNLOAD)
		{
			$result = $urlManager->create('disk.api.file.download', [
				'humanRE' => 1,
				'fileId' => $fileModel->getId(),
				'fileName' => $fileModel->getName()
			])->getUri();
		}

		return $result;
	}
}