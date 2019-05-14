<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

foreach ($arResult["ITEMS"] as $i => $arItem){
	$arr = explode(".", array_shift(explode(" ", $arItem["DATE_CREATE"])) );
	$arResult["ITEMS"][$i]["DATE_CREATE"] = $arr[0]." ".getRusMonth(intval($arr[1]))." ".$arr[2];

}

?>