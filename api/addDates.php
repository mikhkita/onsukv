<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

	CModule::IncludeModule("iblock");
	$el = new CIBlockElement;

	$arSelect = Array();
	$arFilter = Array("IBLOCK_ID" => 8);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1000000), $arSelect);
	$arDates = array();

	while($ob = $res->GetNextElement()){
		$arFields = $ob->GetFields(); 
		$arProps = $ob->GetProperties();
		$arDates[$arFields['ID']] = $arProps['ORDER_DATE']['VALUE'];
	}

	$arSelect = Array();
	$arFilter = Array("IBLOCK_ID" => 5, "CODE" => "ORDER_RESTRICTION");
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1000000), $arSelect);

	while($ob = $res->GetNextElement()){
		$settings = $ob->GetProperties(); 
	}

	foreach ($arDates as $id => $item) {
		$compareDates = $DB->CompareDates($item, date("d.m.Y", time())); 
		if ($compareDates != '1') {
			if(CIBlockElement::Delete($id)){
				echo "delete\n";
			} else {
				echo "0";
			}
		}
	}

	$count = 14;

	for ($i=1; $i <= $count; $i++) { 

		$PROP['ORDER_DATE'] = date("d.m.Y", time() + $i*24*60*60);
		$flag = false;

		foreach ($arDates as $item){
			if ($item == $PROP['ORDER_DATE']){
				$flag = true;
			}
		}

		if (!$flag) {
			$arLoadProductArray = Array(
			  "IBLOCK_ID"      => 8,
			  "PROPERTY_VALUES"=> $PROP,
			  "NAME"           => $settings["PARAM_VALUE"]["VALUE"],
			  "CODE" 		   => "N",
			  "ACTIVE"         => "Y",
			  "DATE_ACTIVE_FROM" => ConvertTimeStamp(time(), "FULL")
			);
			
			if($el->Add($arLoadProductArray)){
				echo "add\n";
			}
			else{
				echo "0";
			}
		}
	}

?>