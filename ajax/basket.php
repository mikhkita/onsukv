<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

\Bitrix\Main\Data\StaticHtmlCache::getInstance()->markNonCacheable();

$GLOBALS['APPLICATION']->RestartBuffer();

$_GET["partial"] = 1;

$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line", "mini", Array(
		"HIDE_ON_BASKET_PAGES" => "Y",	// Не показывать на страницах корзины и оформления заказа
		"PATH_TO_BASKET" => SITE_DIR."personal/cart/",	// Страница корзины
		"PATH_TO_ORDER" => SITE_DIR."personal/order/make/",	// Страница оформления заказа
		"PATH_TO_PERSONAL" => SITE_DIR."personal/",	// Страница персонального раздела
		"PATH_TO_PROFILE" => SITE_DIR."personal/",	// Страница профиля
		"PATH_TO_REGISTER" => SITE_DIR."login/",	// Страница регистрации
		"POSITION_FIXED" => "N",	// Отображать корзину поверх шаблона
		"SHOW_AUTHOR" => "N",	// Добавить возможность авторизации
		"SHOW_EMPTY_VALUES" => "Y",	// Выводить нулевые значения в пустой корзине
		"SHOW_NUM_PRODUCTS" => "Y",	// Показывать количество товаров
		"SHOW_PERSONAL_LINK" => "Y",	// Отображать персональный раздел
		"SHOW_PRODUCTS" => "Y",	// Показывать список товаров
		"SHOW_TOTAL_PRICE" => "Y",	// Показывать общую сумму по товарам
		"MY_AJAX" => "Y"
	),
	false
);

$APPLICATION->IncludeComponent("bitrix:sale.basket.basket", "cart", 
	array(
		"ACTION_VARIABLE" => "basketAction1",	// Название переменной действия
		"AUTO_CALCULATION" => "Y",	// Автопересчет корзины
		"COLUMNS_LIST" => array(	// Выводимые колонки
			0 => "NAME",
			1 => "DISCOUNT",
			2 => "WEIGHT",
			3 => "DELETE",
			4 => "DELAY",
			5 => "TYPE",
			6 => "PRICE",
			7 => "QUANTITY",
		),
		"CORRECT_RATIO" => "N",	// Автоматически рассчитывать количество товара кратное коэффициенту
		"HIDE_COUPON" => "N",	// Спрятать поле ввода купона
		"PATH_TO_ORDER" => "/personal/order.php",	// Страница оформления заказа
		"PRICE_VAT_SHOW_VALUE" => "N",	// Отображать значение НДС
		"QUANTITY_FLOAT" => "N",	// Использовать дробное значение количества
		"SET_TITLE" => "N",	// Устанавливать заголовок страницы
		"TEMPLATE_THEME" => "blue",	// Цветовая тема
		"USE_ENHANCED_ECOMMERCE" => "N",	// Отправлять данные электронной торговли в Google и Яндекс
		"USE_GIFTS" => "N",	// Показывать блок "Подарки"
		"USE_PREPAYMENT" => "N",	// Использовать предавторизацию для оформления заказа (PayPal Express Checkout)
	),
	false
);

die();

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>