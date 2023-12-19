<?php

namespace Bitrix\Crm\Service\Factory;

use Bitrix\Crm\Binding\LeadContactTable;
use Bitrix\Crm\Category\Entity\Category;
use Bitrix\Crm\Field;
use Bitrix\Crm\Item;
use Bitrix\Crm\LeadTable;
use Bitrix\Crm\PhaseSemantics;
use Bitrix\Crm\Service;
use Bitrix\Crm\Service\Container;
use Bitrix\Crm\Service\Context;
use Bitrix\Crm\Service\EventHistory\TrackedObject;
use Bitrix\Crm\Service\Operation;
use Bitrix\Crm\Settings\LeadSettings;
use Bitrix\Crm\Statistics;
use Bitrix\Crm\StatusTable;
use Bitrix\Main\IO\Path;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\NotSupportedException;
use Bitrix\Main\ObjectNotFoundException;
use Bitrix\Main\ORM\Objectify\EntityObject;

final class Lead extends Service\Factory
{
	protected $itemClassName = Item\Lead::class;

	public function __construct()
	{
		Loc::loadMessages(Path::combine(__DIR__, '..', '..', '..', 'classes', 'general', 'crm_lead.php'));
	}

	public function isSourceEnabled(): bool
	{
		return true;
	}

	public function isNewRoutingForDetailEnabled(): bool
	{
		return false;
	}

	public function isRecyclebinEnabled(): bool
	{
		return LeadSettings::getCurrent()->isRecycleBinEnabled();
	}

	public function isDeferredCleaningEnabled(): bool
	{
		return LeadSettings::getCurrent()->isDeferredCleaningEnabled();
	}

	public function isNewRoutingForAutomationEnabled(): bool
	{
		return false;
	}

	public function isUseInUserfieldEnabled(): bool
	{
		return true;
	}

	public function isCrmTrackingEnabled(): bool
	{
		return true;
	}

	public function isLinkWithProductsEnabled(): bool
	{
		return true;
	}

	public function getStagesEntityId(?int $categoryId = null): ?string
	{
		return 'STATUS';
	}

	public function isNewRoutingForListEnabled(): bool
	{
		return false;
	}

	public function isAutomationEnabled(): bool
	{
		return true;
	}

	public function isBizProcEnabled(): bool
	{
		return true;
	}

	public function isObserversEnabled(): bool
	{
		return true;
	}

	public function isClientEnabled(): bool
	{
		return true;
	}

	public function isMultiFieldsEnabled(): bool
	{
		return true;
	}

	public function getDataClass(): string
	{
		return LeadTable::class;
	}

	protected function configureItem(Item $item, EntityObject $entityObject): void
	{
		parent::configureItem($item, $entityObject);

		$fieldNameMap =
			(new Item\FieldImplementation\Binding\FieldNameMap())
				->setSingleId(Item::FIELD_NAME_CONTACT_ID)
				->setMultipleIds(Item::FIELD_NAME_CONTACT_IDS)
				->setBindings(Item::FIELD_NAME_CONTACT_BINDINGS)
				->setBoundEntities(Item::FIELD_NAME_CONTACTS)
		;

		$item->addImplementation(
			new Item\FieldImplementation\Binding(
				$entityObject,
				\CCrmOwnerType::Contact,
				$fieldNameMap,
				LeadContactTable::getEntity(),
				Container::getInstance()->getContactBroker(),
			)
		);
	}

	/**
	 * @inheritDoc
	 */
	public function getFieldsMap(): array
	{
		return [
			Item::FIELD_NAME_STAGE_ID => Item\Lead::FIELD_NAME_STATUS_ID,
			Item::FIELD_NAME_STAGE_SEMANTIC_ID => 'STATUS_SEMANTIC_ID',
			Item::FIELD_NAME_CREATED_TIME => Item\Lead::FIELD_NAME_DATE_CREATE,
			Item::FIELD_NAME_UPDATED_TIME => Item\Lead::FIELD_NAME_DATE_MODIFY,
			Item::FIELD_NAME_CREATED_BY => Item\Lead::FIELD_NAME_CREATED_BY_ID,
			Item::FIELD_NAME_UPDATED_BY => Item\Lead::FIELD_NAME_MODIFY_BY_ID,
			Item::FIELD_NAME_MOVED_BY => 'MOVED_BY_ID',
			Item::FIELD_NAME_OBSERVERS => 'OBSERVER_IDS',
		];
	}

