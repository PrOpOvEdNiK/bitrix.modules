<?php

namespace Bitrix\Disk\Internals\Iterator;


use Bitrix\Main\DB;
use Bitrix\Main\NotSupportedException;
use Bitrix\Main\Text\Converter;

class DbResult implements \Iterator
{
	/**
	 * @var DB\Result
	 */
	private $result;
	/** @var Converter */
	private $converter;
	private $currentData;
	private $counter;


	/**
	 * DbResult constructor.
	 * @param DB\Result                   $result
	 * @param Converter $converter
	 */
	public function __construct(DB\Result $result, Converter $converter = null)
	{
		$this->result = $result;
		$this->converter = $converter;
		$this->counter = -1;
	}

	/**
	 * Return the current element
	 * @link http://php.net/manual/en/iterator.current.php
	 * @return mixed Can return any type.
	 * @since 5.0.0
	 */
	public function current()
	{
		return $this->currentData;
	}

	/**
	 * Move forward to next element
	 * @link http://php.net/manual/en/iterator.next.php
	 * @return void Any returned value is ignored.
	 * @since 5.0.0
	 */
	public function next()
	{
		$this->currentData = $this->result->fetch($this->converter);
		$this->counter++;
	}

	/**
	 * Return the key of the current element
	 * @link http://php.net/manual/en/iterator.key.php
	 * @return mixed scalar on success, or null on failure.
	 * @since 5.0.0
	 */
	public function key()
	{
		return $this->counter;
	}

	/**
	 * Checks if current position is valid
	 * @link http://php.net/manual/en/iterator.valid.php
	 * @return boolean The return value will be casted to boolean and then evaluated.
	 * Returns true on success or false on failure.
	 * @since 5.0.0
	 */
	public function valid()
	{
		return $this->currentData !== false;
	}

	/**
	 * Rewind the Iterator to the first element
	 * @link http://php.net/manual/en/iterator.rewind.php
	 * @throws NotSupportedException
	 * @since 5.0.0
	 */
	public function rewind()
	{
		if($this->counter > 0)
		{
			throw new NotSupportedException('Could not rewind the iterator');
		}
		$this->next();
	}
}