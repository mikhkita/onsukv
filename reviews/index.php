<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Отзывы и пожелания");?>

<div class="b-reviews-menu">
	<a href="quality" class="b-review-menu-item">
		<img src="<?=SITE_TEMPLATE_PATH?>/i/review-menu-1.jpg">Качество работы магазина</a>
	<a href="assortment" class="b-review-menu-item">
		<img src="<?=SITE_TEMPLATE_PATH?>/i/review-menu-2.jpg">Пожелания по ассортименту</a>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>