	public function getEntityTypeId(): int
	{
		return \CCrmOwnerType::Lead;
	}

	protected function getFieldsSettings(): array
	{
		return [
			Item::FIELD_NAME_ID => [
				'TYPE' => Field::TYPE_INTEGER,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::ReadOnly, \CCrmFieldInfoAttr::AutoGenerated],
			],
			Item::FIELD_NAME_TITLE => [
				'TYPE' => Field::TYPE_STRING,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::HasDefaultValue, \CCrmFieldInfoAttr::CanNotBeEmptied],
				'CLASS' => Field\Title::class,
			],
			Item::FIELD_NAME_HONORIFIC => [
				'TYPE' => Field::TYPE_CRM_STATUS,
				'CRM_STATUS_TYPE' => StatusTable::ENTITY_ID_HONORIFIC,
			],
			Item::FIELD_NAME_NAME => [
				'TYPE' => Field::TYPE_STRING,
			],
			Item::FIELD_NAME_SECOND_NAME => [
				'TYPE' => Field::TYPE_STRING,
			],
			Item::FIELD_NAME_LAST_NAME => [
				'TYPE' => Field::TYPE_STRING,
				// it's not a mistake that Field\LastName is not used here. Empty last name for lead is ok
			],
			Item::FIELD_NAME_FULL_NAME => [
				'TYPE' => Field::TYPE_STRING,
				'ATTRIBUTES' => [
					\CCrmFieldInfoAttr::Hidden,
					\CCrmFieldInfoAttr::ReadOnly,
					\CCrmFieldInfoAttr::AutoGenerated,
				],
				'CLASS' => Field\FullName::class,
			],
			Item::FIELD_NAME_BIRTHDATE => [
				'TYPE' => Field::TYPE_DATE,
			],
			Item::FIELD_NAME_BIRTHDAY_SORT => [
				'TYPE' => Field::TYPE_INTEGER,
				'ATTRIBUTES' => [
					\CCrmFieldInfoAttr::Hidden,
					\CCrmFieldInfoAttr::ReadOnly,
					\CCrmFieldInfoAttr::AutoGenerated,
				],
				'CLASS' => Field\BirthdaySort::class,
			],
			Item\Lead::FIELD_NAME_COMPANY_TITLE => [
				'TYPE' => Field::TYPE_STRING,
			],
			Item::FIELD_NAME_SOURCE_ID => [
				'TYPE' => Field::TYPE_CRM_STATUS,
				'CRM_STATUS_TYPE' => StatusTable::ENTITY_ID_SOURCE,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::HasDefaultValue],
			],
			Item::FIELD_NAME_SOURCE_DESCRIPTION => [
				'TYPE' => Field::TYPE_TEXT,
			],
			Item::FIELD_NAME_STAGE_ID => [
				'TYPE' => Field::TYPE_CRM_STATUS,
				'CRM_STATUS_TYPE' => $this->getStagesEntityId(),
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::Progress],
				'CLASS' => Field\Stage::class,
			],
			Item\Lead::FIELD_NAME_STATUS_DESCRIPTION => [
				'TYPE' => Field::TYPE_TEXT,
			],
			Item::FIELD_NAME_STAGE_SEMANTIC_ID => [
				'TYPE' => Field::TYPE_STRING,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::ReadOnly],
				'CLASS' => Field\StageSemanticId::class,
			],
			Item::FIELD_NAME_POST => [
				'TYPE' => Field::TYPE_STRING,
			],
			Item::FIELD_NAME_CURRENCY_ID => [
				'TYPE' => Field::TYPE_CRM_CURRENCY,
				'ATTRIBUTES' => [
					\CCrmFieldInfoAttr::NotDisplayed,
					\CCrmFieldInfoAttr::HasDefaultValue,
					\CCrmFieldInfoAttr::CanNotBeEmptied,
				],
				'CLASS' => Field\CurrencyId::class,
			],
			Item::FIELD_NAME_EXCH_RATE => [
				'TYPE' => Field::TYPE_DOUBLE,
				'ATTRIBUTES' => [
					\CCrmFieldInfoAttr::NotDisplayed,
					\CCrmFieldInfoAttr::Hidden,
					\CCrmFieldInfoAttr::AutoGenerated,
				],
				'CLASS' => Field\ExchRate::class,
			],
			Item::FIELD_NAME_ACCOUNT_CURRENCY_ID => [
				'TYPE' => Field::TYPE_CRM_CURRENCY,
				'ATTRIBUTES' => [
					\CCrmFieldInfoAttr::NotDisplayed,
					\CCrmFieldInfoAttr::Hidden,
					\CCrmFieldInfoAttr::ReadOnly,
					\CCrmFieldInfoAttr::HasDefaultValue,
				],
			],
			Item::FIELD_NAME_IS_MANUAL_OPPORTUNITY => [
				'TYPE' => Field::TYPE_BOOLEAN,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::NotDisplayed],
			],
			Item::FIELD_NAME_PRODUCTS => [
				'TYPE' => Field::TYPE_CRM_PRODUCT_ROW,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::Multiple, \CCrmFieldInfoAttr::Hidden, \CCrmFieldInfoAttr::NotDisplayed],
				'CLASS' => Field\ProductRows::class,
			],
			Item::FIELD_NAME_OPPORTUNITY => [
				'TYPE' => Field::TYPE_DOUBLE,
				'CLASS' => Field\Opportunity::class,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::NotDisplayed],
			],
			Item::FIELD_NAME_OPPORTUNITY_ACCOUNT => [
				'TYPE' => Field::TYPE_DOUBLE,
				'ATTRIBUTES' => [
					\CCrmFieldInfoAttr::NotDisplayed,
					\CCrmFieldInfoAttr::Hidden,
					\CCrmFieldInfoAttr::ReadOnly,
				],
				'CLASS' => Field\OpportunityAccount::class,
			],
			Item::FIELD_NAME_OPENED => [
				'TYPE' => Field::TYPE_BOOLEAN,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::Required],
				'CLASS' => Field\Opened::class,
			],
			Item::FIELD_NAME_COMMENTS => [
				'TYPE' => Field::TYPE_TEXT,
				'VALUE_TYPE' => Field::VALUE_TYPE_BB,
				'CLASS' => Field\Comments::class,
			],
			Item::FIELD_NAME_HAS_PHONE => [
				'TYPE' => Field::TYPE_BOOLEAN,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::ReadOnly, \CCrmFieldInfoAttr::AutoGenerated],
				'CLASS' => Field\HasPhone::class,
			],
			Item::FIELD_NAME_HAS_EMAIL => [
				'TYPE' => Field::TYPE_BOOLEAN,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::ReadOnly, \CCrmFieldInfoAttr::AutoGenerated],
				'CLASS' => Field\HasEmail::class,
			],
			Item::FIELD_NAME_HAS_IMOL => [
				'TYPE' => Field::TYPE_BOOLEAN,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::ReadOnly, \CCrmFieldInfoAttr::AutoGenerated],
				'CLASS' => Field\HasImol::class,
			],
			Item::FIELD_NAME_ASSIGNED => [
				'TYPE' => Field::TYPE_USER,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::CanNotBeEmptied, \CCrmFieldInfoAttr::HasDefaultValue],
				'CLASS' => Field\Assigned::class,
			],
			Item::FIELD_NAME_CREATED_BY => [
				'TYPE' => Field::TYPE_USER,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::ReadOnly, \CCrmFieldInfoAttr::AutoGenerated],
				'CLASS' => Field\CreatedBy::class,
			],
			Item::FIELD_NAME_UPDATED_BY => [
				'TYPE' => Field::TYPE_USER,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::ReadOnly, \CCrmFieldInfoAttr::AutoGenerated],
				'CLASS' => Field\UpdatedBy::class,
			],
			Item::FIELD_NAME_MOVED_BY => [
				'TYPE' => Field::TYPE_USER,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::ReadOnly, \CCrmFieldInfoAttr::AutoGenerated],
				'CLASS' => Field\MovedBy::class,
			],
			Item::FIELD_NAME_LAST_ACTIVITY_BY => [
				'TYPE' => Field::TYPE_USER,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::ReadOnly, \CCrmFieldInfoAttr::AutoGenerated],
			],
			Item::FIELD_NAME_CREATED_TIME => [
				'TYPE' => Field::TYPE_DATETIME,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::ReadOnly, \CCrmFieldInfoAttr::AutoGenerated],
				'CLASS' => Field\CreatedTime::class,
			],
			Item::FIELD_NAME_UPDATED_TIME => [
				'TYPE' => Field::TYPE_DATETIME,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::ReadOnly, \CCrmFieldInfoAttr::AutoGenerated],
				'CLASS' => Field\UpdatedTime::class,
			],
			Item::FIELD_NAME_MOVED_TIME => [
				'TYPE' => Field::TYPE_DATETIME,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::ReadOnly, \CCrmFieldInfoAttr::AutoGenerated],
				'CLASS' => Field\MovedTime::class,
			],
			Item::FIELD_NAME_LAST_ACTIVITY_TIME => [
				'TYPE' => Field::TYPE_DATETIME,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::ReadOnly, \CCrmFieldInfoAttr::AutoGenerated],
				'CLASS' => Field\LastActivityTime::class,
			],
			Item::FIELD_NAME_COMPANY_ID => [
				'TYPE' => Field::TYPE_CRM_COMPANY,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::NotDisplayed],
				'SETTINGS' => [
					'parentEntityTypeId' => \CCrmOwnerType::Company,
				],
			],
			Item::FIELD_NAME_CONTACT_ID => [
				'TYPE' => Field::TYPE_CRM_CONTACT,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::NotDisplayed, \CCrmFieldInfoAttr::Deprecated],
			],
			Item::FIELD_NAME_CONTACT_IDS => [
				'TYPE' => Field::TYPE_CRM_CONTACT,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::NotDisplayed, \CCrmFieldInfoAttr::Multiple]
			],
			Item::FIELD_NAME_CONTACTS => [
				'TYPE' => Field::TYPE_CRM_CONTACT,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::NotDisplayed, \CCrmFieldInfoAttr::Multiple]
			],
			Item::FIELD_NAME_IS_RETURN_CUSTOMER => [
				'TYPE' => Field::TYPE_BOOLEAN,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::ReadOnly, \CCrmFieldInfoAttr::NotDisplayed],
				'CLASS' => Field\IsReturnCustomer::class,
				'SETTINGS' => [
					'isPrimarySource' => true,
				],
			],
			// it has similar logic to Item::FIELD_NAME_CLOSE_DATE, but they are not the same field.
			Item\Lead::FIELD_NAME_DATE_CLOSED => [
				'TYPE' => Field::TYPE_DATETIME,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::ReadOnly, \CCrmFieldInfoAttr::NotDisplayed],
				'CLASS' => Field\CloseDate::class,
				'SETTINGS' => [
					'isSetCurrentDateOnCompletionEnabled' => true,
				],
			],
			Item::FIELD_NAME_ORIGINATOR_ID => [
				'TYPE' => Field::TYPE_STRING,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::NotDisplayed],
			],
			Item::FIELD_NAME_ORIGIN_ID => [
				'TYPE' => Field::TYPE_STRING,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::NotDisplayed],
			],
			Item::FIELD_NAME_FACE_ID => [
				'TYPE' => Field::TYPE_INTEGER,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::Hidden],
			],
			Item::FIELD_NAME_WEBFORM_ID => [
				'TYPE' => Field::TYPE_INTEGER,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::NotDisplayed],
			],
			Item::FIELD_NAME_OBSERVERS => [
				'TYPE' => Field::TYPE_USER,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::Multiple],
				'CLASS' => Field\Observers::class,
			],
			Item::FIELD_NAME_FM => [
				'TYPE' => Field::TYPE_CRM_MULTIFIELD,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::Multiple],
				'CLASS' => Field\Multifield::class,
			],
		];
	}

	public function createCategory(array $data = []): Category
	{
		throw new NotSupportedException('Lead doesn\'t support categories');
	}

	protected function loadCategories(): array
	{
		throw new NotSupportedException('Lead doesn\'t support categories');
	}

	protected function getTrackedFieldNames(): array
	{
		return [
			Item::FIELD_NAME_TITLE,
			Item::FIELD_NAME_NAME,
			Item::FIELD_NAME_SECOND_NAME,
			Item::FIELD_NAME_LAST_NAME,
			Item::FIELD_NAME_POST,
			Item::FIELD_NAME_STAGE_ID,
			Item\Lead::FIELD_NAME_STATUS_DESCRIPTION,
			Item::FIELD_NAME_COMMENTS,
			Item::FIELD_NAME_CURRENCY_ID,
			Item::FIELD_NAME_OPPORTUNITY,
			Item::FIELD_NAME_IS_MANUAL_OPPORTUNITY,
			Item::FIELD_NAME_SOURCE_ID,
			Item::FIELD_NAME_SOURCE_DESCRIPTION,
			Item\Lead::FIELD_NAME_COMPANY_TITLE,
			Item::FIELD_NAME_ASSIGNED,
			Item::FIELD_NAME_BIRTHDATE,
			Item::FIELD_NAME_IS_RETURN_CUSTOMER,
			Item::FIELD_NAME_FM,
		];
	}

	protected function getDependantTrackedObjects(): array
	{
		$objects = [];

		$productTrackedObject = new TrackedObject\Product();
		$productTrackedObject->makeThisObjectDependant(Item::FIELD_NAME_PRODUCTS);
		$objects[] = $productTrackedObject;

		return $objects;
	}

	protected function getOperationSettings(?Context $context): Operation\Settings
	{
		$settings = parent::getOperationSettings($context);

		$providersToAutocomplete = [];

		$completionConfig = LeadSettings::getCurrent()->getActivityCompletionConfig();
		foreach (\Bitrix\Crm\Activity\Provider\ProviderManager::getCompletableProviderIdFlatList() as $providerID)
		{
			$shouldBeAutocompleted = $completionConfig[$providerID] ?? true;
			if ($shouldBeAutocompleted)
			{
				$providersToAutocomplete[] = $providerID;
			}
		}

		$settings->setActivityProvidersToAutocomplete($providersToAutocomplete);
		if (empty($providersToAutocomplete))
		{
			// nothing to complete, all providers disabled by settings
			$settings->disableActivitiesAutocompletion();
		}

		return $settings;
	}

	protected function configureAddOperation(Operation $operation): void
	{
		$operation
			->addAction(
				Operation::ACTION_BEFORE_SAVE,
				new Operation\Action\Compatible\SendEvent\WithCancel\Update(
					'OnBeforeCrmLeadAdd',
					'CRM_LEAD_CREATION_CANCELED',
			),
			)
			->addAction(
				Operation::ACTION_AFTER_SAVE,
				new Operation\Action\ClearCache('b_crm_lead', ),
			)
			->addAction(
				Operation::ACTION_AFTER_SAVE,
				new Operation\Action\Compatible\SocialNetwork\ProcessAdd(),
			)
			->addAction(
				Operation::ACTION_AFTER_SAVE,
				new Operation\Action\Compatible\SendEvent('OnAfterCrmLeadAdd'),
			)
			->addAction(
				Operation::ACTION_AFTER_SAVE,
				new Operation\Action\Compatible\SendEvent\ExternalAdd('OnAfterExternalCrmLeadAdd'),
			)
			->addAction(
				Operation::ACTION_AFTER_SAVE,
				new Operation\Action\Compatible\SendEvent\ProductRowsSave('OnAfterCrmLeadProductRowsSave'),
			)
		;
	}

	public function getUpdateOperation(Item $item, Context $context = null): Operation\Update
	{
		$operation = parent::getUpdateOperation($item, $context);

		$operation
			->addAction(
				Operation::ACTION_BEFORE_SAVE,
				new Operation\Action\Compatible\SendEvent\WithCancel\Update(
					'OnBeforeCrmLeadUpdate',
					'CRM_LEAD_UPDATE_CANCELED',
				),
			)
			->addAction(
				Operation::ACTION_AFTER_SAVE,
				new Operation\Action\ClearCache(
					null,
					'crm_entity_name_' . $this->getEntityTypeId() . '_',
					[Item::FIELD_NAME_TITLE]
				)
			)
			->addAction(
				Operation::ACTION_AFTER_SAVE,
				new Operation\Action\FillEntityFieldsContext()
			)
			->addAction(
				Operation::ACTION_AFTER_SAVE,
				new Operation\Action\ResetEntityCommunicationSettingsInActivities(),
			)
			->addAction(
				Operation::ACTION_AFTER_SAVE,
				new Operation\Action\Compatible\SocialNetwork\ProcessUpdate(),
			)
			->addAction(
				Operation::ACTION_AFTER_SAVE,
				new Operation\Action\UpdateMlScoring(),
			)
			->addAction(
				Operation::ACTION_AFTER_SAVE,
				new Operation\Action\Compatible\SendEvent('OnAfterCrmLeadUpdate'),
			)
			->addAction(
				Operation::ACTION_AFTER_SAVE,
				new Operation\Action\Compatible\SendEvent\ProductRowsSave('OnAfterCrmLeadProductRowsSave'),
			)
		;

		return $operation;
	}

	public function getDeleteOperation(Item $item, Context $context = null): Operation\Delete
	{
		$operation = parent::getDeleteOperation($item, $context);

		$operation
			->addAction(
				Operation::ACTION_BEFORE_SAVE,
				new Operation\Action\Compatible\SendEvent\WithCancel\Delete('OnBeforeCrmLeadDelete')
			)
			->addAction(
				Operation::ACTION_AFTER_SAVE,
				new Operation\Action\ClearCache(
					'b_crm_lead',
					'crm_entity_name_' . $this->getEntityTypeId() . '_'
				)
			)
			->addAction(
				Operation::ACTION_AFTER_SAVE,
				new Operation\Action\DeleteEntityFieldsContext()
			)
		;

		// the action works properly only in this case. otherwise, does basically nothing, since on time of execution all
		// activities either rebound to recycle bin entity or deleted immediately.
		// in most cases this action is not needed, was added to extend backwards compatibility
		if (!$this->isRecyclebinEnabled() && $this->isDeferredCleaningEnabled())
		{
			$operation
				->addAction(
					Operation::ACTION_AFTER_SAVE,
					new Operation\Action\Compatible\RebindActivitiesToClient($this->getSuccessfulStageId()),
				)
			;
		}

		$operation
			->addAction(
				Operation::ACTION_AFTER_SAVE,
				new Operation\Action\Compatible\SocialNetwork\ProcessDelete(),
			)
			->addAction(
				Operation::ACTION_AFTER_SAVE,
				new Operation\Action\Compatible\SendEvent\Delete('OnAfterCrmLeadDelete')
			)
		;

		return $operation;
	}

	private function getSuccessfulStageId(): string
	{
		foreach ($this->getStages() as $stage)
		{
			if ($stage->getSemantics() === PhaseSemantics::SUCCESS)
			{
				return $stage->getStatusId();
			}
		}

		throw new ObjectNotFoundException('Successful stage for lead was not found');
	}

	protected function getStatisticsFacade(): ?Statistics\OperationFacade
	{
		return new Statistics\OperationFacade\Lead($this->getSuccessfulStageId());
	}

	public function isCountersEnabled(): bool
	{
		return true;
	}

	public function isSmartActivityNotificationSupported(): bool
	{
		return true;
	}
}
