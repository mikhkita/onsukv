<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/".SITE_TEMPLATE_ID."/header.php");

$curPage = $APPLICATION->GetCurPage();
$urlArr = $GLOBALS["urlArr"] = explode("/", $curPage);
$GLOBALS["isMain"] = $isMain = ( $curPage == "/" )?true:false;
$page = $GLOBALS["page"] = ( $urlArr[2] == null || $urlArr[2] == "" )?$urlArr[1]:$urlArr[2];
$subPage = $GLOBALS["subpage"] = $urlArr[2];
$GLOBALS["version"] = 411;

$is404 = defined('ERROR_404') && ERROR_404=='Y' && !defined('ADMIN_SECTION');

$arPage = ( isset($arPages[$urlArr[2]]) )?$arPages[$urlArr[2]]:$arPages[$urlArr[1]];

$isCatalog = $GLOBALS["isCatalog"] = ($urlArr[1] == "catalog" || $urlArr[1] == "wholesale" || $urlArr[1] == "sale");
$isWholesale = $GLOBALS["isWholesale"] = ($urlArr[1] == "wholesale");
$isSale = $GLOBALS["isSale"] = ($urlArr[1] == "sale");
$isPersonal = $GLOBALS["isPersonal"] = ($urlArr[1] == "personal");
$isDelivery = $GLOBALS["isDelivery"] = ($urlArr[1] == "delivery");

$isDetail = $GLOBALS["isDetail"] = ($urlArr[1] == "catalog" && isset($urlArr[4]));

$notBText = $GLOBALS["notBText"] = ( in_array($page, array("cart", "contacts", "success", "error", "search", "news", "new")) || $isCatalog || $isMain )?true: false;

$GLOBALS["HEADER_CATEGORIES"] = array();

$GLOBALS["season"] = getSeason();

CModule::IncludeModule('iblock');

?>
<!DOCTYPE html>
<html>
<head>
	<title><?$APPLICATION->ShowTitle()?></title>

	<?$APPLICATION->ShowHead();?>

	<meta name="format-detection" content="telephone=no">

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/reset.css" type="text/css">
	<link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/jquery-ui.min.css" type="text/css">
	<link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/jquery.fancybox.css" type="text/css">
	<link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/KitAnimate.css" type="text/css">
	<link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/layout.css?<?=$GLOBALS["version"]?>" type="text/css">
	<link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/slick.css" type="text/css">
	
	<link rel="stylesheet" media="screen and (min-width: 240px) and (max-width: 1023px)" href="<?=SITE_TEMPLATE_PATH?>/css/layout-tablet.css?<?=$GLOBALS["version"]?>">
	<link rel="stylesheet" media="screen and (min-width: 240px) and (max-width: 960px)" href="<?=SITE_TEMPLATE_PATH?>/css/layout-mobile.css?<?=$GLOBALS["version"]?>">

	<? if (isMobile()):?>
		<meta name="viewport" content="width=device-width, user-scalable=no"> 
	<? else:?> 
		<meta name="viewport" content="width=1024, user-scalable=no"> 
	<? endif;?>

	<link rel="apple-touch-icon" sizes="180x180" href="<?=SITE_TEMPLATE_PATH?>/favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?=SITE_TEMPLATE_PATH?>/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?=SITE_TEMPLATE_PATH?>/favicon/favicon-16x16.png">
	<link rel="manifest" href="<?=SITE_TEMPLATE_PATH?>/favicon/site.webmanifest">
	<link rel="mask-icon" href="<?=SITE_TEMPLATE_PATH?>/favicon/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="theme-color" content="#ffffff">

