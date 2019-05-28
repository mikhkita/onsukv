<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 * @var $APPLICATION CMain
 */

$dels = array();
$db_dtype = CSaleDelivery::GetList(
    array(
            "SORT" => "ASC",
            "NAME" => "ASC"
        ),
    array(
            "LID" => SITE_ID,
            // "+<=WEIGHT_FROM" => $ORDER_WEIGHT,
            // "+>=WEIGHT_TO" => $ORDER_WEIGHT,
            // "+<=ORDER_PRICE_FROM" => $ORDER_PRICE,
            // "+>=ORDER_PRICE_TO" => $ORDER_PRICE,
            "ACTIVE" => "Y",
            // "LOCATION" => $DELIVERY_LOCATION
        ),
    false,
    false,
    array()
);
if ($ar_dtype = $db_dtype->Fetch())
{
   do
   {
      $dels[ $ar_dtype["ID"] ] = $ar_dtype["NAME"];
   }
   while ($ar_dtype = $db_dtype->Fetch());
}


// $dels = array(
// 	2 => "Доставка курьером",
// 	3 => "Самовывоз"
// );

if ($arParams["SET_TITLE"] == "Y")
	$APPLICATION->SetTitle("Заказ оформлен");


$paySystem = array_pop($arResult["PAY_SYSTEM_LIST"]);

$delivery = $dels[$arResult["ORDER"]["DELIVERY_ID"]];

$payment = CSalePaySystem::GetByID($arResult["ORDER"]["PAY_SYSTEM_ID"], $arResult["ORDER"]["PERSON_TYPE_ID"]);

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
				<? if( $payment["ID"] == 1 && 0 ): ?>
					<p>
						Оплата картой на сайте <b>находится в разработке.</b> Приносим свои извинения.<br>
						<br>
						Предлагаем Вам оплатить заказ с помощью перевода на <b>карту Сбербанка</b> по реквизитам:<br>
						<b>Номер карты:</b> <span>4276</span><span>6406</span><span>2638</span><span>9862</span><br>
						<b>Получатель:</b> Артем Сергеевич М.<br><br>
						<? /* ?><b>Номер карты:</b> <span>4276</span><span>6401</span><span>6982</span><span>0992</span><br>
						<b>Получатель:</b> Татьяна Александровна П.<br><br><? */ ?>
						<? /* ?><b>Номер карты:</b> <span>5469</span><span>6400</span><span>1222</span><span>2432</span><br>
						<b>Получатель:</b> Анна Николаевна З.<br><br><? */ ?>
						Наш менеджер свяжется с Вами в ближайшее время для уточнения деталей.<br>
						Спасибо за понимание!
					</p>
				<? else: ?>
					<p>Наш менеджер свяжется с Вами в ближайшее время по телефону, который Вы указали<br>при оформлении заказа, для уточнения деталей.</p>
				<? endif; ?>
				<ul class="b-order-items">
					<li><b>Способ доставки: </b><span class="delivery-method"><?=$delivery?></span></li>
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
