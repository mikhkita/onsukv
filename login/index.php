<?
define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");

$userName = CUser::GetFullName();
if (!$userName)
	$userName = CUser::GetLogin();
?><?$APPLICATION->IncludeComponent(
	"bitrix:system.auth.form",
	"main",
Array()
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>