<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Акции и скидки");
?>
	<img src="/local/templates/main/i/gift.jpg" class="b-about-pic" style="float:right;" width=250 alt="">
	<h3>Оплата</h3>
	<p>Оплатить выбранный товар можно несколькими способами:</p>
	<ul>
		<li>Наличными деньгами при доставке курьером</li>
		<li>Безналичными деньгами на наш расчетный счет при оплате Регионами, либо Юридическими лицами</li>
		<li>Оплата на карточку VISA</li>
	</ul>
</div>
<div class="b-catalog-preview b-text">
	<h3>Скидки для покупателей</h3>
	<p>
		Поделитесь мнением о товарах, получите дополнительную скидку к заказу&nbsp;- 2%!<br>
		Напишите полезный отзыв о товаре, которым пользовались из нашего магазина, и Вы поможете с выбором другим покупателям!<br><br>
		Отзыв должен содержать ваши впечатления от использования данного продукта, его положительные и отрицательные стороны.<br><br>
		За 5 товаров - 2% (учитываются отзывы за последнюю неделю)
	</p>
</div>
<div class="b-catalog-preview b-text">
	<h3>Акция для покупателей</h3>
	<p>
		Сделайте заказ на 5000 руб, получите подарок.</br>
		Подарком может являться товар из магазина на любую стоимость, от 50 до 1000 руб.
	</p>
</div>
<div class="b-catalog-preview b-text">
	<h3>Акция для мастер-кондитеров, которые ведут курсы, имеют свой интернет-сайт и рекомендуют наш магазин для своих учеников и слушателей</h3>
	<p>
		Скидки ученикам по промокоду - <span class="required">3%</span>.<br>
		Мастер-кондитер с каждого заказа получает 100 руб.<br><br>

		Правило акции:
	</p>
	<ul>
		<li>У мастер-кондитера должны быть курсы, либо свой интернет-сайт</li>
		<li>Отправить ссылку на проводимые курсы/ресурс на адрес voprosrukovodstvo@mail.ru</li>
		<li>Согласовать промокод</li>
		<li>Указать реквизиты, куда переводить бонус (номер карты или телефон)</li>
	</ul>
	<br>
	<p>Срок действия промокода - 6 месяцев после его согласования</p>
</div>
<div class="b-catalog-preview b-sale-container">
<h3>Подарочные карты</h3>
<p>
	Подарите прекрасный подарок близкому, родному человеку, а может просто хорошему другу!<br>
	Порадуйте великолепным выбором товаров для выпечки и не только!<br>
	Получайте прекрасные моменты счастья и радости!<br><br>
	Всегда ваш, Вкусный магазин!)
</p>

<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	"main",
	Array(
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "MORE_PHOTO",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_SECTIONS_CHAIN" => "N",
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
		"SECTION_CODE" => "podarochnaya-karta",
		"SECTION_CODE_PATH" => "",
		"SECTION_ID" => "",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array(0=>"",1=>"",),
		"SEF_MODE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
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
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>