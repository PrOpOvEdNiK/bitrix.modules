<?php

class CGroupEntity extends CBaseEntity
{
	protected function __construct() {}

	public function initialize()
	{
		$this->className = __CLASS__;
		$this->filePath = __FILE__;

		$this->fieldsMap = array(
			'ID' => array(
				'data_type' => 'integer',
				'primary' => true
			),
			'TIMESTAMP_X' => array(
				'data_type' => 'datetime'
			),
			'ACTIVE' => array(
				'data_type' => 'boolean'
			),
			'C_SORT' => array(
				'data_type' => 'integer'
			),
			'ANONYMOUS' => array(
				'data_type' => 'boolean'
			),
			'NAME' => array(
				'data_type' => 'string'
			),
			'DESCRIPTION' => array(
				'data_type' => 'string'
			)
		);
	}


}