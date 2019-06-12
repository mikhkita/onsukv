<?
// use Bitrix\Sale;
use Bitrix\Main;
use Sale;

// use Bitrix\Main\EventManager;

// \Bitrix\Main\EventManager::getInstance()->AddEventHandler(
//     "sale",
//     "\Bitrix\Sale\Internals\DiscountTable::DiscountОnAfterUpdate",
//     "DiscountОnAfterUpdateHandler"
// );

// function DiscountОnAfterUpdateHandler(Entity\Event $event) {
//     file_put_contents("test.txt", "asfla");
// }

// Исключаем поиск по описаниям
AddEventHandler("search", "BeforeIndex", array("SearchHandlers", "BeforeIndexHandler"));
AddEventHandler("main", "OnAfterUserLogin", Array("MyClass", "OnAfterUserLoginHandler"));

// AddEventHandler("iblock", "OnAfterIBlockElementUpdate", Array("MyClass", "OnAfterIBlockElementUpdateHandler"));
// AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("MyClass", "OnAfterIBlockElementAddHandler"));

AddEventHandler("catalog", "OnStoreProductUpdate", Array("MyClass", "OnStoreProductUpdateHandler"));
AddEventHandler("sale", "DiscountOnAfterUpdate", Array("MyClass", "DiscountOnAfterUpdateHandler"));
AddEventHandler("main", "OnBeforeEventAdd", Array("MyEventHandlers", "OnBeforeEventAddHandler")); 
AddEventHandler("sale", "OnOrderAdd", Array("MyClass", "OnOrderAddHandler"));
AddEventHandler("sale", "OnBeforeUserAdd", Array("MyClass", "OnBeforeUserAddHandler"));
AddEventHandler("sale", "OnOrderDelete", Array("MyClass", "OnOrderDeleteHandler"));
AddEventHandler("main", "OnBeforeUserUpdate", Array("MyClass", "OnBeforeUserUpdateHandler"));



