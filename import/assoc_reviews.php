<?
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
include 'reviews.php';

$result = array();

foreach ($values as $value) {
	$result[] = array_combine($keys, $value);
}

include 'users.php';

$users = array();

foreach ($values as $value) {
	$users[ $value[0] ] = $value[1]." ".$value[2];
}

// print_r($users);

$params = array(
	"ITEM_REVIEW_ID" => array("NAME" => "ID", "TYPE" => "field"),
	"ITEM_ID" => array("NAME" => "PRODUCT_ID", "TYPE" => "prop"),
	"USER_ID" => array("NAME" => "USER_ID", "TYPE" => "prop"),
	"CMF_USER_ID" => "",
	"CREATE_DATE" => array("NAME" => "DATE_CREATE", "TYPE" => "field"),
	"REVIEW_TEXT" => array("NAME" => "PREVIEW_TEXT", "TYPE" => "field"),
	"USER_RATING" => array("NAME" => "CODE", "TYPE" => "field"),
	"STATUS" => array("NAME" => "ACTIVE", "TYPE" => "field"),
	"SMALL_IMAGE" => "",
	"BIG_IMAGE" => array("NAME" => "PREVIEW_PICTURE", "TYPE" => "field"),
);

$el = new CIBlockElement;
$replace_symbols = array('\\r\\n\\r\\n', '\\r\\n', '\"');

foreach ($result as $element) { //element - вся информация о элементе

	$PROP = array();
	$fields = array();

	$arLoadProductArray = Array(
	  "IBLOCK_ID"      		=> 2,
	  "PREVIEW_TEXT_TYPE" 	=> "text"
	);

	foreach ($params as $param => $param_bitrix) {
		if(!empty($param_bitrix)){
			if($param_bitrix["TYPE"] == "field"){
				if($param_bitrix["NAME"] == "PREVIEW_PICTURE"){
					$arLoadProductArray[$param_bitrix["NAME"]] = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"].$element[$param]);
					continue;
				}
				if($param_bitrix["NAME"] == "ACTIVE"){
					$arLoadProductArray[$param_bitrix["NAME"]] = $element[$param] == 0 ? "N" : "Y";
					continue;
				}
				if($param_bitrix["NAME"] == "DATE_CREATE"){
					if(!empty($element[$param])){
						$arLoadProductArray[$param_bitrix["NAME"]] = date("d.m.Y", strtotime($element[$param]));
					}else{
						$arLoadProductArray[$param_bitrix["NAME"]] = date("d.m.Y", strtotime($element["date"]));
					}
					// echo $arLoadProductArray[$param_bitrix["NAME"]];
					// echo "////";
					continue;
				}
				$arLoadProductArray[$param_bitrix["NAME"]] = str_replace($replace_symbols, array("", "", '"'), $element[$param]);
			}else{
				if($param_bitrix["NAME"] == "USER_ID"){
					$arLoadProductArray["NAME"] = isset($users[ $element[$param] ])?$users[ $element[$param] ]:"Анонимный пользователь";
					continue;
				}
				
				$PROP[$param_bitrix["NAME"]] = str_replace($replace_symbols, array("", "", '"'), $element[$param]);
			}
		}
	}
	$arLoadProductArray["PROPERTY_VALUES"] = $PROP;

	// print_r($arLoadProductArray);
	// print_r($arFields);

	/*$arLoadProductArray = Array(
	  "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
	  "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
	  "IBLOCK_ID"      => 10,
	  "PROPERTY_VALUES"=> $PROP,
	  "NAME"           => "123123",
	  "ACTIVE"         => "Y",            // активен
	  "PREVIEW_TEXT"   => "текст для списка элементов",
	  );*/

	if($PRODUCT_ID = $el->Add($arLoadProductArray)){
	  echo "New ID: ".$PRODUCT_ID;
	}else{
	  echo "Error: ".$el->LAST_ERROR;
	}
}

?>