<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

updateUserDiscount();

function updateUserDiscount($userID, $discount = null){

	$discountID = 5;
	$userID = 24;
	$add = true;

	$discount = CSaleDiscount::GetByID($discountID);
	vardump($discount);

	$conditions = unserialize($discount['CONDITIONS']);
	$idList = $conditions['CHILDREN'][0]['DATA']['value'];

	foreach ($idList as $key => $id) {
		if ($id == $userID) {
			$add = false;
		}
	}

	if ($add) {

		$conditions['CHILDREN'][0]['DATA']['value'][] = $userID;
		$discount['CONDITIONS'] = serialize($conditions);
	 
		if (!CSaleDiscount::Update($discountID, $discount)) { 
		    $ex = $APPLICATION->GetException();
		    vardump($ex->GetString());
		}
	}

}

?>