class MyEventHandlers 
{ 
    function OnBeforeEventAddHandler(&$event, &$lid, &$arFields)
    {
		if($event==="SALE_NEW_ORDER"){

			$order = Bitrix\Sale\Order::load($arFields["ORDER_ID"]);
			$propertyCollection = $order->getPropertyCollection();
			$temp = $propertyCollection->getArray(); 
			$fields = $order->getField("date");
			$description = $order->getField("USER_DESCRIPTION");
			$deliveryID = $order->getField("DELIVERY_ID");
			$arOrder = CSaleOrder::GetByID($arFields["ORDER_ID"]);
			$arDelivery = Bitrix\Sale\Delivery\Services\Manager::getById($deliveryID);
			$pickpoint = "";
			$arFields['ORDER_DATE'] = date("Y-m-d h:i:s", strtotime($arFields['ORDER_DATE']));

			foreach ($temp["properties"] as $arProp) {
				if ($arProp["CODE"] == "CALL") {
					if ($arProp["VALUE"][0] == "Y") {
						$arProps[$arProp["CODE"]] = "ЗВОНОК ОПЕРАТОРА";
					} else {
						$arProps[$arProp["CODE"]] = "СБОРКА БЕЗ ПОДТВЕРЖДЕНИЯ ОПЕРАТОРОМ";
					}
				} else {
					$arProps[$arProp["CODE"]] = $arProp["VALUE"][0];
				}
			}

			$arBasketItems = array();
			$arBasketFilter = array("LID" => 's1',"ORDER_ID" => $arFields["ORDER_ID"]);
			$arBasketSelect = array("PRODUCT_ID", "NAME", "PRICE", "BASE_PRICE", "QUANTITY", "DISCOUNT_PRICE");
			$dbBasketItems = CSaleBasket::GetList(array("NAME" => "ASC","ID" => "ASC"), $arBasketFilter, false, false, $arBasketSelect);
			
			while ($arItems = $dbBasketItems->Fetch()){
				$arFileds = CCatalogProduct::GetByID($arItems["PRODUCT_ID"]);
				$db_props = CIBlockElement::GetProperty(1, $arItems["PRODUCT_ID"], array("sort" => "asc"), Array('ID' => 2));
				while($ar_props = $db_props->Fetch()){
					$arItems["COUNTRY"] = $ar_props["VALUE_ENUM"];
				}

			    $arItems["TOTAL_QUANTITY"] = $arFileds["QUANTITY"];
			    $arBasketItems[] = $arItems;
		    }

		    $itemsText = "";
		    $clientItemsText = "";
		    $sum = 0;
		    $saleSum = 0;

		    foreach ($arBasketItems as $item) {

		    	if (round($item['QUANTITY']) == 1 && $item['BASE_PRICE'] == $item["DISCOUNT_PRICE"]) {
		    		$item['BASE_PRICE'] = $item['DISCOUNT_PRICE'] = 0;
		    	}

		    	$itemsText.="<tr>".
            		"<td>".$item['PRODUCT_ID']."</td>".
            		"<td>".$item['NAME']."</td>".
            		"<td>".round($item['QUANTITY'])."</td>".
            		"<td>".round($item['BASE_PRICE'])."</td>".
            		"<td>".$item["TOTAL_QUANTITY"]."</td>".
            		"<td>".round($item['QUANTITY']*$item['BASE_PRICE'])."</td>".
            		"<td>".$item["COUNTRY"]."</td>".
            	"</tr>";

            	$clientItemsText.="<tr>".
            		"<td>".$item['NAME']."</td>".
            		"<td>".round($item['BASE_PRICE'])."</td>".
            		"<td>".round($item['QUANTITY'])."</td>".
            		"<td>".round($item['QUANTITY']*$item['BASE_PRICE'])."</td>".
            	"</tr>";

            	$sum += round($item['BASE_PRICE']*$item['QUANTITY']);
            	$saleSum += $item['DISCOUNT_PRICE']*$item['QUANTITY'];
		    }

		    $saleSum = round($saleSum);
		    $saleCount = $sum - $saleSum;
		    $discount = (100-(round($saleCount*100/$sum))."%");
		    $totalSum = $saleCount + $arFields["DELIVERY_PRICE"];

			if ($userID = $order->getUserId()) {
				$userID = " ( ".$userID." )";
			}

			$processinginfo = "";

			if (!empty($arProps["CALL"]) && isset($arProps["CALL"])){
				$processing = "Выбран <strong>".$arProps["CALL"]."</strong>";
				$processinginfo = "<br>Вы выбрали Звонок оператора. В ближайшее время (обычно не более суток) операторы свяжутся с Вами по указанному телефону для подтверждения и уточнения по доставке.<br> 
					Если операторы не смогли связаться по заказу, то отправляется письмо покупателю, что телефон был недоступен.<br>
					Если Вы не дождались звонка в течении суток после отправки заказа, напишите нам info@nevkusno.ru, указав номер заказа.<br>
					Без подтверждения заказа мы не отправляем товар!<br>
					Если Вы хотите внести изменения в заказ или изменить способ доставки - дождитесь звонка оператора, или перезвоните сами по рекламным телефонам магазина.<br><br>";
			} else {
				$processing = "Не выбран";
			}

			$str = strval($arProps['PHONE']);

			$arProps['PHONE'] = '+'.substr($str, 0, 1).' ('.substr($str, 1, 3).') '.substr($str, 4, 3).'-'.substr($str, 7, 2).'-'.substr($str, 9, 2);
			$deliveryDateText = "Дата доставки:";

			$arProps["DELIVERY_DATE"] = date("d", strtotime($arProps['DELIVERY_DATE']))." ".getRusMonth(date("m", strtotime($arProps['DELIVERY_DATE']))).", ".getRusDayOfWeek(date("w", strtotime($arProps['DELIVERY_DATE'])));

			switch ($arDelivery['ID']) {
				case "30":
					$deliveryDateText = "Дата cборки:";
                    break;
                case "53":
                	$deliveryDateText = "Дата cборки:";
                	break;
                case "54":
                	$deliveryDateText = "Дата cборки:";
                	break;
                case "55":
                	$deliveryDateText = "Дата cборки:";
                    break;
                case "116":
                	$deliveryDateText = "Дата cборки:";
                    break;
                case "120":
                	$deliveryDateText = "Дата cборки:";
                    break;
                default:
                    break;
			}

			if (isset($arProps['PICKPOINT_ADDRESS']) && !empty($arProps['PICKPOINT_ADDRESS'])) {
				$howToDelivery = "PickPoint, ID постамата : ".$arProps['PICKPOINT_ID']."<br>".
								"Название постамата :".$arProps['PICKPOINT_NAME']."<br>".
								"Адрес постамата : ".$arProps['PICKPOINT_ADDRESS'];
				$pickpoint = $howToDelivery;
			} else {
				$howToDelivery = $arDelivery['NAME'];
			} 

			if (isset($arProps['DELIVERY_DISTANCE']) && !empty($arProps['DELIVERY_DISTANCE'])) {
				$howToDelivery = $howToDelivery.", ".$arProps['DELIVERY_DISTANCE']." км.";
			}

			if (!empty($arProps["ADDRESS"])) {
				$address = "<tr>".
				                "<td nowrap='nowrap'>Адрес доставки:</td>".
			                    "<td>&nbsp;</td>".
			                    "<td>".$arProps["ADDRESS_INDEX"].", ".$arProps["ADDRESS"].", кв/оф. ".$arProps["ADDRESS_ROOM"]."</td>".
		                    "</tr>";
			}
			if (isset($arProps["DELIVERY_TIME"]) && !empty($arProps["DELIVERY_TIME"])) {
				$deliveryTimeAdmin = "<tr>".
					                "<td>Время доставки:</td>".
				                    "<td>&nbsp;</td>".
				    	   	        "<td>".$arProps["DELIVERY_TIME"]."</td>".
				                "</tr>";
                $deliveryTimeClient = "<tr>".
					                "<td>Время доставки:</td>".
				    	   	        "<td>".$arProps["DELIVERY_TIME"]."</td>".
				                "</tr>";
            }
            if (isset($arProps["UNDERGROUND_DISTANCE"]) && !empty($arProps["UNDERGROUND_DISTANCE"])) {
				$undergroundDistanceAdmin = "<tr>".
					                "<td colspan='4'><strong>Удаленность от метро:</strong></td>".
				                    "<td>&nbsp;</td>".
				    	   	        "<td colspan='2'>".$arProps["UNDERGROUND_DISTANCE"]."</td>".
				                "</tr>";
                $undergroundDistanceClient = "<tr>".
					                "<td colspan='3'><strong>Удаленность от метро:</strong></td>".
				    	   	        "<td>".$arProps["UNDERGROUND_DISTANCE"]."</td>".
				                "</tr>";
            }

            if (isset($arProps["CDEK_TYPE"]) && !empty($arProps["CDEK_TYPE"]) && intval($arDelivery["ID"]) == 120 && !isset($pickpoint)) {
            	if ($arProps["CDEK_TYPE"] == 1) {
            		$cdekTypeInfo = "Доставка СДЭК : До пункта самовывоза <br>";
            	} else {
            		$cdekTypeInfo = "Доставка СДЭК : До двери <br>";
            	}
            }

            if (isset($arProps["ADDRESS_METRO"]) && !empty($arProps["ADDRESS_METRO"])) {

				$properties = CIBlockPropertyEnum::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>6, "CODE"=>"METRO", 'ID' => $arProps["ADDRESS_METRO"]));
				while ($prop_fields = $properties->GetNext()){
				  $metro = $prop_fields;
				}

            	$metro = "<tr>".
			                "<td nowrap='nowrap'>Метро: </td>".
			                    "<td>&nbsp;</td>".
			                    "<td>".$metro['VALUE']."</td>".
		                "</tr>";
            }

