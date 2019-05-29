<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
/** @var CBitrixComponent $component */
$this->setFrameMode(true);?>

<? if(count($arResult["ITEMS"])): ?> 
    <? foreach ($arResult["ITEMS"] as $arItem): ?>
        <option value="<?=$arItem["NAME"]?>"><?=$arItem['PROPERTIES']['ORDER_DATE']['VALUE']?></option>
    <? endforeach; ?>
<? endif; ?>