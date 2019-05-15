<?

$arResult["DATES"] = array(
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

?>