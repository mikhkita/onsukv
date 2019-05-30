<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

	CModule::IncludeModule("iblock");
	$el = new CIBlockElement;

	$PROP = array();
	$userID = $USER->GetID()?$USER->GetID():"";

	$PROP["STORE_QUALITY"]['VALUE'] = $_POST["store-quality"];
	$PROP["GOODS_QUALITY"]['VALUE'] = $_POST["goods-quality"];
	$PROP["MANAGER_QUALITY"]['VALUE'] = $_POST["manager-quality"];
	$PROP["PACK_QUALITY"]['VALUE'] = $_POST["pack-quality"];
	$PROP["COURIER_QUALITY"]['VALUE'] = $_POST["courier-quality"];
	$PROP["EMAIL"]['VALUE'] = $_POST["email"];
	$PROP["PHONE"]['VALUE'] = $_POST["phone"];

	$arLoadProductArray = Array(
	  "IBLOCK_SECTION_ID" => 1834,
	  "IBLOCK_ID"      => 3,
	  "PROPERTY_VALUES"=> $PROP,
	  "NAME"           => $_POST["name"],
	  "CODE"		   => $userID,
	  "ACTIVE"         => "Y",
	  "PREVIEW_TEXT"   => $_POST['comment'],
	  "DATE_ACTIVE_FROM" => ConvertTimeStamp(time(), "FULL")
	);
	
	if($el->Add($arLoadProductArray)){
		echo "1";
	}
	else{
		echo "0";
	}

?>