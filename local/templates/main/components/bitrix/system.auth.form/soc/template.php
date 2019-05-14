<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

CJSCore::Init();

$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "auth", 
	array(
		"AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
		"SUFFIX" => "form",
	), 
	$component, 
	array("HIDE_ICONS"=>"Y")
);

?>