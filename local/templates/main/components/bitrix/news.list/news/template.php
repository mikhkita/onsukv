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
$this->setFrameMode(true);

?>

<? $curPage = $APPLICATION->GetCurPage(); ?>
<? $isMain = ( $curPage == "/" )?true:false; ?>

<? if(count($arResult["ITEMS"])): ?>
	<? if($isMain): ?>
		<div class="b-news-preview">
			<?foreach($arResult["ITEMS"] as $arItem):?>
			<h3>Новости магазина</h3>
			<p class="date"><?=$arItem["ACTIVE_FROM"]?></p>
			<p><?=$arItem['NAME']?></p>
			<a href="/news/" class="more">Читать все новости</a>
			<?endforeach;?>
		</div>
	<? else: ?>
		<div class="b-news-list">
			<?foreach($arResult["ITEMS"] as $arItem):?>
			<div class="b-news-item">
				<div class="b-news-header"><?=$arItem['NAME']?></div>
				<div class="b-news-date"><?=$arItem["ACTIVE_FROM"]?></div>
				<div class="b-news-text"><?=$arItem["PREVIEW_TEXT"]?></div>
			</div>
			<?endforeach;?>
		</div>
	<? endif; ?>
<? endif; ?>