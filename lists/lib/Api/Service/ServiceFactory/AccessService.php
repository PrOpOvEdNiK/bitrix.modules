<?php

namespace Bitrix\Lists\Api\Service\ServiceFactory;

use Bitrix\Lists\Api\Response\CheckPermissionsResponse;
use Bitrix\Lists\Security\ElementRight;
use Bitrix\Lists\Security\IblockRight;

final class AccessService extends \Bitrix\Lists\Api\Service\AccessService
{
	public function canUserReadCatalog(): CheckPermissionsResponse
	{
		return $this->hasUserMinIBlockTypePermission();
	}

	public function canUserGetElementList(): CheckPermissionsResponse
	{
		return $this->hasUserMinIBlockTypePermission();
	}

	public function canUserReadIBlock(int $iBlockId): CheckPermissionsResponse
	{
		$response = new CheckPermissionsResponse();

		$checkPermissionsResponse = $this->checkIBlockPermission($iBlockId, IblockRight::READ);
		$response->fillFromResponse($checkPermissionsResponse);

		return $response;
	}

	public function canUserReadElement(int $elementId, int $sectionId = 0): CheckPermissionsResponse
	{
		$response = new CheckPermissionsResponse();

		$checkPermissionsResponse = $this->checkElementPermission($elementId, $sectionId);
		$response->fillFromResponse($checkPermissionsResponse);

		if ($response->isSuccess())
		{
			$elementRight = $checkPermissionsResponse->getElementRight();

			if (
				($elementId === 0 && !$elementRight?->canAdd())
				|| ($elementId !== 0 && !$elementRight?->canRead())
			)
			{
				$response->addError(self::getAccessDeniedError());
			}
		}

		return $response;
	}

	public function canUserAddElement(int $sectionId, int $iBlockId): CheckPermissionsResponse
	{
		$response = new CheckPermissionsResponse();

		$checkPermissionResponse = $this->checkElementPermission(0, $sectionId, ElementRight::ADD, $iBlockId);
		$response->fillFromResponse($checkPermissionResponse);

		return $response;
	}

	private function hasUserMinIBlockTypePermission(): CheckPermissionsResponse
	{
		$response = new CheckPermissionsResponse();

		$checkPermissionResult = $this->checkIBlockTypePermission();
		$permission = $checkPermissionResult->getPermission();

		$response
			->setPermission($permission)
			->addErrors($checkPermissionResult->getErrors())
		;

		if ($response->isSuccess() && $this->isAccessDeniedPermission($permission))
		{
			$response->addError(self::getAccessDeniedError());
		}

		return $response;
	}
}
