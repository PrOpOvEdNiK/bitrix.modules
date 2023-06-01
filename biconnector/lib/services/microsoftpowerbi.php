<?php
namespace Bitrix\BIConnector\Services;

use Bitrix\BIConnector\Service;

class MicrosoftPowerBI extends Service
{
	public static $dateFormats = [
		'datetime_format' => '%Y-%m-%d %H:%i:%s',
		'datetime_format_php' => 'Y-m-d H:i:s',
		'date_format' => '%Y-%m-%d',
		'date_format_php' => 'Y-m-d',
	];

	public static function validateDashboardUrl($url)
	{
		$uri = new \Bitrix\Main\Web\Uri($url);
		return $uri->getScheme() === 'https'
			&& $uri->getHost() === 'app.powerbi.com'
			&& (
				$uri->getPath() === '/view'
				|| $uri->getPath() === '/reportEmbed'
			);
	}

	public function getTableList()
	{
		$result = [];
		foreach ($this->manager->getDataSources($this->languageId) as $tableName => $tableInfo)
		{
			$result[] = [
				$tableName,
				$tableInfo['TABLE_DESCRIPTION'],
			];
		}
		return $result;
	}

	public function getTableFields($tableName)
	{
		$result = [];
		$tableInfo = $this->manager->getTableDescription($tableName, $this->languageId);
		if ($tableInfo)
		{
			foreach ($tableInfo['FIELDS'] as $fieldName => $fieldInfo)
			{
				if (isset($fieldInfo['FIELD_TYPE_EX']))
				{
					$type = $fieldInfo['FIELD_TYPE_EX'];
				}
				else
				{
					$type = $fieldInfo['FIELD_TYPE'];
				}

				$result[] = [
					'CONCEPT_TYPE' => (isset($fieldInfo['IS_METRIC']) && $fieldInfo['IS_METRIC'] === 'Y' ? 'METRIC' : 'DIMENSION'),
					'ID' => $fieldName,
					'NAME' => $fieldInfo['FIELD_DESCRIPTION'],
					'DESCRIPTION' => $fieldInfo['FIELD_DESCRIPTION_FULL'] ?? '',
					'TYPE' => $this->mapType($type),
					'IS_PRIMARY' => $fieldInfo['IS_PRIMARY'] ?? null,
					'CONCAT_GROUP_BY' => $fieldInfo['CONCAT_GROUP_BY'] ?? null,
					'CONCAT_KEY' => $fieldInfo['CONCAT_KEY'] ?? null,
				];
			}
		}
		return $result;
	}

	public function mapType($internalType)
	{
		// \CSQLWhere
		switch ($internalType)
		{
			case 'file':
			case 'enum':
			case 'int':
				return 'NUMBER';
			case 'double':
				return 'NUMBER';
			case 'string':
				return 'STRING';
			case 'date':
				return 'YEAR_MONTH_DAY';
			case 'datetime':
				return 'YEAR_MONTH_DAY_SECOND';
			case 'callback':
				return 'STRING';
			case 'bool':
				return 'BOOLEAN';
		}
		return 'STRING';
	}

	protected function applyDateFilter(&$sqlWhere, $tableFields, $dateRange, $timeFilterColumn = '')
	{
		$startDate = array_key_exists('startDate', $dateRange) ? MakeTimeStamp($dateRange['startDate'], 'YYYY-MM-DD') : false;

		$filterColumnName = false;
		if (
			$timeFilterColumn
			&& array_key_exists($timeFilterColumn, $tableFields)
			&& $tableFields[$timeFilterColumn]['FIELD_TYPE'] === 'datetime'
		)
		{
			$filterColumnName = $timeFilterColumn;
		}
		else
		{
			foreach ($tableFields as $fieldName => $fieldInfo)
			{
				if ($fieldInfo['FIELD_TYPE'] === 'datetime')
				{
					$filterColumnName = $fieldName;
					break;
				}
			}
		}

		if ($filterColumnName)
		{
			if ($startDate)
			{
				$sqlWhere['>=' . $filterColumnName] = ConvertTimeStamp($startDate, 'SHORT');
			}

			$endDate = array_key_exists('endDate', $dateRange) ? MakeTimeStamp($dateRange['endDate'], 'YYYY-MM-DD') : false;
			if ($endDate)
			{
				$endDate += 23 * 3600 + 59 * 60 + 59;
				$sqlWhere['<=' . $filterColumnName] = ConvertTimeStamp($endDate, 'FULL');
			}
		}
	}