			$adminmsg = "<html>".
				"<head>".
					"<title>Вкусный магазин: Новый заказ</title>".
					"<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>".
					"<style>".
						"body,table {font-family: Arial; font-size:14px;}".
						"td, th {padding: 2px 8px;}".
					"</style>".
				"</head>".
				"<body>".
					"Уважаемый администратор интернет-магазина! Поступил новый заказ:<br><br>".
					"<table border='0'>".
						"<tbody>".
							"<tr>".
								"<td>Номер заказа:</td>".
								"<td></td>".
							    "<td><strong>".$arFields["ORDER_ID"]."</strong></td>".
							"</tr>".
							"<tr>".
							    "<td>Способ обработки заказа: </td>".
						        "<td></td>".
					            "<td>".$processing."</strong></td>".
				            "</tr>".
				            "<tr>".
				                "<td>Дата заказа:</td>".
				                    "<td></td>".
				                    "<td>".$arFields['ORDER_DATE']."</td>".
				                "</tr>".
				            "<tr>".
				                "<td colspan='3'>&nbsp;</td>".
			                "</tr>".
				            "<tr>".
				                "<td>".$deliveryDateText."</td>".
			                    "<td>&nbsp;</td>".
			    	   	        "<td>".$arProps["DELIVERY_DATE"]."</td>".
			                "</tr>".
			                $deliveryTimeAdmin.
				            "<tr>".
				                "<td>Фамилия Имя: </td>".
			                    "<td>&nbsp;</td>".
			                    "<td>".$arProps["SURNAME"]." ".$arProps["NAME"].$userID."</td>".
			                "</tr>".
				            "<tr>".
				                "<td>Контактный телефон: </td>".
			                    "<td>&nbsp;</td>".
			                    "<td>".$arProps["PHONE"]."</td>".
			                "</tr>".
			                $address.
			                "</tr>".
				            $metro.
				            "<tr>".
				                "<td nowrap='nowrap'>Адрес электронной почты: </td>".
				                "<td>&nbsp;</td>".
				                "<td>".$arProps["EMAIL"]."</td>".
			                "</tr>".
				            "<tr>".
				                "<td colspan='3'>&nbsp;</td>".
			                "</tr>".
				         "</tbody>".
				     "</table>".
				     "<table border='0' cellpadding='2' cellspacing='2'>".
				     	"<tbody>".
				     		"<tr>".
					         	"<td>#</td>".
					         	"<td>Наименование товара</td>".
					         	"<td>Количество</td>".
					         	"<td>Цена</td>".
					         	"<td>Наличие</td>".
					         	"<td>Сумма</td>".
					         	"<td>Страна</td>".
					         "</tr>".
			            	$itemsText.
				            "<tr>".
				            	"<td colspan='4'><strong>Сумма без скидки</strong>:</td>".
				            	"<td></td>".
				            	"<td colspan='2'>".$sum."</td>".
				            "</tr>".
				            "<tr>".
				            	"<td colspan='4'><strong>Скидка</strong>:</td>".
				            	"<td></td>".
				            	"<td colspan='2'>".$discount."</td>".
				            "</tr>".
				            "<tr>".
				            	"<td colspan='4'><strong>Сумма скидки</strong>:</td>".
				            	"<td></td>".
				            	"<td colspan='2'>".$saleSum."</td>".
				            "</tr>".
				            "<tr>".
				            	"<td colspan='4'><strong>Способ доставки</strong>:</td>".
				            	"<td></td>".
				            	"<td colspan='2'>".$howToDelivery."</td>".
				            "</tr>".
				            $undergroundDistanceAdmin.
				            "<tr>".
				            	"<td colspan='4'><strong>Стоимость доставки</strong>:</td>".
				            	"<td></td>".
				            	"<td colspan='2'>".$arFields["DELIVERY_PRICE"]."</td>".
				            "</tr>".
				            "<tr>".
				            	"<td colspan='4'><strong>Итого</strong>:</td>".
				            	"<td></td>".
				            	"<td colspan='2'>".$totalSum."</td>".
				            "</tr>".
				        "</tbody>".
				    "</table>".
				    "<table border='0'>".
				    	"<tbody>".
				    		"<tr>".
				                "<td colspan='3'>&nbsp;</td>".
				            "</tr>".
				            "<tr>".
				                "<td>Доп. информация о заказе: </td>".
			                    "<td>&nbsp;</td>".
			                    "<td>".
			                    $cdekTypeInfo.
			                    $arProps['CDEK_INFO'].
			                    $pickpoint.
			                    "</td>".
			                "</tr>".
				            "<tr>".
				                "<td>Комментарий к адресу: </td>".
			                    "<td>&nbsp;</td>".
			                    "<td></td>".
			                "</tr>".
				            "<tr>".
			                  	"<td>Комментарий к заказу: </td>".
			                  	"<td>&nbsp;</td>".
			                    "<td>".$description."</td>".
			                "</tr>".
				            "<tr>".
				                "<td>Ссылка на заказ в админке: </td>".
			                    "<td>&nbsp;</td>".
			                    "<td>".
			                    	"<a href='http://vkus.ca03222.tmweb.ru/bitrix/admin/sale_order_view.php?ID=".$arFields["ORDER_ID"]."'>Заказ № ".$arFields["ORDER_ID"]."</a>".
			                    "</td>".
				            "</tr>".
				        "</tbody>".
				    "</table>".
			    "</body>".
			"</html>";

			$clientmsg = "<html>".
				"<head>".
					"<title>Вкусный магазин: Новый заказ</title>".
					"<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>".
					"<style>".
						"body,table,p {font-family: Arial; font-size:14px;}".
						"td, th {padding: 2px 8px;}".
					"</style>".
				"</head>".
				"<body>".
					"<b>Благодарим за Ваш заказ во 'Вкусном магазине'!</b><br><br>".
					"Способ обработки заказа: ".$processing."<br>".
					$processinginfo.
					"<table border='0'>".
						"<tbody>".
							"<tr>".
								"<td>Номер заказа:</td>".
								"<td></td>".
							    "<td><strong>".$arFields["ORDER_ID"]."</strong></td>".
							"</tr>".
				            "<tr>".
				                "<td>Дата заказа:</td>".
				                    "<td></td>".
				                    "<td>".$arFields['ORDER_DATE']."</td>".
				                "</tr>".
				            "<tr>".
				                "<td colspan='3'>&nbsp;</td>".
			                "</tr>".
				            "<tr>".
				                "<td>".$deliveryDateText."</td>".
			                    "<td>&nbsp;</td>".
			    	   	        "<td>".$arProps["DELIVERY_DATE"]."</td>".
			                "</tr>".
			                $deliveryTimeClient.
				            "<tr>".
				                "<td>Фамилия Имя: </td>".
			                    "<td>&nbsp;</td>".
			                    "<td>".$arProps["SURNAME"]." ".$arProps["NAME"]."</td>".
			                "</tr>".
				            "<tr>".
				                "<td>Контактный телефон: </td>".
			                    "<td>&nbsp;</td>".
			                    "<td>".$arProps["PHONE"]."</td>".
			                "</tr>".
			                $address.
			                "</tr>".
				            $metro.
				            "<tr>".
				                "<td nowrap='nowrap'>Адрес электронной почты: </td>".
				                "<td>&nbsp;</td>".
				                "<td>".$arProps["EMAIL"]."</td>".
			                "</tr>".
				            "<tr>".
				                "<td colspan='3'>&nbsp;</td>".
			                "</tr>".
				         "</tbody>".
				     "</table>".
				     "<table border='0' cellpadding='2' cellspacing='2'>".
				     	"<tbody>".
				     		"<tr>".
					         	"<td>Наименование товара</td>".
					         	"<td>Цена</td>".
					         	"<td>Количество</td>".
					         	"<td>Сумма, руб.</td>".
					         "</tr>".
			            	$clientItemsText.
				            "<tr>".
				            	"<td colspan='3'><strong>Сумма без скидки</strong>:</td>".
				            	"<td>".$sum."</td>".
				            "</tr>".
				            "<tr>".
				            	"<td colspan='3'><strong>Скидка</strong>:</td>".
				            	"<td>".$discount."</td>".
				            "</tr>".
				            "<tr>".
				            	"<td colspan='3'><strong>Сумма скидки</strong>:</td>".
				            	"<td>".$saleSum."</td>".
				            "</tr>".
				            "<tr>".
				            	"<td colspan='3'><strong>Способ доставки</strong>:</td>".
				            	"<td>".$howToDelivery."</td>".
				            "</tr>".
				            $undergroundDistanceClient.
				            "<tr>".
				            	"<td colspan='3'><strong>Стоимость доставки</strong>:</td>".
				            	"<td>".$arFields["DELIVERY_PRICE"]."</td>".
				            "</tr>".
				            "<tr>".
				            	"<td colspan='3'><strong>Итого</strong>:</td>".
				            	"<td>".$totalSum."</td>".
				            "</tr>".
				        "</tbody>".
				    "</table>".
				    "<table border='0'>".
				    	"<tbody>".
				    		"<tr>".
				                "<td colspan='3'>&nbsp;</td>".
				            "</tr>".
				            "<tr>".
				                "<td>Доп. информация о заказе: </td>".
			                    "<td>&nbsp;</td>".
			                    "<td>".
			                    $cdekTypeInfo.
			                    $arProps['CDEK_INFO'].
			                    $pickpoint.
			                    "</td>".
			                "</tr>".
				            "<tr>".
			                  	"<td>Комментарий к заказу: </td>".
			                    "<td>".$description."</td>".
			                    "<td></td>".
			                "</tr>".
				        "</tbody>".
				    "</table>".
			    "</body>".
			"</html>";

