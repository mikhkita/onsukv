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
<? if(!$_GET["partial"]): ?>
<a href="/cart/" class="b-basket-btn">
	<div class="icon-basket"></div>
	<div class="b-basket-btn-total icon-ruble"><?=number_format( $arResult["allSum"], 0, ',', ' ' )?></div>
</a>
<? else: ?>
<div>
<div class="b-basket-desktop">
<? endif; ?>
	<div class="b-basket">
		<? include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items.php"); ?>
		<div class="b-basket-down slideout-menu-padding">
			<div class="b-basket-sum-cont">
				<span class="b-basket-sum-text">Сумма заказа:</span>
				<h3 class="b-basket-total icon-ruble"><?=number_format( $arResult["allSum"], 0, ',', ' ' )?></h3>
			</div>
			<a href="/cart/" class="b-btn b-btn-buy">
				<span class="b-basket-btn-mobile">Оформить заказ</span>
				<span class="b-basket-btn-desktop">Оформить</span>
			</a>
		</div>
	</div>
<? if($_GET["partial"]): ?>
	</div>
</div>
<? endif; ?>