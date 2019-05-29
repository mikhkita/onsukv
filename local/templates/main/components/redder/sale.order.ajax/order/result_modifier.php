<?
global $USER;

$arResult["DATES"] = array(
	array( "TIME" => time()),
	array( "TIME" => time() + 1*24*60*60),
	array( "TIME" => time() + 2*24*60*60),
	array( "TIME" => time() + 3*24*60*60),
	array( "TIME" => time() + 4*24*60*60),
	array( "TIME" => time() + 5*24*60*60),
	array( "TIME" => time() + 6*24*60*60),
	array( "TIME" => time() + 7*24*60*60),
	array( "TIME" => time() + 8*24*60*60),
	array( "TIME" => time() + 9*24*60*60),
	array( "TIME" => time() + 10*24*60*60),
);

foreach ($arResult["DATES"] as $key => $arDate) {
	$arResult["DATES"][$key]["KEY"] = date("d.m.Y", $arDate["TIME"]);
	$arResult["DATES"][$key]["VALUE"] = date("d", $arDate["TIME"])." ".getRusMonth(date("m", $arDate["TIME"])).", ".getRusDayOfWeek(date("w", $arDate["TIME"]));
	$arResult["DATES"][$key]["IS_SUNDAY"] = ( date("w", $arDate["TIME"]) == 0 )?"Y":"N";
}

if( !empty($USER->GetID()) ){
	$arSelect = Array("NAME", "PROPERTY_*", "ID", "IBLOCK_ID");
	$arFilter = Array("IBLOCK_ID"=>6, "ACTIVE" => "Y", "PROPERTY_USER" => $USER->GetID());
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1000000), $arSelect);
	$items = array();
	while($ob = $res->GetNextElement()){
		$arFields = $ob->GetFields();
		$arProps = $ob->GetProperties();
		$items[] = array(
			"ID" => $arFields["ID"],
			"ADDRESS" => $arFields["NAME"],
			"INDEX" => $arProps["INDEX"]["VALUE"],
			"ROOM" => $arProps["ROOM"]["VALUE"],
			"REGION" => $arProps["REGION"]["VALUE"],
		);
	}

	$arResult["ADDRESSES"] = $items;
}

?>