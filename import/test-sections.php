<?
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

include 'items.php';

$result = array();

foreach ($values as $value) {
	$result[ $value[0] ] = array_combine($keys, $value);
}

foreach ($result as $key => $item) {
	if( $item["LINKED_CATEGORY"] != 0 && $item["LINKED_CATEGORY"] != -1 ){
		// echo $item["LINKED_CATEGORY"]." ".$item["CATALOGUE_ID"]."<br>";
		$ID = $item["ITEM_ID"];  // код элемента
		$arSects = array($item["LINKED_CATEGORY"], $item["CATALOGUE_ID"]); // массив кодов групп
		CIBlockElement::SetElementSection($ID, $arSects);
	}
}


?>