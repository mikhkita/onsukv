<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$res = CIBlockElement::GetList (array(), array("IBLOCK_ID" => 9), array('IBLOCK_ID', 'ID', 'NAME', 'CODE', 'PROPERTY_USER'));
while($ob = $res->GetNextElement()){ 
	$arFields[] = $ob->GetFields();
}

$arUsers = array();

foreach ($arFields as $arItem) {
	$arUsers[$arItem["PROPERTY_USER_VALUE"]][] = array(
		"NAME" => $arItem["NAME"],
		"CODE" => $arItem["CODE"],
	);
}

vardump($arUsers);

?>