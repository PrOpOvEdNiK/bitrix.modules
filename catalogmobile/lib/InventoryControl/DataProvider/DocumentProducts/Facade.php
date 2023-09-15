<?php

namespace Bitrix\CatalogMobile\InventoryControl\DataProvider\DocumentProducts;

use Bitrix\Catalog\Access\AccessController;
use Bitrix\Catalog\StoreTable;
use Bitrix\CatalogMobile\Catalog;
use Bitrix\CatalogMobile\PermissionsProvider;
use Bitrix\CatalogMobile\Repository\MeasureRepository;
use Bitrix\CatalogMobile\InventoryControl\Dto\DocumentProductRecord;
use Bitrix\CatalogMobile\InventoryControl\Dto\ProductFromWizard;
use Bitrix\CatalogMobile\InventoryControl\UrlBuilder;

class Facade
{
	public static function loadByDocumentId(?int $documentId = null, ?string $documentType = null): array
	{
		$document = Document::load($documentId, $documentType);
		$items = Product::loadByDocumentId($documentId);
		$catalog = [
			'id' => Catalog::getDefaultId(),
			'base_price_id' => Catalog::getBasePrice(),
			'restricted_product_types' => Catalog::getStoreDocumentRestrictedProductTypes(),
			'currency_id' => Catalog::getBaseCurrency(),
			'url' => [
				'create_product' => UrlBuilder::getProductDetailUrl(0),
			]
		];
		$measures = MeasureRepository::findAll();

		$config = [];
		$defaultStoreId = AccessController::getCurrent()->getAllowedDefaultStoreId();
		if ($defaultStoreId)
		{
			$defaultStoreTitle = StoreTable::getRow(['select' => ['TITLE'], 'filter' => ['=ID' => $defaultStoreId]])['TITLE'];
			$config['defaultStore'] = [
				'id' => $defaultStoreId,
				'title' => $defaultStoreTitle,
			];
		}

		return [
			'document' => $document,
			'items' => $items,
			'catalog' => $catalog,
			'measures' => $measures,
			'permissions' => PermissionsProvider::getInstance()->getPermissions(),
			'config' => $config,
		];
	}

	public static function loadProductModel(int $productId, ?int $documentId = null): DocumentProductRecord
	{
		return Product::loadProductModel($productId, $documentId);
	}

	public static function buildProductModelFromWizard(ProductFromWizard $product, ?int $documentId = null): DocumentProductRecord
	{
		return Wizard::buildProductModel($product, $documentId);
	}
}