	protected function applyDimensionsFilters(&$sqlWhere, &$canBeFiltered, $tableFields, $dimensionsFilters)
	{
		foreach ($dimensionsFilters as $topFilter)
		{
			$andFilter = [
				'LOGIC' => 'OR',
			];
			foreach ($topFilter as $subFilter)
			{
				if ($subFilter['fieldName'] && isset($tableFields[$subFilter['fieldName']]))
				{
					if ($tableFields[$subFilter['fieldName']]['FIELD_TYPE'] === 'datetime')
					{
						if (is_array($subFilter['values']))
						{
							foreach ($subFilter['values'] as $i => $value)
							{
								$subFilter['values'][$i] = ConvertTimeStamp(strtotime($value), 'FULL');
							}
						}
						else
						{
							$subFilter['values'] = ConvertTimeStamp(strtotime($subFilter['values']), 'FULL');
						}
					}
					elseif ($tableFields[$subFilter['fieldName']]['FIELD_TYPE'] === 'date')
					{
						if (is_array($subFilter['values']))
						{
							foreach ($subFilter['values'] as $i => $value)
							{
								$subFilter['values'][$i] = ConvertTimeStamp(strtotime($value), 'SHORT');
							}
						}
						else
						{
							$subFilter['values'] = ConvertTimeStamp(strtotime($subFilter['values']), 'SHORT');
						}
					}

					$negate = $subFilter['type'] === 'EXCLUDE' ? '!' : '';
					switch ($subFilter['operator'])
					{
						case 'EQUALS':
						case 'IN_LIST':
							$andFilter[$negate . '=' . $subFilter['fieldName']] = $subFilter['values'];
							break;
						case 'CONTAINS':
							$andFilter[$negate . '%' . $subFilter['fieldName']] = $subFilter['values'];
							break;
						case 'REGEXP_PARTIAL_MATCH':
						case 'REGEXP_EXACT_MATCH':
							$canBeFiltered = false;
							break;
						case 'IS_NULL':
							$andFilter[$negate . '=' . $subFilter['fieldName']] = false;
							break;
						case 'BETWEEN':
							$andFilter[$negate . '><' . $subFilter['fieldName']] = $subFilter['values'];
							break;
						case 'NUMERIC_GREATER_THAN':
							$andFilter[$negate . '>' . $subFilter['fieldName']] = $subFilter['values'];
							break;
						case 'NUMERIC_GREATER_THAN_OR_EQUAL':
							$andFilter[$negate . '>=' . $subFilter['fieldName']] = $subFilter['values'];
							break;
						case 'NUMERIC_LESS_THAN':
							$andFilter[$negate . '<' . $subFilter['fieldName']] = $subFilter['values'];
							break;
						case 'NUMERIC_LESS_THAN_OR_EQUAL':
							$andFilter[$negate . '<=' . $subFilter['fieldName']] = $subFilter['values'];
							break;
						default:
							$canBeFiltered = false;
					}
				}
			}
			if (count($andFilter) > 1)
			{
				$sqlWhere[] = $andFilter;
			}
		}
	}

