<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

	CModule::IncludeModule("iblock");
	$el = new CIBlockElement;

	$PROP = array();

	$PROP["STORE_QUALITY"]['VALUE'] = $_POST["store-quality"];
	$PROP["GOODS_QUALITY"]['VALUE'] = $_POST["goods-quality"];
	$PROP["MANAGER_QUALITY"]['VALUE'] = $_POST["manager-quality"];
	$PROP["PACK_QUALITY"]['VALUE'] = $_POST["pack-quality"];
	$PROP["COURIER_QUALITY"]['VALUE'] = $_POST["courier-quality"];
	$PROP["EMAIL"]['VALUE'] = $_POST["email"];
	$PROP["PHONE"]['VALUE'] = $_POST["phone"];
	
	$round = round(($_POST["store-quality"] + $_POST["goods-quality"] + $_POST["manager-quality"] + $_POST["pack-quality"] + $_POST["courier-quality"])/5);

	$arLoadProductArray = Array(
	  "IBLOCK_SECTION_ID" => 1834,
	  "IBLOCK_ID"      => 3,
	  "PROPERTY_VALUES"=> $PROP,
	  "NAME"           => $_POST["name"],
	  "CODE"		   => $round,
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