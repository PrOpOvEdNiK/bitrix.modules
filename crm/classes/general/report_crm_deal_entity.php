<?php
class CCrmDealEntity extends CBaseEntity
{
	private static $STATUS_INIT = false;
	private static $WORK_STATUSES = array();
	private static $LOSE_STATUSES = array();
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
			'TITLE' => array(
				'data_type' => 'string'
			),
			'OPPORTUNITY' => array(
				'data_type' => 'integer'
			),
			'CURRENCY_ID' => array(
				'data_type' => 'string'
			),
//			'CURRENCY_BY' => array(
//				'data_type' => 'CrmStatus',
//				'reference' => array('CURRENCY_ID', 'STATUS_ID')
//			),
			'OPPORTUNITY_ACCOUNT' => array(
				'data_type' => 'integer'
			),
			'ACCOUNT_CURRENCY_ID' => array(
				'data_type' => 'string'
			),
			'EXCH_RATE' => array(
				'data_type' => 'integer'
			),
			'PROBABILITY' => array(
				'data_type' => 'integer'
			),
			'STAGE_ID' => array(
				'data_type' => 'string'
			),
			'STAGE_BY' => array(
				'data_type' => 'CrmStatus',
				'reference' => array(
					'=this.STAGE_ID' => 'ref.STATUS_ID',
					'=ref.ENTITY_ID' => array('?', 'STATUS')
				)
			),
			'CLOSED' => array(
				'data_type' => 'boolean',
				'values' => array('N', 'Y')
			),
			'TYPE_ID' => array(
				'data_type' => 'string'
			),
			'TYPE_BY' => array(
				'data_type' => 'CrmStatus',
				'reference' => array(
					'=this.TYPE_ID' => 'ref.STATUS_ID',
					'=ref.ENTITY_ID' => array('?', 'DEAL_TYPE')
				)
			),
			'COMMENTS' => array(
				'data_type' => 'string'
			),
			'BEGINDATE' => array(
				'data_type' => 'datetime'
			),
			'CLOSEDATE' => array(
				'data_type' => 'datetime'
			),
			'EVENT_DATE' => array(
				'data_type' => 'datetime'
			),
			'EVENT_ID' => array(
				'data_type' => 'string'
			),
			'EVENT_BY' => array(
				'data_type' => 'CrmStatus',
				'reference' => array(
					'=this.EVENT_ID' => 'ref.STATUS_ID',
					'=ref.ENTITY_ID' => array('?', 'EVENT_TYPE')
				)
			),
			'EVENT_DESCRIPTION' => array(
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
			),
			'LEAD_ID' => array(
				'data_type' => 'integer'
			),
			'LEAD_BY' => array(
				'data_type' => 'CrmLead',
				'reference' => array('=this.LEAD_ID' => 'ref.ID')
			),
			'CONTACT_ID' => array(
				'data_type' => 'integer'
			),
			'CONTACT_BY' => array(
				'data_type' => 'CrmContact',
				'reference' => array('=this.CONTACT_ID' => 'ref.ID')
			),
			'COMPANY_ID' => array(
				'data_type' => 'integer'
			),
			'COMPANY_BY' => array(
				'data_type' => 'CrmCompany',
				'reference' => array('=this.COMPANY_ID' => 'ref.ID')
			),
			'IS_WON' => array(
				'data_type' => 'boolean',
				'expression' => array(
					'CASE WHEN %s = \'WON\' THEN 1 ELSE 0 END',
					'STAGE_ID'
				),
				'values' => array(0, 1)
			),
			'IS_WORK' => array(
				'data_type' => 'boolean',
				'expression' => array(
					'CASE WHEN %s IN %%WORK_STATUS_IDS%% THEN 1 ELSE 0 END',
					'STAGE_ID'
				),
				'values' => array(0, 1)
			),
			'IS_LOSE' => array(
				'data_type' => 'boolean',
				'expression' => array(
					'CASE WHEN %s IN %%LOSE_STATUS_IDS%% THEN 1 ELSE 0 END',
					'STAGE_ID'
				),
				'values' => array(0, 1)
			),
			'RECEIVED_AMOUNT' => array(
				'data_type' => 'integer',
				'expression' => array(
					'CASE WHEN %s = \'WON\' THEN %s ELSE 0 END',
					'STAGE_ID', 'OPPORTUNITY_ACCOUNT'
				)
			),
			'LOST_AMOUNT' => array(
				'data_type' => 'integer',
				'expression' => array(
					'CASE WHEN %s = \'LOSE\' THEN %s ELSE 0 END',
					'STAGE_ID', 'OPPORTUNITY_ACCOUNT'
				)
			),
			'HAS_PRODUCTS' => array(
				'data_type' => 'boolean',
				'expression' => array(
					'CASE WHEN EXISTS (SELECT ID FROM b_crm_product_row WHERE OWNER_ID = %s AND OWNER_TYPE = \'D\') THEN 1 ELSE 0 END',
					'ID'
				),
				'values' => array(0, 1)
			),
			'ORIGIN_ID' => array(
				'data_type' => 'string'
			),
			'ORIGINATOR_ID' => array(
				'data_type' => 'string'
			),
			'ORIGINATOR_BY' => array(
				'data_type' => 'CrmExternalSale',
				'reference' => array('=this.ORIGINATOR_ID' => 'ref.ID')
			)
		);
	}

	private static function EnsureStatusesLoaded()
	{
		if(self::$STATUS_INIT)
		{
			return;
		}

		global $DB;

		$wonStatus = null;
		$arStatuses = array();
		$rsStatuses = $DB->Query('SELECT STATUS_ID, SORT FROM b_crm_status WHERE ENTITY_ID = \'DEAL_STAGE\'');
		while($arStatus = $rsStatuses->Fetch())
		{
			if(!$wonStatus && strval($arStatus['STATUS_ID']) === 'WON')
			{
				$wonStatus = $arStatus;
				continue;
			}

			$arStatuses[$arStatus['STATUS_ID']] = $arStatus;
		}

		self::$WORK_STATUSES = array();
		self::$LOSE_STATUSES = array();

		if($wonStatus)
		{
			$wonStatusSort = intval($wonStatus['SORT']);
			foreach($arStatuses as $statusID => $arStatus)
			{
				$sort = intval($arStatus['SORT']);
				if($sort < $wonStatusSort)
				{
					self::$WORK_STATUSES[] = '\''.$statusID.'\'';;
				}
				elseif($sort > $wonStatusSort)
				{
					self::$LOSE_STATUSES[] = '\''.$statusID.'\'';
				}
			}
		}

		self::$STATUS_INIT = true;
	}

	public static function ProcessQueryOptions(&$options)
	{
		$stub = '_BX_STATUS_STUB_';
		self::EnsureStatusesLoaded();
		$options['WORK_STATUS_IDS'] = '('.(!empty(self::$WORK_STATUSES) ? implode(',', self::$WORK_STATUSES) : "'$stub'").')';
		$options['LOSE_STATUS_IDS'] = '('.(!empty(self::$LOSE_STATUSES) ? implode(',', self::$LOSE_STATUSES) : "'$stub'").')';
	}
}

?>