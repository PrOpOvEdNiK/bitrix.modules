<?php
namespace Bitrix\BIConnector;

class Manager
{
	const IS_VALID_URL = 1;
	const IS_EXTERNAL_URL = 2;

	protected static $instance = null;
	protected $dataSources = [];
	protected $connectionName = '';
	protected $serviceId = '';
	protected $keyId = 0;
	protected $stime = [];

	public static function getInstance(): Manager
	{
		if (static::$instance === null)
		{
			static::$instance = new Manager();
		}
		return static::$instance;
	}

	public function createService($serviceId)
	{
		$this->serviceId = $serviceId;
		switch ($serviceId)
		{
			case 'gds':
				return new Services\GoogleDataStudio($this);
			case 'pbi':
				return new Services\MicrosoftPowerBI($this);
		}
		return null;
	}

	protected function init($languageId = '')
	{
		if (!isset($this->dataSources[$languageId]))
		{
			$this->dataSources[$languageId] = [];
			$event = new \Bitrix\Main\Event('biconnector', 'OnBIConnectorDataSources', [$this, &$this->dataSources[$languageId], $languageId]);
			$event->send();
		}
	}

	public function getDataSources($languageId = '')
	{
		$this->init($languageId);
		return $this->dataSources[$languageId];
	}

	public function getTableDescription($table, $languageId = '')
	{
		$this->init($languageId);
		return $this->dataSources[$languageId][$table];
	}

	public function checkAccessKey($key)
	{
		if ($key)
		{
			$dbKey = KeyTable::getList([
				'select' => [
					'ID',
					'CONNECTION',
				],
				'filter' => [
					'=ACCESS_KEY' => $key,
				],
			])->fetch();
			if ($dbKey)
			{
				$this->connectionName = $dbKey['CONNECTION'];
				$pool = \Bitrix\Main\Application::getInstance()->getConnectionPool();
				if ($this->connectionName === $pool::DEFAULT_CONNECTION_NAME)
				{
					$this->connectionName .= '_' . __CLASS__;
				}
				$this->keyId = $dbKey['ID'];
				return true;
			}
		}
		return false;
	}

	public function getCurrentUserAccessKey()
	{
		global $USER;

		$filter = [
			'=ACTIVE' => 'Y',
		];
		if (!$USER->canDoOperation('biconnector_key_manage'))
		{
			$filter['=PERMISSION.USER_ID'] = $USER->getId();
		}

		$keyList = \Bitrix\BIConnector\KeyTable::getList([
			'select' => ['ACCESS_KEY'],
			'filter' => $filter,
			'order' => ['ID' => 'DESC'],
			'cache' => ['ttl' => 36000],
		]);
		return $keyList->fetch();
	}

	public function getCurrentUserDashboardList()
	{
		global $USER;

		$result = \Bitrix\BIConnector\DashboardTable::getList([
			'filter' => [
				'=PERMISSION.USER_ID' => $USER->getId(),
			],
			'order' => ['NAME' => 'ASC', 'ID' => 'DESC'],
			'cache' => ['ttl' => 36000],
		])->fetchAll();

		return $result;
	}

	private function checkDashboardUrlFlag($url, $flag)
	{
		$found = Services\GoogleDataStudio::validateDashboardUrl($url);
		if ($found & $flag)
		{
			return true;
		}

		$found = Services\MicrosoftPowerBI::validateDashboardUrl($url);
		if ($found & $flag)
		{
			return true;
		}

		$event = new \Bitrix\Main\Event('biconnector', 'OnBIConnectorValidateDashboardUrl', [$url]);
		$event->send();
		foreach($event->getResults() as $evenResult)
		{
			if ($evenResult->getResultType() == \Bitrix\Main\EventResult::SUCCESS)
			{
				$found = $evenResult->getParameters();
				if ($found & $flag)
				{
					return true;
				}
			}
		}

		return false;
	}

	public function validateDashboardUrl($url)
	{
		return $this->checkDashboardUrlFlag($url, static::IS_VALID_URL);
	}

	public function isExternalDashboardUrl($url)
	{
		return $this->checkDashboardUrlFlag($url, static::IS_EXTERNAL_URL);
	}

