<?
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");

// $userTable = \Bitrix\Main\UserTable::getMap();

// echo "<pre>";
// print_r($userTable);
// echo "</pre>";

include 'orders/last.php';

// Чтение заказов из файла
$result = array();
foreach ($values as $value) {
	$result[] = array_combine($keys, $value);
}

$arFields = array(
	"LID" => SITE_ID,
	"ID" => 1230,
	"PERSON_TYPE_ID" => 1,
	"PAYED" => "N",
	"CANCELED" => "N",
	"STATUS_ID" => "N",
	"PRICE" => 279.32,
	"CURRENCY" => "RUB",
	"USER_ID" => 1,
	"PAY_SYSTEM_ID" => 2,
	"PRICE_DELIVERY" => 0,
	"DELIVERY_ID" => 120,
	"DISCOUNT_VALUE" => 0,
	"TAX_VALUE" => 0.0,
	"USER_DESCRIPTION" => ""
);

// if (CModule::IncludeModule("statistic"))
//    $arFields["STAT_GID"] = CStatistic::GetEventParam();

$ORDER_ID = CSaleOrder::Add($arFields);
vardump($ORDER_ID);

if($ex = $APPLICATION->GetException()) echo $ex->GetString(); 


vardump($result);
die();

$added = file_get_contents("orders/orders-result.txt");
$added = explode("|", $added);
$tmp = array();
foreach ($added as $key => $value) {
	$ar = explode(",", $value);
	$tmp[ intval($ar[0]) ] = intval($ar[1]);
}
$added = $tmp;

$params = array(
	'ZAKAZ_ID',
	'DATA',
	'CMF_USER_ID',
	'ADDRESS_ID',
	'USER_ID',
	'DISCOUNT_ID',
	'TOTALSUM',
	'PERSONAL_DISCOUNT',
	'SBERBANK_DISCOUNT',
	'REVIEW_DISCOUNT',
	'DISCOUNT_SUM',
	'SHIPMENT_ID',
	'SHIPMENT_SUM',
	'ZAKAZSUM',
	'SUMMARY',
	'ZAKAZ_INFO',
	'STATUS',
	'C_STATUS',
	'C_MANAGER',
	'C_INV',
	'robokassa_status',
	'robokassa_id',
	'need_callback',
	'sberbank',
	'selected_date',
	'time_to_deliver',
	'WHOLESALE'
);


$el = new CUser;
$replace_symbols = array('\\r\\n\\r\\n', '\\r\\n', '\"');
$IDs = array();

foreach ($result as $element) { //element - вся информация о элементе
	if( isset($added[$element["USER_ID"]]) ){
		continue;
	}
	$PROP = array();
	$fields = array();

	$arFields = Array(
		// "GROUP_ID" => array(5)
	);

	foreach ($params as $param => $param_bitrix) {
		if(!empty($param_bitrix)){
			switch ($param_bitrix) {
				case "LOGIN":
					if( mb_strlen($element[$param], "UTF-8") < 3 ){
						$arFields[$param_bitrix] = trim(str_replace($replace_symbols, array("", "", '"'), $element["EMAIL"]));
					}else{
						$arFields[$param_bitrix] = trim(str_replace($replace_symbols, array("", "", '"'), $element[$param]));
					}
					// if( !empty($element[$param]) ){
					// 	$arFields[$param_bitrix] = str_replace($replace_symbols, array("", "", '"'), trim($element[$param]) );
					// 	$arFields["LOGIN"] = str_replace($replace_symbols, array("", "", '"'), trim($element[$param]) );
					// }else{
					// 	$arFields[$param_bitrix] = "temp@email.ru";
					// 	$arFields["LOGIN"] = "user-".$element["id"];
					// }
					break;
				case "PASSWORD":
					if( empty($element[$param]) ){
						$arFields[$param_bitrix] = md5(rand());
					}else{
						$arFields[$param_bitrix] = $element[$param];
					}
						// $arFields["WORK_ZIP"] = md5(rand().time().rand());
					// }
					break;
				case "ACTIVE":
					$arFields[$param_bitrix] = intval($element[$param]) == 1 ? "Y" : "N";
					break;
				case "DATE_REGISTER":
				case "PERSONAL_BIRTHDAY":
				case "LAST_LOGIN":
					if( !in_array($element[$param], array("0000-06-06 00:00:00", "1970-01-01 12:00:00", "0000-00-00 00:00:00", "0000-04-09 00:00:00")) ){
						$arFields[$param_bitrix] = date("d.m.Y h:i:s", strtotime($element[$param]));
					}
					break;
				
				default:
					$arFields[$param_bitrix] = trim(str_replace($replace_symbols, array("", "", '"'), $element[$param]));
					break;
			}
		}
	}


	// print_r($arFields);
	// die();



	if($USER_ID = $el->Add($arFields)){
		$IDs[$element["USER_ID"]] = $USER_ID;
		file_put_contents("users/users-logs.txt", "New ID: ".$USER_ID."\n", FILE_APPEND);
		
		file_put_contents("users/users-result.txt", $element["USER_ID"].",".$USER_ID."|", FILE_APPEND);
	}else{
		file_put_contents("users/users-logs.txt", "Error: ".$el->LAST_ERROR."(".$element["USER_ID"].")"."\n", FILE_APPEND);
	}
}

file_put_contents( "users/userIDs.txt", serialize($IDs) );

// include 'users/last.php';

// $result = array();

// foreach ($values as $value) {
// 	$result[] = array_combine($keys, $value);
// }

