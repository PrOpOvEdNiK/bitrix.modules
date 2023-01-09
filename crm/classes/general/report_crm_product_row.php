<?php
class CCrmProductRowEntity extends CBaseEntity
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
			'OWNER_ID' => array(
				'data_type' => 'integer'
			),
			'OWNER_TYPE' => array(
				'data_type' => 'string'
			),
			'OWNER' => array(
				'data_type' => 'CrmDeal',
				'reference' => array('=this.OWNER_ID' => 'ref.ID')
			),
            'DEAL_OWNER' => array(
                'data_type' => 'CrmDeal',
                'reference' => array(
                    '=this.OWNER_ID' => 'ref.ID',
                    '=this.OWNER_TYPE' => array('?', 'D')
                )
            ),
			'PRODUCT_ID' => array(
				'data_type' => 'integer'
			),
			'PRODUCT' => array(
				'data_type' => 'CrmProduct',
				'reference' => array('=this.PRODUCT_ID' => 'ref.ID')
			),
			'PRICE' => array(
				'data_type' => 'integer'
			),
			'PRICE_ACCOUNT' => array(
				'data_type' => 'integer'
			),
			'QUANTITY' => array(
				'data_type' => 'integer'
			),
			'SUM_ACCOUNT' => array(
				'data_type' => 'integer',
				'expression' => array(
					'%s * %s',
					'PRICE_ACCOUNT', 'QUANTITY'
				)
			)
		);
	}
}