			$arFields['ADMIN_MSG'] = $adminmsg;
			$arFields['CLIENT_EMAIL'] = $arProps["EMAIL"];
			$arFields['CLIENT_MSG'] = $clientmsg;

			vardump($adminmsg);
			vardump($clientmsg);
			die();

		}else if($event==="USER_INFO"){
			// vardump($arFields);

			$rsUser = CUser::GetByID(intval($arFields["USER_ID"]));
			$arUser = $rsUser->Fetch();

			$password = substr(md5(rand()), 0, 8 );

			$arUser["PASSWORD"] = $arUser["CONFIRM_PASSWORD"] = $password;

			// vardump($arUser);

			$user = new CUser;
			$user->Update(intval($arFields["USER_ID"]), $arUser);
			// echo $user->LAST_ERROR;

			$arFields["PASSWORD"] = $password;
		}
    } 
}

Main\EventManager::getInstance()->addEventHandler(
   'sale',
   'OnSaleOrderSaved',
   'OnSaleOrderSavedHandler'
);

function OnSaleOrderSavedHandler(Main\Event $event){
	global $USER;
	CModule::IncludeModule("iblock");

	$order = $event->getParameter("ENTITY");
	$isNew = $event->getParameter("IS_NEW");

	// print_r($order->getUserId());
	// var_dump($isNew);

	// var_dump($_REQUEST);

	// var_dump($order->getUserId());
	// die();

	if( !$isNew ) return true;

	if( $_REQUEST["address"] == "NEW" && $order->getUserId() ){
		$el = new CIBlockElement;
		$arLoadProductArray = Array(
			"IBLOCK_ID"      		=> 6,
			"NAME"					=> $_REQUEST["ORDER_PROP_15"],
			"PROPERTY_VALUES"		=> array(
				"INDEX"				=> $_REQUEST["ORDER_PROP_24"],
				"REGION"			=> $_REQUEST["ORDER_PROP_16"],
				"ROOM"				=> $_REQUEST["ORDER_PROP_14"],
				"USER"				=> $order->getUserId(),
				"CITY"				=> $_REQUEST["ORDER_PROP_22"],
				"METRO"				=> $_REQUEST["ORDER_PROP_18"],
			),
		);
		if( $PRODUCT_ID = $el->Add($arLoadProductArray) ){
			echo "string";
		}else{
			echo $el->LAST_ERROR;
		}
	}
}

Main\EventManager::getInstance()->addEventHandler(
   'main',
   'OnAfterUserAdd',
   'OnAfterUserAddHandler1'
);

function OnAfterUserAddHandler1($event){
	global $USER;

	CModule::IncludeModule("iblock");

	// print_r($event);
	// die();

	if( isset($_REQUEST["ORDER_PROP_2"]) ){
		// $rsUser = CUser::GetByID(23);
		// $arUser = $rsUser->Fetch();
		// print_r($arUser);
		$event["LAST_NAME"] = $_REQUEST["ORDER_PROP_2"];
		unset($event["PASSWORD"]);
		unset($event["CONFIRM_PASSWORD"]);
		unset($event["RESULT"]);
		unset($event["CHECKWORD_TIME"]);

		$user = new CUser;
		$user->Update($event["ID"], $event);
		// $strError .= $user->LAST_ERROR;
		echo $user->LAST_ERROR;
		// die();
		// $arUser["LAST"]
	}

	// print_r($event);
	// die();

	// if( $_REQUEST["address"] == "NEW" ){
		// $el = new CIBlockElement;
		// $arLoadProductArray = Array(
		// 	"IBLOCK_ID"      		=> 6,
		// 	"NAME"					=> $_REQUEST["ORDER_PROP_15"],
		// 	"PROPERTY_VALUES"		=> array(
		// 		"INDEX"				=> $_REQUEST["ORDER_PROP_24"],
		// 		"REGION"			=> $_REQUEST["ORDER_PROP_16"],
		// 		"ROOM"				=> $_REQUEST["ORDER_PROP_14"],
		// 		"USER"				=> $event["ID"],
		// 		"CITY"				=> $_REQUEST["ORDER_PROP_22"],
		// 		"METRO"				=> $_REQUEST["ORDER_PROP_18"],
		// 	),
		// );
		// $PRODUCT_ID = $el->Add($arLoadProductArray);
	// }
}

class SearchHandlers
{
    function BeforeIndexHandler($arFields)
    {
        if($arFields["MODULE_ID"] == "iblock")
        {
            if(array_key_exists("BODY", $arFields) && substr($arFields["ITEM_ID"], 0, 1) != "S") // Только для элементов
            {
                $arFields["BODY"] = "";
            }

            if (substr($arFields["ITEM_ID"], 0, 1) == "S") // Только для разделов
            {
                $arFields['TITLE'] = "";
                $arFields["BODY"] = "";
                $arFields['TAGS'] = "";
            }
        }

        return $arFields;
    }
}

class MyClass {

	public static function OnStoreProductUpdateHandler($id, $arFields){
		updateWholesale($arFields["PRODUCT_ID"]);
		// print_r($arFields);
		// die();
	}

