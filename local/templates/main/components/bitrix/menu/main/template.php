<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? 

$prevLevel = 1;

?>
<?if (!empty($arResult)):?>
	<ul class="<?=$arParams["CLASS"]?>">
		<?
		foreach($arResult as $i => $arItem):
		$isNextSub = (isset($arResult[$i+1]) && $arResult[$i+1]["DEPTH_LEVEL"] > $arItem["DEPTH_LEVEL"])
		?>
			<? if($arItem["DEPTH_LEVEL"] < $prevLevel): ?>
				<? if( $prevLevel - $arItem["DEPTH_LEVEL"] == 2): ?>
					</ul></li></ul></li>
				<? else: ?>
					</li></ul>
				<? endif; ?>
			<? endif; ?>
			<? if($arItem["DEPTH_LEVEL"] > $prevLevel): ?>
				<ul class="b-submenu">
			<? elseif( $i != 0 ): ?>
				</li>
			<? endif; ?>
			
			<li <?if( $arItem["LINK"] == "/catalog/" ):?> class="top-hide"<?endif;?>><a href="<?=$arItem["LINK"]?>" <?if($arItem["SELECTED"]):?> class="active"<?endif;?>><?=$arItem["TEXT"]?></a>
				<? if( $arItem["LINK"] == "/catalog/" ): ?>
					<?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "menu", Array(
						"ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
							"CACHE_GROUPS" => "Y",	// Учитывать права доступа
							"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
							"CACHE_TYPE" => "N",	// Тип кеширования
							"COUNT_ELEMENTS" => "Y",	// Показывать количество элементов в разделе
							"IBLOCK_ID" => "1",	// Инфоблок
							"IBLOCK_TYPE" => "catalog",	// Тип инфоблока
							"SECTION_CODE" => "",	// Код раздела
							"SECTION_FIELDS" => array(	// Поля разделов
								0 => "NAME",
							),
							"SECTION_ID" => $_REQUEST["SECTION_ID"],	// ID раздела
							"SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
							"SECTION_USER_FIELDS" => array(	// Свойства разделов
								0 => "UF_EXTENDED",
								1 => "",
							),
							"SHOW_PARENT_NAME" => "Y",	// Показывать название раздела
							"TOP_DEPTH" => "1",	// Максимальная отображаемая глубина разделов
							"VIEW_MODE" => "LINE",	// Вид списка подразделов
						),
						false
					);?>
				<? endif; ?>
			<? $prevLevel = $arItem["DEPTH_LEVEL"]; ?>
		<?endforeach?>
				</li>
			</ul>
		</li>
	</ul>
<?endif?>