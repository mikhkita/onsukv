<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

	CModule::IncludeModule("iblock");
	$el = new CIBlockElement;

	$arSelect = Array();
	$arFilter = Array("IBLOCK_ID" => 8);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1000000), $arSelect);
	$arDates = array();
	while($ob = $res->GetNextElement()){
		$arProps = $ob->GetProperties();
		// vardump($arProps);
	 	array_push($arDates, $arProps['ORDER_DATE']['VALUE']);
	}

	for ($i=1; $i <= 21; $i++) { 

		$PROP = array();
		$date = date("d.m.Y", time() + $i*24*60*60);

		foreach ($arDates as $item) {
			if ($item == $date) {
				// $el->delete($arLoadProductArray)
			}
		}

		$arLoadProductArray = Array(
		  "IBLOCK_ID"      => 8,
		  "PROPERTY_VALUES"=> $PROP,
		  "NAME"           => "100",
		  "ACTIVE"         => "Y",
		  "DATE_ACTIVE_FROM" => ConvertTimeStamp(time(), "FULL")
		);
		
		if($el->Add($arLoadProductArray)){
			echo "1";
		}
		else{
			echo "0";
		}
	}

	vardump($arDates);

?>