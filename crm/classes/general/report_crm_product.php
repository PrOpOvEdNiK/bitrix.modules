<?php
class CCrmProductEntity extends CBaseEntity
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
			'IBLOCK_ELEMENT' => array(
				'data_type' => 'IBlockElementProxy',
				'reference' => array('=this.ID' => 'ref.ID')
			),
			'IBLOCK_ELEMENT_GRC' => array(
				'data_type' => 'IBlockElementGrcProxy',
				'reference' => array('=this.ID' => 'ref.ID')
			)
		);
	}
}