	// При обновлении пресета скидки
	public static function DiscountOnAfterUpdateHandler($id, $arFields){
		global $DB;
		// Получаем ID товаров и ID разделов со ВСЕХ скидок
		$arDiscounts = getDiscountProducts();

		// Если скидка указана у разделов, то получаем все товары разделов
		if( count($arDiscounts["SECTIONS"]) ){
			$arSelect = Array("ID");
			$arFilter = Array("IBLOCK_ID"=>1, "SECTION_ID"=>$arDiscounts["SECTIONS"][0], "ACTIVE" => "Y", "INCLUDE_SUBSECTIONS" => "Y");
			$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1000000), $arSelect);
			while($ob = $res->GetNextElement()){
				$arFields = $ob->GetFields();
				$arDiscounts["PRODUCTS"][] = $arFields["ID"];
			}
		}

		// Получаем ID товаров, у которых проставлено свойство «Товар со скидкой»
		$arSelect = Array("ID");
		$arFilter = Array("IBLOCK_ID"=>1, "ACTIVE" => "Y", "PROPERTY_SALE" => 79);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1000000), $arSelect);
		$ids = array();
		while($ob = $res->GetNextElement()){
			$arFields = $ob->GetFields();
			$ids[] = $arFields["ID"];
		}

		// ID товаров, у которых надо убрать галочку «Товар со скидкой»
		$deleteIDs = array_diff($ids, $arDiscounts["PRODUCTS"]);

		// Убираем галочку «Товар со скидкой»
		if( count($deleteIDs) ){
			$sql = "DELETE FROM `b_iblock_element_property` WHERE `IBLOCK_PROPERTY_ID` = 22 AND `IBLOCK_ELEMENT_ID` IN (".implode(",", $deleteIDs).")";
			$res = $DB->Query($sql, false);
			// var_dump($res->result);
		}

		// ID товаров, которым надо проставить галочку «Товар со скидкой»
		$addIDs = array_diff($arDiscounts["PRODUCTS"], $ids);

		// Проставляем галочку «Товар со скидкой»
		if( count($addIDs) ){
			$values = array();
			foreach ($addIDs as $key => $id) {
				array_push($values, "(22,$id,79,'text',79,NULL,NULL)");
			}

			$sql = "INSERT INTO `b_iblock_element_property`(`IBLOCK_PROPERTY_ID`, `IBLOCK_ELEMENT_ID`, `VALUE`, `VALUE_TYPE`, `VALUE_ENUM`, `VALUE_NUM`, `DESCRIPTION`) VALUES ".implode(",", $values);
			$res = $DB->Query($sql, false);
			// var_dump($res->result);
		}
	}

	function OnAfterUserLoginHandler(&$fields){
		global $USER;
        // если логин не успешен то
        // var_dump($fields);
        // die();
        if($fields['USER_ID'] == 0 && !$_SESSION["EMAIL_TRY"] ){
        	// echo "string";
        	$_SESSION["EMAIL_TRY"] = true;

        	// if( $_SESSION["CHECK_OLD_AUTH"] ){
        	// 	unset($_SESSION["CHECK_OLD_AUTH"]);
        	// }else{
        		// $_SESSION["CHECK_OLD_AUTH"] = true;

	        	// ищем пользователя по логину
	            $rsUser = CUser::GetByLogin($fields['LOGIN']);
	            // и если нашли, то
	            if (!($arUser = $rsUser->Fetch())){
                    $arUser = getUserByEmail($fields['LOGIN']);
                    // var_dump($arUser);
                    // die();
	            }

	            // var_dump($arUser);
                    // die();

                if( isset($arUser["ID"]) ){
                    // if (!is_object($USER)){
                    // 	$USER = new CUser;
                    // }
                    // var_dump($USER);
                    // die();
                    // vardump($arUser);
                    // vardump($fields);
                    // die();
                    $arRes = letsLogin($arUser['LOGIN'], $fields["PASSWORD"]);
                    if( $arRes ){
                    	$arFields['RESULT_MESSAGE'] = array("TYPE" => "OK", "MESSAGE" => "");
                    	$_SESSION["EMAIL_TRY"] = false;
                    }else{
                    	$arFields['RESULT_MESSAGE'] = array("TYPE" => "ERROR", "MESSAGE" => "Неверный логин или пароль");
                    }
                    // vardump($arRes);
                    // die();

                    // if( $_SESSION["AUTHORIZE_FAILURE_COUNTER"] >= 2 ){
                    // }else{
                        // $arFields['RESULT_MESSAGE'] = array("TYPE" => "OK", "MESSAGE" => "");
                    // }
                    // unset($_SESSION["AUTHORIZE_FAILURE_COUNTER"]);
                }
        	// }
        }else{
        	$_SESSION["EMAIL_TRY"] = false;
        }
    }

	// public static function OnAfterIBlockElementUpdateHandler($arFields){
 //    	global $GLOBALS;

 //    	if( $arFields["IBLOCK_ID"] == 1 ){
 //    		updateWholesale($arFields["ID"]);
 //    	}
 //    }

 //    public static function OnAfterIBlockElementAddHandler($arFields){
 //    	global $GLOBALS;

 //    	if( $arFields["IBLOCK_ID"] == 1 ){
 //    		updateWholesale($arFields["ID"]);
 //    	}
 //    }
	function OnOrderAddHandler($ID, $arFields){ 

		$date = date("Y-m-d", strtotime($arFields["ORDER_PROP"][8]));

		$arSelect = Array("ID");
		$arFilter = Array("IBLOCK_ID"=>8, "PROPERTY_ORDER_DATE" => $date);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1000), $arSelect);

		while($ob = $res->GetNextElement()){
			$arFields = $ob->GetFields();
			updateOrderDate($arFields['ID']);
		}
	}

	function OnOrderDeleteHandler($ID, $success){

		updateOrderDate();

	}
	function OnBeforeUserAddHandler(&$arFields){

		// vardump($arFields);

	}

	function OnBeforeUserUpdateHandler(&$arParams){

		$newDiscount = $arParams["PERSONAL_WWW"];
		$oldDiscount = $arParams["PERSONAL_ICQ"];

		if ($newDiscount != $oldDiscount) {
			// vardump($arParams);
			// if(updateUserDiscount($arFields['ID'], $newDiscount)){
			// 	die();
			// 	$arParams["PERSONAL_ICQ"] = $arParams["PERSONAL_WWW"];
			// }

		}
    }
}

function letsLogin($login, $password){
	$USER = new CUser;

	return $USER->Login($login, $password);
}

function getUserByEmail($email){
	global $USER;

	$filter = Array("EMAIL" => $email);
	$rsUsers = CUser::GetList(($by = "NAME"), ($order = "desc"), $filter);
	if($arUser = $rsUsers->Fetch()) {
		return $arUser;
	}
	return false;
}

function getOrderCountInDate($date){

	$arFilter = Array("PROPERTY_VAL_BY_CODE_DELIVERY_DATE" => date($date), "CANCELED" => "N");
	$count = CSaleOrder::GetList(array("DATE_INSERT" => "ASC"), $arFilter, array());

	return $count;
}

