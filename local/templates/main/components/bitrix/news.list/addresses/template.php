<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

<? if(count($arResult["ITEMS"])): ?>
	<div class="b-addresss-list">
		<?foreach($arResult["ITEMS"] as $arItem):?>
		<div class="b-addresss-item-container">
	        <div class="b-addresss-item-text">
				<?=$arItem['PROPERTIES']['INDEX']['VALUE']?>, <?=$arItem['NAME']?>, кв/оф. <?=$arItem['PROPERTIES']['ROOM']['VALUE']?><? if( $arItem['PROPERTIES']['METRO']['VALUE'] ): ?>, м. <?=$arItem['PROPERTIES']['METRO']['VALUE']?><? endif; ?>
	        </div>
	        <div>
		        <a href="<?=detailPageUrl($arItem["DETAIL_PAGE_URL"])?>">Изменить</a>&nbsp;&nbsp;&nbsp;
		        <a href="<?=detailPageUrl($arItem["DETAIL_PAGE_URL"])?>?delete=Y">Удалить</a>
		    </div>
	    </div>
		<?endforeach;?>
	</div>
<? endif; ?>
<div>
    <div class="b-addresss-item b-btn-container">
		<a href="create/" class="b-btn b-orange-btn">Добавить</a>
    </div>
</div>