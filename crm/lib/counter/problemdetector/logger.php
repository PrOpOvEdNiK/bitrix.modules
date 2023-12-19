<?php

namespace Bitrix\Crm\Counter\ProblemDetector;

use Bitrix\Crm\Traits\Singleton;

class Logger
{
	use Singleton;

	private const COUNTER_PROBLEM_DETECTOR_TAG = '#crm_counter_problem_detector';

	public function log(ProblemList $problemList, array $extra = []): void
	{
		$problemLevel = $this->getProblemLevel($problemList->problemCount());

		$logData = [];
		foreach ($problemList->getProblems() as $problem)
		{
			if (!$problem->hasProblem())
			{
				continue;
			}

			$logData[] = $problem->toArray();
		}

		$log = [
			'tag' => self::COUNTER_PROBLEM_DETECTOR_TAG,
			'level' => $problemLevel,
			'count' => $problemList->problemCount(),
			'problems' => $logData,
			'extra' => $extra
		];

		$logStr = json_encode($log);

		AddMessage2Log(
			$logStr,
			'crm',
			0
		);
	}

	private function getProblemLevel(int $problemCount): string
	{

		if ($problemCount <= 3)
		{
			return '#crm_counter_problem_level_low';
		}
		elseif ($problemCount <= 10)
		{
			return '#crm_counter_problem_level_medium';
		}
		elseif ($problemCount <= 50)
		{
			return '#crm_counter_problem_level_high';
		}
		else
		{
			return '#crm_counter_problem_level_critical';
		}
	}
}