function OnOrderUpdateHandler($ID, $arFields){ 
	file_put_contents("/order.html", $arFields);
}

function updateWholesale($itemID){
	$prices = getPrices($itemID);

	if( count($prices) > 1 ){
		CIBlockElement::SetPropertyValuesEx($itemID, false, array("WHOLESALE" => 78));
	}else{
		CIBlockElement::SetPropertyValuesEx($itemID, false, array("WHOLESALE" => NULL));
	}
}

function getPrices($itemID){
	$db_res = CPrice::GetList(
        array(),
        array("PRODUCT_ID" => $itemID)
    );
    $prices = array();
	while ($ar_res = $db_res->Fetch()) {
	    array_push($prices, $ar_res);
	}

	return $prices;
}

function getParam($param){

	$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", "IBLOCK_ID", "CODE");
	$arFilter = Array("IBLOCK_ID"=>5, "ACTIVE"=>"Y");

	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1000), $arSelect);

	while($ob = $res->GetNextElement()){
		$arFields = $ob->GetFields();
		$arProps = $ob->GetProperties();
		$arItem[$arFields["CODE"]] = array(
			"ID" => $arFields["ID"],
			"VALUE" => $arProps["PARAM_VALUE"]['VALUE'],
			"DESCRIPTION" => $arFields["PREVIEW_TEXT"],
		);
	}
		
	if (isset($arItem[$param])) {
		return $arItem[$param];
	} else { 
		return NULL;
	}
}

function setParam($param, $value){

	$item = getParams($param);

	if (CIBlockElement::SetPropertyValuesEx($item['ID'], false, array("PARAM_VALUE" => $value))) {
		echo "1";
	} else {
		echo "0";
	}

}

function getBasketCount(){
	CModule::IncludeModule("sale");

	$basket = Bitrix\Sale\Basket::loadItemsForFUser(Bitrix\Sale\Fuser::getId(), "s1");
	$basketItems = $basket->getBasketItems();

	$GLOBALS["BASKET_ITEMS"] = array();

	foreach ($basketItems as $key => $item) {
		$arItem = array(
			"BASKET_ID" => $item->getId(),
			"PRODUCT_ID" => $item->getProductId(),
			"QUANTITY" => $item->getQuantity(),
		);

		$GLOBALS["BASKET_ITEMS"][ $arItem["PRODUCT_ID"] ] = $arItem;
	}

	$order = Bitrix\Sale\Order::create("s1", \Bitrix\Sale\Fuser::getId());
	$order->setPersonTypeId(1);
	$order->setBasket($basket);

	$discounts = $order->getDiscount();
	$res = $discounts->getApplyResult();

	return array(
		"count" => array_sum($basket->getQuantityList()),
		"sum" => number_format( $order->getPrice(), 0, ',', ' ' )
	);
}

function isMobile(){
	$useragent = $_SERVER['HTTP_USER_AGENT'];
	
	return (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)));
}

function getReviewCount(){
	global $USER;
	global $DB;

	// Неделю назад
	$time = time() - 7*24*60*60;
	$userID = (isAuth())?$USER->GetID():0;

	$arSelect = Array("ID");
	$arFilter = Array("IBLOCK_ID"=>array(2,3), "ACTIVE" => "Y", "CODE" => $userID, ">=DATE_CREATE" => date($DB->DateFormatToPHP(CLang::GetDateFormat("SHORT")), mktime(0,0,0,date('m', $time), date('d', $time), date('Y', $time))));

	$res = CIBlockElement::GetList(Array(), $arFilter, array(), $arSelect);
	
	return $res;
}

function getSectionChain(){
	CModule::IncludeModule('iblock');

	if( isset($_REQUEST["SECTION_CODE"]) ){
		$GLOBALS["SECTIONS"] = array();

		$rsSections = CIBlockSection::GetList(array(),array('IBLOCK_ID' => 1, '=CODE' => $_REQUEST["SECTION_CODE"]));
		if ($arSection = $rsSections->Fetch()){
			$nav = CIBlockSection::GetNavChain(1, $arSection['ID']);
			while($section = $nav->GetNext()){
				array_push($GLOBALS["SECTIONS"], array(
					"ID" => $section["ID"],
					"NAME" => $section["NAME"],
					"CODE" => $section["CODE"],
				));
			}
			if( count($GLOBALS["SECTIONS"]) ){
				$GLOBALS["SECTION_ID"] = $GLOBALS["SECTIONS"][ count($GLOBALS["SECTIONS"]) - 1 ]["ID"];
			}
		}
	}
}

function isSectionActive($sectionID){
	foreach ($GLOBALS["SECTIONS"] as $key => $arSection) {
		if( $arSection["ID"] == $sectionID ){
			return true;
		}
	}

	return false;
}

function getSectionByID($iblockID, $sectionID, $props = array()){
	$arFilter = array('IBLOCK_ID'=>$iblockID, 'GLOBAL_ACTIVE'=>'Y', "ID" => $sectionID);
	$arSelect = array("IBLOCK_ID", "PICTURE", "NAME", "DESCRIPTION");
	if( count($props) ){
		$arSelect = array_merge($arSelect, $props);
	}
	$db_list = CIBlockSection::GetList(Array("ID" => "desc"), $arFilter, true, $arSelect, array("nPageSize" => 1));
	if($arSection = $db_list->GetNext()){
		return $arSection;
	}else{
		return false;
	}
}

function addRecently($id){
	if( !isset( $_SESSION["RECENTLY"] ) ){
		$_SESSION["RECENTLY"] = array();
	}

	if( ($index = array_search($id, $_SESSION["RECENTLY"])) !== false ){
		unset( $_SESSION["RECENTLY"][$index] );
		$_SESSION["RECENTLY"] = array_values($_SESSION["RECENTLY"]);
	}

	array_unshift($_SESSION["RECENTLY"], $id);

	$_SESSION["RECENTLY"] = array_slice($_SESSION["RECENTLY"], 0, 21);
}

function getRecently($without = NULL){
	$out = array();

	if( isset( $_SESSION["RECENTLY"] ) ){
		$out = $_SESSION["RECENTLY"];

		if( $without !== NULL && ($index = array_search($without, $out)) !== false ){
			unset( $out[$index] );
			$out = array_values($out);
		}
	}

	return $out;
}

function plural_form($number, $after) {
   $cases = array (2, 0, 1, 1, 1, 2);
   return $after[ ($number%100>4 && $number%100<20)? 2: $cases[min($number%10, 5)] ];
}

function getRusMonth($i){
   $array = array("января","февраля","марта","апреля","мая","июня","июля","августа","сентября","октября","ноября","декабря");
   return $array[$i-1];
}

