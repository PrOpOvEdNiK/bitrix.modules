<?php

class CUtsUserEntity extends CBaseEntity
{
	protected function __construct() {}

	public function initialize()
	{
		$this->className = __CLASS__;
		$this->filePath = __FILE__;

		$this->uf_id = 'USER';

		// get ufields
		global $USER_FIELD_MANAGER;

		$this->fieldsMap = $USER_FIELD_MANAGER->GetUserFields($this->uf_id);

		foreach ($this->fieldsMap as $k => $v)
		{
			if ($v['MULTIPLE'] == 'Y')
			{
				unset($this->fieldsMap[$k]);
			}
		}

		$this->fieldsMap['VALUE_ID'] = array(
			'data_type' => 'integer',
			'primary' => true
		);

		$this->fieldsMap['SOURCE_OBJECT'] = array(
			'data_type' => 'User',
			'reference' => array('=this.VALUE_ID' => 'ref.ID')
		);
	}

	public function IsUts()
	{
		return true;
	}
}

