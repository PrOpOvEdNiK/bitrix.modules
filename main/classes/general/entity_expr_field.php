<?php


class CExprEntityField extends CEntityField
{
	protected
		$expr,
		$buildFrom,
		$buildFromChains;

	protected
		$isAggregated;


	protected static
		$aggrFunctionsMYSQL = array('AVG', 'BIT_AND', 'BIT_OR', 'BIT_XOR', 'COUNT',
			'GROUP_CONCAT', 'MAX', 'MIN', 'STD', 'STDDEV_POP', 'STDDEV_SAMP',
			'STDDEV', 'SUM', 'VAR_POP', 'VAR_SAMP', 'VARIANCE'
		),
		$aggrFunctionsMSSQL = array('AVG', 'MIN', 'CHECKSUM_AGG', 'OVER', 'COUNT',
			'ROWCOUNT_BIG', 'COUNT_BIG', 'STDEV', 'GROUPING', 'STDEVP',
			'GROUPING_ID', 'SUM', 'MAX', 'VAR', 'VARP'
		),
		$aggrFunctionsORACLE = array('AVG', 'COLLECT', 'CORR', 'CORR_S', 'CORR_K',
			'COUNT', 'COVAR_POP', 'COVAR_SAMP', 'CUME_DIST', 'DENSE_RANK', 'FIRST',
			'GROUP_ID', 'GROUPING', 'GROUPING_ID', 'LAST', 'MAX', 'MEDIAN', 'MIN',
			'PERCENTILE_CONT', 'PERCENTILE_DISC', 'PERCENT_RANK', 'RANK',
			'REGR_SLOPE', 'REGR_INTERCEPT', 'REGR_COUNT', 'REGR_R2', 'REGR_AVGX',
			'REGR_AVGY', 'REGR_SXX', 'REGR_SYY', 'REGR_SXY', 'STATS_BINOMIAL_TEST',
			'STATS_CROSSTAB', 'STATS_F_TEST', 'STATS_KS_TEST', 'STATS_MODE',
			'STATS_MW_TEST', 'STATS_ONE_WAY_ANOVA', 'STATS_T_TEST_ONE',
			'STATS_T_TEST_PAIRED', 'STATS_T_TEST_INDEP', 'STATS_T_TEST_INDEPU',
			'STATS_WSR_TEST', 'STDDEV', 'STDDEV_POP', 'STDDEV_SAMP', 'SUM',
			'VAR_POP', 'VAR_SAMP', 'VARIANCE'
		),
		$aggrFunctions;



	public function __construct($name, $dataType, CBaseEntity $entity, $expr, $parameters = array())
	{
		parent::__construct($name, $dataType, $entity, $parameters);

		$this->expr = $expr[0];

		// преобразование buildFrom в объекты полей
		$this->buildFrom = array();
		$this->buildFromChains = array();

		for ($i=1; $i<count($expr); $i++)
		{
			// это может быть уже описанное поле
			if ($this->entity->HasField($expr[$i]))
			{
				$this->buildFrom[] = $this->entity->GetField($expr[$i]);
			}
			else
			{
				$this->buildFrom[] = new CEntityField($expr[$i], '', $this->entity);
			}

			$this->buildFromChains[] = CBaseEntity::GetObjectChain($this->entity, $expr[$i]);
		}

		// определение наличия аггрегирования
		$this->isAggregated = (bool) self::checkAggregation($this->GetSQLDefinition(false));
	}


	public function GetExpr()
	{
		return $this->expr;
	}


	public function IsAggregated()
	{
		return $this->isAggregated;
	}


	public function &GetBuildFromChains()
	{
		return $this->buildFromChains;
	}


	public function GetSQLDefinition($withFieldAlias = true)
	{
		// развертывание составных атрибутов
		$SQLBuildFrom = array();

		foreach ($this->buildFromChains as $chain)
		{
			$lastElem = end($chain);
			$tableAlias = $lastElem['tAlias'];

			if ($lastElem['value'] instanceof CExprEntityField)
			{
				$SQLBuildFrom[] = $lastElem['value']->GetSQLDefinition(false);
			}
			else
			{
				$SQLBuildFrom[] = $lastElem['value']->GetSQLDefinition($tableAlias);
			}
		}

		// склеивание выражения с алиасом
		$expr = call_user_func_array('sprintf', array_merge(array($this->expr), $SQLBuildFrom));

		return $withFieldAlias
			? $expr . ' AS ' . CBaseEntity::$lEsc . $this->name . CBaseEntity::$rEsc
			: $expr;
	}

	public function removeAggregation()
	{
		$oldExpr = $this->expr;
		$this->expr = preg_replace('/^('.join('|', self::$aggrFunctions).')\((.*)\)$/', '$2', $this->expr);

		return $this->expr !== $oldExpr;
	}

	public static function checkAggregation($expr)
	{
		if (empty(self::$aggrFunctions))
		{
			self::$aggrFunctions = array_unique(array_merge(
				self::$aggrFunctionsMYSQL, self::$aggrFunctionsMSSQL, self::$aggrFunctionsORACLE
			));
		}

		preg_match_all('/(?:^|[^a-z0-9_])('.join('|', self::$aggrFunctions).')[\s\(]+/i', $expr, $matches);

		return $matches[1];
	}
}


