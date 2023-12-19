<?php

namespace Bitrix\Calendar\Core\Queue\Processor;

use Bitrix\Calendar\Core\Base\BaseException;
use Bitrix\Calendar\Core\Queue\Interfaces;
use Bitrix\Calendar\Core\Queue\Message\Message;
use Bitrix\Calendar\Core\Queue\Producer\Producer;
use Bitrix\Calendar\ICal\MailInvitation\InvitationInfo;
use Bitrix\Calendar\ICal\MailInvitation\SenderInvitation;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\LoaderException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\NotImplementedException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SiteTable;
use Bitrix\Main\SystemException;
use Bitrix\Main\Text\Emoji;
use TypeError;

class SendingEmailNotification implements Interfaces\Processor
{
	private const MAX_ATTEMPTS_INVITATION = 3;
	private const INCREMENT_COUNTER_INVITATION = 1;

	/**
	 * @throws ObjectPropertyException
	 * @throws NotImplementedException
	 * @throws LoaderException
	 * @throws ArgumentException
	 * @throws SystemException
	 */
	public function process(Interfaces\Message $message): string
	{
		$notificationInfo = $message->getBody();

		if (!isset($notificationInfo['requestInvitation']))
		{
			return self::REJECT;
		}

		try
		{
			$unserializeNotificationInfo = $this->getMailInfo($notificationInfo['requestInvitation']);
		}
		catch (TypeError $e)
		{
			return self::REJECT;
		}

		if (!$this->isNotificationFieldsCorrect($unserializeNotificationInfo))
		{
			return self::REJECT;
		}

		$counterInvitation = $unserializeNotificationInfo['counterInvitations'] ?? 0;
		$counterInvitation += self::INCREMENT_COUNTER_INVITATION;

		$invitationInfo = new InvitationInfo(
			$unserializeNotificationInfo['eventId'],
			$unserializeNotificationInfo['addresserId'],
			$unserializeNotificationInfo['receiverId'],
			$unserializeNotificationInfo['type'],
			$unserializeNotificationInfo['changeFields'] ?? [],
			$counterInvitation,
		);

		$notification = $invitationInfo->getSenderInvitation();

		if (is_null($notification))
		{
			return self::REJECT;
		}

		$failSent = [];
		$this->setLanguageId();
		$notification->incrementCounterInvitations();

		if ($notification->send())
		{
			$notification->executeAfterSuccessfulInvitation();

			return self::ACK;
		}

		if ($notification->getCountAttempsSend() < self::MAX_ATTEMPTS_INVITATION)
		{
			self::sendMessageToQueue($unserializeNotificationInfo);

			return self::ACK;
		}

		$failSent[$notification->getEventParentId()] = $this->getDataForNotify($notification);
		$this->sendFailSendNotify($failSent);

		return self::REJECT;
	}

	private function isNotificationFieldsCorrect (array $notification): bool
	{
		return (
			isset($notification['eventId'])
			|| isset($notification['addresserId'])
			|| isset($notification['receiverId'])
			|| isset($notification['type'])
		);
	}

	private function getMailInfo(string $jsonNotificationInfo): mixed
	{
		$notification = str_replace("\'", "'", $jsonNotificationInfo);
		$notification = Emoji::decode($notification);

		return unserialize($notification, ['allowed_classes' => false]);
	}

	private function sendFailSendNotify(array $failSent): void
	{
		foreach ($failSent as $parentId => $item)
		{
			if (isset($item[0]))
			{
				$item = $item[0];
			}
			\CCalendarNotify::Send([
				'mode' => 'fail_ical_invite',
				'eventId' => $parentId,
				'userId' => $item['userId'],
				'guestId' => $item['userId'],
				'items' => $item,
				'name' => $item['name'],
				'icalMethod' => $item['method'],
			]);
		}
	}

	private function getDataForNotify(SenderInvitation $sender): array
	{
		$event = $sender->getEvent();
		return [
			'email' => $sender->getReceiver()->getEmail(),
			'eventId' => $event['PARENT_ID'],
			'name' => $event['NAME'],
			'userId' => $event['MEETING_HOST'],
			'method' => $sender->getMethod(),
		];
	}

	/**
	 * @throws ArgumentException
	 * @throws ObjectPropertyException
	 * @throws SystemException
	 */
	private function setLanguageId(): void
	{
		$siteDb = SiteTable::getById(SITE_ID);
		if ($site = $siteDb->fetchObject())
		{
			Loc::setCurrentLang($site->getLanguageId());
		}
	}

	/**
	 * @throws BaseException
	 * @throws SystemException
	 * @throws ArgumentException
	 */
	public static function sendMessageToQueue(array $invitation): void
	{
		$serializedData = str_replace("'", "\'", serialize($invitation));
		$message = (new Message())
			->setBody(['requestInvitation' => $serializedData])
			->setRoutingKey('calendar:sending_email_notification')
		;

		(new Producer())->send($message);
	}

	/**
	 * @param SenderInvitation[] $invitations
	 * @return void
	 * @throws ArgumentException
	 * @throws SystemException
	 */
	public static function sendBatchOfMessagesToQueue(array $invitations): void
	{
		$messages = [];

		if (!is_iterable($invitations))
		{
			AddMessage2Log('Ical senders collection is not iterable', 'calendar', 4);
			return;
		}

		foreach ($invitations as $invitation)
		{
			$serializedData = str_replace("'", "\'", serialize($invitation));
			$messages[] = (new Message())
				->setBody(['requestInvitation' => $serializedData])
				->setRoutingKey('calendar:sending_email_notification')
			;
		}

		(new Producer())->sendBatch($messages);
	}
}