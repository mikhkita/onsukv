<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

<? if(count($arResult["ITEMS"])): ?>
	<div class="b-addresss-list">
		<div class="b-addresss-item-container">
	        <div class="b-addresss-item">
				<div class="b-addresss-item__address"><b>Город, улица, дом</b></div>
				<div class="b-addresss-item__room"><b>Квартира/офис</b></div>
				<div class="b-addresss-item__index"><b>Индекс</b></div>
	        </div>
	    </div>
		<?foreach($arResult["ITEMS"] as $arItem):?>
		<div class="b-addresss-item-container">
	        <div class="b-addresss-item">
				<div class="b-addresss-item__address"><?=$arItem['NAME']?></div>
				<div class="b-addresss-item__room"><?=$arItem['PROPERTIES']['ROOM']['VALUE']?></div>
				<div class="b-addresss-item__index"><?=$arItem['PROPERTIES']['INDEX']['VALUE']?></div>
	        </div>
	        <div class="b-addresss-btn-container">
		        <a href="<?=detailPageUrl($arItem["DETAIL_PAGE_URL"])?>">Изменить</a>
		        <a href="<?=detailPageUrl($arItem["DETAIL_PAGE_URL"])?>?delete=Y">Удалить</a>
		    </div>
	    </div>
		<?endforeach;?>
		<div class="b-addresss-item-container">
	        <div class="b-addresss-item">
				<a href="create/">Добавить</a>
	        </div>
	    </div>
	</div>
<? endif; ?>