// // print_r($users);

// $params = array(
// 	"USER_ID" => array("NAME" => "ID", "TYPE" => "field"),
// 	"FIRSTNAME" => array("NAME" => "ID", "TYPE" => "field"), #######
// 	"LASTNAME" => array("NAME" => "ID", "TYPE" => "field"), #######
// 	"BIRTH" => array("NAME" => "ID", "TYPE" => "field"), #######
// 	"EMAIL" => array("NAME" => "ID", "TYPE" => "field"), #######
// 	"SUBSCRIBE" => array("NAME" => "ID", "TYPE" => "field"), #######
// 	"MAINPHONE" => array("NAME" => "ID", "TYPE" => "field"), #######
// 	"SUBPHONE" => array("NAME" => "ID", "TYPE" => "field"), #######
// 	"ADDIT" => array("NAME" => "ID", "TYPE" => "field"), #######
// 	"INFOSOURCE" => array("NAME" => "ID", "TYPE" => "field"), #######
// 	"LOGIN" => array("NAME" => "ID", "TYPE" => "field"), #######
// 	"PASSWORD" => array("NAME" => "ID", "TYPE" => "field"), #######
// 	"STATUS" => array("NAME" => "ID", "TYPE" => "field"), #######
// 	"R_DATE" => array("NAME" => "DATE_CREATE", "TYPE" => "field"), #######
// 	"L_DATE" => array("NAME" => "ID", "TYPE" => "field"), #######
// 	"PERSONAL_DISCOUNT" => array("NAME" => "ID", "TYPE" => "field"), #######




// 	"ITEM_REVIEW_ID" => array("NAME" => "ID", "TYPE" => "field"),
// 	"ITEM_ID" => array("NAME" => "PRODUCT_ID", "TYPE" => "prop"),
// 	"USER_ID" => array("NAME" => "USER_ID", "TYPE" => "prop"),
// 	"CMF_USER_ID" => "",
// 	"CREATE_DATE" => array("NAME" => "DATE_CREATE", "TYPE" => "field"),
// 	"REVIEW_TEXT" => array("NAME" => "PREVIEW_TEXT", "TYPE" => "field"),
// 	"USER_RATING" => array("NAME" => "CODE", "TYPE" => "field"),
// 	"STATUS" => array("NAME" => "ACTIVE", "TYPE" => "field"),
// 	"SMALL_IMAGE" => "",
// 	"BIG_IMAGE" => array("NAME" => "PREVIEW_PICTURE", "TYPE" => "field"),
// );

// $el = new CIBlockElement;
// $replace_symbols = array('\\r\\n\\r\\n', '\\r\\n', '\"');

// foreach ($result as $element) { //element - вся информация о элементе

// 	$PROP = array();
// 	$fields = array();

// 	$arLoadProductArray = Array(
// 	  "IBLOCK_ID"      		=> 2,
// 	  "PREVIEW_TEXT_TYPE" 	=> "text"
// 	);

// 	foreach ($params as $param => $param_bitrix) {
// 		if(!empty($param_bitrix)){
// 			if($param_bitrix["TYPE"] == "field"){
// 				if($param_bitrix["NAME"] == "PREVIEW_PICTURE"){
// 					$arLoadProductArray[$param_bitrix["NAME"]] = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"].$element[$param]);
// 					continue;
// 				}
// 				if($param_bitrix["NAME"] == "ACTIVE"){
// 					$arLoadProductArray[$param_bitrix["NAME"]] = $element[$param] == 0 ? "N" : "Y";
// 					continue;
// 				}
// 				if($param_bitrix["NAME"] == "DATE_CREATE"){
// 					if(!empty($element[$param])){
// 						$arLoadProductArray[$param_bitrix["NAME"]] = date("d.m.Y", strtotime($element[$param]));
// 					}else{
// 						$arLoadProductArray[$param_bitrix["NAME"]] = date("d.m.Y", strtotime($element["date"]));
// 					}
// 					// echo $arLoadProductArray[$param_bitrix["NAME"]];
// 					// echo "////";
// 					continue;
// 				}
// 				$arLoadProductArray[$param_bitrix["NAME"]] = str_replace($replace_symbols, array("", "", '"'), $element[$param]);
// 			}else{
// 				if($param_bitrix["NAME"] == "USER_ID"){
// 					$arLoadProductArray["NAME"] = isset($users[ $element[$param] ])?$users[ $element[$param] ]:"Анонимный пользователь";
// 					continue;
// 				}
				
// 				$PROP[$param_bitrix["NAME"]] = str_replace($replace_symbols, array("", "", '"'), $element[$param]);
// 			}
// 		}
// 	}
// 	$arLoadProductArray["PROPERTY_VALUES"] = $PROP;

// 	// print_r($arLoadProductArray);
// 	// print_r($arFields);

// 	/*$arLoadProductArray = Array(
// 	  "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
// 	  "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
// 	  "IBLOCK_ID"      => 10,
// 	  "PROPERTY_VALUES"=> $PROP,
// 	  "NAME"           => "123123",
// 	  "ACTIVE"         => "Y",            // активен
// 	  "PREVIEW_TEXT"   => "текст для списка элементов",
// 	  );*/

// 	if($PRODUCT_ID = $el->Add($arLoadProductArray)){
// 	  echo "New ID: ".$PRODUCT_ID;
// 	}else{
// 	  echo "Error: ".$el->LAST_ERROR;
// 	}
// }

?>