	public function getConnections()
	{
		$biConnections = [];

		$configParams = \Bitrix\Main\Config\Configuration::getValue('connections');
		if (is_array($configParams))
		{
			foreach ($configParams as $connectionName => $connectionParams)
			{
				if (is_a($connectionParams['className'], '\Bitrix\BIConnector\Connection', true))
				{
					$biConnections[$connectionName] = $connectionName;
				}
			}
		}

		if (!$biConnections)
		{
			$pool = \Bitrix\Main\Application::getInstance()->getConnectionPool();
			$biConnections[$pool::DEFAULT_CONNECTION_NAME] = $pool::DEFAULT_CONNECTION_NAME;
		}

		return $biConnections;
	}

	public function getDatabaseConnection()
	{
		$pool = \Bitrix\Main\Application::getInstance()->getConnectionPool();
		$isConnectionExists = $pool->getConnection($this->connectionName) !== null;
		if (!$isConnectionExists)
		{
			$pool->cloneConnection($pool::DEFAULT_CONNECTION_NAME, $this->connectionName, [
				'className' => '\\Bitrix\\BIConnector\\Connection',
			]);
		}

		return $pool->getConnection($this->connectionName);
	}

	public function startQuery($sourceId, $fields = '', $filters = '', $input = '', $request_method = '', $request_uri = '')
	{
		$statData = [
			'TIMESTAMP_X' => new \Bitrix\Main\Type\DateTime(),
			'KEY_ID' => $this->keyId,
			'SERVICE_ID' => substr($this->serviceId, 0, 150),
			'SOURCE_ID' => substr($sourceId, 0, 150),
		];
		if ($fields)
		{
			$statData['FIELDS'] = $fields;
		}
		if ($filters)
		{
			$statData['FILTERS'] = $filters;
		}
		if ($input)
		{
			$statData['INPUT'] = $input;
		}
		if ($request_method)
		{
			$statData['REQUEST_METHOD'] = $request_method;
		}
		if ($request_uri)
		{
			$statData['REQUEST_URI'] = $request_uri;
		}

		$addResult = \Bitrix\BIConnector\LogTable::add($statData);
		if ($addResult->isSuccess())
		{
			$logId = $addResult->getId();
			$this->stime[$logId] = microtime(true);
			return $logId;
		}

		return false;
	}

	public function endQuery($logId, $count)
	{
		if (isset($this->stime[$logId]))
		{
			$statData = [
				'TIMESTAMP_X' => new \Bitrix\Main\Type\DateTime(),
				'ROW_NUM' => $count,
				'REAL_TIME' => microtime(true) - $this->stime[$logId],
			];

			$updateResult = \Bitrix\BIConnector\LogTable::update($logId, $statData);
			$updateResult->isSuccess();
		}
	}

	public function isAvailable()
	{
		return !empty($this->getMenuItems());
	}

	public function getMenuItems()
	{
		global $USER;

		$items = [];
		if (\Bitrix\Main\Loader::includeModule('bitrix24'))
		{
			if (!\Bitrix\Bitrix24\Feature::isFeatureEnabled('biconnector'))
			{
				return $items;
			}
		}

		if ($USER->canDoOperation('biconnector_key_manage'))
		{
			$items[] = [
				'id' => 'crm_bi_connect',
				'url' => '/biconnector/',
			];
		}

		if ($USER->canDoOperation('biconnector_dashboard_manage'))
		{
			$items[] = [
				'id' => 'crm_bi_dashboard_manage',
				'url' => '/biconnector/dashboard_list.php',
			];
		}

		if ($USER->canDoOperation('biconnector_key_manage'))
		{
			$items[] = [
				'id' => 'crm_bi_key',
				'url' => '/biconnector/key_list.php',
			];
		}

		foreach ($this->getCurrentUserDashboardList() as $dashboard)
		{
			$items[] = [
				'id' => 'crm_bi_dashboard_' . $dashboard['ID'],
				'url' => '/biconnector/dashboard.php?id=' . $dashboard['ID'],
				'title' => $dashboard['NAME'],
			];
		}

		return $items;
	}
}
