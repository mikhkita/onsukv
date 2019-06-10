<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(false);
if (!empty($arResult["ERRORS"])):?>
	<?ShowError(implode("<br />", $arResult["ERRORS"]))?>
<?endif;
if (strlen($arResult["MESSAGE"]) > 0):?>
	<?header('Location: /personal/addresses/');?>
<?endif?>
<? $userID = $USER->GetID(); ?>
<form name="iblock_add" action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data" class="order-adress-map-form">
	<?=bitrix_sessid_post()?>
	<div class="order-adress-map-form-content">
        <div class="b-addresss-item form-item __adress b-ui-autocomplete">
			<div class="b-addresss-item__address b-input ui-menu ui-widget ui-widget-content ui-autocomplete ui-front">
				<input type="text" id="js-order-adress-map-input" class="js-order-adress-map-input ui-autocomplete-input" name="PROPERTY[NAME][0]" value="<?=$arResult["ELEMENT"]['NAME']?>" autocomplete="off" required>
				<label for="name">Город, улица, дом <span class="required">*</span></label>
			</div>
			<div class="b-addresss-item__room b-input">
				<input type="text" id="number-room-input" name="PROPERTY[26][0]" value="<?=$arResult["ELEMENT_PROPERTIES"][26][0]['VALUE']?>" autocomplete="off" required>
				<label for="name">Квартира/офис <span class="required">*</span></label>
			</div>
			<div class="b-addresss-item__index b-input">
				<input type="text" id="postal-code" name="PROPERTY[24][0]" value="<?=$arResult["ELEMENT_PROPERTIES"][24][0]['VALUE']?>" autocomplete="off" required>
				<label for="name">Индекс <span class="required">*</span></label>
			</div>
			<div class="b-addresss-item__metro b-input hide">
				<select name="PROPERTY[31]">
					<option value>Выберите метро</option>
					<? foreach ($arResult["PROPERTY_LIST_FULL"][31]['ENUM'] as $metro): ?>
						<option value="<?=$metro['ID']?>"><?=$metro['VALUE']?></option>
					<? endforeach; ?>
				</select>
			</div>
			<input type="hidden" id="region" name="PROPERTY[25][0]" value="<?=$arResult["ELEMENT_PROPERTIES"][25][0]['VALUE']?>">
			<input type="hidden" id="city" name="PROPERTY[29][0]" value="<?=$arResult["ELEMENT_PROPERTIES"][29][0]['VALUE']?>">
			<input type="hidden" name="PROPERTY[27][0]" value="<?=$userID?>">
			<input type="hidden" name="iblock_submit" value="Сохранить">
        </div>
        <div class="b-addresss-btn-container">
	    	<input type="submit" name="iblock_submit3" value="Сохранить" class="b-btn-address-save not-ajax">
	    </div>
    </div>
</form>
<div id="map-address"></div>