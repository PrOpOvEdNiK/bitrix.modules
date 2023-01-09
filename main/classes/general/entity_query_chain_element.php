<?php

class CEntityQueryChainElement
{
	protected $value;

	protected $parameters;

	protected $type;

	protected $definition_fragment;

	protected $alias_fragment;

	/**
	 * Value format:
	 * 1. CEntityField - normal scalar field
	 * 2. CReferenceField - pointer to another entity
	 * 3. array(CBaseEntity, CReferenceEntityField) - pointer from another entity to this
	 * 4. CBaseEntity - all fields of entity
	 * @param CScalarEntityField|CExpressionEntityField|CReferenceEntityField|array|CBaseEntity $element
	 * @param array $parameters
	 * @throws Exception
	 */
	public function __construct($element, $parameters = array())
	{
		if ($element instanceof CReferenceEntityField)
		{
			$this->type = 2;
		}
		elseif (is_array($element)
			&& $element[0] instanceof CBaseEntity
			&& $element[1] instanceof CReferenceEntityField
		)
		{
			$this->type = 3;
		}
		elseif ($element instanceof CBaseEntity)
		{
			$this->type = 4;
		}
		elseif ($element instanceof CEntityField)
		{
			$this->type = 1;
		}
		else
		{
			throw new Exception(sprintf('Invalid value for QueryChainElement: %s.', $element));
		}

		$this->value = $element;
		$this->parameters = $parameters;
	}

	/**
	 * @return array|CBaseEntity|CExpressionEntityField|CReferenceEntityField|CScalarEntityField
	 */
	public function getValue()
	{
		return $this->value;
	}

	public function getParameter($name)
	{
		return $this->parameters[$name];
	}

	public function setParameter($name, $value)
	{
		$this->parameters[$name] = $value;
	}

	public function getDefinitionFragment()
	{
		if (is_null($this->definition_fragment))
		{
			if ($this->type == 2)
			{
				// skip uts entity
				if ($this->value->getRefEntity()->isUts())
				{
					$this->definition_fragment = '';
				}
				else
				{
					$this->definition_fragment = $this->value->getName();
				}
			}
			elseif ($this->type == 3)
			{
				// skip utm entity
				if ($this->value[0]->isUtm())
				{
					$this->definition_fragment = '';
				}
				else
				{
					$this->definition_fragment = $this->value[0]->getName() . ':' . $this->value[1]->getName();
				}
			}
			elseif ($this->type == 4)
			{
				$this->definition_fragment = '*';
			}
			else
			{
				if (!empty($this->parameters['uField']))
				{
					$this->definition_fragment = $this->parameters['uField']->getName();
				}
				else
				{
					$this->definition_fragment = $this->value->getName();
				}
			}
		}

		return $this->definition_fragment;
	}

	public function getAliasFragment()
	{
		if (is_null($this->alias_fragment))
		{
			if ($this->type == 2)
			{
				// skip uts entity
				if ($this->value->getRefEntity()->isUts())
				{
					$this->alias_fragment = '';
				}
				else
				{
					$this->alias_fragment = $this->value->getName();
				}
			}
			elseif ($this->type == 3)
			{
				// skip utm entity
				if ($this->value[0]->isUtm())
				{
					$this->alias_fragment = '';
				}
				else
				{
					$this->alias_fragment = strtoupper(CBaseEntity::camel2snake($this->value[0]->getName())) . '_' . $this->value[1]->getName();
				}
			}
			elseif ($this->type == 4)
			{
				$this->alias_fragment = strtoupper(CBaseEntity::camel2snake($this->value->getName()));
			}
			else
			{
				if (!empty($this->parameters['ufield']))
				{
					$this->alias_fragment = $this->parameters['ufield']->getName();
				}
				else
				{
					$this->alias_fragment = $this->value->getName();
				}
			}
		}

		return $this->alias_fragment;
	}

	public function getSqlDefinition()
	{
		if (is_array($this->value) || $this->value instanceof CReferenceEntityField || $this->value instanceof CBaseEntity)
		{
			throw new Exception('');
		}

		if ($this->value instanceof CExpressionEntityField)
		{
			$SQLBuildFrom = array();

			foreach ($this->value->getBuildFromChains() as $chain)
			{
				$SQLBuildFrom[] = $chain->GetSQLDefinition();
			}

			// join
			$sql = call_user_func_array('sprintf', array_merge(array($this->value->getExpression()), $SQLBuildFrom));
		}
		else
		{
			global $DB;

			$sql = $DB->escL . $this->getParameter('talias') . $DB->escR . '.';
			$sql .= $DB->escL . $this->value->getName() . $DB->escR;
		}

		return $sql;
	}

	public function isBackReference()
	{
		return $this->type === 3;
	}

	public function dump()
	{
		echo gettype($this->value).' ';

		if ($this->value instanceof CEntityField)
		{
			echo get_class($this->value).' '.$this->value->getName();
		}
		elseif ($this->value instanceof CBaseEntity)
		{
			echo get_class($this->value);
		}
		elseif (is_array($this->value))
		{
			echo '('.get_class($this->value[0]).', '.get_class($this->value[1]).' '.$this->value[1]->getName().')';
		}

		echo ' '.json_encode($this->parameters);
	}
}