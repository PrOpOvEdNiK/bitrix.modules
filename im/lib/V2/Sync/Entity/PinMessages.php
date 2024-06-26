<?php

namespace Bitrix\Im\V2\Sync\Entity;

use Bitrix\Im\V2\Link\Pin\PinCollection;
use Bitrix\Im\V2\Rest\RestAdapter;
use Bitrix\Im\V2\Sync\Entity;
use Bitrix\Im\V2\Sync\Event;

class PinMessages implements Entity
{
	private array $pinIds = [];
	private array $deletedPinIds = [];

	public function add(Event $event): void
	{
		$entityId = $event->entityId;
		switch ($event->eventName)
		{
			case Event::DELETE_EVENT:
				$this->deletedPinIds[$entityId] = $entityId;
				break;
			case Event::ADD_EVENT:
				$this->pinIds[$entityId] = $entityId;
				break;
		}
	}

	public function getData(): array
	{
		$fullPin = new PinCollection($this->pinIds);

		return [
			'addedPins' => (new RestAdapter($fullPin))->toRestFormat(),
			'deletedPins' => $this->deletedPinIds,
		];
	}
}