<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
	<? 
	if ($_REQUEST['delete']=="Y") {
		if (CIBlockElement::Delete($_REQUEST['CODE'])) {
			header('Location: /personal/addresses/');
		} else {
			$header = "Ошибка удаления";
		}
	}
	if ($urlArr[3]=="create") {
		$header = "Добавление";
	} else {
		$header = "Редактирование";
	}
	?>
	<h1><?=$header?> адреса</h1>
	<?$APPLICATION->IncludeComponent(
		"bitrix:iblock.element.add.form",
		"addresses",
		Array(
			"CUSTOM_TITLE_DATE_ACTIVE_FROM" => "",
			"CUSTOM_TITLE_DATE_ACTIVE_TO" => "",
			"CUSTOM_TITLE_DETAIL_PICTURE" => "",
			"CUSTOM_TITLE_DETAIL_TEXT" => "",
			"CUSTOM_TITLE_IBLOCK_SECTION" => "",
			"CUSTOM_TITLE_NAME" => "Город, улица, дом",
			"CUSTOM_TITLE_PREVIEW_PICTURE" => "",
			"CUSTOM_TITLE_PREVIEW_TEXT" => "",
			"CUSTOM_TITLE_TAGS" => "",
			"DEFAULT_INPUT_SIZE" => "30",
			"DETAIL_TEXT_USE_HTML_EDITOR" => "N",
			"ELEMENT_ASSOC" => "PROPERTY_BY",
			"ELEMENT_ASSOC_PROPERTY" => "USER",
			"GROUPS" => array("3"),
			"IBLOCK_ID" => "6",
			"IBLOCK_TYPE" => "",
			"LEVEL_LAST" => "Y",
			"LIST_URL" => "",
			"MAX_FILE_SIZE" => "0",
			"MAX_LEVELS" => "100000",
			"MAX_USER_ENTRIES" => "100000",
			"PREVIEW_TEXT_USE_HTML_EDITOR" => "N",
			"PROPERTY_CODES" => array("NAME","24","25","26","27","29"),
			"PROPERTY_CODES_REQUIRED" => array(),
			"RESIZE_IMAGES" => "N",
			"SEF_MODE" => "N",
			"STATUS" => "ANY",
			"STATUS_NEW" => "N",
			"USER_MESSAGE_ADD" => "",
			"USER_MESSAGE_EDIT" => "",
			"USE_CAPTCHA" => "N"
		)
	);?>
	<a href="/personal/addresses/" class="b-btn-address-back">Назад к списку адресов</a>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>