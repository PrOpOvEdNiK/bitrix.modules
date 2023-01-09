<?php

class CSiteEntity extends CBaseEntity
{
	protected function __construct() {}

	public function initialize()
	{
		$this->className = __CLASS__;
		$this->filePath = __FILE__;

		$this->dbTableName = 'b_lang';

		$this->fieldsMap = array(
			'LID' => array(
				'data_type' => 'integer',
				'primary' => true
			),
			'NAME' => array(
				'data_type' => 'string'
			),
			// short name
			'SITE_NAME' => array(
				'data_type' => 'string'
			)
		);
	}

}