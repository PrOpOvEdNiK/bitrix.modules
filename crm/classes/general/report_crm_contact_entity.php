<?php
class CCrmContactEntity extends CBaseEntity
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
			'NAME' => array(
				'data_type' => 'string'
			),
			'LAST_NAME' => array(
				'data_type' => 'string'
			),
			'SECOND_NAME' => array(
				'data_type' => 'string'
			),
			'POST' => array(
				'data_type' => 'string'
			),
			'ADDRESS' => array(
				'data_type' => 'string'
			),
			'COMMENTS' => array(
				'data_type' => 'string'
			),
			'TYPE_ID' => array(
				'data_type' => 'string'
			),
			'TYPE_BY' => array(
				'data_type' => 'CrmStatus',
				'reference' => array(
                    '=this.TYPE_ID' => 'ref.STATUS_ID',
                    '=ref.ENTITY_ID' => array('?', 'CONTACT_TYPE')
                )
			),
			'SOURCE_ID' => array(
				'data_type' => 'string'
			),
			'SOURCE_BY' => array(
				'data_type' => 'CrmStatus',
				'reference' => array(
                    '=this.SOURCE_ID' => 'ref.STATUS_ID',
                    '=ref.ENTITY_ID' => array('?', 'SOURCE')
                )
			),
			'SOURCE_DESCRIPTION' => array(
				'data_type' => 'string'
			),
			'DATE_CREATE' => array(
				'data_type' => 'datetime'
			),
			'DATE_MODIFY' => array(
				'data_type' => 'datetime'
			),
			'ASSIGNED_BY_ID' => array(
				'data_type' => 'integer'
			),
			'ASSIGNED_BY' => array(
				'data_type' => 'User',
				'reference' => array('=this.ASSIGNED_BY_ID' => 'ref.ID')
			),
			'CREATED_BY_ID' => array(
				'data_type' => 'integer'
			),
			'CREATED_BY' => array(
				'data_type' => 'User',
				'reference' => array('=this.CREATED_BY_ID' => 'ref.ID')
			),
			'MODIFY_BY_ID' => array(
				'data_type' => 'integer'
			),
			'MODIFY_BY' => array(
				'data_type' => 'User',
				'reference' => array('=this.MODIFY_BY_ID' => 'ref.ID')
			),
			'EVENT_RELATION' => array(
				'data_type' => 'CrmEventRelations',
				'reference' => array('=this.ID' => 'ref.ENTITY_ID')
			)
		);
	}
}

?>