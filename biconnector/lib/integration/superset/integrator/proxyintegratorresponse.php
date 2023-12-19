<?php

namespace Bitrix\BIConnector\Integration\Superset\Integrator;

final class ProxyIntegratorResponse extends IntegratorResponse
{
	public const HTTP_STATUS_OK = "200";
	public const HTTP_STATUS_CREATED = "201";
	public const HTTP_STATUS_ACCEPTED = "202";
	public const HTTP_STATUS_ETERNAL_SERVER_ERROR = "500";
	public const HTTP_STATUS_UNAUTHORIZED = "401";
	public const HTTP_STATUS_FORBIDDEN = "403";

	protected static function parseInnerStatus(mixed $status): int
	{
		if ($status === self::HTTP_STATUS_OK || $status === self::HTTP_STATUS_CREATED)
		{
			return IntegratorResponse::STATUS_OK;
		}
		else if ($status === self::HTTP_STATUS_ACCEPTED)
		{
			return IntegratorResponse::STATUS_IN_PROGRESS;
		}
		else if ($status === self::HTTP_STATUS_UNAUTHORIZED || $status === self::HTTP_STATUS_FORBIDDEN)
		{
			return IntegratorResponse::STATUS_NO_ACCESS;
		}
		else if ($status === self::HTTP_STATUS_ETERNAL_SERVER_ERROR)
		{
			return IntegratorResponse::STATUS_SERVER_ERROR;
		}

		return IntegratorResponse::STATUS_UNKNOWN;
	}
}