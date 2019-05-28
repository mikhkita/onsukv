<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

foreach ($arResult["ITEMS"] as $i => $arItem){
	$arr = explode(".", array_shift(explode(" ", $arItem["ACTIVE_FROM"])) );
	$arResult["ITEMS"][$i]["ACTIVE_FROM"] = $arr[0]." ".getRusMonth(intval($arr[1]))." ".$arr[2];
}

?>