</head>
<body>
	<?$APPLICATION->ShowPanel();?>
	<div id="mobile-menu" class="mobile-menu hide">
		<h2>Меню</h2>
		<ul>
			<li><a href="/discounts/" class="active icon-discount">Акции и скидки</a></li>
			<li><a href="/">Главная</a></li>
			<li><a href="/delivery/">Доставка и&nbsp;оплата</a></li>
			<li><a href="#">Новые приходы</a></li>
			<li><a href="/magazin/">Розничный магазин</a></li>
			<li><a href="/rukovodstvo/">Связь с&nbsp;руководством</a></li>
		</ul>
		<div class="b-phone">
			<a href="tel:+74959225055" class="phone">+ 7 495 922 50 55</a>
			<a href="tel:+74956447572" class="phone">+ 7 495 644 75 72</a>
			<a href="#b-popup-phone" class="phone-link fancy">Не дозвонились?</a>
		</div>
	</div>
	<div id="mobile-catalog" class="mobile-catalog hide">
		<h2 class="b-bottom-border">Каталог</h2>
		<div class="menu-accordion">
			<div class="menu-accodion-block ">
				<h3 class="menu-header icon-arrow">Лавка кулинара</h3>
				<ul>
					<li><a href="#" class="active">Агар-агар, пектин и желатин</a></li>
					<li><a href="#">Ганаш</a></li>
					<li><a href="#">Айсинг и гель для рисования</a></li>
					<li><a href="#">Альбумин - яичный белок</a></li>
					<li><a href="#">Ароматизаторы, пасты</a></li>
					<li><a href="#">Ваниль, ванильный экстракт, ванильная паста</a></li>
					<li><a href="#">Глазури и гели для покрытия тортов</a></li>
					<li><a href="#">Глицерин пищевой, пропиленгликоль</a></li>
					<li><a href="#">Добавки кондитерские</a></li>
					<li><a href="#">Дрожжи и закваски</a></li>
					<li><a href="#">Загустители для мастики, лак, клей</a></li>
					<li><a href="#">Изомальт</a></li>
					<li><a href="#">Красители пищевые</a></li>
					<li><a href="#">Крахмал</a></li>
					<li><a href="#">Марципан</a></li>
					<li><a href="#">Масла кондитерские, маргарин</a></li>
					<li><a href="#">Масличные семена</a></li>
					<li><a href="#">Мастика кондитерская и маршмеллоу</a></li>
					<li><a href="#">Мука, крупы</a></li>
					<li><a href="#">Начинки для торта, начинки для конфет, наполнители</a></li>
					<li><a href="#">Орехи, лепестки ореха, кокосовая стружка</a></li>
					<li><a href="#">Ореховая мука</a></li>
					<li><a href="#">Ореховые пасты</a></li>
					<li><a href="#">Печенье савоярди и полуфабрикаты готовые</a></li>
					<li><a href="#">Пралине, нуга</a></li>
					<li><a href="#">Разрыхлитель, пекарский порошок, улучшитель теста</a></li>
					<li><a href="#">Сахарная пудра, сахар, патока</a></li>
					<li><a href="#">Сиропы</a></li>
					<li><a href="#">Сливки, стабилизаторы сливок, молоко</a></li>
					<li><a href="#">Смеси кондитерские, крема, сыр</a></li>
					<li><a href="#">Сублимированные ягоды, изюм</a></li>
					<li><a href="#">Специи</a></li>
					<li><a href="#">Топпинги, пасты для мармелада</a></li>
					<li><a href="#">Украшения кондитерские</a></li>
					<li><a href="#">Украшения - Посыпки кондитерские</a></li>
					<li><a href="#">Украшения - Шарики кондитерские</a></li>
					<li><a href="#">Украшения сахарные</a></li>
					<li><a href="#">Украшения вафельные</a></li>
					<li><a href="#">Фломастеры пищевые</a></li>
					<li><a href="#">Фруктовые пюре</a></li>
					<li><a href="#">Шоколадный велюр (спрей)</a></li>
					<li><a href="#">Шоколад и какао</a></li>
					<li><a href="#">Пасха</a></li>
					<li><a href="#">День Святого Валентина!</a></li>
					<li><a href="#">Новый год</a></li>
					<li><a href="#">Подарочная карта</a></li>
				</ul>
			</div>
			<div class="menu-accodion-block">
				<h3 class="menu-header icon-arrow">Кондитерский инвентарь</h3>
				<ul>
					<li><a href="#">Аэрография</a></li>
					<li><a href="#">Бумажные формы для выпечки</a></li>
					<li><a href="#">Вайнеры цветочные</a></li>
					<li><a href="#">Вырубки и каттеры для пряников, печенья и мастики</a></li>
					<li><a href="#">Инструменты для работы с кремом</a></li>
					<li><a href="#">Инструменты для работы с мастикой и тестом</a></li>
					<li><a href="#">Кондитерские принадлежности</a></li>
					<li><a href="#">Книги для кондитера, журналы</a></li>
					<li><a href="#">Кухонные приборы и утварь</a></li>
					<li><a href="#">Коврики для айсинга</a></li>
					<li><a href="#">Молды и маты силиконовые</a></li>
					<li><a href="#">Молды пластиковые для шоколада, мастики</a></li>
					<li><a href="#">Муляж для торта</a></li>
					<li><a href="#">Подложки, салфетки</a></li>
					<li><a href="#">Подставки и тарелки для тортов, кексов и кейкпопсов</a></li>
					<li><a href="#">Поликарбонатные формы для конфет</a></li>
					<li><a href="#">Принтер пищевой, пищевая бумага</a></li>
					<li><a href="#">Расходники для приготовления и хранения</a></li>
					<li><a href="#">Трафареты, штампы, пэчворки</a></li>
					<li><a href="#">Упаковка для кондитерских изделий</a></li>
					<li><a href="#">Упаковочные материалы</a></li>
					<li><a href="#">Флористика</a></li>
					<li><a href="#">Формы для выпечки</a></li>
					<li><a href="#">Формы для выпечки раздвижные, резаки</a></li>
					<li><a href="#">Формы для шоколада, печенья, леденцов, кейкпопсов и мороженого</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div id="panel-page">
		<!-- Хедер для главной -->
		<div class="b-header<? if( !$isMain ): ?> inner-header<? endif; ?>">
		<!-- Хедер для внутренних -->
			<div class="b-block">
				<div class="b-header-block b-header-top clearfix">
					<? if( $isCatalog ): ?>
						<a href="/" class="b-logo b-logo-<?=$GLOBALS["SECTIONS"][0]["ID"]?>"></a>
					<? else: ?>
						<a href="/" class="b-logo"></a>
					<? endif; ?>
					<div class="b-menu-container">
						<ul class="b-menu">
							<li><a href="/delivery/">Доставка и&nbsp;оплата</a></li>
							<li><a href="/new/">Новые приходы</a></li>
							<li><a href="/magazin/">Розничный магазин</a></li>
							<li><a href="/rukovodstvo/">Связь с&nbsp;руководством</a></li>
							<li><a href="/discounts/" class="yellow">Акции и&nbsp;скидки</a></li>
						</ul>
					</div>
					<a href="#b-popup-auth" class="b-mobile-auth fancy"></a>
					<? $basketInfo = getBasketCount(); ?>
					<a href="/cart/" class="b-cart">
						<div class="b-cart-img icon-cart"></div>
						<div class="b-cart-text">
							<p class="mobile-cart-count"><?=$basketInfo["count"]?></p>
							<p class="cart-count" <? if( $basketInfo["sum"] == 0 ): ?>style="display:none;"<? endif; ?>><?=$basketInfo["count"]?> шт.</p>
							<p class="cart-sum icon-rub" <? if( $basketInfo["sum"] == 0 ): ?>style="display:none;"<? endif; ?>><?=$basketInfo["sum"]?></p>
						</div>
					</a>
					<div class="b-phone">
						<a href="tel:+74959225055" class="phone">+ 7 495 922 50 55</a>
						<a href="tel:+74956447572" class="phone">+ 7 495 644 75 72</a>
						<a href="#b-popup-phone" class="phone-link fancy">Не дозвонились?</a>
					</div>
				</div>
				<div class="b-header-block pink-header-block house-<?=$GLOBALS["season"]?> clearfix">
					<a href="#" class="b-catalog-menu icon-list b-go" data-block=".b-big-menu">Каталог товаров</a>
					<div class="b-phone">
						<a href="tel:+74959225055" class="phone">+ 7 495 922 50 55</a>
						<a href="tel:+74956447572" class="phone">+ 7 495 644 75 72</a>
						<a href="#b-popup-phone" class="phone-link fancy">Не дозвонились?</a>
					</div>
					<div id="burger-menu" class="burger-menu icon-menu"></div>
					<div class="b-search-form-cont">
						<?$APPLICATION->IncludeComponent("bitrix:search.title", "header", Array(
							"CATEGORY_0" => array(	// Ограничение области поиска
									0 => "iblock_content",
								),
								"CATEGORY_0_TITLE" => "",	// Название категории
								"CATEGORY_0_forum" => array(
									0 => "all",
								),
								"CATEGORY_0_iblock_content" => array(	// Искать в информационных блоках типа "iblock_content"
									0 => "1",
								),
								"CATEGORY_0_main" => array(
									0 => "",
								),
								"CHECK_DATES" => "N",	// Искать только в активных по дате документах
								"CONTAINER_ID" => "title-search",	// ID контейнера, по ширине которого будут выводиться результаты
								"CONVERT_CURRENCY" => "N",	// Показывать цены в одной валюте
								"INPUT_ID" => "title-search-input",	// ID строки ввода поискового запроса
								"NUM_CATEGORIES" => "1",	// Количество категорий поиска
								"ORDER" => "rank",	// Сортировка результатов
								"PAGE" => "#SITE_DIR#search/",	// Страница выдачи результатов поиска (доступен макрос #SITE_DIR#)
								"PREVIEW_HEIGHT" => "75",	// Высота картинки
								"PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода
								"PREVIEW_WIDTH" => "75",	// Ширина картинки
								"PRICE_CODE" => "",	// Тип цены
								"PRICE_VAT_INCLUDE" => "Y",	// Включать НДС в цену
								"SHOW_INPUT" => "Y",	// Показывать форму ввода поискового запроса
								"SHOW_OTHERS" => "N",	// Показывать категорию "прочее"
								"SHOW_PREVIEW" => "Y",	// Показать картинку
								"TEMPLATE_THEME" => "blue",
								"TOP_COUNT" => "8",	// Количество результатов в каждой категории
								"USE_LANGUAGE_GUESS" => "Y",	// Включить автоопределение раскладки клавиатуры
							),
							false
						);?>
					</div>
					<a href="#b-popup-ask" class="dashed fancy">Задать вопрос</a>
				</div>
				<div class="b-header-block menu-header-block">
					<?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "header_categories", Array(
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
							"SECTION_ID" => 0,	// ID раздела
							"SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
							"SECTION_USER_FIELDS" => array(	// Свойства разделов
							),
							"SHOW_PARENT_NAME" => "Y",	// Показывать название раздела
							"TOP_DEPTH" => "1",	// Максимальная отображаемая глубина разделов
							"VIEW_MODE" => "LINE",	// Вид списка подразделов
						),
						false
					);?>
					<? if( !isAuth() ): ?>
						<a href="#b-popup-auth" class="auth fancy">Войти</a>
					<? else: ?>
						<div class="b-auth-block">
							<a href="/personal/">Личный кабинет</a>
							<a href="/personal?action=logout&redirect=/" class="grey">Выйти</a>
						</div>
					<? endif; ?>
				</div>
				<div class="b-header-block mobile-menu-header-block">
					<div class="mobile-menu-header-text icon-list" id="catalog-menu-btn">Каталог товаров</div>
				</div>
			</div>
		</div>
		<? if( !$isMain ): ?>
		<div class="b-content-block">
			<div class="b-block clearfix">
				<? if( $isCatalog ): ?>
					<div class="b-category-left b-category-item">
						<?
						$property = ($GLOBALS["isWholesale"])?array( "WHOLESALE" => 78 ):Array();
						if( ($GLOBALS["isSale"]) ){
							$property = array("SALE" => 79);
						}
						?>
						<?$APPLICATION->IncludeComponent("redder:catalog.section.list", "left_categories", Array(
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
									1 => "PICTURE",
								),
								"SECTION_ID" => ($GLOBALS["isWholesale"] || $GLOBALS["isSale"])?$GLOBALS["HEADER_CATEGORIES"]:$GLOBALS["SECTIONS"][0]["ID"],	// ID раздела
								"SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
								"SECTION_USER_FIELDS" => array(	// Свойства разделов
									"UF_HIGHLIGHT",
									"UF_HIDE",
								),
								"SHOW_PARENT_NAME" => "Y",	// Показывать название раздела
								"TOP_DEPTH" => "1",	// Максимальная отображаемая глубина разделов
								"VIEW_MODE" => "LINE",	// Вид списка подразделов
								"PROPERTY" => $property,
							),
							false
						);?>
						<ul>
							<li>
								<a href="/sale/" class="highlight">Распродажа</a>
							</li>
						</ul>
					</div>
					<div class="b-category-right b-category-item">
				<? elseif( $isPersonal ): ?>
					<div class="b-category-left b-category-item">
						<?$APPLICATION->IncludeComponent("bitrix:menu", "personal_menu", array(
							"ROOT_MENU_TYPE" => "personal",
							"MAX_LEVEL" => "1",
							"MENU_CACHE_TYPE" => "A",
							"CACHE_SELECTED_ITEMS" => "N",
							"MENU_CACHE_TIME" => "36000000",
							"MENU_CACHE_USE_GROUPS" => "Y",
							"MENU_CACHE_GET_VARS" => array(),
						),
							false
						);?>
					</div>
					<div class="b-category-right b-personal-right b-category-item">
				<? endif; ?>					
					<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "main", Array(
							"COMPONENT_TEMPLATE" => ".default",
							"START_FROM" => "0",	// Номер пункта, начиная с которого будет построена навигационная цепочка
							"PATH" => "",	// Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
							"SITE_ID" => "-",	// Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
						),
						false
					);?>
					<h1><?$APPLICATION->ShowTitle(false)?></h1>
		<? endif; ?>
		<? if( !$notBText ): ?>
			<div class="b-text<? if( $isDelivery ): ?> b-delivery-text<? endif; ?>">
		<? endif; ?>