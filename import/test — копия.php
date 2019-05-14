<?
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
// die();
function strip_word_html($text, $allowed_tags = '<b><i><sup><sub><em><strong><u><br><p><ul><li><ol>') { 
    mb_regex_encoding('UTF-8'); 
    //replace MS special characters first 
    $search = array('/&lsquo;/u', '/&rsquo;/u', '/&ldquo;/u', '/&rdquo;/u', '/&mdash;/u'); 
    $replace = array('\'', '\'', '"', '"', '-'); 
    $text = preg_replace($search, $replace, $text); 
    //make sure _all_ html entities are converted to the plain ascii equivalents - it appears 
    //in some MS headers, some html entities are encoded and some aren't 
    $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8'); 
    //try to strip out any C style comments first, since these, embedded in html comments, seem to 
    //prevent strip_tags from removing html comments (MS Word introduced combination) 
    if(mb_stripos($text, '/*') !== FALSE){ 
        $text = mb_eregi_replace('#/\*.*?\*/#s', '', $text, 'm'); 
    } 
    //introduce a space into any arithmetic expressions that could be caught by strip_tags so that they won't be 
    //'<1' becomes '< 1'(note: somewhat application specific) 
    $text = preg_replace(array('/<([0-9]+)/'), array('< $1'), $text); 
    $text = strip_tags($text, $allowed_tags); 
    //eliminate extraneous whitespace from start and end of line, or anywhere there are two or more spaces, convert it to one 
    $text = preg_replace(array('/^\s\s+/', '/\s\s+$/', '/\s\s+/u'), array('', '', ' '), $text); 
    //strip out inline css and simplify style tags 
    
    // $search = array('#<(strong|b)[^>]*>(.*?)</(strong|b)>#isu', '#<(em|i)[^>]*>(.*?)</(em|i)>#isu', '#<u[^>]*>(.*?)</u>#isu'); 
    // $replace = array('<b>$2</b>', '<i>$2</i>', '<u>$1</u>'); 
    // $text = preg_replace($search, $replace, $text); 

    //on some of the ?newer MS Word exports, where you get conditionals of the form 'if gte mso 9', etc., it appears 
    //that whatever is in one of the html comments prevents strip_tags from eradicating the html comment that contains 
    //some MS Style Definitions - this last bit gets rid of any leftover comments */ 
    $num_matches = preg_match_all("/\<!--/u", $text, $matches); 
    if($num_matches){ 
          $text = preg_replace('/\<!--(.)*--\>/isu', '', $text); 
    } 
    return $text; 
} 

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

function getCode($code, $index = 0){
	CModule::IncludeModule('iblock');

	$findCode = ($index == 0)?$code:($code.$index);
	$rsSections = CIBlockElement::GetList(array(),array('IBLOCK_ID' => 1, '=CODE' => $findCode));
	if ($arSection = $rsSections->Fetch()){
		return getCode( $code, $index + 1 );
	}else{
		return $findCode;
	}
}

// $xmlFileName = "test.xml";
$xmlFileName = "catalogue_export.xml";

