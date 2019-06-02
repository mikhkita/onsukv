<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("test");

// CCatalogDiscountCoupon::SetCoupon("AJSD123uyiashjdk8932ioda");

print_r(getReviewCount());

?><?$APPLICATION->IncludeComponent("ipol:ipol.sdekPickup", "cdek", Array(
	"CITIES" => "",	// Подключаемые города (если не выбрано ни одного - подключаются все)
		"CNT_BASKET" => "N",	// Расчитывать доставку для корзины
		"CNT_DELIV" => "N",	// Расчитывать доставку при подключении
		"COUNTRIES" => array(	// Подключенные страны
			0 => "rus",
		),
		"FORBIDDEN" => array(	// Отключить расчет для профилей
			0 => "inpost",
		),
		"NOMAPS" => "N",	// Не подключать Яндекс-карты (если их подключает что-то еще на странице)
		"PAYER" => "1",	// Тип плательщика, от лица которого считать доставку
		"PAYSYSTEM" => "2",	// Тип платежной системы, с которой будет считатся доставка
	),
	false
);?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>