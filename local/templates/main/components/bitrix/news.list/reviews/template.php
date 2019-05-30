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
<? if(count($arResult["ITEMS"])): ?>
	<div class="b-detail-reviews">
		<h3>Отзывы покупателей</h3>
		<div class="b-reviews">
			<?foreach($arResult["ITEMS"] as $arItem):?>
				<?
				$renderImage = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], Array("width" => 150, "height" => 150), BX_RESIZE_IMAGE_EXACT, false, $arFilters );
				$renderBigImage = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], Array("width" => 1920, "height" => 1400), BX_RESIZE_IMAGE_PROPORTIONAL, false, $arFilters );
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				?>
				<div class="b-review" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
					<div class="b-review-info">
						<? if (isset($arItem['PROPERTIES']["STORE_QUALITY"])){
							$stars = ($arItem['PROPERTIES']["STORE_QUALITY"]["VALUE"] + $arItem['PROPERTIES']["GOODS_QUALITY"]["VALUE"] + $arItem['PROPERTIES']["MANAGER_QUALITY"]["VALUE"] + $arItem['PROPERTIES']["PACK_QUALITY"]["VALUE"] + $arItem['PROPERTIES']["COURIER_QUALITY"]["VALUE"])/5;
						} else {
							$stars = $arItem["PROPERTIES"]["RATING"]["VALUE"];
						} ?>
						<div class="b-stars b-stars-<?=$stars?>">
							<div class="b-star"></div>
							<div class="b-star"></div>
							<div class="b-star"></div>
							<div class="b-star"></div>
							<div class="b-star"></div>
						</div>
						<div class="b-review-name"><?=$arItem["NAME"]?></div>
						<div class="b-review-date"><?=$arItem["DATE_CREATE"]?></div>
					</div>
					<div class="b-review-text">
						<div class="b-review-text-wrap<? if( !$arItem["PREVIEW_PICTURE"] ): ?> b-review-text-without-image<? endif; ?>">
							<p><?=$arItem["PREVIEW_TEXT"]?></p>
						</div>
						<div class="b-review-image">
							<? if( $arItem["PREVIEW_PICTURE"] ): ?>
								<a href="<?=$renderBigImage["src"]?>" class="fancy-img"><img src="<?=$renderImage["src"]?>" alt=""></a>
							<? endif; ?>
						</div>
					</div>
				</div>
			<?endforeach;?>
		</div>
		<? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
			<?=$arResult["NAV_STRING"];?>
		<?endif;?>
	</div>
<? endif; ?>