if (file_exists($xmlFileName)) {
	$doc = new DOMDocument();
	$doc->load( $xmlFileName );
	 
	$objects = array();
	$export = $doc->documentElement;
	foreach ($export->childNodes as $ex) {
		if( $ex->nodeName == "items" ){
			foreach ($ex->childNodes as $x) {
				if( $x->nodeName == "item" ){
					$object = array();
					foreach ($x->childNodes as $item) {
						if( $item->nodeName == "attributes" ){
							$attributes = array();
							foreach ($item->childNodes as $attr) {
								if( $attr->nodeName == "attribut" ){
									$attrID = NULL;
									$attrValue = NULL;

									foreach ($attr->childNodes as $attrItem) {
										if( $attrItem->nodeName == "attribut_id" ){
											$attrID = $attrItem->nodeValue;
										}
										if( $attrItem->nodeName == "value" ){
											$attrValue = $attrItem->nodeValue;
										}
									}

									if( $attrID && $attrValue ){
										$attributes[ $attrID ] = $attrValue;
									}
								}
							}
							$object[ "attributes" ] = $attributes;

							continue;
						}

						if( $item->nodeName != "#text" ){
							$object[ $item->nodeName ] = $item->nodeValue;
						}
					}	
					array_push($objects, $object);
				}
			}
		}
	}

	// print_r($objects);
	// die();

	$units = array(
		"упаковка" => 6,
		"шт." => 5,
		"литр" => 2,
		"кг" => 4,
		"гр" => 3,
	);
	foreach ($objects as $key => $object) {
		$el = new CIBlockElement;
		$PROP = array();

		$string = str_replace("&nbsp;", " ", $object["xml"]);
		$object["xml"] = preg_replace("/\s+/", ' ', strip_word_html($string));

		$arLoadProductArray = Array(
			"IBLOCK_ID" 		=> 1,
			"ID" 				=> $object["id"],
			"DETAIL_TEXT_TYPE" 	=> "html",
			"IBLOCK_SECTION_ID" => $object["catalogue_id"],
			"NAME" 				=> $object["name"],
			"CODE"				=> getCode(str2url($object["name"])),
			"DETAIL_TEXT" 		=> $object["xml"],
		);

		$filename = NULL;
		if( isset($object["image600"]) && !empty($object["image600"]) ){
			$filename = array_shift( explode("#", $object["image600"]) );
		}elseif( isset($object["image200"]) && !empty($object["image200"]) ){
			$filename = array_shift( explode("#", $object["image200"]) );
		}elseif( isset($object["image120"]) && !empty($object["image120"]) ){
			$filename = array_shift( explode("#", $object["image120"]) );
		}

		if( $filename !== NULL ){
			$arLoadProductArray[ "DETAIL_PICTURE" ] = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/images/it/".$filename);
		}

		if( isset($object["weight"]) ){
			$PROP["WEIGHT"] = $object["weight"];
		}

		if( isset($object["country"]) ){
			$PROP["COUNTRY"] = $object["country"];
		}

		if( isset($object["quantity"]) ){
			$PROP["QUANTITY"] = $object["quantity"];
		}

		if( isset($object["shcode"]) ){
			$PROP["SHCODE"] = $object["shcode"];
		}

		if( isset($object["supplier"]) ){
			$PROP["MANUFACTURER"] = $object["supplier"];
		}

		if( isset($object["attributes"]) ){
			$attrs = $object["attributes"];

			if( isset($attrs["73231"]) && !$object["supplier"] ){
				$PROP["MANUFACTURER"] = $attrs["73231"];
			}

			if( isset($attrs["73498"]) ){
				$PROP["COMPOSITION"] = $attrs["73498"];
			}

			if( isset($attrs["73499"]) ){
				$PROP["ENERGY"] = $attrs["73499"];
			}
		}

		$arLoadProductArray["PROPERTY_VALUES"] = $PROP;

		if($PRODUCT_ID = $el->Add($arLoadProductArray)){
			file_put_contents("test.txt", "New ID: ".$PRODUCT_ID."\n", FILE_APPEND);

			$measure = ( isset($units[ $object["unit"] ]) )?$units[ $object["unit"] ]:5;

			$arFields = array(
		       	"ID" => $PRODUCT_ID, 
		        "VAT_INCLUDED" => "Y",
		        "MEASURE" => $measure,
		        "QUANTITY" => rand(0, 40),
		    );

		    if(CCatalogProduct::Add($arFields)) {
				// file_put_contents("test.txt", "Добавили параметры товара к элементу каталога " . $PRODUCT_ID . '\n', FILE_APPEND);
		         
		        $arFields = Array(
		            "PRODUCT_ID" => $PRODUCT_ID,
		            "CATALOG_GROUP_ID" => 1,
		            "PRICE" => $object["price"],
		            "CURRENCY" => "RUB",
		        );
		        CPrice::Add($arFields);
		    }else{
		        file_put_contents("test.txt", 'Ошибка добавления параметров товара\n', FILE_APPEND);
		    }
		}else{
			file_put_contents("test.txt", "Error: ".$el->LAST_ERROR."\n", FILE_APPEND);
		}

		// die();
	}
} else {
    exit('Не удалось открыть файл catalogue_export.xml.');
}

?>