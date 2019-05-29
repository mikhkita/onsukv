<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main,
    Bitrix\Sale,
    Bitrix\Sale\Delivery,
    Bitrix\Main\Localization\Loc;

// echo "<pre>";
// print_r($arResult["DELIVERY"]);
// echo "</pre>";

$context = Main\Application::getInstance()->getContext();
$request = $context->getRequest();
$server = $context->getServer();

// print_r($arResult["PAY_SYSTEM"]);

$intervals = array();
$curDate = date("Y-m-d H:i");

$arFilter = array("IBLOCK_ID"=>5, "ACTIVE"=>"Y", ">=PROPERTY_DATE_TO"=>$curDate);
$res = CIBlockElement::GetList(array(), $arFilter, false, false, array());
while($ob = $res->GetNextElement()){ 
    $arProps = $ob->GetProperties();
    $intervals[] = array($arProps["DATE_FROM"]["VALUE"], $arProps["DATE_TO"]["VALUE"]);
}

$intervalsJSON = htmlspecialchars(json_encode($intervals));

global $USER;
$arUser = array();
if( $userID = $USER->GetID() ){
    $rsUser = CUser::GetByID($userID);
    $arUser = $rsUser->Fetch();
}

// $order = Sale\Order::create(SITE_ID, $USER->GetID());
// $deliveryCollection = $order->getShipmentCollection();

// // $delivery = $deliveryCollection->getItemByShipmentCode(33);
// print_r($deliveryCollection);

// foreach ($deliveryCollection as $shipment){
// //     // print_r($shipment->getField("PRICE"));
// //     print_r($shipment->getFieldValues());
//     // echo "string";
// }
// print_r($arResult);

foreach ($arResult["DELIVERY"] as $key => $arDelivery) {
    $arResult["DELIVERY"][$key] = Delivery\Services\Manager::getById($arDelivery["ID"]);
}

// print_r($arResult["DELIVERY"]);

