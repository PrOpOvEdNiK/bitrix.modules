<?php

namespace Bitrix\Crm\Service\Timeline\Layout;

use Bitrix\Crm\Service\Timeline\Layout\Action\Animation;

abstract class Action extends Base
{
	protected ?array $actionParams = null;
	protected ?Animation $animation = null;

	public function getActionParams(): ?array
	{
		return $this->actionParams;
	}

	public function addActionParamString(string $paramName, ?string $paramValue): self
	{
		$this->actionParams[$paramName] = $paramValue;

		return $this;
	}

	public function addActionParamInt(string $paramName, ?int $paramValue): self
	{
		$this->actionParams[$paramName] = $paramValue;

		return $this;
	}

	public function getAnimation(): ?Animation
	{
		return $this->animation;
	}


	public function setAnimation(?Animation $animation): self
	{
		$this->animation = $animation;

		return $this;
	}
}