	public function getData($tableName, $parameters)
	{
		$tableInfo = $this->manager->getTableDescription($tableName, $this->languageId);
		$tableFields = $tableInfo['FIELDS'];

		$canBeFiltered = true;
		$sqlWhere = $tableInfo['FILTER'] ?? [];

		if (isset($parameters['dateRange']) && is_array($parameters['dateRange']))
		{
			$timeFilterColumn = isset($parameters['configParams']) && is_array($parameters['configParams']) && array_key_exists('timeFilterColumn', $parameters['configParams']) ? $parameters['configParams']['timeFilterColumn'] : '';
			$this->applyDateFilter($sqlWhere, $tableFields, $parameters['dateRange'], $timeFilterColumn);
		}

		// https://developers.google.com/datastudio/connector/filters?hl=ru
		if (isset($parameters['dimensionsFilters']) && is_array($parameters['dimensionsFilters']))
		{
			$this->applyDimensionsFilters($sqlWhere, $canBeFiltered, $tableFields, $parameters['dimensionsFilters']);
		}

		$queryWhere = new \CBIConnectorSqlBuilder;
		$queryWhere->setFields($tableFields);
		if (isset($tableInfo['FILTER_FIELDS']))
		{
			$queryWhere->addFields($tableInfo['FILTER_FIELDS']);
		}

		$strQueryWhere = '';
		if ($canBeFiltered && $sqlWhere)
		{
			$strQueryWhere = $queryWhere->getQuery($sqlWhere);
		}

		$selectedFields = [];
		$concatFields = [];
		if (isset($parameters['fields']) && is_array($parameters['fields']))
		{
			foreach ($parameters['fields'] as $field)
			{
				$fieldName = trim($field['name'], " \t\n\r");
				if ($fieldName && isset($tableFields[$fieldName]))
				{
					$tableField = $tableFields[$fieldName];
					if (
						(!isset($field['forFilterOnly']) || !$field['forFilterOnly'])
						|| !($strQueryWhere && $canBeFiltered)
					)
					{
						if (isset($tableField['CONCAT_KEY']))
						{
							$concatKey = $tableField['CONCAT_KEY'];
							$concatFields[$concatKey] = $tableFields[$concatKey];
							$concatFields[$concatKey]['ID'] = $concatKey;
						}
						$selectedFields[$fieldName] = $tableFields[$fieldName];
					}
				}
				else
				{
					//TODO
				}
			}
			if (!$selectedFields)
			{
				return [
					'error' => 'EMPTY_SELECT_FIELDS_LIST',
				];
			}
		}
		else
		{
			$selectedFields = $tableFields;
		}

		$primaryFields = [];
		if ($concatFields)
		{
			foreach ($tableFields as $fieldName => $tableField)
			{
				if (isset($tableField['IS_PRIMARY']) && $tableField['IS_PRIMARY'] == 'Y')
				{
					$tableField['ID'] = $fieldName;
					$primaryFields[$fieldName] = $tableField;
				}
			}
		}

		foreach ($concatFields as $concatKey => $tmp)
		{
			if (isset($selectedFields[$concatKey]))
			{
				unset($concatFields[$concatKey]);
			}
		}

		foreach ($primaryFields as $primaryKey => $tmp)
		{
			if (isset($selectedFields[$primaryKey]))
			{
				unset($primaryFields[$primaryKey]);
			}
		}

		$shadowFields = array_merge($primaryFields, $concatFields);

		$queryWhere->setSelect(array_merge($selectedFields, $shadowFields), static::$dateFormats);

		$additionalJoins = $queryWhere->getJoins();
		$sql = "select\n  " . $queryWhere->getSelect()
			. "\nfrom\n  " . $tableInfo['TABLE_NAME'] . ' AS ' . $tableInfo['TABLE_ALIAS']
			. ($additionalJoins ? "\n  " . $additionalJoins : '')
			. ($strQueryWhere ? "\nWHERE " . $strQueryWhere : '')
			. "\n";

		$i = 0;
		$fetchCallbacks = [];
		foreach (array_merge($selectedFields, $shadowFields) as $fieldInfo)
		{
			if (isset($fieldInfo['CALLBACK']))
			{
				$fetchCallbacks[$i] = $fieldInfo['CALLBACK'];
			}
			elseif ($fieldInfo['FIELD_TYPE'] === 'int')
			{
				$fetchCallbacks[$i] = function ($value, $dateFormats)
				{
					return $value === null ? null : (int)$value;
				};
			}
			$i++;
		}

		$schemaFields = $this->getTableFields($tableName);
		$schema = [];
		foreach ($selectedFields as $fieldName => $tmp)
		{
			foreach ($schemaFields as $fieldInfo)
			{
				if ($fieldName === $fieldInfo['ID'])
				{
					$schema[] = $fieldInfo;
				}
			}
		}

		return [
			'schema' => $schema,
			'sql' => $sql,
			'filtersApplied' => $strQueryWhere && $canBeFiltered,
			'onAfterFetch' => $fetchCallbacks,
			'where' => $sqlWhere,
			'shadowFields' => $shadowFields,
		];
	}
}
