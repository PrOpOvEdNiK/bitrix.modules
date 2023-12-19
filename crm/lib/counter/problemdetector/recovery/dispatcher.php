<?php

namespace Bitrix\Crm\Counter\ProblemDetector\Recovery;

use Bitrix\Crm\Counter\ProblemDetector\ProblemList;
use Bitrix\Crm\Traits\Singleton;

class Dispatcher
{
	use Singleton;

	/** @var AsyncRecovery[] */
	private array $recoveryList;

	public function __construct()
	{
		$this->recoveryList = [
			new CountableCompleted(),
			new CountableDeleted(),
			new UncompletedCompleted(),
			new UncompletedDeleted(),
		];
	}

	public function execute(ProblemList $problemList): void
	{
		$typesToRecovery = [];
		foreach ($problemList->getProblems() as $problem)
		{
			if (!$problem->hasProblem())
			{
				continue;
			}
			$typesToRecovery[] = $problem->type();
		}

		$typesToRecovery = array_unique($typesToRecovery);

		foreach ($typesToRecovery as $type)
		{
			$recovery = $this->findRecoveryByType($type);
			if($recovery === null)
			{
				continue;
			}

			if ($recovery instanceof AsyncRecovery)
			{
				$recovery->planAsyncFix();
			}
		}
	}

	private function findRecoveryByType(string $type): ?AsyncRecovery
	{
		foreach ($this->recoveryList as $item)
		{
			if ($item->supportedType() === $type)
			{
				return $item;
			}
		}
		return null;
	}

}