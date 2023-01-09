<?php
class CIBlockElementProxyEntity extends CBaseEntity
{
	protected function __construct()
	{
		$this->dbTableName = 'b_iblock_element';
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

// Greated only for groupping deal products in report (please see CCrmReportHelper::getGrcColumns)
class CIBlockElementGrcProxyEntity extends CBaseEntity
{
	protected function __construct()
	{
		$this->dbTableName = 'b_iblock_element';
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
