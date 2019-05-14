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
<?if( count($arResult["SECTIONS"]) ): ?>
	<div class="b-category-tiles">
		<?foreach($arResult["SECTIONS"] as $key => $arItem):?>
			<? $isSectionActive = isSectionActive($arItem["ID"]); ?>
			<a href="<?=detailPageUrl($arItem["SECTION_PAGE_URL"])?>" class="<? if( $isSectionActive ): ?>active <? endif; ?>b-tile-item">
				<p><?=$arItem["NAME"]?></p>
			</a>
		<?endforeach;?>
	</div>
<? endif; ?>