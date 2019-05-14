<?
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

\Bitrix\Main\Loader::includeModule('catalog'); 

$filename = "balance.csv";

$row = 1;
$keys = array();
if (($handle = fopen($filename, "r")) !== FALSE) {
	if(($str = fgets($handle, 4096)) !== FALSE){
		$keys = str_getcsv(str_replace(":::", "#", $str), "#");
	}
	while (($str = fgets($handle, 4096)) !== FALSE) {
		$values = str_getcsv(str_replace(":::", "#", $str), "#");
	 	$data = array_combine($keys, $values);

	 	$obProduct = new CCatalogProduct(); 
		$obProduct->Update($data["ARTIKUL"], ['QUANTITY' => $data["OSTATOK"], 'SUBSCRIBE' => 'D']); 

		$arFields = Array(
	        "PRODUCT_ID" => $data["ARTIKUL"],
	        "STORE_ID" => 1,
	        "AMOUNT" => $data["OSTATOK1"],
	    );
	    
	    $ID = CCatalogStoreProduct::Add($arFields);
	}
	fclose($handle);
}
print_r($data);
die();

?>