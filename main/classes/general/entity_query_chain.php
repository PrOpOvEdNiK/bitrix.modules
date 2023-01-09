<?php

class CEntityQueryChain
{
	/**
	 * @var CEntityQueryChainElement[]
	 */
	protected $chain;

	protected $size = 0;

	protected $definition;

	protected $alias;

	/**
	 * @var CEntityQueryChainElement
	 */
	protected $last_element;

	public function __construct()
	{
		$this->chain = array();
	}

	public function addElement(CEntityQueryChainElement $element)
	{
		if (empty($this->chain) && !($element->getValue() instanceof CBaseEntity))
		{
			throw new Exception('The first element of chain should be Entity only.');
		}

		$this->chain[] = $element;
		$this->definition = null;
		$this->alias = null;

		$this->last_element = $element;
		$this->size++;
	}

	public function getFirstElement()
	{
		return $this->chain[0];
	}

	public function getLastElement()
	{
		return $this->last_element;
	}

	public function getAllElements()
	{
		return $this->chain;
	}

	public function removeLastElement()
	{
		$this->chain = array_slice($this->chain, 0, -1);
		$this->definition = null;
		$this->alias = null;

		$this->last_element = end($this->chain);
		$this->size--;
	}

	public function hasBackReference()
	{
		foreach ($this->chain as $element)
		{
			if ($element->isBackReference())
			{
				return true;
			}
		}

		return false;
	}

	public function getSize()
	{
		return $this->size;
	}

	public function getDefinition()
	{
		if (is_null($this->definition))
		{
			$this->definition = self::getDefinitionByChain($this);
		}

		return $this->definition;
	}

	public function getAlias()
	{
		if (is_null($this->alias))
		{
			$this->alias = self::getAliasByChain($this);
		}

		return $this->alias;
	}

	public static function getChainByDefinition(CBaseEntity $init_entity, $definition)
	{
		$chain = new CEntityQueryChain;
		$chain->addElement(new CEntityQueryChainElement($init_entity));

		$def_elements = explode('.', $definition);
		$def_elements_size = count($def_elements);

		$prev_entity  = $init_entity;

		$i = 0;

		foreach ($def_elements as &$def_element)
		{
			$is_first_elem = ($i == 0);
			$is_last_elem  = (++$i == $def_elements_size);

			// all elements should be a Reference field or Entity
			// normal (scalar) field can only be the last element

			if ($prev_entity->hasField($def_element))
			{
				// field has been found at current entity
				$field = $prev_entity->getField($def_element);

				if ($field instanceof CReferenceEntityField)
				{
					$prev_entity = $field->getRefEntity();
				}
				elseif ($field instanceof CExpressionEntityField)
				{
					// expr can be in the middle too
				}
				elseif (!$is_last_elem)
				{
					throw new Exception(sprintf(
						'Normal fields can be only the last in chain, `%s` %s is not the last.',
						$field->getName(), get_class($field)
					));
				}

				if ($is_last_elem && $field instanceof CExpressionEntityField)
				{
					// we should have own copy of build_from_chains to set join aliases there
					$field = clone $field;
				}

				$chain->addElement(new CEntityQueryChainElement($field));
			}
			elseif ($prev_entity->hasUField($def_element))
			{
				// extend chain with utm/uts entity
				$ufield = $prev_entity->getUField($def_element);

				$u_entity = null;

				if ($ufield->isMultiple())
				{
					// add utm entity  user.utm:source_object (1:N)
					$utm_entity = CBaseEntity::getInstance('Utm'.$prev_entity->getName());
					$u_entity = $utm_entity;

					$chain->addElement(new CEntityQueryChainElement(
						array($utm_entity, $utm_entity->getField('SOURCE_OBJECT')),
						array('ufield' => $ufield)
					));

					if ($ufield->getTypeId() == 'iblock_section'
						&& substr($ufield->getName(), -3) == '_BY'
						&& $prev_entity->hasUField(substr($ufield->getName(), 0, -3))
					)
					{
						// connect next entity
						$utm_fname = $ufield->getName();
						$prev_entity = CBaseEntity::getInstance('IblockSection');
					}
					else
					{
						$utm_fname = $ufield->getValueFieldName();
					}

					$chain->addElement(new CEntityQueryChainElement(
						$utm_entity->getField($utm_fname),
						array('ufield' => $ufield)
					));
				}
				else
				{
					// uts table - single value
					// add uts entity user.uts (1:1)
					$uts_entity = CBaseEntity::getInstance('Uts'.$prev_entity->getName());
					$u_entity = $uts_entity;

					$chain->addElement(new CEntityQueryChainElement(
						$prev_entity->getField('UTS_OBJECT')
					));

					// add `value` field
					$chain->addElement(new CEntityQueryChainElement(
						$uts_entity->getField($def_element)
					));
				}
			}
			elseif (CBaseEntity::isExists($def_element)
				&& CBaseEntity::getInstance($def_element)->getReferencesCountTo($prev_entity->getName()) == 1
			)
			{
				// def_element is another entity with only 1 reference to current entity
				// need to identify Reference field
				$ref_entity = CBaseEntity::getInstance($def_element);
				$field = end($ref_entity->getReferencesTo($prev_entity->getName()));

				$prev_entity = $ref_entity;

				$chain->addElement(new CEntityQueryChainElement(
					array($ref_entity, $field)
				));
			}
			elseif ( ($pos_wh = strpos($def_element, ':')) > 0
					&& CBaseEntity::isExists(($ref_entity_name = substr($def_element, 0, $pos_wh)))
					&& CBaseEntity::getInstance($ref_entity_name)->hasField($ref_field_name = substr($def_element, $pos_wh+1))
					&& CBaseEntity::getInstance($ref_entity_name)->getField($ref_field_name)->getRefEntity()->getName() == $prev_entity->getName()
			)
			{
				// chain element is another entity with >1 references to current entity
				// def like NewsArticle:AUTHOR, NewsArticle:LAST_COMMENTER
				// NewsArticle - entity, AUTHOR and LAST_COMMENTER - Reference fields
				$chain->addElement(new CEntityQueryChainElement(array(
					CBaseEntity::getInstance($ref_entity_name),
					CBaseEntity::getInstance($ref_entity_name)->getField($ref_field_name)
				)));

				$prev_entity = CBaseEntity::getInstance($ref_entity_name);
			}
			elseif ($def_element == '*' && $is_last_elem)
			{
				continue;
			}
			else
			{
				// unknown chain
				throw new Exception(sprintf(
					'Unknown field definition `%s` (%s) for %s Entity.',
					$def_element, $definition, $prev_entity->getName()
				), 100);
			}
		}

		return $chain;
	}

