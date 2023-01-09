<?php

class CCrmEventRelationsEntity extends CBaseEntity
{
	protected function __construct() {}

	public function initialize()
	{
		$this->className = __CLASS__;
		$this->filePath = __FILE__;

		global $DB;

		$this->fieldsMap = array(
			'EVENT_ID' => array(
				'data_type' => 'integer',
				'primary' => true
			),
			'EVENT_BY' => array(
				'data_type' => 'CrmEvent',
				'reference' => array('=this.EVENT_ID' => 'ref.ID')
			),
			'ENTITY_TYPE' => array(
				'data_type' => 'string'
			),
			'ENTITY_ID' => array(
				'data_type' => 'integer',
				'primary' => true
			),
			'ASSIGNED_BY_ID' => array(
				'data_type' => 'integer'
			),
			'ASSIGNED_BY' => array(
				'data_type' => 'User',
				'reference' => array('=this.ASSIGNED_BY_ID' => 'ref.ID')
			)
		);
	}
}

class CCrmEventEntity extends CBaseEntity
{
	protected function __construct() {}

	public function initialize()
	{
		$this->className = __CLASS__;
		$this->filePath = __FILE__;

		global $DB;

		$this->fieldsMap = array(
			'ID' => array(
				'data_type' => 'integer',
				'primary' => true
			),
			'EVENT_ID' => array(
				'data_type' => 'string'
			),
			'EVENT_BY' => array(
				'data_type' => 'CrmStatus',
				'reference' => array('EVENT_ID', 'STATUS_ID', 'ENTITY_ID')
			),
			'EVENT_NAME' => array(
				'data_type' => 'string'
			),
			'DATE_CREATE' => array(
				'data_type' => 'datetime'
			),
			'CREATED_BY_ID' => array(
				'data_type' => 'integer'
			),
			'CREATED_BY' => array(
				'data_type' => 'User',
				'reference' => array('CREATED_BY_ID', 'ID')
			)
		);
	}
}


?>