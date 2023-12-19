<?php

namespace Bitrix\Im\V2\Chat;

use Bitrix\Im\V2\Chat;
use Bitrix\Im\V2\Chat\EntityLink\CalendarType;
use Bitrix\Im\V2\Chat\EntityLink\CrmType;
use Bitrix\Im\V2\Chat\EntityLink\MailType;
use Bitrix\Im\V2\Chat\EntityLink\SonetType;
use Bitrix\Im\V2\Chat\EntityLink\TasksType;
use Bitrix\Im\V2\Common\ContextCustomer;
use Bitrix\Im\V2\Rest\RestConvertible;
use Bitrix\Im\V2\Result;
use Bitrix\Main\Application;
use Bitrix\Main\Loader;

class EntityLink implements RestConvertible
{
	use ContextCustomer;

	public const TYPE_TASKS = 'TASKS';
	public const TYPE_SONET = 'SONET_GROUP';
	public const TYPE_CRM = 'CRM';
	public const TYPE_MAIL = 'MAIL';

	protected const HAS_URL = false;

	private const CACHE_TTL = 18144000;

	protected int $chatId;
	protected string $id = '';
	protected string $type = '';
	protected string $url = '';

	private function __construct()
	{
	}

	public static function getInstanceByChat(Chat $chat): self
	{
		return static::getInstance($chat->getEntityType() ?? '', $chat->getEntityId() ?? '', $chat->getId() ?? 0);
	}

	public static function getInstance(string $type, string $id, int $chatId): self
	{
		if ($type === self::TYPE_SONET && Loader::includeModule('socialnetwork'))
		{
			$instance = new SonetType();
		}
		elseif ($type === self::TYPE_TASKS && Loader::includeModule('tasks'))
		{
			$instance = new TasksType();
		}
		elseif (Loader::includeModule('calendar') && $type === \CCalendar::CALENDAR_CHAT_ENTITY_TYPE)
		{
			$instance = new CalendarType();
		}
		elseif ($type === self::TYPE_CRM && Loader::includeModule('crm'))
		{
			$instance = new CrmType();
		}
		elseif ($type === self::TYPE_MAIL && Loader::includeModule('mail'))
		{
			$instance = new MailType();
		}
		else
		{
			$instance = new self();
		}

		$instance->type = $type;
		$instance->id = $id;
		$instance->chatId = $chatId;
		$instance->fillUrl();

		return $instance;
	}

	private function fillUrl(): void
	{
		if (!static::HAS_URL)
		{
			return;
		}

		$cache = Application::getInstance()->getCache();
		if ($cache->initCache(self::CACHE_TTL, $this->getCacheId(), $this->getCacheDir()))
		{
			$cachedEntityUrl = $cache->getVars();

			if (!is_array($cachedEntityUrl))
			{
				$cachedEntityUrl = [];
			}

			$this->url = $cachedEntityUrl['url'] ?? '';
			return;
		}

		$this->url = $this->getUrl();
		$cache->startDataCache();
		$cache->endDataCache(['url' => $this->url]);
	}

	private function getCacheDir(): string
	{
		$cacheSubDir = $this->chatId % 100;

		return "/bx/imc/chatentitylink/1/{$cacheSubDir}/{$this->chatId}";
	}

	private function getCacheId(): string
	{
		return "chat_entity_link_{$this->chatId}";
	}

	protected function getUrl(): string
	{
		return '';
	}

	public static function getRestEntityName(): string
	{
		return 'entityLink';
	}

	public function toRestFormat(array $option = []): array
	{
		return [
			'id' => $this->id,
			'type' => $this->type,
			'url' => $this->url,
		];
	}

	/**
	 * @deprecated
	 * @see \Bitrix\Im\V2\Chat\EntityLink::toRestFormat
	 */
	public function toArray(array $options = []): array
	{
		return [
			'ID' => $this->id,
			'TYPE' => $this->type,
			'URL' => $this->url,
		];
	}
}