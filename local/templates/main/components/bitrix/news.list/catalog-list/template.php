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

$arFilters = Array(
    array("name" => "watermark", "position" => "center", "size"=>"resize", "coefficient" => 0.9, "alpha_level" => 29, "file" => $_SERVER['DOCUMENT_ROOT']."/upload/wat.png"),
);
$month = " ";
?>

<? if(count($arResult["ITEMS"])): ?>
	<div class="b-catalog-list clearfix <?=$arParams["CLASS"]?>">
		<?foreach($arResult["ITEMS"] as $arItem):?>
			<? if ($month !== FormatDate('f', MakeTimeStamp($arItem["CREATED_DATE"],"YYYY.MM.DD"))):
				$month = FormatDate('f', MakeTimeStamp($arItem["CREATED_DATE"],"YYYY.MM.DD")); ?>
			<h4><?=$month?></h4>
			<?endif;?>
			<div class="b-catalog-item-top">
				<h6><a href="<?=detailPageUrl($arItem["DETAIL_PAGE_URL"])?>"><?=$arItem["NAME"]?></a></h6>
			</div>
		<?endforeach;?>
	</div>
<? else: ?>
	<div class="b-not-result b-text">
		<br>
		<p>По Вашему запросу товаров не найдено.</p>
	</div>
<? endif; ?>