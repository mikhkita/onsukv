<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

global $APPLICATION;

$arFilters = Array(
    array("name" => "watermark", "position" => "center", "size"=>"resize", "coefficient" => 0.9, "alpha_level" => 29, "file" => $_SERVER['DOCUMENT_ROOT']."/upload/wat.png"),
);

$GLOBALS["isToys"] = ($arResult["IBLOCK_SECTION_ID"] == 8)?true:false;

// $APPLICATION->SetTitle("ТЕСТ");
$this->setFrameMode(true);
$APPLICATION->SetPageProperty('title', $arResult["NAME"]);
$APPLICATION->AddHeadString('<link rel="canonical" href="https://nevkusno.ru' . $arResult["DETAIL_PAGE_URL"] . '" />');

// print_r($arResult);

?>

<? $renderImage = CFile::ResizeImageGet($arResult["DETAIL_PICTURE"], Array("width" => 1000, "height" => 1000), BX_RESIZE_IMAGE_PROPORTIONAL, false, $arFilters ); ?>
<? $bigImage = CFile::ResizeImageGet($arResult["DETAIL_PICTURE"], Array("width" => 1600, "height" => 1600), BX_RESIZE_IMAGE_PROPORTIONAL, false, $arFilters ); ?>

<div class="b-detail clearfix">
	<div class="b-detail-left">
		<a href="<?=$bigImage["src"]?>" class="fancy-img"><img src="<?=$renderImage["src"]?>"></a>
		<div class="b-stars-detail">
			<div class="b-stars b-stars-<?=$arResult["AVERAGE_RATING"]?>">
				<div class="b-star"></div>
				<div class="b-star"></div>
				<div class="b-star"></div>
				<div class="b-star"></div>
				<div class="b-star"></div>
			</div>
			<div class="b-reviews-count">
				<p><?=$arResult["COUNT_REVIEWS"]?> <?=plural_form($arResult["COUNT_REVIEWS"], array("отзыв", "отзыва", "отзывов"))?></p>
			</div>
			<div class="b-add-review-btn">
				<a href="#b-review-form" class="b-btn b-brown-btn fancy item-review-btn" data-id="<?=$arResult["ID"]?>" ><span>Оставить отзыв</span></a>
			</div>
		</div>
	</div>
	<div class="b-detail-right">
		<? if($arResult["PROPERTIES"]["COUNTRY"]["VALUE"]): ?>
			<div class="b-detail-country"><?=$arResult["PROPERTIES"]["COUNTRY"]["VALUE"]?></div>
		<? endif; ?>
		<div class="b-catalog-item-bottom b-detail-price">
			<div class="price-container">
				<? if( $arResult["PRICES"]["PRICE"]["DISCOUNT_VALUE"] != $arResult["PRICES"]["PRICE"]["VALUE"] ): ?>
					<div class="b-discount-price">
						<div class="old-price icon-rub"><?=number_format( $arResult["PRICES"]["PRICE"]["VALUE"], 0, ',', ' ' )?></div>
						<div class="new-price icon-rub"><?=number_format( $arResult["PRICES"]["PRICE"]["DISCOUNT_VALUE"], 0, ',', ' ' )?></div>
					</div>
				<? else: ?>
					<p class="price b-dynamic-price icon-rub"><?=number_format( $arResult["PRICES"]["PRICE"]["VALUE"], 0, ',', ' ' )?></p>
					<? if( count($arResult["ITEM_PRICES"]) > 1 ): ?>
						<? foreach ($arResult["ITEM_PRICES"] as $kp => $price): ?>
							<? if( $kp == 0 ) continue; ?>
							<div class="b-discount-price b-dynamic-price b-dynamic-discount-price" style="display:none;" data-from="<?=$price["QUANTITY_FROM"]?>">
								<div class="old-price icon-rub"><?=number_format( $arResult["PRICES"]["PRICE"]["VALUE"], 0, ',', ' ' )?></div>
								<div class="new-price icon-rub"><?=number_format( $price["PRICE"], 0, ',', ' ' )?></div>
							</div>
						<? endforeach; ?>
					<? endif; ?>
				<? endif; ?>
			</div>
			<? if( count($arResult["ITEM_PRICES"]) > 1 ): ?>
				<div class="b-wholesale-price">
					<!-- Оптом дешевле<br> -->
					<? foreach ($arResult["ITEM_PRICES"] as $kp => $price): ?>
						<? if( $kp == 0 ) continue; ?>
						от <?=$price["QUANTITY_FROM"]?> шт. – <span class="price icon-rub"><?=number_format( $price["PRICE"], 0, ',', ' ' )?></span><br>
					<? endforeach; ?>
				</div>
			<? endif; ?>
			<div class="b-detail-count b-basket-count-cont<? if( isset($arResult["BASKET"]) ): ?> b-item-in-basket<? endif; ?>">
				<? if( intval($arResult["CATALOG_QUANTITY"]) > 0 ): ?>
					<div class="b-basket-count">
						<div class="b-input-cont">
							<a href="#" class="icon-minus b-change-quantity" data-side="-"></a>
							<a href="#" class="icon-plus b-change-quantity" data-side="+"></a>
							<input type="text" name="quantity" data-min="1" data-max="<?=$arResult["CATALOG_QUANTITY"]?>" data-id="<?=$arResult["ID"]?>" class="b-quantity-input" maxlength="3" oninput="this.value = this.value.replace(/\D/g, '')" value="<?=( (isset($arResult["BASKET"]))?$arResult["BASKET"]["QUANTITY"]:1 )?>">
						</div>
					</div>
					<div class="b-detail-btn-container clearfix">
						<a href="/ajax/?partial=1&ELEMENT_ID=<?=$arResult["ID"]?>&action=ADD2BASKET" class="b-btn icon-cart b-btn-to-cart"><span>В корзину</span></a>
						<? foreach ($arResult["AMOUNT"] as $store): ?>
							<p><a href="/magazin/" class="b-green-link"><?=$store["STORE_NAME"]?></a> – <?=number_format( ceil($arResult["PRICES"]["PRICE"]["VALUE"]*1.07), 0, ',', ' ' )?> руб.<br>
								в наличии на текущее утро<br>
							</p>
						<? endforeach; ?>
					</div>
					<div class="b-error-max-count">Доступно для заказа: <?=$arResult["CATALOG_QUANTITY"]?> шт.</div>
				<? else: ?>
					<div class="b-catalog-item-empty">Нет в наличии</div>
					<? if (!isAuth()): ?>
						<div class="b-catalog-item-empty-text">Авторизуйтесь, чтобы оставить заявку. Когда товар будет в наличии, Вам автоматически придет письмо на почту.</div>
					<? else: ?>	
						<div class="b-catalog-item-empty-text green">Вы можете оставить заявку на данный товар.<br>Когда товар будет в наличии, Вам автоматически придет письмо на почту.</div>
					<? endif; ?>
					<? $isDisabled = (!isAuth())? "disabled": "" ; ?>
					<a href="/ajax/?action=ADD2RESERVE" id="<?=$arResult["ID"]?>" class="b-btn b-green-btn bx-catalog-subscribe-button <?=$isDisabled?>" data-item="<?=$arResult["ID"]?>" data-name="<?=$arResult["NAME"]?>">
						<span>Оставить заявку</span>
					</a>
					<a href="#b-popup-success-reserved" class="b-thanks-link fancy" style="display:none;"></a>
					<a href="#b-popup-error-reserved" class="b-error-link fancy" style="display:none;"></a>
				<? endif; ?>
			</div>
		</div>
		<div class="b-text">
			<div class="b-detail-text limit">
				<div class="b-detail-text-wrap">
					<div class="b-subtitle">Описание:</div>
					<?=$arResult["DETAIL_TEXT"]?>
				</div>
			</div>
			<a href='#' class="b-detail-text-more">Читать полностью</a>

			<? if($arResult["PROPERTIES"]["COMPOSITION"]["VALUE"]): ?>
				<div class="b-opacity">
					<p><div class="b-subtitle">Состав: </div><?=$arResult["PROPERTIES"]["COMPOSITION"]["VALUE"]?></p>
				</div>
			<? endif; ?>

			<? if($arResult["PROPERTIES"]["ENERGY"]["VALUE"]): ?>
				<div class="b-opacity">
					<p><div class="b-subtitle">Энергетическая ценность: </div></b><?=$arResult["PROPERTIES"]["ENERGY"]["VALUE"]?></p>
				</div>
			<? endif; ?>

			
		</div>
	</div>
