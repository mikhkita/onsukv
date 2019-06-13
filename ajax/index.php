<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
// use Bitrix\Sale;

\Bitrix\Main\Data\StaticHtmlCache::getInstance()->markNonCacheable();

$GLOBALS['APPLICATION']->RestartBuffer();

$action = (isset($_GET["action"]))?$_GET["action"]:NULL;
$action = (isset($_GET["actions"]))?$_GET["actions"]:$action;
$review_id = (isset($_GET["review_id"]))?$_GET["review_id"]:NULL;
$product_id = (isset($_GET["product_id"]))?$_GET["product_id"]:NULL; // id товара для отзыва
$isBasket = isset($_GET["basket"]);
$hashKey = 481516;

switch ($action) {
	case 'BUY':
	case 'ADD2BASKET':
		$productId = $_GET["ELEMENT_ID"];
		$quantity = (isset($_GET["quantity"]))?$_GET["quantity"]:1;

		if (CModule::IncludeModule("catalog")){
		    if (($action == "ADD2BASKET" || $action == "BUY")){
		        Add2BasketByProductID(
	                $productId,
	                $quantity
	            );
		    }
		}
			
		$result = getBasketCount();

		if( isset($_GET["gift"]) ){
			$result["action"] = "reload";
		}

		returnSuccess( $result );

		// // if ($ex = $APPLICATION->GetException())
		// // echo $ex->GetString();
		// // die();
		
		// $APPLICATION->IncludeComponent("bitrix:sale.basket.basket", "mini-cart", Array(
		// 	"ACTION_VARIABLE" => "actionsss",	// Название переменной действия
		// 		"AUTO_CALCULATION" => "Y",	// Автопересчет корзины
		// 		"COLUMNS_LIST" => array(	// Выводимые колонки
		// 			0 => "NAME",
		// 			1 => "DISCOUNT",
		// 			2 => "WEIGHT",
		// 			3 => "DELETE",
		// 			4 => "DELAY",
		// 			5 => "TYPE",
		// 			6 => "PRICE",
		// 			7 => "QUANTITY",
		// 		),
		// 		"CORRECT_RATIO" => "N",	// Автоматически рассчитывать количество товара кратное коэффициенту
		// 		"HIDE_COUPON" => "N",	// Спрятать поле ввода купона
		// 		"PATH_TO_ORDER" => "/personal/order.php",	// Страница оформления заказа
		// 		"PRICE_VAT_SHOW_VALUE" => "N",	// Отображать значение НДС
		// 		"QUANTITY_FLOAT" => "N",	// Использовать дробное значение количества
		// 		"SET_TITLE" => "N",	// Устанавливать заголовок страницы
		// 		"TEMPLATE_THEME" => "blue",	// Цветовая тема
		// 		"USE_ENHANCED_ECOMMERCE" => "N",	// Отправлять данные электронной торговли в Google и Яндекс
		// 		"USE_GIFTS" => "N",	// Показывать блок "Подарки"
		// 		"USE_PREPAYMENT" => "N",	// Использовать предавторизацию для оформления заказа (PayPal Express Checkout)
		// 	),
		// 	false
		// );

		// if( $isBasket ){
			// LocalRedirect("basket.php");
		// }else{
		// $APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line", "mini", Array(
		// 		"HIDE_ON_BASKET_PAGES" => "Y",	// Не показывать на страницах корзины и оформления заказа
		// 		"PATH_TO_BASKET" => SITE_DIR."personal/cart/",	// Страница корзины
		// 		"PATH_TO_ORDER" => SITE_DIR."personal/order/make/",	// Страница оформления заказа
		// 		"PATH_TO_PERSONAL" => SITE_DIR."personal/",	// Страница персонального раздела
		// 		"PATH_TO_PROFILE" => SITE_DIR."personal/",	// Страница профиля
		// 		"PATH_TO_REGISTER" => SITE_DIR."login/",	// Страница регистрации
		// 		"POSITION_FIXED" => "N",	// Отображать корзину поверх шаблона
		// 		"SHOW_AUTHOR" => "N",	// Добавить возможность авторизации
		// 		"SHOW_EMPTY_VALUES" => "Y",	// Выводить нулевые значения в пустой корзине
		// 		"SHOW_NUM_PRODUCTS" => "Y",	// Показывать количество товаров
		// 		"SHOW_PERSONAL_LINK" => "Y",	// Отображать персональный раздел
		// 		"SHOW_PRODUCTS" => "Y",	// Показывать список товаров
		// 		"SHOW_TOTAL_PRICE" => "Y",	// Показывать общую сумму по товарам
		// 		"MY_AJAX" => "Y"
		// 	),
		// 	false
		// );
		// }
		break;

	case 'REMOVE':
		if( !isset($_GET["ELEMENT_ID"]) ){
			returnError("Не указан ID товара");
		}
		$productId = $_GET["ELEMENT_ID"];

		//Получение корзины текущего пользователя
		$basket = \Bitrix\Sale\Basket::loadItemsForFUser(
		   \Bitrix\Sale\Fuser::getId(), 
		   \Bitrix\Main\Context::getCurrent()->getSite()
		);

		// Получение товара корзины по ID товара
		if( !$basket->getItemById($productId)->delete() ){
			returnError("Не найден товар с ID равным ".$productId);
		}	

		//Сохранение изменений
		if( $basket->save() ){
			$result = "error";
			returnSuccess(array(
				"sum" => number_format( getBasketSum(), 0, ',', ' ' )
			));
		}else{
			returnError("Ошибка сохранения товара");
		}
		break;

	case 'QUANTITY':
		// sleep(rand(1, 3));

		if( !isset($_GET["ELEMENT_ID"]) ){
			returnError("Не указан ID товара");
		}
		if( !isset($_GET["QUANTITY"]) ){
			returnError("Неверно передно количество");
		}
		$productId = $_GET["ELEMENT_ID"];
		$quantity = $_GET["QUANTITY"];

		//Получение корзины текущего пользователя
		$basket = \Bitrix\Sale\Basket::loadItemsForFUser(
		   \Bitrix\Sale\Fuser::getId(), 
		   \Bitrix\Main\Context::getCurrent()->getSite()
		);

		foreach ($basket as $basketItem) {
		    if( $basketItem->getProductId() == $productId ){
		    	if( intval($quantity) == 0 ){
		    		if( $basketItem->delete() && $basket->save() ){
		    			$basketInfo = getBasketCount();
		    			returnSuccess(array(
							"id" => $productId,
							"quantity" => 0,
							"count" => $basketInfo["count"],
							"sum" => $basketInfo["sum"],
						));
		    		}else{
		    			returnError("Ошибка удаления товара из корзины");
		    		}
		    	}else{
		    		$basketItem->setField("QUANTITY", $quantity);

			    	// Сохранение изменений
			    	if( $basketItem->save() ){
			    		$basketInfo = getBasketCount();
			    		returnSuccess(array(
							"id" => $productId,
							"quantity" => intval($basketItem->getField("QUANTITY")),
							"count" => $basketInfo["count"],
							"sum" => $basketInfo["sum"],
						));
			    	}else{
			    		returnError("Не удалось сохранить товар");
			    	}
		    	}
		    }
		}

		if (CModule::IncludeModule("catalog")){
	        Add2BasketByProductID(
                $productId,
                $quantity
            );

	        $basketInfo = getBasketCount();
            returnSuccess(array(
				"id" => $productId,
				"quantity" => $quantity,
				"count" => $basketInfo["count"],
				"sum" => $basketInfo["sum"],
			));
		}

		returnError("Не найден товар с ID равным ".$productId);

		break;
	case 'ADDREVIEW':

		if ($_POST["MAIL"] == ""){
			$spam = false;
		}else{
			$spam = true;
		}

		if (!$spam) {
			CModule::IncludeModule("iblock");
			$el = new CIBlockElement;

			$PROP = array();

			$PROP["EMAIL"]['VALUE'] = $_POST["email"];
			$PROP["PHONE"]['VALUE'] = $_POST["phone"];
			$userID = $USER->GetID()?$USER->GetID():"";
			
			if ($product_id) {

				$PROP["PRODUCT_ID"]['VALUE'] = $product_id;
				$PROP["RATING"]['VALUE'] = $_POST["item-quality"];

				$arLoadProductArray = Array(
				  "IBLOCK_ID"      => 2,
				  "PROPERTY_VALUES"=> $PROP,
				  "NAME"           => $_POST["name"],
				  "CODE"		   => $userID,
				  "ACTIVE"         => "Y",
				  "PREVIEW_TEXT"   => $_POST['comment'],
				  "DATE_ACTIVE_FROM" => ConvertTimeStamp(time(), "FULL"),
				  "PREVIEW_PICTURE" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/upload/tmp/".$_POST["random_filename"])
				);

			} else {

				$PROP["STORE_QUALITY"]['VALUE'] = $_POST["store-quality"];
				$PROP["GOODS_QUALITY"]['VALUE'] = $_POST["goods-quality"];
				$PROP["MANAGER_QUALITY"]['VALUE'] = $_POST["manager-quality"];
				$PROP["PACK_QUALITY"]['VALUE'] = $_POST["pack-quality"];
				$PROP["COURIER_QUALITY"]['VALUE'] = $_POST["courier-quality"];

				$round = round(($_POST["store-quality"] + $_POST["goods-quality"] + $_POST["manager-quality"] + $_POST["pack-quality"] + $_POST["courier-quality"])/5);

				$arLoadProductArray = Array(
				  "IBLOCK_SECTION_ID" => $review_id,
				  "IBLOCK_ID"      => 3,
				  "PROPERTY_VALUES"=> $PROP,
				  "NAME"           => $_POST["name"],
				  "CODE"		   => $round,
				  "ACTIVE"         => "Y",
				  "PREVIEW_TEXT"   => $_POST['comment'],
				  "DATE_ACTIVE_FROM" => ConvertTimeStamp(time(), "FULL")
				);

			}

			if (isAuth()) {
				$arLoadProductArray['MODIFIED_BY'] = $USER->GetID();
				$arLoadProductArray['NAME'] = $USER->GetFullName();
			}
			
			if ($id = $el->Add($arLoadProductArray)) {

				if ($product_id) {
					$href = "http://vkus.ca03222.tmweb.ru/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=2&type=content&ID=".$id."&lang=ru&find_section_section=-1&WF=Y";
				} else {
					$href = "http://vkus.ca03222.tmweb.ru/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=3&type=content&ID=".$id."&lang=ru&find_section_section=".$review_id ."&WF=Y";
				}

				$message = "";
				$name = isAuth()?$USER->GetFullName():$_POST["name"];
				$email = isAuth()?$USER->GetEmail():$_POST["email"];
				$mark = isset($round)?$round:$_POST["item-quality"];

				$message .= "От кого: ".$name."<br>";
				// $message .= "e-mail: ".$email."<br>";

				if (!isAuth()) {
					$message .= "Номер телефона: ".$_POST["phone"]."<br>";
				}

				$message .= "Отзыв: ".$_POST['comment']."<br>";
				$message .= "Оценка: ".$mark."<br>";
				$message .= "<a href='".$href."'>Ссылка на отзыв</a>";


				if(CEvent::Send("NEW_REVIEW", "s1", array("MESSAGE" => $message))){
					echo "1";
				} else {
					echo "0";
				}
			}
		}else{
			echo "1";
		}

		break;

	case 'ASK':

		if ($_POST["MAIL"] == ""){
			$spam = false;
		} else {
			$spam = true;
		}

		if (!$spam) {

			$name = $_POST['name'];
			$email = $_POST['email'];
			$phone = $_POST['phone'];
			$question = $_POST['question'];

			if(CEvent::Send("NEW_ASK", "s1", array('NAME' => $name, 'EMAIL' => $email, 'PHONE' => $phone, 'QUESTION' => $question,))){
				echo "1";
			} else {
				echo "0";
			}
		}else{
			echo "1";
		}

		break;

	case 'PHONE':

		if ($_POST["MAIL"] == ""){
			$spam = false;
		} else {
			$spam = true;
		}

		if (!$spam) {

			$name = $_POST['name'];
			$phone = $_POST['phone'];

			if(CEvent::Send("NEW_PHONE", "s1", array('NAME' => $name, 'PHONE' => $phone))){
				echo "1";
			} else {
				echo "0";
			}
		}else{
			echo "1";
		}

		break;
	case 'REG':

		if ($_POST["MAIL"] == ""){
			$spam = false;
		} else {
			$spam = true;
		}

		if (!$spam) {

			$filter = Array("EMAIL" => $_POST['email']);
			$rsUser = CUser::GetList(($by="id"), ($order="desc"), $filter);
			$arUser = $rsUser->Fetch();

			if(!$arUser){

				$email = $_POST['email'];
				$password = $_POST['password'];
				$user = new CUser;
				$hash = md5($email.$hashKey);
				$link = "http://vkus.ca03222.tmweb.ru/ajax/?action=CONFIRM_USER&email=".$email."&hash=".$hash;

				$arFields = Array(
				  // "NAME"              => "Пользователь",
				  "EMAIL"             => $email,
				  "LOGIN"             => $email,
				  "LID"               => "ru",
				  "ACTIVE"            => "N",
				  "PASSWORD"          => $password,
				  "CONFIRM_PASSWORD"  => $password,
				);

				if ($user->Add($arFields)){
				    if(CEvent::Send("NEW_USER_CONFIRM", "s1", array('EMAIL' => $email, "LINK" => $link))){
						echo "1";
					} else {
						returnError("Ошибка регистрации.");
					}
				}
				else{
				    echo "0";
				}
			} else {
				returnError("Пользователь с таким E-mail уже зарегестрирован.");
			}
		}else{
			echo "0";
		}

		break;
	case 'CONFIRM_USER':

		$email = $_GET['email'];
		$userHash = $_GET['hash'];
		$hash = md5($email.$hashKey);

		if ($userHash == $hash) {

			$filter = Array("EMAIL" => $email);
			$rsUser = CUser::GetList(($by="id"), ($order="desc"), $filter);
			$arUser = $rsUser->Fetch();

			$user = new CUser;
			$fields = Array(
			  "ACTIVE" => "Y",
			);
			
			if ($user->Update($arUser["ID"], $fields)) {
				$USER->Authorize($arUser["ID"]);
			 	LocalRedirect("/personal/");
			} 
			else {
				LocalRedirect("/");
			}

		}	

		break;
	case 'ADD2RESERVE':
		$userID = $USER->GetID()?$USER->GetID():0;

		if ($userID != 0) {

			$arFilter = Array(
				"IBLOCK_ID" => 9,
				"ACTIVE_DATE" => "Y",
				"ACTIVE" => "Y",
				"CODE" => $_REQUEST["id"],
				"PROPERTY_USER_VALUE" => $userID,
			);

			$res = CIBlockElement::GetList(array(), $arFilter, array(), false, array());

			if (isset($res) && $res == 0) {

				$el = new CIBlockElement;

				$PROP["USER"]['VALUE'] = $userID;
				$name = str_replace("_", " ", $_REQUEST["name"]);

				$arLoadProductArray = Array(
				  "IBLOCK_ID"      => 9,
				  "PROPERTY_VALUES"=> $PROP,
				  "NAME"           => $name,
				  "CODE"           => $_REQUEST["id"],
				);

				if($PRODUCT_ID = $el->Add($arLoadProductArray))
				  echo "success";
				else
				  echo "error";
			} else {
				echo "already reserved";
			}
		}
		break;
	default:
		break;
}
die();

function returnError( $text ){
	echo json_encode(array(
		"result" => "error",
		"error" => $text
	));
	die();
}

function returnSuccess( $array ){
	$arResult = array(
		"result" => "success"
	);
	$arResult = $arResult + $array;

	echo json_encode($arResult);
	die();
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>