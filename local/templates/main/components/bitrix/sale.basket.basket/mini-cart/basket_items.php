<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Sale\DiscountCouponsManager;

// if (!empty($arResult["ERROR_MESSAGE"]))
	// ShowError($arResult["ERROR_MESSAGE"]);

$bDelayColumn  = false;
$bDeleteColumn = false;
$bWeightColumn = false;
$bPropsColumn  = false;
$bPriceType    = false;

$count = 0;
foreach ($arResult["ITEMS"]["AnDelCanBuy"] as $arItem){
	$count += intval($arItem["QUANTITY"]);
}

if (count($arResult["ITEMS"]["AnDelCanBuy"])):
// print_r($arResult["ITEMS"]["AnDelCanBuy"]);
// die();
?>
<ul>
<? foreach ($arResult["ITEMS"]["AnDelCanBuy"] as $arItem): ?>
	<?
	$renderImage = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], Array("width" => 64*2, "height" => 64*2), ($arItem["NOT_EXACT"] == "Да")?BX_RESIZE_IMAGE_PROPORTIONAL:BX_RESIZE_IMAGE_EXACT );

	?>
	<li class="b-cart-item" data-id="<?=$arItem["ID"]?>">
		<div>
			<a href="/ajax/?partial=1&ELEMENT_ID=<?=$arItem["ID"]?>&action=REMOVE" class="icon-close b-btn-remove-from-cart"></a>
			<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
				<div class="b-basket-item-img" style="background-image: url('<?=$renderImage["src"]?>');"></div>
			</a>
			<div class="b-basket-item-text">
				<a class="b-basket-item-name" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><h4><?=$arItem["NAME"]?></h4></a>
				<p class="b-basket-item-price icon-ruble"><?=number_format( $arItem["PRICE"], 0, ',', ' ' )?></p>
				<p class="b-basket-item-count"><?=$arItem["QUANTITY"]?> шт.</p>
			</div>
		</div>
	</li>
<? endforeach; ?>
</ul>
<?
else:
?>
<ul>
	<li class="b-preload-cart">
		Ваша корзина пуста.
	</li>
</ul>
<?
endif;
?>