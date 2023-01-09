<?php

class CHuaweiPushKitService extends CPushService {

	function getMessageInstance($token)
	{
		return new CHuaweiPushKitMessage($token);
	}

	public static function shouldBeSent($messageRowData)
	{
		return true;
	}

	public function getBatch($messages)
	{
		$arGroupedMessages = self::getGroupedByAppID($messages);
		if (is_array($arGroupedMessages) && count($arGroupedMessages) <= 0)
		{
			return false;
		}

		return $this->getBatchWithModifier($arGroupedMessages, ";6;");
	}
}

class CHuaweiPushKitMessage extends CGoogleMessage {

	public function getBatch(): string
	{
		$data = $this->getPayload();
		$batch = "Content-type: application/json\r\n";
		$batch .= "Content-length: " . strlen($data) . "\r\n";
		$batch .= "\r\n";
		$batch .= $data;

		return base64_encode($batch);
	}

	public function getPayload(): string
	{
		$customData = json_encode([
			'contentTitle' => $this->title,
			"contentText" => $this->text,
			"badge" => $this->badge,
			"messageParams" => $this->customProperties,
			"category" => $this->getCategory(),
			"sound" => $this->getSound(),
		], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE);

		$payload = [
			'message'=> [
				"data" => $customData,
				'android' => [
					'ttl'=> (string)$this->expiryValue,
				],
				"token" => $this->deviceTokens
			]
		];

		return $this->strippedPayload($payload);
	}
}