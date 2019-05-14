<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Sale\DiscountCouponsManager;

if (!empty($arResult["ERROR_MESSAGE"]))
	ShowError($arResult["ERROR_MESSAGE"]);

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

?>
<? foreach ($arResult["ITEMS"]["AnDelCanBuy"] as $arItem): ?>
	<tr class="b-cart-item" data-id="<?=$arItem["ID"]?>">
		<?
		$renderImage = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], Array("width" => 98*2, "height" => 98*2), ($arItem["NOT_EXACT"] == "Да")?BX_RESIZE_IMAGE_PROPORTIONAL:BX_RESIZE_IMAGE_EXACT );

		?>
		<td class="b-basket-name">
			<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
				<div class="b-basket-name-img" style="background-image: url('<?=$renderImage["src"]?>');"></div>
			</a>	
			<div class="b-name">
				<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><h4><?=$arItem["NAME"]?></h4></a>
				<div class="b-selects icon-arrow-down">
					<select name="basket-count" class="b-basket-item-count">
						<? for( $i = 1; $i <= 20; $i++ ): ?>
							<option value="<?=$i?>" <? if($arItem["QUANTITY"] == $i): ?>selected<? endif; ?>><?=$i?> шт.</option>
						<? endfor; ?>
					</select>
				</div>
			</div>
		</td>
		<td class="b-basket-price">
			<h4 class="icon-ruble-medium"><?=number_format( $arItem["PRICE"], 0, ',', ' ' )?></h4>
		</td>
		<td class="b-basket-count">
			<div class="b input-cont">
				<a href="/ajax/?partial=1&ELEMENT_ID=<?=$arItem["ID"]?>&action=QUANTITY" class="icon-minus b-change-quantity" data-side="-"></a>
				<a href="/ajax/?partial=1&ELEMENT_ID=<?=$arItem["ID"]?>&action=QUANTITY" class="icon-plus b-change-quantity" data-side="+"></a>
				<input type="text" name="count" class="b-quantity-input" maxlength="3" oninput="this.value = this.value.replace(/\D/g, '')" value="<?=$arItem["QUANTITY"]?>">
			</div>
		</td>
		<td class="b-basket-sum">
			<h4 class="icon-ruble"><?$ar = explode(" руб", $arItem["SUM"]); echo $ar[0];?></h4>
		</td>
		<td class="b-basket-delete">
			<div class="b-tip-cont">
				<a href="/ajax/?partial=1&ELEMENT_ID=<?=$arItem["ID"]?>&action=REMOVE" class="icon-close b-tip-ref b-btn-remove-from-cart"></a>
				<div class="b-tip">Удалить</div>
			</div>
		</td>
	</tr>
<? endforeach; ?>
<?
else:
?>
<?
endif;
?>