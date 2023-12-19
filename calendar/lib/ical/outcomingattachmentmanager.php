<?php


namespace Bitrix\Calendar\ICal;


use Bitrix\Calendar\ICal\Basic\{AttachmentManager, Dictionary, ICalUtil};
use Bitrix\Calendar\ICal\MailInvitation\Helper;
use Bitrix\Mail\User;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Calendar\ICal\Builder\
{
	AttendeesCollection,
	Calendar,
	Event,
	StandardObservances,
	Timezone};
use Bitrix\Calendar\Util;

class OutcomingAttachmentManager extends AttachmentManager
{
	private ?array $event = [];
	private ?AttendeesCollection $attendees;
	private ?string $attachment = '';
	private ?string $method = '';
	private ?string $uid = '';

	public function __construct($data, $attendees, $method)
	{
		$this->event = $data;
		$this->attendees = $attendees;
		$this->method = $method;
	}

	public function prepareRequestAttachment(): OutcomingAttachmentManager
	{
		$event = $this->prepareRequestEvent();
		$this->uid = isset($event['DAV_XML_ID']) ? $event['DAV_XML_ID'] : ICalUtil::getUniqId();

		$this->attachment = Calendar::createInstance()
			->setMethod(Dictionary::METHODS[$this->method])
			->setTimezones(Timezone::createInstance()
				->setTimezoneId($event['TZ_FROM'])
				->setObservance(StandardObservances::createInstance()
					->setOffsetFrom($event['TZ_FROM'])
					->setOffsetTo($event['TZ_TO'])
					->setDTStart()
				)
			)
			->addEvent(Event::createInstance($this->uid)
				->setName($event['NAME'])
				->setAttendees($this->attendees)
				->setStartsAt(Util::getDateObject($event['DATE_FROM'], $event['SKIP_TIME'], $event['TZ_FROM']))
				->setEndsAt(Util::getDateObject($event['DATE_TO'], $event['SKIP_TIME'], $event['TZ_TO']))
				->setCreatedAt(Util::getDateObject($event['CREATED'], false, $event['TZ_FROM']))
				->setDtStamp(Util::getDateObject($event['CREATED'], false, $event['TZ_FROM']))
				->setModified(Util::getDateObject($event['MODIFIED'], false, $event['TZ_FROM']))
				->setWithTimezone(!$event['SKIP_TIME'])
				->setWithTime(!$event['SKIP_TIME'])
				->setOrganizer($this->attendees[$event['MEETING_HOST']], $this->getReplyAddress())
				->setDescription($event['DESCRIPTION'])
				->setTransparent(Dictionary::TRANSPARENT[$event['ACCESSIBILITY']])
				->setRRule($event['RRULE'])
				->setExdates($event['EXDATE'])
				->setLocation($event['TEXT_LOCATION'])
				->setSequence((int)$event['VERSION'])
				->setStatus(Dictionary::INVITATION_STATUS['confirmed'])
			)
			->get();

		return $this;
	}

	public function getAttachment(): string
	{
		return $this->attachment;
	}

	public function getUid()
	{
		return $this->uid;
	}

