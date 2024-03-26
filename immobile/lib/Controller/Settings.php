<?php

namespace Bitrix\ImMobile\Controller;

class Settings extends \Bitrix\Main\Engine\Controller
{
	public function getAction(): array
	{
		return [
			'IS_BETA_AVAILABLE' => \Bitrix\ImMobile\Settings::isBetaAvailable(),
			'IS_COPILOT_MOBILE_BETA_AVAILABLE' => \Bitrix\ImMobile\Settings::isCopilotMobileBetaEnabled(),
			'IS_COPILOT_AVAILABLE' => \Bitrix\ImMobile\Settings::isCopilotEnabled(),
			'IS_CHAT_M1_ENABLED' => \Bitrix\ImMobile\Settings::isChatM1Enabled(),
			'IS_CHAT_LOCAL_STORAGE_AVAILABLE' => \Bitrix\ImMobile\Settings::isChatLocalStorageAvailable(),
		];
	}

	public function setCopilotMobileBetaAction(string $value): bool
	{
		$value = $value === 'Y' ? 'Y' : 'N';
		return \Bitrix\ImMobile\Settings::setCopilotMobileBeta($value);
	}
}
