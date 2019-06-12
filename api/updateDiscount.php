<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

// updateUserDiscount();

global $USER;

// $userID = $USER->GetID()
$userID = 1;
$rsUser = CUser::GetByID($userID);
$arUser = $rsUser->Fetch();

$newDiscount = $arUser["PERSONAL_WWW"];
$oldDiscount = $arUser["PERSONAL_ICQ"];

vardump($newDiscount);
vardump($oldDiscount);

if ($newDiscount != $oldDiscount) {
	updateUserDiscount($userID, $newDiscount);
}

function updateUserDiscount($userID, $discountValue = null){

	$db_res = CSaleDiscount::GetList( array("SORT" => "ASC"), array("LID" => 's1'), false, false, array('ID', 'NAME','ACTIONS','CONDITIONS', 'XML_ID','USER_GROUPS'));

	$isUserRemoved = false;
	$discountID = 0;
	$arDiscount = array();
	$discountList = array();

	while ($discount = $db_res->Fetch()){

		if ($discount['XML_ID'] == "PERSONAL_DISCOUNT"){

			if ($discount['USER_GROUPS']) {
				$discount['USER_GROUPS'] = array($discount['USER_GROUPS']);
			} else {
				$discount['USER_GROUPS'] = array("2");
			}

			$discountList[] = $discount;
			$actions = unserialize($discount['ACTIONS']);
			$conditions = unserialize($discount['CONDITIONS']);
			$idList = $conditions['CHILDREN'][0]['DATA']['value'];

			if($actions["CHILDREN"][0]["DATA"]["Value"] == $discountValue && !isset($arDiscount['ID'])){
				$arDiscount = $discount;
			}

			if (!$isUserRemoved) {
				foreach ($idList as $key => $id) {
					if ($id == $userID) {

						unset($idList[$key]);
						$idList = array_unique($idList);
						$idList = array_filter($idList, 'userIdFilter');

						$conditions['CHILDREN'][0]['DATA']['value'] = $idList;
						$discount['CONDITIONS'] = serialize($conditions);

						if (!CSaleDiscount::Update($discount['ID'], $discount)) { 
						    $ex = $APPLICATION->GetException();
						    vardump($ex->GetString());
						} else {
							vardump('remove ok');
							$isUserRemoved = true;
							break;
						}
					}
				}
			}
		}
	}

	if(isset($arDiscount['ID'])){

		$conditions = unserialize($arDiscount['CONDITIONS']);

		$conditions['CHILDREN'][0]['DATA']['value'][] = $userID;
		$conditions['CHILDREN'][0]['DATA']['value'] = array_values(array_filter(array_unique($conditions['CHILDREN'][0]['DATA']['value']), 'userIdFilter'));

		$arDiscount['CONDITIONS'] = serialize($conditions);
		global $APPLICATION;

		if (!CSaleDiscount::Update($arDiscount['ID'], $arDiscount)) { 
		    $ex = $APPLICATION->GetException();
		    vardump($ex->GetString());
		} else {
			vardump("update ok");
		}

	} else {

		CModule::IncludeModule('catalog');
		global $APPLICATION;

		$arDiscount = array(
			"LID" => "s1",
			"SITE_ID" => "s1",
			"NAME"=> "Персональная скидка ".$discountValue."%",
		    'ACTIVE' => 'Y',
		    'LAST_DISCOUNT' => 'N',
		    'LAST_LEVEL_DISCOUNT' => 'N',
		    'CURRENCY' => 'RUB',
		    'VALUE' => $discountValue,
		);

		if (!empty($discountList)) {
			$arDiscount += $discountList[count($discountList)-1];
		}

		unset($arDiscount['ID']);

		$actions = unserialize($arDiscount['ACTIONS']);
		$actions["CHILDREN"][0]["DATA"]["Value"] = floatval($discountValue);

		$conditions = unserialize($arDiscount['CONDITIONS']);
		$conditions['CHILDREN'][0]['DATA']['value'] = array($userID);

		$arDiscount['CONDITIONS'] = $conditions;
		$arDiscount['ACTIONS'] = $actions;


		if (!CSaleDiscount::Add($arDiscount)) { 
	    	$ex = $APPLICATION->GetException();
	    	vardump($ex->GetString());
		} else {
			vardump("add ok");
		}
	}
}

function userIdFilter($var){
	return ($var !== NULL && $var !== FALSE && $var !== '');
}

?>