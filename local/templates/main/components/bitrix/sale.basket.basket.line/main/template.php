<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$GLOBALS["totalPrice"] = preg_replace("/[^0-9]/", '', $arResult['TOTAL_PRICE']);

?>