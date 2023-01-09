<?php

class CCrmActivityDbResult extends CDBResult
{
	private $selectFields = null;
	private $selectCommunications = false;

	private ?array $records = null;
	private int $currentRecordsIndex = 0;

	public function __construct($res, $selectFields = [])
	{
		parent::__construct($res);

		if (!is_array($selectFields))
		{
			$selectFields = [];
		}
		$this->selectFields = $selectFields;
		$this->selectCommunications = in_array('COMMUNICATIONS', $selectFields, true);
	}

	public function Fetch()
	{
		if (
			in_array('IS_INCOMING_CHANNEL', $this->selectFields, true)
			&& in_array('ID', $this->selectFields, true)
		)
		{
			return $this->getNextFetchedRecord();
		}

		return $this->fetchOneRecord();
	}

	private function getNextFetchedRecord()
	{
		return $this->getAllRecords()[$this->currentRecordsIndex++] ?? false;
	}
	private function getAllRecords()
	{
		if (is_array($this->records))
		{
			return $this->records;
		}

		$this->records = [];
		$this->currentRecordsIndex = 0;
		while ($record = $this->fetchOneRecord())
		{
			$this->records[$record['ID']] = $record;
		}
		$incomingChannelRecords = array_column(
			\Bitrix\Crm\Activity\Entity\IncomingChannelTable::query()
				->whereIn('ACTIVITY_ID', array_keys($this->records))
				->setSelect(['ACTIVITY_ID'])
				->fetchAll()
			,
			'ACTIVITY_ID'
		);
		foreach ($this->records as $id => $record)
		{
			$this->records[$id]['IS_INCOMING_CHANNEL'] = (in_array($id, $incomingChannelRecords, false) ? 'Y' : 'N');
		}
		$this->records = array_values($this->records);

		return $this->records;
	}

	private function fetchOneRecord()
	{
		if ($result = parent::Fetch())
		{
			if (array_key_exists('SETTINGS', $result))
			{
				$result['SETTINGS'] = is_string($result['SETTINGS']) ? unserialize($result['SETTINGS'],
					['allowed_classes' => false]) : [];
			}

			if (array_key_exists('PROVIDER_PARAMS', $result))
			{
				$result['PROVIDER_PARAMS'] = is_string($result['PROVIDER_PARAMS'])
					? unserialize($result['PROVIDER_PARAMS'], ['allowed_classes' => false]) : [];
			}

			if ($this->selectCommunications)
			{
				$result['COMMUNICATIONS'] = CCrmActivity::GetCommunications($result['ID']);
			}

			if (isset($result['SUBJECT']))
			{
				$result['SUBJECT'] = \Bitrix\Main\Text\Emoji::decode($result['SUBJECT']);
			}
			if (isset($result['DESCRIPTION']))
			{
				$result['DESCRIPTION'] = \Bitrix\Main\Text\Emoji::decode($result['DESCRIPTION']);
			}
		}
		return $result;
	}
}
