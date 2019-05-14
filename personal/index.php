<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Персональный раздел");


if( isset($_REQUEST["action"]) ){
	$APPLICATION->RestartBuffer();
	switch ($_REQUEST["action"]) {
		case "regSite":
			global $USER;
			$email = $_POST["reg_mail"];
			$password = $_POST["reg_pass"];
			$confirmPassword = $_POST["reg_pass2"];
			$post = $_POST["reg_post"];
			$uni = ($_POST['mod'] == "uni");
			$name = $_POST["reg_name"];

			if( $uni ){
				if( !$name ){
					echo json_encode(array('error' => array('reg_name' => 'Укажите ФИО'))); die();
				}
				if( !$email ){
					echo json_encode(array('error' => array('reg_mail' => 'Вы не ввели e-mail'))); die();
				}
				if( $password != $confirmPassword ){
					echo json_encode(array('error' => array('reg_pass' => 'Пароли не совпадают'))); die();
				}
				if( strlen($password) < 8 ){
					echo json_encode(array('error' => array('reg_pass' => 'Пароль не может быть меньше 8 символов'))); die();
				}
			}

			$arResult = $USER->Register($email, $name, "", $password, $confirmPassword, $email);

			if( $arResult["TYPE"] == "OK" ){
				$userId = intval($arResult["ID"]);

				$user = new CUser;
				$arFields = Array(
					"WORK_POSITION" => $post
				);

				$user->Update($userId, $arFields);

				if( $uni ){
					echo json_encode(array('success' => true, 'message' => 'Вы зарегистрировались. На вашу почту отправлено письмо для активации аккаунта.', 'action' => 'registration'));
				}else{
					echo json_encode(array(
						"error" => 0,
						"message" => "Вы зарегистрировались. На вашу почту отправлено письмо для активации аккаунта."
					));
				}
			}else{
				if( $uni ){
					echo json_encode(array('error' => array('reg_name' => $arResult["MESSAGE"])));
				}else{
					echo json_encode(array(
						"error" => 1,
						"message" => $arResult["MESSAGE"]
					));
				}
			}
			break;
		case "authSite":
			$APPLICATION->IncludeComponent(
				"bitrix:system.auth.form",
				"main",
				Array(
					"FORGOT_PASSWORD_URL" => "",
					"PROFILE_URL" => "/personal",
					"REGISTER_URL" => "",
					"SHOW_ERRORS" => "N"
				)
			);
			break;
		case "pwdSite":
			$login = $_REQUEST["pwd_mail"];

			$rsUser = CUser::GetByLogin($login);
			if( $arUser = $rsUser->Fetch() ){
				$hash = md5(rand().time());
				$data = array(
					"EMAIL" => $login,
					"USER_ID" => $arUser["ID"],
					"HASH" => $arUser["CHECKWORD"]
				);

				CEvent::Send("USER_PASS_REQUEST", "s1", $data);

				echo json_encode(array(
					"error" => 0,
					"message" => "На вашу почту отправлен новый пароль."
				));
			}else{
				echo json_encode(array(
					"error" => 1,
					"message" => "Введенный email не найден."
				));
			}
			break;
		case "updatePWD":
			$hash = $_REQUEST["hash"];
			$userId = $_REQUEST["user_id"];
			$newPass = $_REQUEST["new_pass"];

			$rsUser = CUser::GetByID($userId);
			$arUser = $rsUser->Fetch();

			if( $arUser["CHECKWORD"] == $hash ){
				$user = new CUser;
				$arFields = Array(
					"PASSWORD" => $newPass
				);

				if( $user->Update($userId, $arFields) ){
					echo json_encode(array(
						"error" => 0,
						"message" => "Пароль сохранён, войдите под новым паролем"
					));
				}else{
					echo json_encode(array(
						"error" => 1,
						// "message" => $arResult["MESSAGE"]
						"message" => "Ошибка смены пароля."
					));
				}
			}else{
				echo json_encode(array(
					"error" => 1,
					"message" => "Ошибка смены пароля."
				));
			}

			break;
		case "logout":
			$USER->Logout();
			LocalRedirect($_REQUEST["redirect"]);
			break;
		
		default:
			# code...
			break;
	}
	die();
}

