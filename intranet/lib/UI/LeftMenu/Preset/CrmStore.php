<?php
namespace Bitrix\Intranet\UI\LeftMenu\Preset;

use Bitrix\Main\Localization\Loc;

class CrmStore extends Crm
{
	const CODE = 'crm_store';

	const STRUCTURE = [
		'shown' => [
			'menu_crm_store',
			'menu_crm_favorite',
			'menu_marketing',
			'menu_sites',
			'menu_shop',
			'menu_tasks',
			'menu_teamwork' => [
				'menu_live_feed',
				'menu_im_messenger',
				'menu_calendar',
				'menu_documents',
				'menu_files',
				'menu_external_mail',
				'menu_all_groups',
				'menu_all_spaces',
			],
			'menu_company',
			'menu_bizproc_sect',
			'menu_automation',
			'menu_marketplace_group' => [
				'menu_marketplace_sect',
				'menu_devops_sect',
			],
		],
		'hidden' => [
			'menu_timeman_sect',
			'menu_rpa',
			"menu_contact_center",
			"menu_crm_tracking",
			"menu_analytics",
			"menu-sale-center",
			"menu_openlines",
			"menu_telephony",
			"menu_ai",
			"menu_onec_sect",
			"menu_tariff",
			"menu_updates",
			'menu_knowledge',
			'menu_conference',
			'menu_configs_sect',
		]
	];
}