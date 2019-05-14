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
	<ul>
		<?foreach($arResult["SECTIONS"] as $arItem):?>
			<li><a href="<?=$arItem["SECTION_PAGE_URL"]?>" <? if( $GLOBALS["subpage"] == $arItem["CODE"] ): ?>class="active"<? endif; ?>><?=$arItem["NAME"]?></a></li>
		<?endforeach;?>
	</ul>
<? endif; ?>