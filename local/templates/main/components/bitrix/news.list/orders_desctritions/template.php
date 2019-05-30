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
    	<? $arDate = $arItem['PROPERTIES']['ORDER_DATE']['VALUE']; ?>
    	<? $date = date("d", strtotime($arDate))." ".getRusMonth(date("m", strtotime($arDate))).", ".getRusDayOfWeek(date("w", strtotime($arDate))); ?>
    	<? $isSunday = ( date("w", strtotime($arDate)) == 0 )?'data-isSunday="Y" disabled':""; ?>
        <option value="<?=$arDate?>" <?=$isSunday?>> <?=$date?></option>
    <? endforeach; ?>
<? endif; ?>