</div>
<? 
	$GLOBALS["arProductReviews"] = array(
		"PROPERTY_PRODUCT_ID" => $arResult["ID"]
	); 
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"reviews",
	Array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "Y",
		"AJAX_OPTION_JUMP" => "Y",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array("NAME","PREVIEW_TEXT","","DATE_CREATE"),
		"FILTER_NAME" => "arProductReviews",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "2",
		"IBLOCK_TYPE" => "content",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "10",
		"PAGER_BASE_LINK" => "",
		"PAGER_BASE_LINK_ENABLE" => "Y",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_PARAMS_NAME" => "arrPager",
		"PAGER_SHOW_ALL" => "Y",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "main",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array("PRODUCT_ID", "USER_ID"),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "ACTIVE_FROM",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "DESC"
	)
);?> 
<?
if( $arResult["PROPERTIES"]["SIMILAR"]["VALUE"] ){
	$GLOBALS["arrFilterSimilar"] = array(
		"ID" => getSimilarFilter($arResult["ID"], $GLOBALS["SECTION_ID"], 16, $arResult["PROPERTIES"]["SIMILAR"]["VALUE"]),
	);
}else{
	$GLOBALS["arrFilterSimilar"] = array(
		"ID" => getSimilarFilter($arResult["ID"], $GLOBALS["SECTION_ID"], 16),
	);
}
?>
<? if( count($GLOBALS["arrFilterSimilar"]["ID"]) ): ?>
	<div class="b-detail-items">
		<h3>Похожие товары</h3>
		<?$APPLICATION->IncludeComponent(
			"bitrix:catalog.section",
			"main",
			Array(
				"ACTION_VARIABLE" => "action",
				"ADD_PICT_PROP" => "MORE_PHOTO",
				"ADD_PROPERTIES_TO_BASKET" => "Y",
				"ADD_SECTIONS_CHAIN" => "Y",
				"ADD_TO_BASKET_ACTION" => "ADD",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_ADDITIONAL" => "",
				"AJAX_OPTION_HISTORY" => "Y",
				"AJAX_OPTION_JUMP" => "Y",
				"AJAX_OPTION_STYLE" => "Y",
				"BACKGROUND_IMAGE" => "-",
				"BASKET_URL" => "/personal/cart/",
				"BROWSER_TITLE" => "-",
				"CACHE_FILTER" => "N",
				"CACHE_GROUPS" => "Y",
				"CACHE_TIME" => "36000000",
				"CACHE_TYPE" => "N",
				"COMPONENT_TEMPLATE" => ".default",
				"CONVERT_CURRENCY" => "N",
				"DETAIL_URL" => "",
				"DISABLE_INIT_JS_IN_COMPONENT" => "N",
				"DISPLAY_BOTTOM_PAGER" => "N",
				"DISPLAY_TOP_PAGER" => "N",
				"ELEMENT_SORT_FIELD" => "",
				"ELEMENT_SORT_FIELD2" => "id",
				"ELEMENT_SORT_ORDER" => "",
				"ELEMENT_SORT_ORDER2" => "DESC",
				"FILTER_NAME" => "arrFilterSimilar",
				"HIDE_NOT_AVAILABLE" => "N",
				"IBLOCK_ID" => "1",
				"IBLOCK_TYPE" => "catalog",
				"IBLOCK_TYPE_ID" => "catalog",
				"INCLUDE_SUBSECTIONS" => "A",
				"LABEL_PROP" => "SALELEADER",
				"LINE_ELEMENT_COUNT" => "1",
				"MESSAGE_404" => "",
				"MESS_BTN_ADD_TO_BASKET" => "В корзину",
				"MESS_BTN_BUY" => "Купить",
				"MESS_BTN_DETAIL" => "Подробнее",
				"MESS_BTN_SUBSCRIBE" => "Подписаться",
				"MESS_NOT_AVAILABLE" => "Заказ по телефону",
				"META_DESCRIPTION" => "-",
				"META_KEYWORDS" => "-",
				"OFFERS_CART_PROPERTIES" => array(0=>"COLOR_REF",1=>"SIZES_CLOTHES",),
				"OFFERS_FIELD_CODE" => array(0=>"",1=>"",),
				"OFFERS_LIMIT" => "5",
				"OFFERS_PROPERTY_CODE" => array(0=>"COLOR_REF",1=>"SIZES_CLOTHES",2=>"SIZES_SHOES",3=>"",),
				"OFFERS_SORT_FIELD" => "sort",
				"OFFERS_SORT_FIELD2" => "id",
				"OFFERS_SORT_ORDER" => "desc",
				"OFFERS_SORT_ORDER2" => "desc",
				"OFFER_ADD_PICT_PROP" => "-",
				"OFFER_TREE_PROPS" => array(0=>"COLOR_REF",1=>"SIZES_SHOES",2=>"SIZES_CLOTHES",),
				"PAGER_BASE_LINK_ENABLE" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => "main",
				"PAGER_TITLE" => "Товары",
				"PAGE_ELEMENT_COUNT" => 100,
				"PARTIAL_PRODUCT_PROPERTIES" => "N",
				"PRICE_CODE" => array(0=>"PRICE",),
				"PRICE_VAT_INCLUDE" => "N",
				"PRODUCT_DISPLAY_MODE" => "N",
				"PRODUCT_ID_VARIABLE" => "id",
				"PRODUCT_PROPERTIES" => array(),
				"PRODUCT_PROPS_VARIABLE" => "prop",
				"PRODUCT_QUANTITY_VARIABLE" => "",
				"PRODUCT_SUBSCRIPTION" => "N",
				"PROPERTY_CODE" => array(0=>"",1=>"",),
				"SECTION_CODE" => "",
				"SECTION_CODE_PATH" => "",
				"SECTION_ID" => "",
				"SECTION_ID_VARIABLE" => "",
				"SECTION_URL" => "",
				"SECTION_USER_FIELDS" => array(0=>"",1=>"",),
				"SEF_MODE" => "N",
				"SET_BROWSER_TITLE" => "Y",
				"SET_LAST_MODIFIED" => "N",
				"SET_META_DESCRIPTION" => "Y",
				"SET_META_KEYWORDS" => "Y",
				"SET_STATUS_404" => "N",
				"SET_TITLE" => "Y",
				"SHOW_404" => "N",
				"SHOW_ALL_WO_SECTION" => "Y",
				"SHOW_CLOSE_POPUP" => "N",
				"SHOW_DISCOUNT_PERCENT" => "N",
				"SHOW_OLD_PRICE" => "N",
				"SHOW_PRICE_COUNT" => "1",
				"TEMPLATE_THEME" => "site",
				"USE_MAIN_ELEMENT_SECTION" => "N",
				"USE_PRICE_COUNT" => "N",
				"USE_PRODUCT_QUANTITY" => "N",
				"WITH_REVIEWS" => "N",
				"WITH_CALLBACK" => "N",
				"CLASS" => "b-catalog-slider",
				"CUSTOM_ORDER" => $arResult["PROPERTIES"]["SIMILAR"]["VALUE"]
			),
		false,
		Array(
			'ACTIVE_COMPONENT' => 'Y'
		)
		);?>
	</div>
