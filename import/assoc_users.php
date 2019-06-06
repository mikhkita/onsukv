<?
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");

$userTable = \Bitrix\Main\UserTable::getMap();

// echo "<pre>";
// print_r($userTable);
// echo "</pre>";

include 'users/last.php';
// include 'articles/articles_journals.php';
// include 'articles/files.php';
// include 'articles/tags.php';

// Чтение пользователей из файла
$result = array();
foreach ($values as $value) {
	$result[] = array_combine($keys, $value);
}

$added = file_get_contents("users-result.txt");
$added = explode("|", $added);
$tmp = array();
foreach ($added as $key => $value) {
	$ar = explode(",", $value);
	$tmp[ intval($ar[0]) ] = intval($ar[1]);
}
$added = $tmp;

// $added = array_fill_keys($added, 1);

// print_r($result);
// die();
// $unique = array();
// foreach ($result as $key => $value) {
// 	if( !is_array($unique[$value["mail"]]) ){
// 		$unique[$value["mail"]] = array();
// 	}
// 	array_push($unique[$value["mail"]], $value["id"]);
// }

// foreach ($unique as $key => $value) {
// 	if( count($value) > 1 ){
// 		echo $key." ||| ";
// 		print_r($value);
// 	}
// }
// var_dump($unique);

// array_splice($result, 10);

	// "fb_id" => ,
	// "vk_id" => ,
	// "tw_id" => ,
	// "in_id" => ,
	// "mm_id" => ,
	// "ok_id" => ,
	// "ya_id" => ,
	// "fb_nick" => ,
	// "vk_nick" => ,
	// "tw_nick" => ,
	// "in_nick" => ,
	// "mm_nick" => ,
	// "ok_nick" => ,
	// "ya_nick" => ,
	// "uin" => "",
	// "mail_soc" => "",
	// "auth_hash" => "",
	// "pwd_hash" => "",
	// "fname" => "",
	// "lname" => "",
	// "job_id" => "",
	// "pharmacy" => "",
	// "avatar_medium" => "",
	// "avatar_big" => "",
	// "last_visit" => "",
	// "ip_address" => "",
	// "ip_geolocation_city" => "",
	// "ip_geolocation_region" => "",
	// "ip_geolocation_data" => "",
	// "is_admin" => "",
	// "kladr_code" => "",

$params = array(
	"USER_ID" => "ID",
	"FIRSTNAME" => "NAME",
	"LASTNAME" => "LAST_NAME",
	"BIRTH" => "PERSONAL_BIRTHDATE",
	"EMAIL" => "EMAIL",
	"SUBSCRIBE" => "",
	"MAINPHONE" => "PERSONAL_PHONE",
	"SUBPHONE" => "WORK_PHONE",
	"ADDIT" => "PERSONAL_NOTES",
	"INFOSOURCE" => "WORK_NOTES",
	"LOGIN" => "LOGIN",
	"PASSWORD" => "PASSWORD",
	"STATUS" => "ACTIVE",
	"R_DATE" => "DATE_REGISTER",
	"L_DATE" => "LAST_LOGIN",
	"PERSONAL_DISCOUNT" => "",
);


$el = new CUser;
$replace_symbols = array('\\r\\n\\r\\n', '\\r\\n', '\"');
$IDs = array();

foreach ($result as $element) { //element - вся информация о элементе
	if( isset($added[$element["id"]]) ){
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
				// case "EMAIL":
				// 	// if( !empty($element[$param]) ){
				// 	// 	$arFields[$param_bitrix] = str_replace($replace_symbols, array("", "", '"'), trim($element[$param]) );
				// 	// 	$arFields["LOGIN"] = str_replace($replace_symbols, array("", "", '"'), trim($element[$param]) );
				// 	// }else{
				// 	// 	$arFields[$param_bitrix] = "temp@email.ru";
				// 	// 	$arFields["LOGIN"] = "user-".$element["id"];
				// 	// }
				// 	break;
				case "PASSWORD":
					// if( !empty($element[$param]) ){
						$arFields[$param] = md5($element[$param]."nev");
						$arFields["WORK_ZIP"] = md5(rand().time().rand());
					// }
					break;
				case "ACTIVE":
					$arFields[$param_bitrix] = intval($element[$param]) == 1 ? "Y" : "N";
					break;
				case "DATE_REGISTER":
				case "PERSONAL_BIRTHDATE":
				case "LAST_LOGIN":
					$arFields[$param_bitrix] = $element[$param];
					break;
				
				default:
					$arFields[$param_bitrix] = str_replace($replace_symbols, array("", "", '"'), $element[$param]);
					break;
			}
		}
	}


	// print_r($arFields);
	// die();



	if($USER_ID = $el->Add($arFields)){
		$IDs[$element["id"]] = $USER_ID;
		file_put_contents("users-logs.txt", "New ID: ".$USER_ID, FILE_APPEND);
		
		file_put_contents("users-result.txt", $element["id"].",".$USER_ID."|", FILE_APPEND);
	}else{
		file_put_contents("users-logs.txt", "Error: ".$el->LAST_ERROR."(".$element["id"].")", FILE_APPEND);
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