	public function prepareReplyAttachment(): OutcomingAttachmentManager
	{
		$event = $this->event;
		$this->uid = $event['DAV_XML_ID'];

		$this->attachment = Calendar::createInstance()
			->setMethod(Dictionary::METHODS[$this->method])
			->addEvent(Event::createInstance($event['DAV_XML_ID'])
				->setName($event['NAME'])
				->setAttendees($this->attendees)
				->setStartsAt(Util::getDateObject($event['DATE_FROM'], $event['SKIP_TIME'], $event['TZ_FROM']))
				->setEndsAt($this->getEndDate($event))
				// ->setCreatedAt(Util::getDateObject($event['DATE_CREATE'], false, $event['TZ_FROM']))
				// ->setDtStamp(Helper::getIcalDateTime())
				->setDtStamp(Helper::getIcalDateTime('20230828T200641Z'))
				->setCreatedAt(Helper::getIcalDateTime('20230828T200631Z'))
				// ->setModified(Helper::getIcalDateTime())
				->setModified(Helper::getIcalDateTime('20230828T200639Z'))
				->setWithTimezone(!$event['SKIP_TIME'])
				->setWithTime(!$event['SKIP_TIME'])
				->setOrganizer(
					$event['ICAL_ORGANIZER'],
						$event['ORGANIZER_MAIL']['MAILTO'] ?? $event['ORGANIZER_MAIL']['EMAIL']
				)
				->setTransparent(Dictionary::TRANSPARENT[$event['ACCESSIBILITY']])
//				->setRRule($event['RRULE'])
// 				->setLocation($event['TEXT_LOCATION'])
				->setSequence(((int)$event['VERSION']))
				->setStatus(Dictionary::INVITATION_STATUS['confirmed'])
				->setUrl($event['URL'])
			)
			->get();

		return $this;
	}

	public function prepareCancelAttachment(): OutcomingAttachmentManager
	{
		$event = $this->event;
		$fullDay = $event['DT_SKIP_TIME'] === 'Y';

		$this->attachment = Calendar::createInstance()
			->setMethod(Dictionary::METHODS[$this->method])
			->addEvent(Event::createInstance($event['DAV_XML_ID'])
				->setName($event['NAME'])
				->setAttendees($this->attendees)
				->setStartsAt(Util::getDateObject($event['DATE_FROM'], $fullDay, $event['TZ_FROM']))
				->setEndsAt(Util::getDateObject($event['DATE_TO'], $fullDay, $event['TZ_TO']))
				->setCreatedAt(Util::getDateObject($event['DATE_CREATE'], false, $event['TZ_FROM']))
				->setDtStamp(Helper::getIcalDateTime())
				->setModified(Util::getDateObject($event['TIMESTAMP_X'], false, $event['TZ_FROM']))
				->setWithTimezone(!$fullDay)
				->setWithTime(!$fullDay)
				->setOrganizer($this->attendees[$event['MEETING_HOST']], $this->getReplyAddress())
				->setDescription($event['DESCRIPTION'])
				->setTransparent(Dictionary::TRANSPARENT[$event['ACCESSIBILITY']])
//				->setRRule($event['RRULE'])
				->setLocation($event['TEXT_LOCATION'])
				->setSequence((int)$event['VERSION'] + 1)
				->setStatus(Dictionary::INVITATION_STATUS['cancelled'])
			)
			->get();

		return $this;
	}

	private function getReplyAddress(): string
	{
		if (Loader::includeModule('mail'))
		{
			[$replyTo, $backUrl] = User::getReplyTo(
				SITE_ID,
				$this->event['OWNER_ID'],
				'ICAL_INVENT',
				$this->event['PARENT_ID'],
				SITE_ID
			);
		}

		return $replyTo;
	}

	private function prepareRequestEvent()
	{
		$event = $this->event;

		if (!empty($event['ATTACHES']))
		{
			$filesDesc = [];
			foreach ($event['ATTACHES'] as $attach)
			{
				$filesDesc[] = $attach['name'] . ' (' . $attach['link'] . ')';
			}

			if (!empty($event['DESCRIPTION']))
			{
				$event['DESCRIPTION'] .= "\r\n";
			}
			$event['DESCRIPTION'] .= Loc::getMessage('EC_FILES_TITLE') . ': ' . implode(', ', $filesDesc);
		}

		return $event;
	}

	private function getEndDate($event)
	{
		if ($event['SKIP_TIME'])
		{
			return (Util::getDateObject($event['DATE_TO']))->add('1 days');
		}
		else
		{
			return Util::getDateObject($event['DATE_TO'], false, $event['TZ_TO']);
		}
	}
}