<? endif; ?>
<? if( $recently = getRecently($arResult["ID"]) ): ?>
	<div class="b-detail-items">
		<h3>Вы недавно смотрели</h3>
		<?
		$GLOBALS["arrFilterRecently"] = array(
			"ID" => $recently
		);
		?>
		<?$APPLICATION->IncludeComponent(
			"bitrix:catalog.section",
			"main",
			Array(
				"ACTION_VARIABLE" => "action",
				"ADD_PICT_PROP" => "MORE_PHOTO",
				"ADD_PROPERTIES_TO_BASKET" => "Y",
				"ADD_SECTIONS_CHAIN" => "Y",
				"ADD_TO_BASKET_ACTION" => "ADD",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_ADDITIONAL" => "",
				"AJAX_OPTION_HISTORY" => "Y",
				"AJAX_OPTION_JUMP" => "Y",
				"AJAX_OPTION_STYLE" => "Y",
				"BACKGROUND_IMAGE" => "-",
				"BASKET_URL" => "/personal/cart/",
				"BROWSER_TITLE" => "-",
				"CACHE_FILTER" => "N",
				"CACHE_GROUPS" => "Y",
				"CACHE_TIME" => "36000000",
				"CACHE_TYPE" => "N",
				"COMPONENT_TEMPLATE" => ".default",
				"CONVERT_CURRENCY" => "N",
				"DETAIL_URL" => "",
				"DISABLE_INIT_JS_IN_COMPONENT" => "N",
				"DISPLAY_BOTTOM_PAGER" => "N",
				"DISPLAY_TOP_PAGER" => "N",
				"ELEMENT_SORT_FIELD" => $_REQUEST["ORDER_FIELD"],
				"ELEMENT_SORT_FIELD2" => "id",
				"ELEMENT_SORT_ORDER" => $_REQUEST["ORDER_TYPE"],
				"ELEMENT_SORT_ORDER2" => "DESC",
				"FILTER_NAME" => "arrFilterRecently",
				"HIDE_NOT_AVAILABLE" => "N",
				"IBLOCK_ID" => "1",
				"IBLOCK_TYPE" => "catalog",
				"IBLOCK_TYPE_ID" => "catalog",
				"INCLUDE_SUBSECTIONS" => "A",
				"LABEL_PROP" => "SALELEADER",
				"LINE_ELEMENT_COUNT" => "1",
				"MESSAGE_404" => "",
				"MESS_BTN_ADD_TO_BASKET" => "В корзину",
				"MESS_BTN_BUY" => "Купить",
				"MESS_BTN_DETAIL" => "Подробнее",
				"MESS_BTN_SUBSCRIBE" => "Подписаться",
				"MESS_NOT_AVAILABLE" => "Заказ по телефону",
				"META_DESCRIPTION" => "-",
				"META_KEYWORDS" => "-",
				"OFFERS_CART_PROPERTIES" => array(0=>"COLOR_REF",1=>"SIZES_CLOTHES",),
				"OFFERS_FIELD_CODE" => array(0=>"",1=>"",),
				"OFFERS_LIMIT" => "5",
				"OFFERS_PROPERTY_CODE" => array(0=>"COLOR_REF",1=>"SIZES_CLOTHES",2=>"SIZES_SHOES",3=>"",),
				"OFFERS_SORT_FIELD" => "sort",
				"OFFERS_SORT_FIELD2" => "id",
				"OFFERS_SORT_ORDER" => "desc",
				"OFFERS_SORT_ORDER2" => "desc",
				"OFFER_ADD_PICT_PROP" => "-",
				"OFFER_TREE_PROPS" => array(0=>"COLOR_REF",1=>"SIZES_SHOES",2=>"SIZES_CLOTHES",),
				"PAGER_BASE_LINK_ENABLE" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "Y",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => "main",
				"PAGER_TITLE" => "Товары",
				"PAGE_ELEMENT_COUNT" => 16,
				"PARTIAL_PRODUCT_PROPERTIES" => "N",
				"PRICE_CODE" => array(0=>"PRICE",),
				"PRICE_VAT_INCLUDE" => "N",
				"PRODUCT_DISPLAY_MODE" => "N",
				"PRODUCT_ID_VARIABLE" => "id",
				"PRODUCT_PROPERTIES" => array(),
				"PRODUCT_PROPS_VARIABLE" => "prop",
				"PRODUCT_QUANTITY_VARIABLE" => "",
				"PRODUCT_SUBSCRIPTION" => "N",
				"PROPERTY_CODE" => array(0=>"",1=>"",),
				"SECTION_CODE" => "",
				"SECTION_CODE_PATH" => "",
				"SECTION_ID" => "",
				"SECTION_ID_VARIABLE" => "SECTION_ID",
				"SECTION_URL" => "",
				"SECTION_USER_FIELDS" => array(0=>"",1=>"",),
				"SEF_MODE" => "N",
				"SET_BROWSER_TITLE" => "Y",
				"SET_LAST_MODIFIED" => "N",
				"SET_META_DESCRIPTION" => "Y",
				"SET_META_KEYWORDS" => "Y",
				"SET_STATUS_404" => "N",
				"SET_TITLE" => "Y",
				"SHOW_404" => "N",
				"SHOW_ALL_WO_SECTION" => "Y",
				"SHOW_CLOSE_POPUP" => "N",
				"SHOW_DISCOUNT_PERCENT" => "N",
				"SHOW_OLD_PRICE" => "N",
				"SHOW_PRICE_COUNT" => "1",
				"TEMPLATE_THEME" => "site",
				"USE_MAIN_ELEMENT_SECTION" => "N",
				"USE_PRICE_COUNT" => "N",
				"USE_PRODUCT_QUANTITY" => "N",
				"WITH_REVIEWS" => "N",
				"WITH_CALLBACK" => "N",
				"CLASS" => "b-catalog-slider",
				"CUSTOM_ORDER" => $recently,
			),
		false,
		Array(
			'ACTIVE_COMPONENT' => 'Y'
		)
		);?>
	</div>
<? endif; ?>