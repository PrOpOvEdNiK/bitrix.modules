<?php

class CUtmUserEntity extends CBaseEntity
{
	protected function __construct() {}

	public function initialize()
	{
		$this->className = __CLASS__;
		$this->filePath = __FILE__;

		// get ufields
		global $USER_FIELD_MANAGER;

		$this->fieldsMap = $USER_FIELD_MANAGER->GetUserFields($this->uf_id);

		foreach ($this->fieldsMap as $k => $v)
		{
			if ($v['MULTIPLE'] == 'N')
			{
				unset($this->fieldsMap[$k]);
			}
		}

		$this->fieldsMap = array_merge(array(
			'ID' => array(
				'data_type' => 'integer',
				'primary' => true
			),
			'VALUE_ID' => array(
				'data_type' => 'integer'
			),
			'SOURCE_OBJECT' => array(
				'data_type' => 'User',
				'reference' => array('=this.VALUE_ID' => 'ref.ID')
			),
			'FIELD_ID' => array(
				'data_type' => 'integer'
			),
			'VALUE' => array(
				'data_type' => 'string'
			),
			'VALUE_INT' => array(
				'data_type' => 'integer'
			),
			'VALUE_DOUBLE' => array(
				'data_type' => 'float'
			),
			'VALUE_DATE' => array(
				'data_type' => 'datetime'
			)
		), $this->fieldsMap);

	}

	public function IsUtm()
	{
		return true;
	}
}