	public static function getDefinitionByChain(CEntityQueryChain $chain)
	{
		$def = array();

		// add members of chain except of init entity
		$elements = array_slice($chain->getAllElements(), 1);

		foreach ($elements  as $element)
		{
			$def[] = $element->getDefinitionFragment();
		}

		return join('.', $def);
	}

	public static function getAliasByChain(CEntityQueryChain $chain)
	{
		$alias = array();

		// add prefix of init entity
		if ($chain->getSize() > 2)
		{
			$alias[] = $chain->getFirstElement()->getAliasFragment();
		}

		// add other members of chain
		$elements = array_slice($chain->getAllElements(), 1);

		foreach ($elements  as $element)
		{
			$fragment = $element->getAliasFragment();

			if (strlen($fragment))
			{
				$alias[] = $fragment;
			}
		}

		return join('_', $alias);
	}

	public static function getAliasByDefinition(CBaseEntity $entity, $definition)
	{
		$alias = array();

		foreach (explode('.', $definition) as $elem)
		{
			if ($elem === strtoupper($elem))
			{
				// field
				$alias[] = $elem;
			}
			else
			{
				// entity
				$tmp = explode(':', $elem);
				$alias[] = CBaseEntity::camel2snake($tmp[0]);

				// or link from entity
				if (!empty($tmp[1]))
				{
					$alias[] = $tmp[1];
				}
			}
		}

		$strAlias = join('_', $alias);

		if (count($alias) > 1)
		{
			// doesn't apply for fields of initial entity
			$strAlias = CBaseEntity::camel2snake($entity->getName()).'_'.$strAlias;
		}

		return strtoupper($strAlias);
	}

	public function hasAggregation()
	{
		$elements = array_reverse($this->chain);

		foreach ($elements as $element)
		{
			/**
			 * @var $element CEntityQueryChainElement
			 */
			if ($element->getValue() instanceof CExpressionEntityField && $element->getValue()->isAggregated())
			{
				return true;
			}
		}

		return false;
	}

	public function getSqlDefinition($with_alias = false)
	{
		$sql_def = $this->getLastElement()->getSqlDefinition();

		if ($with_alias)
		{
			global $DB;

			$sql_def .= ' AS ' . $DB->escL . $this->getAlias() . $DB->escR;
		}

		return $sql_def;
	}

	public function dump()
	{
		$i = 0;
		foreach ($this->chain as $elem)
		{
			echo '  '.++$i.'. ';
			$elem->dump();
			echo PHP_EOL;
		}
	}
}