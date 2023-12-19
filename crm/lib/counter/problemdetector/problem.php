<?php

namespace Bitrix\Crm\Counter\ProblemDetector;

use Bitrix\Main\Type\Date;

class Problem
{
	public function __construct(
		private string $type,
		private int $problemCount,
		private array $records,
		private array $activities,
		private array $extra = []
	)
	{
	}

	public function type(): string
	{
		return $this->type;
	}

	public function problemCount(): int
	{
		return $this->problemCount;
	}

	public function payload(): array
	{
		return [
			'records' => $this->records,
			'activities' => $this->activities
		];
	}

	public function records(): array
	{
		return $this->records;
	}

	public function activities(): array
	{
		return $this->activities;
	}

	public function extra(): array
	{
		return $this->extra;
	}

	public function hasProblem(): bool
	{
		return $this->problemCount() > 0;
	}

	public function toArray(): array
	{
		$badRecords = [];
		foreach ($this->records() as $record)
		{
			$this->dateTimeToString($record);
			$badRecords[] = $record;
		}

		$activities = [];
		foreach ($this->activities() as $record)
		{
			$this->dateTimeToString($record);
			$activities[] = $record;
		}

		return [
			'type' => $this->type(),
			'problemCount' => $this->problemCount(),
			'payload' => [
				'badRecords' => $badRecords,
				'activities' => $activities,
				'extra' => $this->extra()
			]
		];
	}

	private function dateTimeToString(array &$row): void
	{
		foreach ($row as $key => &$val) {
			if ($val instanceof Date)
			{
				$row[$key] = $val->toString();
			}
		}
	}

	public static function makeEmptyProblem(string $type): self
	{
		return new self($type, 0, [], []);
	}
}