if( isset($_REQUEST["confirm_registration"]) && $_REQUEST["confirm_registration"] == "yes" ){
	$APPLICATION->IncludeComponent(
		"bitrix:system.auth.confirmation",
		"main",
		Array(
			"CONFIRM_CODE" => "confirm_code",
			"LOGIN" => "login",
			"USER_ID" => "confirm_user_id"
		)
	);
}elseif( isset($_REQUEST["change_password"]) && $_REQUEST["change_password"] == "yes" ){
	$rsUser = CUser::GetByID($_REQUEST["user_id"]);
	$arUser = $rsUser->Fetch();
	if( $arUser["CHECKWORD"] != $_REQUEST["hash"] ){
		LocalRedirect("/personal");
	}
	$APPLICATION->SetTitle("Смена пароля");

	?>
		<!-- <div class="content-wide cf"> -->
		    <form action="" id="pwd_form" class="profile cf" method="POST">
	            <input type="hidden" name="hash" value="<?=$_REQUEST["hash"]?>">
	            <input type="hidden" name="user_id" value="<?=$_REQUEST["user_id"]?>">
	            <div class="form profile-data">
                    <p class="input cf">
                        <label for="profile-name" class="label">Введите новый пароль</label>
                        <input name="new_pass" type="password" class="textInput" autocomplete="off">
                    </p>
	            </div>       
	            <p class="submit">
	                <button class="btn" id="pwd_btn" type="submit">Сохранить</button>
	            </p>
		    </form>	
		<!-- </div> -->
	<?
}

?><?$APPLICATION->IncludeComponent(
	"bitrix:sale.personal.section",
	"main",
	Array(
		"ACCOUNT_PAYMENT_ELIMINATED_PAY_SYSTEMS" => array("0"),
		"ACCOUNT_PAYMENT_PERSON_TYPE" => "1",
		"ACCOUNT_PAYMENT_SELL_SHOW_FIXED_VALUES" => "Y",
		"ACCOUNT_PAYMENT_SELL_TOTAL" => array("100","200","500","1000","5000",""),
		"ACCOUNT_PAYMENT_SELL_USER_INPUT" => "Y",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ALLOW_INNER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHECK_RIGHTS_PRIVATE" => "N",
		"COMPATIBLE_LOCATION_MODE_PROFILE" => "N",
		"CUSTOM_PAGES" => "",
		"CUSTOM_SELECT_PROPS" => array(""),
		"MAIN_CHAIN_NAME" => "Мой кабинет",
		"NAV_TEMPLATE" => "",
		"ONLY_INNER_FULL" => "N",
		"ORDERS_PER_PAGE" => "20",
		"ORDER_DEFAULT_SORT" => "STATUS",
		"ORDER_HIDE_USER_INFO" => array("0"),
		"ORDER_HISTORIC_STATUSES" => array("F"),
		"ORDER_REFRESH_PRICES" => "N",
		"ORDER_RESTRICT_CHANGE_PAYSYSTEM" => array("0"),
		"PATH_TO_BASKET" => "/personal/cart",
		"PATH_TO_CATALOG" => "/catalog/",
		"PATH_TO_CONTACT" => "/about/contacts",
		"PATH_TO_PAYMENT" => "/personal/order/payment",
		"PER_PAGE" => "20",
		"PROFILES_PER_PAGE" => "20",
		"PROP_1" => array(),
		"PROP_2" => array(),
		"SAVE_IN_SESSION" => "Y",
		"SEF_FOLDER" => "/personal/",
		"SEF_MODE" => "Y",
		"SEF_URL_TEMPLATES" => Array("account"=>"account/","index"=>"index.php","order_cancel"=>"cancel/#ID#","order_detail"=>"orders/#ID#","orders"=>"orders/","private"=>"private/","profile"=>"profiles/","profile_detail"=>"profiles/#ID#","subscribe"=>"subscribe/"),
		"SEND_INFO_PRIVATE" => "N",
		"SET_TITLE" => "Y",
		"SHOW_ACCOUNT_COMPONENT" => "Y",
		"SHOW_ACCOUNT_PAGE" => "Y",
		"SHOW_ACCOUNT_PAY_COMPONENT" => "Y",
		"SHOW_BASKET_PAGE" => "Y",
		"SHOW_CONTACT_PAGE" => "N",
		"SHOW_ORDER_PAGE" => "Y",
		"SHOW_PRIVATE_PAGE" => "Y",
		"SHOW_PROFILE_PAGE" => "Y",
		"SHOW_SUBSCRIBE_PAGE" => "Y",
		"USER_PROPERTY_PRIVATE" => array(),
		"USE_AJAX_LOCATIONS_PROFILE" => "N"
	)
);?><br>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>