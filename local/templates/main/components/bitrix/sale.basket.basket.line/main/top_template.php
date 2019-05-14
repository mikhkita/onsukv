<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$compositeStub = (isset($arResult['COMPOSITE_STUB']) && $arResult['COMPOSITE_STUB'] == 'Y');

print_r($arResult);
?>
<?= str_replace(" руб.", "", $arResult['TOTAL_PRICE']) ?>