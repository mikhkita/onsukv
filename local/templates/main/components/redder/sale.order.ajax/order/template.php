<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main,
    Bitrix\Sale,
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
            <input type="hidden" name="PRICE_DELIVERY" id="delivery-price" value="">
            <? /* ?><input type="hidden" name="account_only" value="N"><? */ ?>
            <? /* ?><input type="hidden" name="PAY_CURRENT_ACCOUNT" value="N"><? */ ?>
            <? /* ?><input type="hidden" name="confirmorder" id="confirmorder" value="Y"><? */ ?>
            <? /* ?><input type="hidden" name="profile_change" id="profile_change" value="N"><? */ ?>
            <? /* ?><input type="hidden" name="is_ajax_post" id="is_ajax_post" value="Y"><? */ ?>
            <? /* ?><input type="hidden" name="json" value="Y"><? */ ?>
            <input type="hidden" name="save" value="Y">
            <input type="hidden" name="DELIVERY_ID" value="2">

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
                                <option value="<?=$arDelivery["ID"]?>" data-price="<?=$arDelivery["PRICE"]?>" data-date="<?=intval($arDelivery["PRIOD"])?>"><?=$arDelivery["NAME"]?></option>
                            <? endforeach; ?>
                        </select>
                        <input type="hidden" name="deliveryPrice" id="b-delivery-price-input">
                    </div>
                    <div class="b-input not-empty">
                        <label for="last_name">Дата доставки <span class="required">*</span></label>
                        <select name="DELIVERY_DOC_DATE" id="date" required>
                            <? foreach ($arResult["DATES"] as $key => $arDate): ?>
                                <option value="<?=$arDate["KEY"]?>" data-isSunday="<?=$arDate["IS_SUNDAY"]?>"><?=$arDate["VALUE"]?></option>
                            <? endforeach; ?>
                        </select>
                    </div>
                    <div class="b-input not-empty b-wide-input b-pickpoint" style="display: none;">
                        <span id="total_sum_pickpoint" data-levels="7" data-1-match="БЕЛГОРОД|Белгородская обл.|БРЯНСК|Брянская обл.|ВЛАДИМИР|Владимирская обл.|ВОРОНЕЖ|Воронежская обл.|ИВАНОВО|Ивановская обл.|КАЗАНЬ|Татарстан респ.|КАЛУГА|Калужская обл.|КОСТРОМА|Костромская обл.|КРАСНОДАР|Краснодарский край|КУРСК|Курская обл.|ЛИПЕЦК|Липецкая обл.|НИЖНИЙ НОВГОРОД|Нижегородская обл.|ОРЕЛ|Орловская обл.|ПСКОВ|Псковская обл.|РОСТОВ-НА-ДОНУ|Ростовская обл.|РЯЗАНЬ|Рязанская обл.|САМАРА|Самарская обл.|СМОЛЕНСК|Смоленская обл.|ТАМБОВ|Тамбовская обл.|ТВЕРЬ|Тверская обл.|ТОЛЬЯТТИ|Самарская обл.|ТУЛА|Тульская обл.|ЯРОСЛАВЛЬ|Ярославская обл." data-1-price="490" data-2-match="АНАПА|Краснодарский край|АРМАВИР|Краснодарский край|ВОЛГОГРАД|Волгоградская обл.|ВОЛГОДОНСК|Ростовская обл.|ВОЛОГДА|Вологодская обл.|ГЕЛЕНДЖИК|Краснодарский край|ЕКАТЕРИНБУРГ|Свердловская обл.|ИЖЕВСК|Удмуртская респ.|ЙОШКАР-ОЛА|Марий Эль респ.|КИРОВ|Кировская обл.|НАБЕРЕЖНЫЕ ЧЕЛНЫ|Татарстан респ.|НОВОРОССИЙСК|Краснодарский край|ОРЕНБУРГ|Оренбургская обл.|ПЕНЗА|Пензенская обл.|РЫБИНСК|Ярославская обл.|САРАНСК|Мордовия респ.|САРАТОВ|Саратовская обл.|САРОВ|Нижегородская обл.|СОЧИ|Краснодарский край|СТАВРОПОЛЬ|Ставропольский край|СЫЗРАНЬ|Самарская обл.|ТАГАНРОГ|Ростовская обл.|ТУАПСЕ|Краснодарский край|УФА|Башкортостан респ.|ЧЕБОКСАРЫ|Чувашия респ.|ЧЕЛЯБИНСК|Челябинская обл." data-2-price="590" data-3-match="НОВОСИБИРСК|Новосибирская обл.|БЕРЕЗНИКИ|Пермский край|ВЕРХНЯЯ ПЫШМА|Свердловская обл.|КАМЕНСК-УРАЛЬСКИЙ|Свердловская обл.|МАГНИТОГОРСК|Челябинская обл.|НИЖНИЙ ТАГИЛ|Свердловская обл.|ОМСК|Омская обл.|ОРСК|Оренбургская обл.|ПЕРМЬ|Пермский край|ПЯТИГОРСК|Ставропольский край|СЕРОВ|Свердловская обл.|ТЮМЕНЬ|Тюменская обл.|УЛЬЯНОВСК|Ульяновская обл.|ЧЕРЕПОВЕЦ|Вологодская обл." data-3-price="690" data-4-match="БАРНАУЛ|Алтайский край|КЕМЕРОВО|Кемеровская обл.|КРАСНОЯРСК|Красноярский край|КУРГАН|Курганская обл.|НИЖНЕВАРТОВСК|Ханты-Мансийский АО|НОВОКУЗНЕЦК|Кемеровская обл.|ПЕТРОЗАВОДСК|Карелия респ.|СУРГУТ|Ханты-Мансийский АО|ТОМСК|Томская обл." data-4-price="1190" data-5-match="АРХАНГЕЛЬСК|Архангельская обл.|АСТРАХАНЬ|Астраханская обл.|ВЛАДИВОСТОК|Приморский край|ХАБАРОВСК|Хабаровский край|УЛАН-УДЭ|Бурятия респ.|МУРМАНСК|Мурманская обл.|СЫКТЫВКАР|Коми респ.|ИРКУТСК|Иркутская обл." data-5-price="990" data-6-match="МАГАДАН|Магаданская обл." data-6-price="2290" data-7-match="Санкт-Петербург" data-7-price="490"></span>
                        <!-- <label for="last_name">Постамат <span class="required">*</span></label> -->
                        <div class="b-postamat" id="pickpoint-delivery-point">
                            Постамат <span class="required">*</span>: не выбран
                        </div>
                        <a href="#" onclick="PickPoint.open(pickPointHandler); return false">Выбрать постамат</a>
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
                </div>
                <div style="display: none;">
                <h4 class="b-delivery-price">Стоимость доставки: <span id="b-delivery-price">0</span> руб.</h4>
                </div>
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