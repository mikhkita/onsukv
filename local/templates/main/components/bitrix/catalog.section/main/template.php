<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$arFilters = Array(
    array("name" => "watermark", "position" => "center", "size"=>"resize", "coefficient" => 0.9, "alpha_level" => 29, "file" => $_SERVER['DOCUMENT_ROOT']."/upload/wat.png"),
);

?>
			
<? if(count($arResult["ITEMS"])): ?>
	<div class="b-catalog-list clearfix <?=$arParams["CLASS"]?>">
		<?foreach($arResult["ITEMS"] as $arItem):?>
			<? $renderImage = CFile::ResizeImageGet($arItem["DETAIL_PICTURE"], Array("width" => 180, "height" => 180), BX_RESIZE_IMAGE_PROPORTIONAL, false, $arFilters ); ?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			?>
			<div class="b-catalog-item clearfix<? if( !$arItem["CATALOG_QUANTITY"] ): ?> with-notice<? endif; ?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<div class="b-catalog-back"></div>
				<a href="<?=detailPageUrl($arItem["DETAIL_PAGE_URL"])?>" class="b-catalog-img" style="background-image:url('<?=$renderImage["src"]?>');"></a>
				<div class="b-catalog-desc">
					<div class="b-catalog-item-top">
						<h6><a href="<?=detailPageUrl($arItem["DETAIL_PAGE_URL"])?>"><?=$arItem["NAME"]?></a></h6>
						<p class="article b-catalog-item-country"><?=$arItem["PROPERTIES"]["COUNTRY"]["VALUE"]?></p>
					</div>
					<div class="b-catalog-item-bottom">
						<div class="price-container">
							<? if( $arItem["PRICES"]["PRICE"]["DISCOUNT_VALUE"] != $arItem["PRICES"]["PRICE"]["VALUE"] ): ?>
								<div class="b-discount-price">
									<div class="old-price icon-rub"><?=number_format( $arItem["PRICES"]["PRICE"]["VALUE"], 0, ',', ' ' )?></div>
									<div class="new-price icon-rub"><?=number_format( $arItem["PRICES"]["PRICE"]["DISCOUNT_VALUE"], 0, ',', ' ' )?></div>
									<? if( isset($arItem["MEASURE"]) ): ?>
										<p class="article"><?=$arItem["MEASURE"]?></p>
									<? endif; ?>
								</div>
							<? else: ?>
								<p class="price icon-rub"><?=number_format( $arItem["PRICES"]["PRICE"]["VALUE"], 0, ',', ' ' )?></p>
								<!-- <p class="article"><?=$arItem["MEASURE"]?></p> -->
							<? endif; ?>
							<? if( count($arItem["ITEM_PRICES"]) > 1 ): ?>
								<? foreach ($arItem["ITEM_PRICES"] as $kp => $price): ?>
									<? if( $kp == 0 ) continue; ?>
									<div class="b-discount-price b-dynamic-price b-dynamic-discount-price" style="display:none;" data-from="<?=$price["QUANTITY_FROM"]?>">
										<div class="old-price icon-rub"><?=number_format( $arItem["PRICES"]["PRICE"]["VALUE"], 0, ',', ' ' )?></div>
										<div class="new-price icon-rub"><?=number_format( $price["PRICE"], 0, ',', ' ' )?></div>
									</div>
								<? endforeach; ?>
							<? endif; ?>
						</div>
						<div class="b-right-button b-basket-count-cont<? if( isset($arItem["BASKET"]) ): ?> b-item-in-basket<? endif; ?>">
							<? if( $arItem["CATALOG_QUANTITY"] ): ?>
								<div class="b-basket-count">
									<div class="b-input-cont">
										<a href="#" class="icon-minus b-change-quantity" data-side="-"></a>
										<a href="#" class="icon-plus b-change-quantity" data-side="+"></a>
										<input type="text" name="quantity" data-min="<?=(( $GLOBALS["isWholesale"] )?$arItem["ITEM_PRICES"][1]["QUANTITY_FROM"]:1)?>" data-max="<?=$arItem["CATALOG_QUANTITY"]?>" data-id="<?=$arItem["ID"]?>" class="b-quantity-input" maxlength="3" oninput="this.value = this.value.replace(/\D/g, '')" value="<?=( (isset($arItem["BASKET"]))?$arItem["BASKET"]["QUANTITY"]:( ( isset($arItem["ITEM_PRICES"][1]["QUANTITY_FROM"]) )?$arItem["ITEM_PRICES"][1]["QUANTITY_FROM"]:$arItem["ITEM_PRICES"][0]["QUANTITY_FROM"] ) )?>">
									</div>
								</div>
								<a href="/ajax/?partial=1&ELEMENT_ID=<?=$arItem["ID"]?>&action=ADD2BASKET" class="b-btn icon-cart b-btn-to-cart"><span>В корзину</span></a>
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
					<? if( $GLOBALS["isWholesale"] ): ?>
						<? if( count($arItem["ITEM_PRICES"]) > 2 ): ?>
							<div class="b-wholesale-price">
								<? foreach ($arItem["ITEM_PRICES"] as $kp => $price): ?>
									<? if( $kp == 0 || $kp == 1 ) continue; ?>
									от <?=$price["QUANTITY_FROM"]?> шт. – <span class="price icon-rub"><?=number_format( $price["PRICE"], 0, ',', ' ' )?></span><br>
								<? endforeach; ?>
							</div>
						<? endif; ?>
					<? else: ?>
						<? if( count($arItem["ITEM_PRICES"]) > 1 ): ?>
							<div class="b-wholesale-price">
								Оптом дешевле:<br>
								<? foreach ($arItem["ITEM_PRICES"] as $kp => $price): ?>
									<? if( $kp == 0 ) continue; ?>
									от <?=$price["QUANTITY_FROM"]?> шт. – <span class="price icon-rub"><?=number_format( $price["PRICE"], 0, ',', ' ' )?></span><br>
								<? endforeach; ?>
							</div>
						<? endif; ?>
					<? endif; ?>
				</div>
			</div>
		<?endforeach;?>
	</div>	
	<? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
		<?=$arResult["NAV_STRING"];?>
	<?endif;?>
<? else: ?>
	<div class="b-not-result b-text">
		<br>
		<p>По Вашему запросу товаров не найдено.</p>
	</div>
<? endif; ?>