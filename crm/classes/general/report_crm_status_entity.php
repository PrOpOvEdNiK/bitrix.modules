<?php

class CCrmStatusEntity extends CBaseEntity
{
	protected function __construct() {}

	public function initialize()
	{
		$this->className = __CLASS__;
		$this->filePath = __FILE__;

		$this->dbTableName = 'b_crm_status';

		$this->fieldsMap = array(
			'ENTITY_ID' => array(
				'data_type' => 'integer',
				'primary' => true
			),
			'STATUS_ID' => array(
				'data_type' => 'string',
				'primary' => true
			),
			'NAME' => array(
				'data_type' => 'string'
			),
			'SORT' => array(
				'data_type' => 'integer'
			)
		);
	}

}
?>