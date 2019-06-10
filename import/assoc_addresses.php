<?
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
include 'users/addresses-all.php';

$firstUpdate = 23961;
$secondUpdate = 37987;
// 23961

$result = array();

foreach ($values as $value) {
	$result[] = array_combine($keys, $value);
}

include 'users/metro.php';

$metro = array();

$start = 80;
foreach ($values as $value) {
	$metro[ $value[0] ] = $start;
	$start++;
}

$params = array(
	'USER_ID' => array("NAME" => "USER", "TYPE" => "prop"),
	'ADDRESS_ID' => "",
	'ADDRESS' => array("NAME" => "NAME", "TYPE" => "field"),
	'ADDRESS_TYPE' => "",
	'STREET_ID' => "",
	'HOUSE' => "",
	'HOUSE_TYPE' => "",
	'HOUSEROOM' => array("NAME" => "ROOM", "TYPE" => "prop"),
	'REGION' => array("NAME" => "REGION", "TYPE" => "prop"),
	'CODE' => array("NAME" => "INDEX", "TYPE" => "prop"),
	'METRO_ID' => array("NAME" => "METRO", "TYPE" => "prop"),
	'PHONE' => "",
	'EMAIL' => "",
	'CONTACT' => "",
	'CITY' => array("NAME" => "CITY", "TYPE" => "prop"),
	'CITY_TYPE' => ""
);

$added = file_get_contents("users/addresses-result.txt");
$added = explode("|", $added);
$tmp = array();
foreach ($added as $key => $value) {
	$ar = explode(",", $value);
	$tmp[ intval($ar[0]) ] = intval($ar[1]);
}
$added = $tmp;

$el = new CIBlockElement;
$replace_symbols = array('\\r\\n\\r\\n', '\\r\\n', '\"');
$regions = array();

foreach ($result as $element) { //element - вся информация о элементе
	if( isset($added[$element["ADDRESS_ID"]]) ){
		continue;
	}

	$PROP = array();
	$fields = array();

	// if( !in_array($element["REGION"], $regions) ){
	// 	array_push($regions, $element["REGION"]);
	// }

	// continue;

	$arLoadProductArray = Array(
	  "IBLOCK_ID"      		=> 6,
	  // "PREVIEW_TEXT_TYPE" 	=> "text"
	);

	foreach ($params as $param => $param_bitrix) {
		if(!empty($param_bitrix)){
			if($param_bitrix["TYPE"] == "field"){
				if($param_bitrix["NAME"] == "NAME"){
					if( $element["ADDRESS_ID"] >= $secondUpdate ){
						$tmp = array();
						if( !empty(trim($element["REGION"])) && $element["REGION"] != "Москва" ){
							array_push($tmp, trim($element["REGION"]));
						}
						$tmpStreet = explode("|", $element["ADDRESS_TYPE"]);
						if( count( $tmpStreet ) == 2 ){
							array_push($tmp, strtolower($tmpStreet[0])." ".trim($element[$param]));
						}else{
							array_push($tmp, trim($element[$param]));
						}
						if( !empty(trim($element["REGION"])) ){
							array_push($tmp, trim($element["HOUSE"]));
						}
						$str = implode(", ", $tmp);
					}else{
						$str = $element[$param];
					}
					$arLoadProductArray[$param_bitrix["NAME"]] = str_replace($replace_symbols, array("", "", '"'), $str);
					continue;
				}
				// $arLoadProductArray[$param_bitrix["NAME"]] = str_replace($replace_symbols, array("", "", '"'), $element[$param]);
			}else{
				if($param_bitrix["NAME"] == "METRO" && !empty($element[$param]) && isset($metro[ $element[$param] ]) ){
					$PROP[$param_bitrix["NAME"]] = $metro[ $element[$param] ];
					continue;
				}

				if($param_bitrix["NAME"] == "ROOM" && $element["ADDRESS_ID"] >= $secondUpdate){
					$PROP[$param_bitrix["NAME"]] = str_replace($replace_symbols, array("", "", '"'), trim($element[$param]));
					continue;
				}

				if($param_bitrix["NAME"] == "REGION" && $element["ADDRESS_ID"] >= $firstUpdate){
					$PROP[$param_bitrix["NAME"]] = str_replace($replace_symbols, array("", "", '"'), trim($element[$param]));
					continue;
				}

				if($param_bitrix["NAME"] == "INDEX" && $element["ADDRESS_ID"] >= $firstUpdate){
					$PROP[$param_bitrix["NAME"]] = str_replace($replace_symbols, array("", "", '"'), trim($element[$param]));
					continue;
				}

				if($param_bitrix["NAME"] == "CITY" && $element["ADDRESS_ID"] >= $firstUpdate){
					$PROP[$param_bitrix["NAME"]] = str_replace($replace_symbols, array("", "", '"'), trim($element[$param]));
					continue;
				}
				
				$PROP[$param_bitrix["NAME"]] = str_replace($replace_symbols, array("", "", '"'), trim($element[$param]));
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
	  	file_put_contents("users/addresses-logs.txt", "New ID: ".$PRODUCT_ID."\n", FILE_APPEND);
		
		file_put_contents("users/addresses-result.txt", $element["ADDRESS_ID"].",".$PRODUCT_ID."|", FILE_APPEND);
	}else{
		file_put_contents("users/addresses-logs.txt", "Error: ".$el->LAST_ERROR."(".$element["ADDRESS_ID"].")"."\n", FILE_APPEND);
	}
}

// asort($regions);

// echo "<pre>";
// var_dump($regions);
// echo "</pre>";

?>