if (strlen($_REQUEST['ORDER_ID']) > 0){
    include($server->getDocumentRoot().$templateFolder.'/confirm.php');
}else{
?>
<div class="b-data-order b-block-gray b-padding">
    <div class="b-block">
       <!--  <div class="b-data-order-top clearfix">
            <h2 class="b-title">Данные к заказу</h2>
            <div class="b b-addressee b-addressee-desktop">
                <a href="#" class="b-addressee-switch"></a>
                <div class="b-btn-switch b-addressee-left active" data-payment="delivery" data-short="Доставка" data-long="Нужна доставка">Нужна доставка</div>
                <div class="b-btn-switch b-addressee-right" data-payment="pickup">Самовывоз</div>
                <div class="b-btn-addressee"></div>
            </div>
        </div> -->
        <form class="b-data-order-form" method="POST" name="ORDER_FORM" id="ORDER_FORM" enctype="multipart/form-data" action="<?=$APPLICATION->GetCurPage();?>">
            <?=bitrix_sessid_post()?>
            <input type="hidden" id="PERSON_TYPE_1" name="PERSON_TYPE" value="1">
            <input type="hidden" name="soa-action" value="saveOrderAjax">
            <? /* ?><input type="hidden" name="PROFILE_ID" value="0"><? */ ?>
            <input type="hidden" name="PERSON_TYPE_OLD" value="1">
            <input type="hidden" name="location_type" value="code">
            <input type="hidden" name="ORDER_DESCRIPTION" value="">
            <input type="hidden" name="BUYER_STORE" id="BUYER_STORE" value="0">
            <? /* ?><input type="hidden" name="account_only" value="N"><? */ ?>
            <? /* ?><input type="hidden" name="PAY_CURRENT_ACCOUNT" value="N"><? */ ?>
            <? /* ?><input type="hidden" name="confirmorder" id="confirmorder" value="Y"><? */ ?>
            <? /* ?><input type="hidden" name="profile_change" id="profile_change" value="N"><? */ ?>
            <? /* ?><input type="hidden" name="is_ajax_post" id="is_ajax_post" value="Y"><? */ ?>
            <? /* ?><input type="hidden" name="json" value="Y"><? */ ?>
            <input type="hidden" name="save" value="Y">
            <!-- <input type="hidden" name="DELIVERY_ID" value="2"> -->

            <div class="b-inputs b-input-row clearfix">
                <div class="b-input<?=( isset($arUser["NAME"])?" not-empty":"")?>">
                    <input type="text" id="name" name="ORDER_PROP_1" value="<?=( isset($arUser["NAME"])?$arUser["NAME"]:"")?>" required>
                    <label for="name">Ваше имя <span class="required">*</span></label>
                </div>
                <div class="b-input<?=( isset($arUser["LAST_NAME"])?" not-empty":"")?>">
                    <input type="text" id="last_name" name="ORDER_PROP_2" value="<?=( isset($arUser["LAST_NAME"])?$arUser["LAST_NAME"]:"")?>" required>
                    <label for="last_name">Ваша фамилия <span class="required">*</span></label>
                </div>
                <div class="b-input<?=( isset($arUser["WORK_PHONE"])?" not-empty":"")?>">
                    <input type="tel" id="phone" pattern="[0-9]*" name="ORDER_PROP_4" value="<?=( isset($arUser["WORK_PHONE"])?$arUser["WORK_PHONE"]:"")?>" required>
                    <label for="phone">Ваш телефон <span class="required">*</span></label>
                </div>
                <div class="b-input b-email-input<?=( isset($arUser["EMAIL"])?" not-empty":"")?>">
                    <input type="text" id="email" name="ORDER_PROP_3" value="<?=( isset($arUser["EMAIL"])?$arUser["EMAIL"]:"")?>" required>
                    <label for="email">Ваш E-mail <span class="required">*</span></label>
                </div>
                <!-- <div class="b-date-time" data-intervals="<?=$intervalsJSON;?>">
                    <div class="b-date-tip">Дата недоступна</div>
                    <div class="b-input b-date">
                        <input type="text" id="date" name="ORDER_PROP_5" autocomplete="off">
                        <label for="date">Дата и время</label>
                    </div>
                    <div class="b-input b-time">
                        <input type="text" class="input-time" id="time" name="ORDER_PROP_6" data-hour="1" autocomplete="off">
                        <label for="time"></label>
                    </div>
                    <div class="b-time-list">
                        <ul>
                            <li>
                                <input id="hour-8" type="radio" data-hour="8" name="time-select">
                                <label for="hour-8">08:00</label>
                            </li>
                            <li>
                                <input id="hour-9" type="radio" data-hour="9" name="time-select">
                                <label for="hour-9">09:00</label>
                            </li>
                            <li>
                                <input id="hour-10" type="radio" data-hour="10" name="time-select">
                                <label for="hour-10">10:00</label>
                            </li>
                            <li>
                                <input id="hour-11" type="radio" data-hour="11" name="time-select">
                                <label for="hour-11">11:00</label>
                            </li>
                            <li>
                                <input id="hour-12" type="radio" data-hour="12" name="time-select">
                                <label for="hour-12">12:00</label>
                            </li>
                        </ul>
                        <ul>
                            <li>
                                <input id="hour-13" type="radio" data-hour="13" name="time-select">
                                <label for="hour-13">13:00</label>
                            </li>
                            <li>
                                <input id="hour-14" type="radio" data-hour="14" name="time-select">
                                <label for="hour-14">14:00</label>
                            </li>
                            <li>
                                <input id="hour-15" type="radio" data-hour="15" name="time-select">
                                <label for="hour-15">15:00</label>
                            </li>
                            <li>
                                <input id="hour-16" type="radio" data-hour="16" name="time-select">
                                <label for="hour-16">16:00</label>
                            </li>
                            <li>
                                <input id="hour-17" type="radio" data-hour="17" name="time-select">
                                <label for="hour-17">17:00</label>
                            </li>
                        </ul>
                        <ul>
                            <li>
                                <input id="hour-18" type="radio" data-hour="18" name="time-select">
                                <label for="hour-18">18:00</label>
                            </li>
                            <li>
                                <input id="hour-19" type="radio" data-hour="19" name="time-select">
                                <label for="hour-19">19:00</label>
                            </li>
                            <li>
                                <input id="hour-20" type="radio" data-hour="20" name="time-select">
                                <label for="hour-20">20:00</label>
                            </li>
                            <li>
                                <input id="hour-21" type="radio" data-hour="21" name="time-select">
                                <label for="hour-21">21:00</label>
                            </li>
                            <li>
                                <input id="hour-22" type="radio" data-hour="22" name="time-select">
                                <label for="hour-22">22:00</label>
                            </li>
                        </ul>
                    </div>
                    <div class="icon-clock hide"></div>
                    <div class="icon-calendar"></div>
                </div>
                <div class="b-input b-input-date-mobile">
                    <input type="text" id="date-mobile" name="date-mobile">
                    <label for="date-mobile">Дата и время</label>
                </div> -->
            </div>
            <div class="b-inputs clearfix b-input-row">
                <div class="clearfix">
                    <div class="b-input not-empty">
                        <label for="last_name">Способ доставки <span class="required">*</span></label>
                        <select name="DELIVERY_ID" id="delivery" data-price="0" data-date="1" required>
                            <option>Выберите тип доставки</option>
                            <? foreach ($arResult["DELIVERY"] as $key => $arDelivery): ?>
                                <option value="<?=$arDelivery["ID"]?>" data-price="<?=$arDelivery["CONFIG"]["MAIN"]["PRICE"]?>" data-date="<?=$arDelivery["CONFIG"]["MAIN"]["PERIOD"]?>"><?=$arDelivery["NAME"]?></option>
                            <? endforeach; ?>
                        </select>
                        <input type="hidden" name="PRICE_DELIVERY" id="b-delivery-price-input">
                    </div>
                    <div class="b-input not-empty">
                        <label for="last_name">Дата доставки <span class="required">*</span></label>
                        <select name="DELIVERY_DOC_DATE" id="date" required>
                            <? foreach ($arResult["DATES"] as $key => $arDate): ?>
                                <option value="<?=$arDate["KEY"]?>" data-isSunday="<?=$arDate["IS_SUNDAY"]?>"><?=$arDate["VALUE"]?></option>
                            <? endforeach; ?>
                        </select>
                    </div>
                    <div class="b-input b-time-input not-empty" style="display:none;" id="b-time-input">
                        <label for="last_name">Время доставки <span class="required">*</span></label>
                        <select name="time" id="time" required>
                            
                        </select>
                    </div>
                    <div class="b-input b-mkad-input" style="display:none;" id="b-mkad-input">
                        <input type="number" id="mkad" name="mkad">
                        <label for="mkad">Расстояние от МКАД</label>
                    </div>
                    <div class="b-input not-empty b-wide-input b-pickpoint" style="display: none;">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:news.list", 
                            "PickPoint", 
                            array(
                                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                                "ADD_SECTIONS_CHAIN" => "N",
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
                                "FIELD_CODE" => array(
                                    0 => "",
                                    1 => "",
                                ),
                                "FILTER_NAME" => "",
                                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                                "IBLOCK_ID" => "7",
                                "IBLOCK_TYPE" => "content",
                                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                                "INCLUDE_SUBSECTIONS" => "Y",
                                "MESSAGE_404" => "",
                                "NEWS_COUNT" => "1000",
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
                                "PROPERTY_CODE" => array(
                                    0 => "",
                                    1 => "",
                                ),
                                "SET_BROWSER_TITLE" => "N",
                                "SET_LAST_MODIFIED" => "N",
                                "SET_META_DESCRIPTION" => "N",
                                "SET_META_KEYWORDS" => "N",
                                "SET_STATUS_404" => "N",
                                "SET_TITLE" => "N",
                                "SHOW_404" => "N",
                                "SORT_BY1" => "SORT",
                                "SORT_BY2" => "SORT",
                                "SORT_ORDER1" => "ASC",
                                "SORT_ORDER2" => "ASC",
                                "STRICT_SECTION_CHECK" => "N",
                                "COMPONENT_TEMPLATE" => "news"
                            ),
                            false
                        );?>
                        <span id="total_sum_pickpoint"></span>
                        <!-- <label for="last_name">Постамат <span class="required">*</span></label> -->
                        <div class="b-postamat" id="pickpoint-delivery-point">
                            Постамат <span class="required">*</span>: не выбран
                        </div>
                        <a href="#" onclick="PickPoint.open(pickPointHandler); return false">Выбрать постамат</a>
                    </div>
                </div>
                <? foreach ($arResult["DELIVERY"] as $key => $arDelivery): ?>
                    <? if( $arDelivery["DESCRIPTION"] !== "" ): ?>
                        <div class="b-delivery-info b-text" id="delivery-info-<?=$arDelivery["ID"]?>" style="display: none;">
                            <?=$arDelivery["DESCRIPTION"]?>
                        </div>
                    <? endif; ?>
                <? endforeach; ?>
                <div class="b-order-addr-cont" style="display: none;">
                    <div class="b-row b-order-addr">
                        <h4>Адрес доставки:</h4>
                        <? foreach ($arResult["ADDRESSES"] as $key => $arAddress): ?>
                            <div class="b-checkbox">
                                <input type="radio" id="addr-<?=$arAddress["ID"]?>" class="b-addr-radio" name="address" data-index="<?=$arAddress["INDEX"]?>" data-region="<?=$arAddress["REGION"]?>" data-address="<?=$arAddress["ADDRESS"]?>" data-room="<?=$arAddress["ROOM"]?>">
                                <label for="addr-<?=$arAddress["ID"]?>"><?=$arAddress["INDEX"]?>, <?=$arAddress["REGION"]?>, <?=$arAddress["ADDRESS"]?>, кв/оф. <?=$arAddress["ROOM"]?></label>
                            </div>
                        <? endforeach; ?>
                        <? if( count($arResult["ADDRESSES"]) ): ?>
                            <div class="b-checkbox">
                                <input type="radio" id="addr-new" class="b-addr-radio" name="address" value="NEW">
                                <label for="addr-new">Добавить адрес</label>
                            </div>
                        <? endif; ?>
                    </div>
                    <div class="b-row b-order-addr-new b-text clearfix" <? if(count($arResult["ADDRESSES"])): ?>style="display:none;"<? endif; ?>>
                        <div class="order-adress-map-form-content">
                            <div class="b-addresss-item form-item __adress b-ui-autocomplete">
                                <div class="b-addresss-item__address b-input ui-menu ui-widget ui-widget-content ui-autocomplete ui-front">
                                    <input type="text" id="js-order-adress-map-input" class="js-order-adress-map-input ui-autocomplete-input" name="PROPERTY[NAME][0]" value="" autocomplete="off" required>
                                    <label for="name">Город, улица, дом <span class="required">*</span></label>
                                </div>
                                <div class="b-addresss-item__room b-input">
                                    <input type="text" id="number-room-input" name="PROPERTY[26][0]" value="" autocomplete="off" required>
                                    <label for="name">Квартира/офис <span class="required">*</span></label>
                                </div>
                                <div class="b-addresss-item__index b-input">
                                    <input type="text" id="postal-code" name="PROPERTY[24][0]" value="" autocomplete="off" required>
                                    <label for="name">Индекс <span class="required">*</span></label>
                                </div>
                            </div>
                            <input type="hidden" id="region" name="PROPERTY[25][0]" value="<?=$arResult["ELEMENT_PROPERTIES"][25][0]['VALUE']?>">
                            <!-- <div class="b-addresss-btn-container">
                                <input type="submit" name="iblock_submit3" value="Сохранить" class="b-btn-address-save not-ajax">
                            </div> -->
                        </div>
                        <div id="map-address"></div>
                    </div>
                </div>
                <!-- /*<div style="display: none;">*/ -->
                <h4 class="b-delivery-price">Стоимость доставки: <span id="b-delivery-price">0</span> руб.</h4>
                <!-- </div> -->
            </div>
            <!-- <div class="b-address b-table">
                <div class="b-table-cell">
                    <div class="b-choose-address">
                        <p>Адрес доставки: <span class="required">*</span></p>
                        <span class="choose-address-value"></span>
                        <div class="choose-address-change-cont">
                            <a href="#b-popup-map" class="fancy b-btn-dashed choose-address-change">
                                <span class="choose-address-action">указать адрес</span>
                                <input class="error" type="text" id="address" name="ORDER_PROP_4" required>
                            </a>
                            <div class="b-address-tip">Укажите адрес доставки</div>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="b-row clearfix">
                <div class="b-inputs b-input-row b-input-move clearfix">
                    <div class="b-input b-textarea">
                        <textarea id="comment" name="ORDER_DESCRIPTION" rows="1"></textarea>
                        <label for="comment">Комментарий или пожелание</label>
                    </div>
                </div>
            </div>
           <div class="b-inputs b-input-row b-for-payment clearfix">
                <div class="b-for-payment-left">
                    <!-- <div class="b-radio b-payment-method" style="display: none;">
                        <p>Способ оплаты:</p>
                        <div class="b-payment-method-list">
                            <? foreach ($arResult["PAY_SYSTEM"] as $key => $payment): ?>
                                <div class="b-payment-method-item <?=$payment["CODE"]?>">
                                    <input id="pay-<?=$payment["ID"]?>" type="radio" name="PAY_SYSTEM_ID" value="<?=$payment["ID"]?>" required<? if( $key == 0 ): ?> checked<? endif; ?>>
                                    <label for="pay-<?=$payment["ID"]?>"><?=$payment["NAME"]?></label>
                                </div>
                            <? endforeach; ?>
                        </div>
                    </div>
                    <div class="b-checkbox b-basket-checkbox">
                        <input id="politics1" class="" type="checkbox" name="politics" checked required>
                        <label for="politics1">Настоящим подтверждаю, что я ознакомлен и согласен с <a href="/politics/">политикой по обработке персональных данных</a></label>
                    </div> -->
                    <?
                    $sales = CSaleOrder::GetList(array("SORT" => "ASC"), array("USER_ID" => $USER->GetID()), false, false, array()); 
                    $class = "invisible-checkbox";
                    if($sales->Fetch()){
                        $class = "";
                    };
                    ?>
                    <div class="b-checkbox b-basket-checkbox <?=$class?>">
                        <input id="CALL" type="checkbox" name="ORDER_PROP_6" checked value="Y">
                        <label for="CALL">Заказать звонок оператора</a></label>
                    </div>
                </div>
            </div>
            <!-- <div class="b-center">
                <img src="/bitrix/templates/main/html/i/preload.svg" alt="" class="b-svg-preload b-svg-preload-popup">
                <a href="#" class="b-btn b-btn-buy not-ajax b-btn-cart icon-success">
                    <div class="b-btn-more-text b-center">Оформить заказ</div>
                </a>
            </div> -->
            <input type="submit" value="Заказать" class="goal-click" data-goal="TRY_BUY" style="display:none;">
            <?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket", "order", Array(
                "ACTION_VARIABLE" => "basketAction",    // Название переменной действия
                    "ADDITIONAL_PICT_PROP_1" => "-",    // Дополнительная картинка [Товары]
                    "AUTO_CALCULATION" => "Y",  // Автопересчет корзины
                    "BASKET_IMAGES_SCALING" => "adaptive",  // Режим отображения изображений товаров
                    "COLUMNS_LIST_EXT" => array(    // Выводимые колонки
                        0 => "PREVIEW_PICTURE",
                        1 => "DISCOUNT",
                        2 => "DELETE",
                        3 => "DELAY",
                        4 => "TYPE",
                        5 => "SUM",
                    ),
                    "COLUMNS_LIST_MOBILE" => array( // Колонки, отображаемые на мобильных устройствах
                        0 => "PREVIEW_PICTURE",
                        1 => "DISCOUNT",
                        2 => "DELETE",
                        3 => "DELAY",
                        4 => "TYPE",
                        5 => "SUM",
                    ),
                    "COMPATIBLE_MODE" => "Y",   // Включить режим совместимости
                    "CORRECT_RATIO" => "Y", // Автоматически рассчитывать количество товара кратное коэффициенту
                    "DEFERRED_REFRESH" => "N",  // Использовать механизм отложенной актуализации данных товаров с провайдером
                    "DISCOUNT_PERCENT_POSITION" => "top-left",  // Расположение процента скидки
                    "DISPLAY_MODE" => "extended",   // Режим отображения корзины
                    "EMPTY_BASKET_HINT_PATH" => "/",    // Путь к странице для продолжения покупок
                    "GIFTS_BLOCK_TITLE" => "Выберите один из подарков", // Текст заголовка "Подарки"
                    "GIFTS_CONVERT_CURRENCY" => "N",    // Показывать цены в одной валюте
                    "GIFTS_HIDE_BLOCK_TITLE" => "N",    // Скрыть заголовок "Подарки"
                    "GIFTS_HIDE_NOT_AVAILABLE" => "N",  // Не отображать товары, которых нет на складах
                    "GIFTS_MESS_BTN_BUY" => "Выбрать",  // Текст кнопки "Выбрать"
                    "GIFTS_MESS_BTN_DETAIL" => "Подробнее", // Текст кнопки "Подробнее"
                    "GIFTS_PAGE_ELEMENT_COUNT" => "4",  // Количество элементов в строке
                    "GIFTS_PLACE" => "BOTTOM",  // Вывод блока "Подарки"
                    "GIFTS_PRODUCT_PROPS_VARIABLE" => "prop",   // Название переменной, в которой передаются характеристики товара
                    "GIFTS_PRODUCT_QUANTITY_VARIABLE" => "quantity",    // Название переменной, в которой передается количество товара
                    "GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",   // Показывать процент скидки
                    "GIFTS_SHOW_OLD_PRICE" => "N",  // Показывать старую цену
                    "GIFTS_TEXT_LABEL_GIFT" => "Подарок",   // Текст метки "Подарка"
                    "HIDE_COUPON" => "N",   // Спрятать поле ввода купона
                    "LABEL_PROP" => "", // Свойства меток товара
                    "PATH_TO_ORDER" => "/cart/order/",  // Страница оформления заказа
                    "PRICE_DISPLAY_MODE" => "Y",    // Отображать цену в отдельной колонке
                    "PRICE_VAT_SHOW_VALUE" => "N",  // Отображать значение НДС
                    "PRODUCT_BLOCKS_ORDER" => "props,sku,columns",  // Порядок отображения блоков товара
                    "QUANTITY_FLOAT" => "Y",    // Использовать дробное значение количества
                    "SET_TITLE" => "N", // Устанавливать заголовок страницы
                    "SHOW_DISCOUNT_PERCENT" => "Y", // Показывать процент скидки рядом с изображением
                    "SHOW_FILTER" => "Y",   // Отображать фильтр товаров
                    "SHOW_RESTORE" => "Y",  // Разрешить восстановление удалённых товаров
                    "TEMPLATE_THEME" => "yellow",   // Цветовая тема
                    "TOTAL_BLOCK_DISPLAY" => array( // Отображение блока с общей информацией по корзине
                        0 => "bottom",
                    ),
                    "USE_DYNAMIC_SCROLL" => "Y",    // Использовать динамическую подгрузку товаров
                    "USE_ENHANCED_ECOMMERCE" => "N",    // Отправлять данные электронной торговли в Google и Яндекс
                    "USE_GIFTS" => "Y", // Показывать блок "Подарки"
                    "USE_PREPAYMENT" => "N",    // Использовать предавторизацию для оформления заказа (PayPal Express Checkout)
                    "USE_PRICE_ANIMATION" => "Y",   // Использовать анимацию цен
                ),
                false
            );?>
            <div class="b-checkbox b-basket-checkbox">
                <input id="politics1" class="" type="checkbox" name="politics" checked required>
                <label for="politics1">Настоящим подтверждаю, что я ознакомлен и согласен с <a href="/politics/">политикой по обработке персональных данных</a></label>
            </div>
        </form>
    </div>
</div>
<?
}
?>