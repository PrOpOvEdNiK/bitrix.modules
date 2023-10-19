<?php

namespace Bitrix\Tasks\Replicator\Template\Conversion\Converters;

use Bitrix\Main\ArgumentException;
use Bitrix\Tasks\Replicator\Template\Conversion\Converter;
use Bitrix\Tasks\Replicator\Template\Repository;
use Bitrix\Tasks\Util\UserField\Task;
use Bitrix\Tasks\Util\UserField\Task\Template;

final class UFConverter implements Converter
{
	public function convert(Repository $repository): array
	{
		$template = $repository->getTemplate();
		// change inline attachments
		$taskFields = [
			'DESCRIPTION' => $template->getDescription(),
		];

		$ufTemplateController = new Template();
		$ufTaskController = new Task();
		$ufScheme = $ufTaskController::getScheme();
		foreach ($ufScheme as $fieldName => $fieldData)
		{
			// plus all user fields
			if ($ufTemplateController::isFieldExist($fieldName))
			{
				$taskFields[$fieldName] = $template->get($fieldName);
			}
		}

		try
		{
			$result = $ufTemplateController->cloneValues($taskFields, $ufTaskController, $template->getCreatedByMemberId());
		}
		catch (ArgumentException)
		{
			return [];
		}

		if (!$result->isSuccess())
		{
			return [];
		}

		return $result->getData();
	}

	public function getTemplateFieldName(): string
	{
		return 'UF_*';
	}
}