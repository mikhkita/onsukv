<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords", "Товары для кондитера, инструменты для кондитера");
$APPLICATION->SetPageProperty("description", "Магазин по продаже товаров для профессионального кондитера");
$APPLICATION->SetTitle("Вкусный магазин для кондитеров и кулинаров");

?>

<div class="b-preview-block">
	<div class="b-block">
		<div class="b-two-blocks">
			<div class="b-two-block b-block-1">
				<div class="b-about-preview">
					<h2>Добро пожаловать во&nbsp;Вкусный Магазин</h2>
					<p>Вкусный магазин – это магазин кондитерского инвентаря и профессиональных товаров для кулинаров. Наша компания – это профессинальная команда, специализирующаяся на принципах качества высокого сервиса.</p>
					<a href="/about/" class="more">Подробнее о магазине</a>
				</div>
				<a href="/reviews/" class="more">Отзывы и пожелания</a>
				<br>
				<br>
				<br>
				<?$APPLICATION->IncludeComponent(
					"bitrix:news.list",
					"news",
					Array(
						"ACTIVE_DATE_FORMAT" => "d.m.Y",
						"ADD_SECTIONS_CHAIN" => "Y",
						"AJAX_MODE" => "N",
						"AJAX_OPTION_ADDITIONAL" => "",
						"AJAX_OPTION_HISTORY" => "N",
						"AJAX_OPTION_JUMP" => "N",
						"AJAX_OPTION_STYLE" => "Y",
						"CACHE_FILTER" => "N",
						"CACHE_GROUPS" => "Y",
						"CACHE_TIME" => "36000000",
						"CACHE_TYPE" => "A",
						"CHECK_DATES" => "Y",
						"DETAIL_URL" => "",
						"DISPLAY_BOTTOM_PAGER" => "Y",
						"DISPLAY_DATE" => "Y",
						"DISPLAY_NAME" => "Y",
						"DISPLAY_PICTURE" => "Y",
						"DISPLAY_PREVIEW_TEXT" => "Y",
						"DISPLAY_TOP_PAGER" => "N",
						"FIELD_CODE" => array("", ""),
						"FILTER_NAME" => "",
						"HIDE_LINK_WHEN_NO_DETAIL" => "N",
						"IBLOCK_ID" => "4",
						"IBLOCK_TYPE" => "content",
						"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
						"INCLUDE_SUBSECTIONS" => "Y",
						"MESSAGE_404" => "",
						"NEWS_COUNT" => "1",
						"PAGER_BASE_LINK_ENABLE" => "N",
						"PAGER_DESC_NUMBERING" => "N",
						"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
						"PAGER_SHOW_ALL" => "N",
						"PAGER_SHOW_ALWAYS" => "N",
						"PAGER_TEMPLATE" => ".default",
						"PAGER_TITLE" => "Новости",
						"PARENT_SECTION" => "",
						"PARENT_SECTION_CODE" => "",
						"PREVIEW_TRUNCATE_LEN" => "",
						"PROPERTY_CODE" => array("", ""),
						"SET_BROWSER_TITLE" => "N",
						"SET_LAST_MODIFIED" => "N",
						"SET_META_DESCRIPTION" => "N",
						"SET_META_KEYWORDS" => "N",
						"SET_STATUS_404" => "N",
						"SET_TITLE" => "N",
						"SHOW_404" => "N",
						"SORT_BY1" => "ACTIVE_FROM",
						"SORT_BY2" => "SORT",
						"SORT_ORDER1" => "DESC",
						"SORT_ORDER2" => "ASC",
						"STRICT_SECTION_CHECK" => "N"
					)
				);?>
			</div>
			<div class="b-two-block b-block-2">
				<img src="<?=SITE_TEMPLATE_PATH?>/i/<?=$GLOBALS["season"]?>.jpg">
			</div>
		</div>
	</div>
</div>
<div class="b-catalog-preview">
	<div class="b-block">
		<h2>Хиты продаж</h2>
		<?$APPLICATION->IncludeComponent(
			"bitrix:catalog.section",
			"main",
			Array(
				"ACTION_VARIABLE" => "action",
				"ADD_PICT_PROP" => "MORE_PHOTO",
				"ADD_PROPERTIES_TO_BASKET" => "Y",
				"ADD_SECTIONS_CHAIN" => "Y",
				"ADD_TO_BASKET_ACTION" => "ADD",
				"AJAX_MODE" => "Y",
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
				"ELEMENT_SORT_FIELD" => "sort",
				"ELEMENT_SORT_FIELD2" => "id",
				"ELEMENT_SORT_ORDER" => "ASC",
				"ELEMENT_SORT_ORDER2" => "DESC",
				"FILTER_NAME" => "arrFilter2",
				"HIDE_NOT_AVAILABLE" => "Y",
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
				"PAGE_ELEMENT_COUNT" => 10,
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
				"SET_TITLE" => "N",
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
</div>
<div class="b-big-menu">
	<div class="b-block">
		<div class="b-big-menu-container">
			<div class="b-big-menu-columns">
				<div class="b-big-menu-column">
					<div class="menu-header">Лавка кулинара</div>
					<?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "main_categories", Array(
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
							"SECTION_ID" => 1,	// ID раздела
							"SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
							"SECTION_USER_FIELDS" => array(	// Свойства разделов
							),
							"SHOW_PARENT_NAME" => "Y",	// Показывать название раздела
							"TOP_DEPTH" => "1",	// Максимальная отображаемая глубина разделов
							"VIEW_MODE" => "LINE",	// Вид списка подразделов
						),
						false
					);?>
				</div>
				<div class="b-big-menu-column">
					<div class="menu-header">Кондитерский инвентарь</div>
					<?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "main_categories", Array(
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
							"SECTION_ID" => 2,	// ID раздела
							"SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
							"SECTION_USER_FIELDS" => array(	// Свойства разделов
							),
							"SHOW_PARENT_NAME" => "Y",	// Показывать название раздела
							"TOP_DEPTH" => "1",	// Максимальная отображаемая глубина разделов
							"VIEW_MODE" => "LINE",	// Вид списка подразделов
						),
						false
					);?>
				</div>
			</div>
		</div>
	</div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>