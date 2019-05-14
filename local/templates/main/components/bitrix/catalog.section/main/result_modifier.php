<?

$units = array(
	2 => "за 1 литр",
	3 => "за 1 грамм",
	4 => "за 1 килограмм",
	5 => "за штуку",
	6 => "за упаковку",
);

foreach($arResult["ITEMS"] as $key => $arItem){
	if( isset($GLOBALS["BASKET_ITEMS"][ $arItem["ID"] ]) ){
		$arResult["ITEMS"][$key]["BASKET"] = $GLOBALS["BASKET_ITEMS"][ $arItem["ID"] ];
	}
}

if( isset($arParams["CUSTOM_ORDER"]) ){
	$items = array();
	$order = ($arParams["CUSTOM_ORDER"])?$arParams["CUSTOM_ORDER"]:array();

	foreach($arResult["ITEMS"] as $key => $arItem){
		if( ($index = array_search($arItem["ID"], $order)) !== false ){
			$items[ $index ] = $arItem;
		}else{
			$items[ intval($key) + 10000 ] = $arItem;
		}
	}

	ksort($items);
	$arResult["ITEMS"] = array_values($items);
}

foreach ($arResult["ITEMS"] as $key => $arItem) {
	if( $GLOBALS["isWholesale"] && isset($arItem["ITEM_PRICES"][1]) ){
		$arResult["ITEMS"][$key]["PRICES"]["PRICE"]["DISCOUNT_VALUE"] = $arItem["ITEM_PRICES"][1]["PRICE"];

		$arResult["ITEMS"][$key]["MEASURE"] = "от ".$arItem["ITEM_PRICES"][1]["QUANTITY_FROM"]." шт.";
	}
}


?>
