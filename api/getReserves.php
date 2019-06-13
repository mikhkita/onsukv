<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$res = CIBlockElement::GetList (array(), array("IBLOCK_ID" => 9, "ACTIVE_DATE" => "Y", "ACTIVE" => "Y"), array('IBLOCK_ID', 'ID', 'NAME', 'CODE', 'PROPERTY_USER'));
while($ob = $res->GetNextElement()){ 
	$arFields[] = $ob->GetFields();

}

$arUsers = array();
$objDateTime = new DateTime();
$currentDate = $objDateTime->format("d.m.Y");

foreach ($arFields as $arItem) {

	$arItem['DATE_ACTIVE_TO'] = $currentDate;
	
	$el = new CIBlockElement;
	$arLoadProductArray = $arItem; 
	unset($arLoadProductArray['ID']);
	unset($arLoadProductArray["CNT"]);

	$res = $el->Update($arItem['ID'], $arLoadProductArray);
	if (!$res) {
		die();
	}

	$arUsers[$arItem["PROPERTY_USER_VALUE"]][] = array(
		"NAME" => $arItem["NAME"],
		"CODE" => $arItem["CODE"],
		"QUANTITY" => 0,
	);
}

if(count($arUsers)){
	$output = '<?xml version="1.0" encoding="UTF-8"?><data>';

	$output .= '<users_list>';
	foreach( $arUsers as $userID => $item )
	{	
		$rsUser = CUser::GetById($userID);
		$arUser = $rsUser->Fetch();

		$output .= '<user>';
		$output .= '<id>' . intval( $userID ) . '</id>';
		$output .= '<name>' . xml_entities( $arUser["NAME"] . ' ' . $arUser["LAST_NAME"] ) . '</name>';
		$output .= '<email>' . xml_entities( $arUser["EMAIL"] ) . '</email>';
		$output .= '<phone>' . xml_entities( convertPhoneNumber($arUser['PERSONAL_PHONE']) ) . '</phone>';
		$output .= '<request_list>';

		foreach ( $item as $req )
		{
			$output .= '<request_item>';
			$output .= '<name>' . xml_entities( $req['NAME'] ) . '</name>';
			$output .= '<code>' . xml_entities( $req['CODE'] ) . '</code>';
			$output .= '<quantity>' . xml_entities( $req['QUANTITY'] ) . '</quantity>';
			$output .= '</request_item>';
		}

		$output .= '</request_list>';
		$output .= '</user>';
	}

	$output .= '</users_list>';
	$output .= '<timestamp>' . time() . '</timestamp>';
	$output .= '</data>';

	header('Content-Description: File Transfer');
	header('Content-Type: application/force-download');
	header('Content-Type: application/octet-stream');
	header('Content-Type: application/download');
	header('Content-Disposition: attachment; filename=' . 'users_list_' . date('d_m_y') . '.xml' );
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . strlen( $output ) );
	print( $output );
}
die;

function xml_entities($string){
	return
		strtr(
			$string,
			array(
				"<" => "&lt;",
				">" => "&gt;",
				'"' => "&quot;",
				"'" => "&apos;",
				"&" => "&amp;",
			)
		);
}

?>