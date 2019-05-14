<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

$units = array(
	2 => "за 1 литр",
	3 => "за 1 грамм",
	4 => "за 1 килограмм",
	5 => "за штуку",
	6 => "за упаковку",
);

$arResult["MEASURE"] = $units[ $arResult["PRODUCT"]["MEASURE"] ];

if( isset($GLOBALS["BASKET_ITEMS"][ $arResult["ID"] ]) ){
	$arResult["BASKET"] = $GLOBALS["BASKET_ITEMS"][ $arResult["ID"] ];
}

$arResult = $arResult + getRating($arResult["ID"]);

$rsStore = CCatalogStoreProduct::GetList(array(), array('PRODUCT_ID' =>$arResult["ID"], 'STORE_ID' => 1), false, false); 
$arResult["AMOUNT"] = array();
if ($arStore = $rsStore->Fetch()){
	array_push($arResult["AMOUNT"], $arStore);
}