<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

// CModule::IncludeModule("iblock");
// $el = new CIBlockElement;
// $arLoadProductArray = Array(
// 	"IBLOCK_ID"      		=> 6,
// 	"NAME"					=> "Адрес",
// 	"PROPERTY_VALUES"		=> array(
// 		"INDEX"				=> "123123",
// 		"REGION"			=> "Тестовый",
// 		"ROOM"				=> "123",
// 		"USER"				=> 1,
// 		"CITY"				=> "Тест",
// 		"METRO"				=> "Метро",
// 	),
// );
// $PRODUCT_ID = $el->Add($arLoadProductArray);


// $productID = 171560;
// $amount = 2;
// $quantity = 123;
// $weight = 0.01;

// $row = 1;
// $keys = array();
// if (($handle = fopen($_SERVER["DOCUMENT_ROOT"]."/1C_exchange/Ostatki_2019125.csv", "r")) !== FALSE) {
//     while (($data = fgets($handle)) !== FALSE) {
//         $data = str_getcsv(str_replace(":::", "#", $data), "#");

//         if( $row == 1 ){
//         	$keys = $data;
//         }else{
//         	$data = array_combine($keys, $data);

//         	$productID = $data["ARTIKUL"];
//         	$weight = $data["VES"];
//         	$quantity = $data["OSTATOK"];
//         	$amount = $data["OSTATOK1"];

//         	updateStore($productID, $weight, $quantity, $amount);

//         	file_put_contents($_SERVER["DOCUMENT_ROOT"]."/1C_exchange/store_log.txt", "$row: ".$data["ARTIKUL"]."\n", FILE_APPEND);
//         }

//         if( $row == 30 ){
//         	break;
//         }

//         $row++;
//     }
//     fclose($handle);
// }


?>