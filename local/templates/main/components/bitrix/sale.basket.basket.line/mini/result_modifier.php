<?

foreach ($arResult["CATEGORIES"]["READY"] as $key => $arItem){
	$price = CCatalogProduct::GetOptimalPrice($arItem["PRODUCT_ID"]);
	$arResult["CATEGORIES"]["READY"][$key]["DISCOUNT_PRICE"] = $price["DISCOUNT_PRICE"];
}

?>