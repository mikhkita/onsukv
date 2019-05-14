<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

foreach ($arResult["SECTIONS"] as $i => $arSection) {
	if( $arSection["CODE"] == "wholesale" ){
		$arResult["SECTIONS"][$i]["SECTION_PAGE_URL"] = "/wholesale/";
	}else{
		array_push($GLOBALS["HEADER_CATEGORIES"], $arSection["ID"]);
	}
}

?>