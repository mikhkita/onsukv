<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Пожелания по ассортименту");?>

<div class="b-detail clearfix">
	<div class="b-detail-left">
		<img src="<?=SITE_TEMPLATE_PATH?>/i/review-menu-2.jpg">
		<div class="b-stars-detail">
			<div class="b-reviews-count">
				<?
				$reviews_count = 0;
			    $element = GetIBlockElementList(3, 1835);
			    while($arelement = $element->GetNext()) { $reviews_count++;   }
				?>
				<p><?=$reviews_count?> <?=plural_form($reviews_count, array("отзыв", "отзыва", "отзывов"))?></p>
			</div>
			<div class="b-add-review-btn">
				<a href="#b-review-form" class="b-btn b-brown-btn fancy"><span>Оставить отзыв</span></a>
			</div>
		</div>
	</div>
	<div class="b-detail-right">
		<div class="b-text">
			<div class="b-detail-text limit">
				<div class="b-detail-text-wrap">
					<div class="b-subtitle">Поделитесь впечатлениями о работе магазина:</div>
					<ul>
						<li>Общение с операторами</li>
						<li>Быстрота приема заказа</li>
						<li>Упаковка продукции</li>
						<li>Своевременность доставки</li>
						<li>Вежливы ли наши курьеры</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"reviews",
	Array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "Y",
		"AJAX_OPTION_JUMP" => "Y",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array("NAME","PREVIEW_TEXT","DATE_CREATE",""),
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "3",
		"IBLOCK_TYPE" => "content",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "10",
		"PAGER_BASE_LINK" => "",
		"PAGER_BASE_LINK_ENABLE" => "Y",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_PARAMS_NAME" => "arrPager",
		"PAGER_SHOW_ALL" => "Y",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "main",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "1835",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array("PRODUCT_ID", "USER_ID"),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "ACTIVE_FROM",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "DESC"
	)
);?> 

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>