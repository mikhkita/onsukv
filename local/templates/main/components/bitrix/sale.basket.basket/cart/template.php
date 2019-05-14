<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixBasketComponent $component */

// print_r($arResult);

$GLOBALS["isEmpty"] = true;

if (count($arResult["ITEMS"]["AnDelCanBuy"])):

$GLOBALS["isEmpty"] = false;
$GLOBALS["totalSum"] = $arResult["allSum"];

$ids = array();
foreach ($arResult["ITEMS"]["AnDelCanBuy"] as $key => $arItem) {
	array_push($ids, $arItem["PRODUCT_ID"]);
}

$notExact = array();

$arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM","PROPERTY_*");
$arFilter = Array("IBLOCK_ID" => 1, "ACTIVE" => "Y", "ID" => $ids);
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
while($ob = $res->GetNextElement()){ 
	$arFields = $ob->GetFields();  
 	$arProps = $ob->GetProperties();
 	if( $arProps["NOT_EXACT"]["VALUE"] ){
 		$notExact[$arFields["ID"]] = true;
 	}
}

foreach ($arResult["ITEMS"]["AnDelCanBuy"] as $key => $arItem) {
	if( isset($notExact[$arItem["PRODUCT_ID"]]) ){
		$arResult["ITEMS"]["AnDelCanBuy"][$key]["NOT_EXACT"] = "Да";
	}
}

?>
<div class="b-block">
	<div class="b-basket-list">
		<h2 class="b-title">Корзина</h2>
		<div class="b-for-basket">
			<table class="b-basket-table">
				<tr class="table-header">
					<th class="header-name">Название</th>
					<th class="header-price">Цена</th>
					<th class="header-count">Количество</th>
					<th class="header-sum">Сумма</th>
					<th></th>
				</tr>
				<? include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items.php"); ?>
			</table>
		</div>
	</div>
</div>
<? endif; ?>

<div class="b-block b-cart-empty" <? if(count($arResult["ITEMS"]["AnDelCanBuy"])): ?>style="display: none;"<? endif; ?>>
	Ваша корзина пуста. <a href="/catalog/">Перейти в каталог</a>
</div>