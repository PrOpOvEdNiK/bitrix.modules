<?php
class CCrmExternalSaleEntity extends CBaseEntity
{
	protected function __construct()
	{
		$this->dbTableName = 'b_crm_external_sale';
	}

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
			)
		);
	}
}
