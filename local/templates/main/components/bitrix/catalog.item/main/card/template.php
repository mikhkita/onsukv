<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $item
 * @var array $actualItem
 * @var array $minOffer
 * @var array $itemIds
 * @var array $price
 * @var array $measureRatio
 * @var bool $haveOffers
 * @var bool $showSubscribe
 * @var array $morePhoto
 * @var bool $showSlider
 * @var bool $itemHasDetailUrl
 * @var string $imgTitle
 * @var string $productTitle
 * @var string $buttonSizeClass
 * @var CatalogSectionComponent $component
 */

$actualItem['CAN_BUY'] = true;
$arItem = $actualItem;
?>

<? $renderImage = CFile::ResizeImageGet($arItem["DETAIL_PICTURE"], Array("width" => 180, "height" => 180), BX_RESIZE_IMAGE_PROPORTIONAL, false, $arFilters ); ?>
<?
$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
?>
<div class="b-catalog-item b-gift clearfix<? if( !$arItem["CATALOG_QUANTITY"] ): ?> with-notice<? endif; ?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
	<div class="b-catalog-back"></div>
	<a href="<?=detailPageUrl($arItem["DETAIL_PAGE_URL"])?>" class="b-catalog-img" style="background-image:url('<?=$renderImage["src"]?>');"></a>
	<div class="b-catalog-desc">
		<div class="b-catalog-item-top">
			<h6><a href="<?=detailPageUrl($arItem["DETAIL_PAGE_URL"])?>"><?=$arItem["NAME"]?></a></h6>
		</div>
		<div class="b-catalog-item-bottom">
			<div class="b-right-button b-basket-count-cont<? if( isset($arItem["BASKET"]) ): ?> b-item-in-basket<? endif; ?>">
				<? if( $arItem["CATALOG_QUANTITY"] ): ?>
					<a href="/ajax/?partial=1&ELEMENT_ID=<?=$arItem["ID"]?>&action=ADD2BASKET&gift=1" class="b-btn icon-cart b-btn-to-cart"><span>Добавить</span></a>
					<div class="b-error-max-count">Доступно: <?=$arItem["CATALOG_QUANTITY"]?> шт.</div>
				<? else: ?>
					<?$APPLICATION->IncludeComponent(
					    "bitrix:catalog.product.subscribe",
					    "main",
					    Array(
					        "BUTTON_CLASS" => "b-btn b-green-btn",
					        "BUTTON_ID" => $arItem["ID"],
					        "CACHE_TIME" => "3600",
					        "CACHE_TYPE" => "A",
					        "PRODUCT_ID" => $arItem["ID"]
					    )
					);?>
				<? endif; ?>
			</div>
		</div>
		<? if( !$arItem["CATALOG_QUANTITY"] ): ?>
			<div class="b-catalog-item-empty-text">Вы можете оставить заявку на данный товар. Когда товар будет в наличии, Вам придет автоматическое письмо на почту.</div>
		<? endif; ?>
	</div>
</div>