<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

$id = $_GET['ID'];
$db_res = CIBlockElement::GetByID($id);
if ($ar_res = $db_res->GetNext()) {
	LocalRedirect($ar_res['DETAIL_PAGE_URL']);
}

?>