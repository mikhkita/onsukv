<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Localization\Loc,
	Bitrix\Sale,
    Bitrix\Sale\Delivery;

/**
 * @var array $arParams
 * @var array $arResult
 * @var $APPLICATION CMain
 */

// $dels = array();
// $db_dtype = CSaleDelivery::GetList(
//     array(
//             "SORT" => "ASC",
//             "NAME" => "ASC"
//         ),
//     array(
//             "LID" => SITE_ID,
//             // "+<=WEIGHT_FROM" => $ORDER_WEIGHT,
//             // "+>=WEIGHT_TO" => $ORDER_WEIGHT,
//             // "+<=ORDER_PRICE_FROM" => $ORDER_PRICE,
//             // "+>=ORDER_PRICE_TO" => $ORDER_PRICE,
//             "ACTIVE" => "Y",
//             // "LOCATION" => $DELIVERY_LOCATION
//         ),
//     false,
//     false,
//     array()
// );
// if ($ar_dtype = $db_dtype->Fetch())
// {
//    do
//    {
//       $dels[ $ar_dtype["ID"] ] = $ar_dtype["NAME"];
//    }
//    while ($ar_dtype = $db_dtype->Fetch());
// }


// $dels = array(
// 	2 => "Доставка курьером",
// 	3 => "Самовывоз"
// );

if ($arParams["SET_TITLE"] == "Y")
	$APPLICATION->SetTitle("Заказ оформлен");

$paySystem = array_pop($arResult["PAY_SYSTEM_LIST"]);

// print_r($arResult);

if( $arResult["ORDER"]["DELIVERY_ID"] ){
	$delivery = Delivery\Services\Manager::getById($arResult["ORDER"]["DELIVERY_ID"]);
}

$payment = CSalePaySystem::GetByID($arResult["ORDER"]["PAY_SYSTEM_ID"], $arResult["ORDER"]["PERSON_TYPE_ID"]);

$order = Sale\Order::load($arResult["ORDER_ID"]);

// Получение свойств заказа
$propertyCollection = $order->getPropertyCollection();
$tmp = $propertyCollection->getArray();
$props = array();
foreach ($tmp["properties"] as $key => $arProp) {
	$props[$arProp["ID"]] = $arProp["VALUE"][0];
}

// print_r($props);

?>
<? if ($paySystem["BUFFERED_OUTPUT"] && $payment["ID"] == 1){
	$GLOBALS['APPLICATION']->RestartBuffer();
?>
<div style="display: none;">
<?
	$_SESSION['SALE_ORDER_ID'] = array($_REQUEST["ORDER_ID"]);
	echo $paySystem["BUFFERED_OUTPUT"];
?>
</div>
<script>
	document.getElementById("pay").submit();
</script>
<?	die();
} ?>

<?
if (!empty($arResult["ORDER"])){
	?>
	<div class="b-block clearfix">
		<?

		$arr = explode(".", $arResult["ORDER"]["DATE_INSERT"]);
		$arr[1] = getRusMonth($arr[1]);
		$arr = explode(":", implode(" ", $arr));
		array_pop($arr);
		$arResult["ORDER"]["DATE_INSERT"] = implode(":", $arr);
		
	// 	$arResult["ORDER"]["ID"]; //Номер заказа
	// ?	$arResult["ORDER"]["PAY_SYSTEM_ID"]; //Способ обработки заказа
	// 	$arResult["ORDER"]["DATE_INSERT"] //Дата заказа
	// ?	$arResult["ORDER"]["DELIVERY_DOC_DATE"] //Дата доставки
	// 	$arUser['NAME'] // Имя
	// 	$arUser['LAST_NAME'] // Фамилия
	// 	$arUser['EMAIL'] // 
	// 	$arUser["PERSONAL_PHONE"] //
	// 	//Адрес доставки
	// 	//Метро
	// 	//Наименование товара
	// 	//Количество
	// 	//Цена
	// 	//Наличие
	// 	//Сумма
	// 	//Страна
	// 	//Сумма без скидки
	// 	//Скидка
	// 	//Сумма скидки:
	// 	$delivery //Способ доставки:
	// 	$arResult["ORDER"]["PRICE_DELIVERY"]//Стоимость доставки
	// 	$arResult["ORDER"]["PRICE"] //Итого
		 
		//Доп. информация о заказе
		//Комментарий к адресу
		//Комментарий к заказу
		//Ссылка на заказ в админке

		?>
		<div class="b-order-left">
			<div class="b-order-box"></div>
		</div>
		<div class="b-order-right">
			<div class="b-text">
				<h2>Ваш заказ №<?=$arResult["ORDER"]["ACCOUNT_NUMBER"]?> успешно создан!</h2>
				<? if( $props[6] == "Y" ): ?>
					<p>Наш менеджер свяжется с Вами в ближайшее время по телефону, который Вы указали<br>при оформлении заказа, для уточнения деталей.</p>
				<? endif; ?>
				<ul class="b-order-items">
					<li><b>Способ доставки: </b><span class="delivery-method"><?=$delivery["NAME"]?></span></li>
					<!-- <li><b>Способ оплаты: </b><span class="payment-method"><?=$payment["NAME"]?></span></li> -->
					<li><b>Сумма к оплате: </b><span class="payment-sum icon-ruble-regular"><?=number_format( intval($arResult["ORDER"]["PRICE"]), 0, '.', ' ' )?> руб.</span></li>
				</ul>
			</div>

			<? if ($paySystem["BUFFERED_OUTPUT"] && $payment["ID"] == 1):
				$_SESSION['SALE_ORDER_ID'] = array($_REQUEST["ORDER_ID"]);
				?>
				<div style="display: none;">
					<?=$paySystem["BUFFERED_OUTPUT"]?>
				</div>
				<a href="#" class="b-btn b-btn-buy icon-card b-btn-pay">
					<span>Оплатить заказ</span>
				</a>
			<?else: ?>
				<a href="/" class="b-btn b-btn-more icon-arrow-right-bold">
					<span>На главную</span>
				</a>
			<?endif; ?>
		</div>
		<script>
		function myReady() {
			setTimeout(function(){
				if( typeof yaCounter47641909 != "undefined" ){
					yaCounter47641909.reachGoal("BUY");
				}else{
					myReady();
				}
			}, 1000);
		}

		document.addEventListener("DOMContentLoaded", myReady);
		</script>
	</div>
<?
}
else
{
	if ($arParams["SET_TITLE"] == "Y")
		$APPLICATION->SetTitle("Заказ не найден");
	?>
	<div class="b-block clearfix">
		<div class="b-text">
			<h3>Ошибка заказа</h3>

			<table class="sale_order_full_table">
				<tr>
					<td>
						<?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST", Array("#ORDER_ID#" => $arResult["ACCOUNT_NUMBER"]))?>
						<?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST1")?>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<?
}
?>
