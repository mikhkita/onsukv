<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

if( $GLOBALS["isWholesale"] && $_REQUEST["WHOLESALE"] == "Y" ){
	$APPLICATION->SetTitle("Оптовый раздел");
	$APPLICATION->AddChainItem("ОПТ", "/wholesale/");
}else{
	$APPLICATION->SetTitle("Каталог");
}

if( !isset($_REQUEST["ORDER_FIELD"]) ){
	$_REQUEST["ORDER_FIELD"] = "NAME";
}

if( !isset($_REQUEST["ORDER_TYPE"]) ){
	$_REQUEST["ORDER_TYPE"] = "ASC";
}

?>
<? if( $GLOBALS["SECTION_ID"] == 1 || $GLOBALS["SECTION_ID"] == 2 ): ?>
	<?
		$arSection = getSectionByID(1, $GLOBALS["SECTIONS"][0]["ID"]);
		$APPLICATION->SetTitle($arSection["NAME"]);
	?>
	<div class="b-text">
		<br>
		<?=$arSection["DESCRIPTION"]?>
	</div>
<? else: ?>
	<?$APPLICATION->IncludeComponent("redder:catalog.section.list", "subcategories", Array(
		"ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
			"CACHE_GROUPS" => "Y",	// Учитывать права доступа
			"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
			"CACHE_TYPE" => "N",	// Тип кеширования
			"COUNT_ELEMENTS" => "Y",	// Показывать количество элементов в разделе
			"IBLOCK_ID" => "1",	// Инфоблок
			"IBLOCK_TYPE" => "content",	// Тип инфоблока
			"SECTION_CODE" => "",	// Код раздела
			"SECTION_FIELDS" => array(	// Поля разделов
				0 => "NAME",
			),
			"SECTION_ID" => (isset($GLOBALS["SECTION_ID"]))?$GLOBALS["SECTION_ID"]:12389817264128,	// ID раздела
			"SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
			"SECTION_USER_FIELDS" => array(	// Свойства разделов
			),
			"SHOW_PARENT_NAME" => "Y",	// Показывать название раздела
			"TOP_DEPTH" => "1",	// Максимальная отображаемая глубина разделов
			"VIEW_MODE" => "LINE",	// Вид списка подразделов
			"PROPERTY" => ($GLOBALS["isWholesale"])?array( "WHOLESALE" => 78 ):array(),
		),
		false
	);?>
	<div class="b-sort">
		<div class="b-sort-block b-sort-text">Сортировать по:</div>
		<div class="b-sort-block b-sort-field"><a href="?ORDER_FIELD=CATALOG_PRICE_1&ORDER_TYPE=<?=( ($_REQUEST["ORDER_TYPE"] == "DESC" || $_REQUEST["ORDER_FIELD"] != "CATALOG_PRICE_1")?"ASC":"DESC" )?>" class="<? if($_REQUEST["ORDER_FIELD"] == "CATALOG_PRICE_1"): ?>active <? endif; ?><? if($_REQUEST["ORDER_TYPE"] == "ASC"): ?>up <? endif; ?>icon-arrow">цене</a></div>
		<div class="b-sort-block b-sort-field"><a href="?ORDER_FIELD=NAME&ORDER_TYPE=<?=( ($_REQUEST["ORDER_TYPE"] == "DESC" || $_REQUEST["ORDER_FIELD"] != "NAME")?"ASC":"DESC" )?>" class="<? if($_REQUEST["ORDER_FIELD"] == "NAME"): ?>active <? endif; ?><? if($_REQUEST["ORDER_TYPE"] == "ASC"): ?>up <? endif; ?> icon-arrow">названию</a></div>
		<div class="b-sort-block b-sort-field"><a href="?ORDER_FIELD=DATE_CREATED&ORDER_TYPE=<?=( ($_REQUEST["ORDER_TYPE"] == "DESC" || $_REQUEST["ORDER_FIELD"] != "DATE_CREATED")?"ASC":"DESC" )?>" class="<? if($_REQUEST["ORDER_FIELD"] == "DATE_CREATED"): ?>active <? endif; ?><? if($_REQUEST["ORDER_TYPE"] == "ASC"): ?>up <? endif; ?> icon-arrow">новинкам</a>
		</div>
		<div class="b-sort-block b-sort-field"><a href="?ORDER_FIELD=SORT&ORDER_TYPE=<?=( ($_REQUEST["ORDER_TYPE"] == "DESC" || $_REQUEST["ORDER_FIELD"] != "SORT")?"ASC":"DESC" )?>" class="<? if($_REQUEST["ORDER_FIELD"] == "SORT"): ?>active <? endif; ?><? if($_REQUEST["ORDER_TYPE"] == "ASC"): ?>up <? endif; ?> icon-arrow">популярности</a></div>
	</div>
	<div class="b-catalog">
		<?
		if( $GLOBALS["isWholesale"] ){
			$GLOBALS["arrFilter2"] = array(
				"PROPERTY_WHOLESALE_VALUE" => "Y"
			);
		}
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
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"DISPLAY_TOP_PAGER" => "N",
				"ELEMENT_SORT_FIELD" => $_REQUEST["ORDER_FIELD"],
				"ELEMENT_SORT_FIELD2" => "id",
				"ELEMENT_SORT_ORDER" => $_REQUEST["ORDER_TYPE"],
				"ELEMENT_SORT_ORDER2" => "DESC",
				"FILTER_NAME" => "arrFilter2",
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
				"SECTION_CODE" => $_REQUEST["SECTION_CODE"],
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
				"WITH_REVIEWS" => ($isFirst)?"Y":"N",
				"WITH_CALLBACK" => ($isLast)?"Y":"N",
				"CLASS" => "b-limit",
			),
		false,
		Array(
			'ACTIVE_COMPONENT' => 'Y'
		)
		);?>
	</div>
<? endif; ?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>