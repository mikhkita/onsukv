<?
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

function rus2translit($string) {
    $converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
        
        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
    );
    return strtr($string, $converter);
}
function str2url($str) {
    // переводим в транслит
    $str = rus2translit($str);
    // в нижний регистр
    $str = strtolower($str);
    // заменям все ненужное нам на "-"
    $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
    // удаляем начальные и конечные '-'
    $str = trim($str, "-");
    return $str;
}

include 'categories.php';

$result = array();

foreach ($values as $value) {
	$result[] = array_combine($keys, $value);
}

//print_r($result);
//array("NAME" => "EMAIL", "TYPE" => "prop"),

$params = array(
	"CATALOGUE_ID" => array("NAME" => "ID", "TYPE" => "field"),
	"PARENT_ID" => array("NAME" => "IBLOCK_SECTION_ID", "TYPE" => "field"),
	// "SLUG" => ,
	"NAME" => array("NAME" => "NAME", "TYPE" => "field"),
	// "CATNAME" => ,
	// "REALCATNAME" => ,
	// "URL" => ,
	// "TITLE" => ,
	// "DESCRIPTION" => ,
	// "METADESC" => ,
	// "METAKEYW" => ,
	// "ICON_IMAGE" => ,
	// "COLOR" => ,
	// "IMG_TITLE" => ,
	// "COUNT_" => ,
	// "LINKED_COUNT_" => ,
	// "OLDCODE" => ,
	"STATUS" => array("NAME" => "ACTIVE", "TYPE" => "field"),
	// "REALSTATUS" => ,
	"ORDERING" => array("NAME" => "SORT", "TYPE" => "field"),
	// "EXPORT_ID" => ,
	"WHOLESALE" => array("NAME" => "UF_OPT", "TYPE" => "field"),
);

// $params = array(
// 	'id' => "", 
// 	'ctime' => "", 
// 	'date' => "", 
// 	'title' => array("NAME" => "NAME", "TYPE" => "field"),
// 	'title_url' => array("NAME" => "CODE", "TYPE" => "field"),
// 	'anons' => array("NAME" => "PREVIEW_TEXT", "TYPE" => "field"),
// 	'teaser' => "",
// 	'image' => array("NAME" => "PREVIEW_PICTURE", "TYPE" => "field"),
// 	'author' => array("NAME" => "AUTHOR", "TYPE" => "prop"), 
// 	'author_desc' => array("NAME" => "AUTHOR_TEXT", "TYPE" => "prop"),
// 	'author_photo' => array("NAME" => "DETAIL_PICTURE", "TYPE" => "field"),
// 	'text' => array("NAME" => "DETAIL_TEXT", "TYPE" => "field"),
// 	'header_title' => "",
// 	'keywords' => "",
// 	'description' => "",
// 	'open_date' => array("NAME" => "ACTIVE_FROM", "TYPE" => "field"),
// 	'blocked' => array("NAME" => "ACTIVE", "TYPE" => "field"),
// 	'is_main' => array("NAME" => "IS_MAIN", "TYPE" => "prop"),
// 	'is_main_pinned' => array("NAME" => "IS_MAIN_PINNED", "TYPE" => "prop"),
// 	'block_all_banner' => array("NAME" => "BLOCK_BANNER", "TYPE" => "prop"),
// 	'photo_author' => array("NAME" => "AUTHOR_PHOTO", "TYPE" => "prop"),
// 	'updated_at' => "",
// 	'cnt' => array("NAME" => "SHOW_COUNTER", "TYPE" => "field")
// );

$section = new CIBlockSection;
$replace_symbols = array('\\r\\n\\r\\n', '\\r\\n', '\"');

foreach ($result as $element) { //element - вся информация о элементе

	$PROP = array();
	$fields = array();

	$rsSections = CIBlockSection::GetList(array(),array('IBLOCK_ID' => 1, 'ID' => $element["CATALOGUE_ID"]));
	if ($arSection = $rsSections->Fetch()){
		$arLoadSectionArray = Array(
			"IBLOCK_ID" => 1,
			"ID" => $arSection["ID"],
			"ACTIVE" => $arSection["ACTIVE"],
			"CODE" => $arSection["CODE"],
			"NAME" => $arSection["NAME"],
			"SORT" => $arSection["SORT"],
			"UF_OPT" => $arSection["UF_OPT"],
		);

		foreach ($params as $param => $param_bitrix) {
			if(!empty($param_bitrix)){
				if($param_bitrix["TYPE"] == "field"){
					// if($param_bitrix["NAME"] == "NAME"){
					// 	$arLoadSectionArray["CODE"] = str2url(str_replace($replace_symbols, array("", "", '"'), $element[$param]));
					// 	// continue;
					// }
					// if($param_bitrix["NAME"] == "ACTIVE"){
					// 	$arLoadSectionArray[$param_bitrix["NAME"]] = $element[$param] == 1 ? "Y" : "N";
					// 	continue;
					// }

					if($param_bitrix["NAME"] == "IBLOCK_SECTION_ID"){
						if( $element[$param] == 1 ){
							$element[$param] = 2;
						}elseif( $element[$param] == 51 ){
							$element[$param] = 1;
						}
						$arLoadSectionArray[$param_bitrix["NAME"]] = $element[$param];
						continue;
					}
					
					// $arLoadSectionArray[$param_bitrix["NAME"]] = str_replace($replace_symbols, array("", "", '"'), $element[$param]);
				}
			}
		}

		// print_r($arLoadSectionArray);

		if($PRODUCT_ID = $section->Update($arLoadSectionArray["ID"], $arLoadSectionArray, true)){
		  echo "New ID: ".$PRODUCT_ID;
		}else{
		  echo "Error: ".$section->LAST_ERROR;
		}
	}
}

?>