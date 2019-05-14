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
	<ul class="b-header-categories">
		<?foreach($arResult["SECTIONS"] as $key => $arItem):?>
			<? 
				$isSectionActive = ( $GLOBALS["isWholesale"] )?( $arItem["CODE"] == "wholesale" ):(isSectionActive($arItem["ID"]));
				if( $GLOBALS["isSale"] ){
					$isSectionActive = false;
				}
			?>
			<li><a href="<?=$arItem["SECTION_PAGE_URL"]?>" class="<? if( $isSectionActive ): ?>active <? endif; ?>category-icon-<?=$arItem["ID"]?>"><?=$arItem["NAME"]?></a></li>
			<? if( $key < count($arResult["SECTIONS"]) - 1 ): ?>
				<li class="list-dot"></li>
			<? endif; ?>
		<?endforeach;?>
	</ul>
<? endif; ?>