function getRusDayOfWeek($i){
   $array = array("Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота");
   return $array[$i];
}

function getRating($id){
	$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", "IBLOCK_ID", "CODE");
	$arFilter = Array("IBLOCK_ID"=>2, "PROPERTY_PRODUCT_ID"=>$id, "ACTIVE"=>"Y");
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1000), $arSelect);
	$count = 0;
	$sum = 0;
	while($ob = $res->GetNextElement()){
		$arFields = $ob->GetFields();
		$count++;
		$sum += intval($arFields["CODE"]);
	}

	return array(
		"COUNT_REVIEWS" => $count,
		"AVERAGE_RATING" => round($sum/$count),
	);
}

function detailPageUrl($url){
	if( $GLOBALS["isWholesale"] ){
		return str_replace("/catalog/", "/wholesale/", $url);
	}
	if( $GLOBALS["isSale"] ){
		return str_replace("/catalog/", "/sale/", $url);
	}
	return $url;
}

function getElementByID($iblockID, $elementID, $props = false){
	$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", "DETAIL_PAGE_URL", "PREVIEW_TEXT", "DETAIL_TEXT", "PREVIEW_PICTURE");
	$arFilter = Array("IBLOCK_ID"=>$iblockID, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "ID" => $elementID);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);

	if($ob = $res->GetNextElement()){
		$arFields = $ob->GetFields();

		if( $props ){
			$arFields["PROPERTIES"] = $ob->GetProperties();
		}

		return $arFields;
	}

	return false;
}

function getSimilarFilter($itemID, $sectionID, $pageSize = 16, $similarIDs = array()){
	if( count($similarIDs) >= $pageSize ){
		return $similarIDs;
	}

	$arSelect = Array("ID", "NAME");
	$arFilter = Array("IBLOCK_ID"=>1, "SECTION_ID"=>$sectionID, "ACTIVE"=>"Y", "!ID" => $itemID);
	$res = CIBlockElement::GetList(Array("RAND" => "ASC"), $arFilter, false, Array("nPageSize"=>$pageSize - count($similarIDs) ), $arSelect);
	while($ob = $res->GetNextElement()){
		$arFields = $ob->GetFields();
		array_push($similarIDs, $arFields["ID"]);
	}

	return $similarIDs;
}

function getSaleFilter(){
    global $DB;

    $arDiscountElementID = array();
    $dbProductDiscounts = CCatalogDiscount::GetList(
       array("SORT" => "ASC"),
       array(
          "ACTIVE" => "Y",
          "!>ACTIVE_FROM" => $DB->FormatDate(date("Y-m-d H:i:s"),
                "YYYY-MM-DD HH:MI:SS",
                CSite::GetDateFormat("FULL")),
          "!<ACTIVE_TO" => $DB->FormatDate(date("Y-m-d H:i:s"),
                "YYYY-MM-DD HH:MI:SS",
                CSite::GetDateFormat("FULL")),
       ),
       false,
       false,
       array(
          "ID", "SITE_ID", "ACTIVE", "ACTIVE_FROM", "ACTIVE_TO",
          "RENEWAL", "NAME", "SORT", "MAX_DISCOUNT", "VALUE_TYPE",
          "VALUE", "CURRENCY", "PRODUCT_ID"
       )
    );

    $dbProductDiscounts = CCatalogDiscount::GetList(
	    array("SORT" => "ASC"),
	    array(
	            // "+PRODUCT_ID" => $PRODUCT_ID,
	            "ACTIVE" => "Y",
	            "!>ACTIVE_FROM" => $DB->FormatDate(date("Y-m-d H:i:s"), 
	                                               "YYYY-MM-DD HH:MI:SS",
	                                               CSite::GetDateFormat("FULL")),
	            "!<ACTIVE_TO" => $DB->FormatDate(date("Y-m-d H:i:s"), 
	                                             "YYYY-MM-DD HH:MI:SS", 
	                                             CSite::GetDateFormat("FULL")),
	            "COUPON" => ""
	        ),
	    false,
	    false,
	    array(
	            "ID", "SITE_ID", "ACTIVE", "ACTIVE_FROM", "ACTIVE_TO", 
	            "RENEWAL", "NAME", "SORT", "MAX_DISCOUNT", "VALUE_TYPE", 
	    "VALUE", "CURRENCY", "PRODUCT_ID"
	        )
	    );
	while ($arProductDiscounts = $dbProductDiscounts->Fetch())
	{
	    echo "string";
	}

    while ($arProductDiscounts = $dbProductDiscounts->Fetch())
    {
       if($res = CCatalogDiscount::GetDiscountProductsList(array(), array(">=DISCOUNT_ID" => $arProductDiscounts['ID']), false, false, array())){
          while($ob = $res->GetNext()){
             if(!in_array($ob["PRODUCT_ID"],$arDiscountElementID))
                $arDiscountElementID[] = $ob["PRODUCT_ID"];
          }}
    }

    return $arDiscountElementID;
} 

function getSeason(){
	$seasons = array(
		1 => "winter",
		2 => "winter",
		3 => "spring",
		4 => "spring",
		5 => "spring",
		6 => "summer",
		7 => "summer",
		8 => "summer",
		9 => "autumn",
		10 => "autumn",
		11 => "autumn",
		12 => "winter",
	);
	return $seasons[ intval(date("m")) ];
}

function isAuth(){
	global $USER;
	return $USER->IsAuthorized();
}

