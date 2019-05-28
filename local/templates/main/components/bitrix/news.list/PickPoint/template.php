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
    <span id="total_sum_pickpoint" data-levels="<?=count($arResult["ITEMS"])?>" 
    	<? foreach ($arResult["ITEMS"] as $i => $arItem): ?>
			data-<?echo $i+1?>-match="<?=$arItem['PREVIEW_TEXT']?>" 
            data-<?echo $i+1?>-price="<?=$arItem['NAME']?>" 
    	<? endforeach; ?>
    ></span>
<? endif; ?>