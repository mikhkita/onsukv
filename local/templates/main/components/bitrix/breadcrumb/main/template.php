<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

//delayed function must return a string
// print_r($arResult);
// die();
if(empty($arResult))
	return "";

if( $GLOBALS["isWholesale"] ){
	foreach ($arResult as $i => $arItem) {
		if( $i == 0 ){
			$arResult[$i]["TITLE"] = "ОПТ";
			$arResult[$i]["LINK"] = "/wholesale/";
		}else{
			$arResult[$i]["LINK"] = detailPageUrl($arItem["LINK"]);
		}
	}
}

if( $GLOBALS["isSale"] ){
	foreach ($arResult as $i => $arItem) {
		if( $i == 0 ){
			$arResult[$i]["TITLE"] = "Распродажа";
			$arResult[$i]["LINK"] = "/sale/";
		}else{
			$arResult[$i]["LINK"] = detailPageUrl($arItem["LINK"]);
		}
	}
}

$strReturn = '';

$strReturn .= '<ul class="b-breadcrumbs"><li><a href="/" class="icon-arrow"><span>Магазин товаров для кондитера</span></a></li>';

$itemSize = count($arResult);
for($index = 0; $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);

	$nextRef = ($index < $itemSize-2 && $arResult[$index+1]["LINK"] <> ""? ' itemref="bx_breadcrumb_'.($index+1).'"' : '');
	$child = ($index > 0? ' itemprop="child"' : '');

	if($arResult[$index]["LINK"] <> "" && ($index != $itemSize - 1 || $tog) )
	{
		$strReturn .= '
			<li id="bx_breadcrumb_'.$index.'" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"'.$child.$nextRef.'>
				<a href="'.$arResult[$index]["LINK"].'" title="'.$title.'" class="icon-arrow" itemprop="url">
					<span itemprop="title">'.$title.'</span>
				</a>
			</li>';
	}
	else
	{
		$strReturn .= '
			<li class="bx-breadcrumb-item">
				<span>'.$title.'</span>
			</li>';
	}
}

$strReturn .= '</ul>';

return $strReturn;