function getAllDiscounts()
{   
   	Bitrix\Main\Loader::includeModule('sale');
    require_once ($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sale/handlers/discountpreset/simpleproduct.php");

    $arDiscounts = array();
    $arProductDiscountsObject = \Bitrix\Sale\Internals\DiscountTable::getList(array(
        'filter' => array(
            // 'ID' => 1231,
        ),
        'select' => array(
            "*"
       	)
    ));

    while( $arProductDiscounts = $arProductDiscountsObject->fetch() ){
    	$discountObj = new Sale\Handlers\DiscountPreset\SimpleProduct();
    	$discount = $discountObj->generateState($arProductDiscounts);

    	// print_r($discount);
    	// echo "<br>";
    	// echo "<br>";

    	array_push($arDiscounts, array(
    		"PRODUCTS" => $discount['discount_product'],
		    "TYPE" => $discount['discount_type'],
		    "SECTIONS" => $discount['discount_section'],
		    "VALUE" => $discount['discount_value'],
    	));
    }

    return $arDiscounts;
}

function getDiscountProducts(){
	$arDiscounts = getAllDiscounts();

	$out = array(
		"PRODUCTS" => array(),
		"SECTIONS" => array()
	);
	$sections = array();
	foreach ($arDiscounts as $key => $arDiscout) {
		if( isset( $arDiscout["PRODUCTS"] ) && count($arDiscout["PRODUCTS"]) ){
			$out["PRODUCTS"] = array_merge($out["PRODUCTS"], $arDiscout["PRODUCTS"]);
		}
		if( isset( $arDiscout["SECTIONS"] ) && count($arDiscout["SECTIONS"]) ){
			$out["SECTIONS"] = array_merge($out["SECTIONS"], $arDiscout["SECTIONS"]);
		}
	}

	return $out;
}

function getNewItems($count){
	$out = array();
	$arSelect = Array("ID");
	$arFilter = Array("IBLOCK_ID"=>1, "ACTIVE" => "Y");
	$res = CIBlockElement::GetList(Array("CREATED_DATE" => "DESC"), $arFilter, false, Array("nPageSize"=>$count), $arSelect);
	while($ob = $res->GetNextElement()){
		$arFields = $ob->GetFields();
		$out[] = $arFields["ID"];
	}
	return $out;
}

function updateStore($productID, $weight, $quantity, $amount){
	Cmodule::IncludeModule('catalog');

	$weight = floatval($weight)*1000;

	$arFields = array(
	    "PRODUCT_ID" => $productID,
	    "STORE_ID" => 1,
	    "AMOUNT" => $amount,
	);

	$ID = CCatalogStoreProduct::UpdateFromForm($arFields);

	\Bitrix\Main\Loader::includeModule('catalog'); 
	$obProduct = new CCatalogProduct(); 

	$arFields = array(
		'QUANTITY' => $quantity,
		'WEIGHT' => $weight,
		'SUBSCRIBE' => 'D'
	);

	$result = $obProduct->Update($productID, $arFields); 

	return ($result && $ID)?true:false;

}

function vardump($array){
	echo "<pre>";
	var_dump($array);
	echo "</pre>";
}

function updateOrderDate($ID = 0){

	if ($ID == 0) {
		$arFilter = Array("IBLOCK_ID" => 8);
	} else {
		$arFilter = Array("IBLOCK_ID" => 8, "ID" => $ID);
	}

	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1000000), Array());

	while($ob = $res->GetNextElement()){
		$el = new CIBlockElement;
		$arFields = $ob->GetFields();
		$arProps = $ob->GetProperties();
		$orderCount = getOrderCountInDate($arProps['ORDER_DATE']["VALUE"]);
		$result = $el->Update($arFields['ID'], Array("CODE" => $orderCount));
	} 
}

// function updateUserDiscount($userID, $discountValue = null){

// 	$db_res = CSaleDiscount::GetList( array("SORT" => "ASC"), array("LID" => 's1'), false, false, array('ID', 'NAME','ACTIONS','CONDITIONS', 'XML_ID','USER_GROUPS'));

// 	$isUserRemoved = false;
// 	$discountID = 0;
// 	$arDiscount = array();
// 	$discountList = array();

// 	while ($discount = $db_res->Fetch()){

// 		if ($discount['XML_ID'] == "PERSONAL_DISCOUNT"){

// 			if ($discount['USER_GROUPS']) {
// 				$discount['USER_GROUPS'] = array($discount['USER_GROUPS']);
// 			} else {
// 				$discount['USER_GROUPS'] = array("2");
// 			}

// 			$discountList[] = $discount;
// 			$actions = unserialize($discount['ACTIONS']);
// 			$conditions = unserialize($discount['CONDITIONS']);
// 			$idList = $conditions['CHILDREN'][0]['DATA']['value'];

// 			if($actions["CHILDREN"][0]["DATA"]["Value"] == $discountValue && !isset($arDiscount['ID'])){
// 				$arDiscount = $discount;
// 			}

// 			if (!$isUserRemoved) {
// 				foreach ($idList as $key => $id) {
// 					if ($id == $userID) {

// 						unset($idList[$key]);
// 						$idList = array_unique($idList);

// 						$conditions['CHILDREN'][0]['DATA']['value'] = $idList;
// 						$discount['CONDITIONS'] = serialize($conditions);

// 						if (!CSaleDiscount::Update($discount['ID'], $discount)) { 
// 						    $ex = $APPLICATION->GetException();
// 						    vardump($ex->GetString());
// 						    die();
// 						    return false;
// 						} else {
// 							vardump('remove ok from dicsount id = '.$discount['ID']);
// 							$isUserRemoved = true;
// 							break;
// 						}
// 					}
// 				}
// 			}
// 		}
// 	}

// 	if(isset($arDiscount['ID'])){

// 		$conditions = unserialize($arDiscount['CONDITIONS']);

// 		$conditions['CHILDREN'][0]['DATA']['value'][] = $userID;
// 		$conditions['CHILDREN'][0]['DATA']['value'] = array_unique($conditions['CHILDREN'][0]['DATA']['value']);
// 		$arDiscount['CONDITIONS'] = serialize($conditions);
// 		global $APPLICATION;

// 		if (!CSaleDiscount::Update($arDiscount['ID'], $arDiscount)) { 
// 		    $ex = $APPLICATION->GetException();
// 		    vardump($ex->GetString());
// 		    die();
// 		    return false;
// 		} else {
// 			vardump('update ok to discount id = '.$arDiscount['ID']);
// 			die();
// 			return true;
// 		}

// 	} else {

// 		CModule::IncludeModule('catalog');
// 		global $APPLICATION;

// 		$arDiscount = array(
// 			"LID" => "s1",
// 			"SITE_ID" => "s1",
// 			"NAME"=> "Персональная скидка ".$discountValue."%",
// 		    'ACTIVE' => 'Y',
// 		    'LAST_DISCOUNT' => 'N',
// 		    'LAST_LEVEL_DISCOUNT' => 'N',
// 		    'CURRENCY' => 'RUB',
// 		    'VALUE' => $discountValue,
// 		);

// 		if (!empty($discountList)) {
// 			$arDiscount += $discountList[count($discountList)-1];
// 		}

// 		unset($arDiscount['ID']);

// 		$actions = unserialize($arDiscount['ACTIONS']);
// 		$actions["CHILDREN"][0]["DATA"]["Value"] = floatval($discountValue);

// 		$conditions = unserialize($arDiscount['CONDITIONS']);
// 		$conditions['CHILDREN'][0]['DATA']['value'] = array($userID);

// 		$arDiscount['CONDITIONS'] = $conditions;
// 		$arDiscount['ACTIONS'] = $actions;

// 		if (!CSaleDiscount::Add($arDiscount)) { 
// 	    	$ex = $APPLICATION->GetException();
// 	    	vardump($ex->GetString());
// 	    	die();
// 	    	return false;
// 		} else {
// 			vardump('add ok');
// 			die();
// 			return true;
// 		}
// 	}
// }

getSectionChain();

?>