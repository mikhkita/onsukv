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
<? $i = 0; ?>
	<ul>
		<?foreach($arResult["SECTIONS"] as $arItem):?>
			<? if( $arItem["PICTURE"] && $i == 0): ?>
				<li class="b-with-image">
					<a href="<?=detailPageUrl($arItem["SECTION_PAGE_URL"])?>" class="clearfix <? if( $GLOBALS["SECTION_ID"] == $arItem["ID"] ): ?>active icon-tick<? endif; ?><?=(($arItem["UF_HIGHLIGHT"])?" highlight":"")?>">
						<img src="<?=$arItem["PICTURE"]["SRC"]?>" alt="">
						<span><?=$arItem["NAME"]?></span>
					</a>
				</li>
				<?$i++;?>
			<? endif; ?>
		<?endforeach;?>
	</ul>
<? endif; ?>