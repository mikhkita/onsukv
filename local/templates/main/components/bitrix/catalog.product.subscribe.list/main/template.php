<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */
/** @global CMain $APPLICATION */

use Bitrix\Main\Localization\Loc;

CJSCore::init(array('popup'));

$randomString = $this->randString();

$APPLICATION->setTitle(Loc::getMessage('CPSL_SUBSCRIBE_TITLE_NEW'));
if(!$arResult['USER_ID'] && !isset($arParams['GUEST_ACCESS'])):?>
	<?
	$contactTypeCount = count($arResult['CONTACT_TYPES']);
	$authStyle = 'display: block;';
	$identificationStyle = 'display: none;';
	if(!empty($_GET['result']))
	{
		$authStyle = 'display: none;';
		$identificationStyle = 'display: block;';
	}
	?>

	<div class="row">
		<div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
			<div class="alert alert-danger"><?=Loc::getMessage('CPSL_SUBSCRIBE_PAGE_TITLE_AUTHORIZE')?></div>
		</div>
		<? $authListGetParams = array(); ?>
		<div class="col-md-8 col-sm-7" id="catalog-subscriber-auth-form" style="<?=$authStyle?>">
			<?$APPLICATION->authForm('', false, false, 'N', false);?>
			<hr class="bxe-light">
		</div>
	</div>

	<?$APPLICATION->setTitle(Loc::getMessage('CPSL_TITLE_PAGE_WHEN_ACCESSING'));?>


	<div class="row" id="catalog-subscriber-identification-form" style="<?=$identificationStyle?>">
		<div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">

			<div class="row">
				<div class="col-lg-12 catalog-subscriber-identification-form">
					<h4><?=Loc::getMessage('CPSL_HEADLINE_FORM_SEND_CODE')?></h4>
					<hr class="bxe-light">
					<form method="post">
						<?=bitrix_sessid_post()?>
						<input type="hidden" name="siteId" value="<?=SITE_ID?>">
						<?if($contactTypeCount > 1):?>
							<div class="form-group">
								<label for="contactType"><?=Loc::getMessage('CPSL_CONTACT_TYPE_SELECTION')?></label>
								<select id="contactType" class="form-control" name="contactType">
									<?foreach($arResult['CONTACT_TYPES'] as $contactTypeData):?>
										<option value="<?=intval($contactTypeData['ID'])?>">
											<?=htmlspecialcharsbx($contactTypeData['NAME'])?></option>
									<?endforeach;?>
								</select>
							</div>
						<?endif;?>
						<div class="form-group">
							<?
								$contactLable = Loc::getMessage('CPSL_CONTACT_TYPE_NAME');
								$contactTypeId = 0;
								if($contactTypeCount == 1)
								{
									$contactType = current($arResult['CONTACT_TYPES']);
									$contactLable = $contactType['NAME'];
									$contactTypeId = $contactType['ID'];
								}
							?>
							<label for="contactInputOut"><?=htmlspecialcharsbx($contactLable)?></label>
							<input type="text" class="form-control" name="userContact" id="contactInputOut">
							<input type="hidden" name="subscriberIdentification" value="Y">
							<?if($contactTypeId):?>
								<input type="hidden" name="contactType" value="<?=$contactTypeId?>">
							<?endif;?>
						</div>
						<button type="submit" class="btn btn-default"><?=Loc::getMessage('CPSL_BUTTON_SUBMIT_CODE')?></button>
					</form>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<h4><?=Loc::getMessage('CPSL_HEADLINE_FORM_FOR_ACCESSING')?></h4>
					<hr class="bxe-light">
					<form method="post">
						<?=bitrix_sessid_post()?>
						<div class="form-group">
							<label for="contactInputCheck"><?=htmlspecialcharsbx($contactLable)?></label>
							<input type="text" class="form-control" name="userContact" id="contactInputCheck" value=
								"<?=!empty($_GET['contact']) ? htmlspecialcharsbx(urldecode($_GET['contact'])): ''?>">
						</div>
						<div class="form-group">
							<label for="token"><?=Loc::getMessage('CPSL_CODE_LABLE')?></label>
							<input type="text" class="form-control" name="subscribeToken" id="token">
							<input type="hidden" name="accessCodeVerification" value="Y">
						</div>
						<button type="submit" class="btn btn-default"><?=Loc::getMessage('CPSL_BUTTON_SUBMIT_ACCESS')?></button>
					</form>
				</div>
			</div>

		</div>
	</div>

	<script type="text/javascript">
		BX.ready(function() {
			if(BX('cpsl-auth'))
			{
				BX.bind(BX('cpsl-auth'), 'click', BX.delegate(showAuthForm, this));
				BX.bind(BX('cpsl-identification'), 'click', BX.delegate(showAuthForm, this));
			}
			function showAuthForm()
			{
				var formType = BX.proxy_context.id.replace('cpsl-', '');
				var authForm = BX('catalog-subscriber-auth-form'),
					codeForm = BX('catalog-subscriber-identification-form');
				if(!authForm || !codeForm || !BX('catalog-subscriber-'+formType+'-form')) return;

				BX.style(authForm, 'display', 'none');
				BX.style(codeForm, 'display', 'none');
				BX.style(BX('catalog-subscriber-'+formType+'-form'), 'display', '');
			}
		});
	</script>
<?endif;

?>
<script type="text/javascript">
	BX.message({
		CPSL_MESS_BTN_DETAIL: '<?=('' != $arParams['MESS_BTN_DETAIL']
			? CUtil::JSEscape($arParams['MESS_BTN_DETAIL']) : GetMessageJS('CPSL_TPL_MESS_BTN_DETAIL'));?>',

		CPSL_MESS_NOT_AVAILABLE: '<?=('' != $arParams['MESS_BTN_DETAIL']
			? CUtil::JSEscape($arParams['MESS_BTN_DETAIL']) : GetMessageJS('CPSL_TPL_MESS_BTN_DETAIL'));?>',
		CPSL_BTN_MESSAGE_BASKET_REDIRECT: '<?=GetMessageJS('CPSL_CATALOG_BTN_MESSAGE_BASKET_REDIRECT');?>',
		CPSL_BASKET_URL: '<?=$arParams["BASKET_URL"];?>',
		CPSL_TITLE_ERROR: '<?=GetMessageJS('CPSL_CATALOG_TITLE_ERROR') ?>',
		CPSL_TITLE_BASKET_PROPS: '<?=GetMessageJS('CPSL_CATALOG_TITLE_BASKET_PROPS') ?>',
		CPSL_BASKET_UNKNOWN_ERROR: '<?=GetMessageJS('CPSL_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
		CPSL_BTN_MESSAGE_SEND_PROPS: '<?=GetMessageJS('CPSL_CATALOG_BTN_MESSAGE_SEND_PROPS');?>',
		CPSL_BTN_MESSAGE_CLOSE: '<?=GetMessageJS('CPSL_CATALOG_BTN_MESSAGE_CLOSE') ?>',
		CPSL_STATUS_SUCCESS: '<?=GetMessageJS('CPSL_STATUS_SUCCESS');?>',
		CPSL_STATUS_ERROR: '<?=GetMessageJS('CPSL_STATUS_ERROR') ?>'
	});
</script>
<?

if(!empty($_GET['result']) && !empty($_GET['message']))
{
	$successNotify = strpos($_GET['result'], 'Ok') ? true : false;
	$postfix = $successNotify ? 'Ok' : 'Fail';
	$popupTitle = Loc::getMessage('CPSL_SUBSCRIBE_POPUP_TITLE_'.strtoupper(str_replace($postfix, '', $_GET['result'])));

	$arJSParams = array(
		'NOTIFY_USER' => true,
		'NOTIFY_POPUP_TITLE' => $popupTitle,
		'NOTIFY_SUCCESS' => $successNotify,
		'NOTIFY_MESSAGE' => urldecode($_GET['message']),
	);
	?>
	<script type="text/javascript">
		var <?='jaClass_'.$randomString;?> = new JCCatalogProductSubscribeList(<?=CUtil::PhpToJSObject($arJSParams, false, true);?>);
	</script>
	<?
}

if (!empty($arResult['ITEMS']))
{
	$skuTemplate = array();
	if (!empty($arResult['SKU_PROPS']))
	{
		foreach ($arResult['SKU_PROPS'] as $itemId => $arProp)
		{
			foreach($arProp as $propId => $prop)
			{
				$propId = $prop['ID'];
				$skuTemplate[$itemId][$propId] = array(
					'SCROLL' => array(
						'START' => '',
						'FINISH' => '',
					),
					'FULL' => array(
						'START' => '',
						'FINISH' => '',
					),
					'ITEMS' => array()
				);
				$templateRow = '';
				if ('TEXT' == $prop['SHOW_MODE'])
				{
					$skuTemplate[$itemId][$propId]['SCROLL']['START'] = '<div class="bx_item_detail_size full" id="#ITEM#_prop_'.$propId.'_cont">'.
						'<span class="bx_item_section_name_gray">'.htmlspecialcharsbx($prop['NAME']).'</span>'.
						'<div class="bx_size_scroller_container"><div class="bx_size"><ul id="#ITEM#_prop_'.$propId.'_list" style="width: #WIDTH#;">';;
					$skuTemplate[$itemId][$propId]['SCROLL']['FINISH'] = '</ul></div>'.
						'<div class="bx_slide_left" id="#ITEM#_prop_'.$propId.'_left" data-treevalue="'.$propId.'" style=""></div>'.
						'<div class="bx_slide_right" id="#ITEM#_prop_'.$propId.'_right" data-treevalue="'.$propId.'" style=""></div>'.
						'</div></div>';

					$skuTemplate[$itemId][$propId]['FULL']['START'] = '<div class="bx_item_detail_size" id="#ITEM#_prop_'.$propId.'_cont">'.
						'<span class="bx_item_section_name_gray">'.htmlspecialcharsbx($prop['NAME']).'</span>'.
						'<div class="bx_size_scroller_container"><div class="bx_size"><ul id="#ITEM#_prop_'.$propId.'_list" style="width: #WIDTH#;">';;
					$skuTemplate[$itemId][$propId]['FULL']['FINISH'] = '</ul></div>'.
						'<div class="bx_slide_left" id="#ITEM#_prop_'.$propId.'_left" data-treevalue="'.$propId.'" style="display: none;"></div>'.
						'<div class="bx_slide_right" id="#ITEM#_prop_'.$propId.'_right" data-treevalue="'.$propId.'" style="display: none;"></div>'.
						'</div></div>';
					foreach ($prop['VALUES'] as $value)
					{
						$value['NAME'] = htmlspecialcharsbx($value['NAME']);
						$skuTemplate[$itemId][$propId]['ITEMS'][$value['ID']] = '<li data-treevalue="'.$propId.'_'.$value['ID'].
							'" data-onevalue="'.$value['ID'].'" style="width: #WIDTH#;" title="'.$value['NAME'].'"><i></i><span class="cnt">'.$value['NAME'].'</span></li>';
					}
					unset($value);
				}
				elseif ('PICT' == $prop['SHOW_MODE'])
				{
					$skuTemplate[$itemId][$propId]['SCROLL']['START'] = '<div class="bx_item_detail_scu full" id="#ITEM#_prop_'.$propId.'_cont">'.
						'<span class="bx_item_section_name_gray">'.htmlspecialcharsbx($prop['NAME']).'</span>'.
						'<div class="bx_scu_scroller_container"><div class="bx_scu"><ul id="#ITEM#_prop_'.$propId.'_list" style="width: #WIDTH#;">';
					$skuTemplate[$itemId][$propId]['SCROLL']['FINISH'] = '</ul></div>'.
						'<div class="bx_slide_left" id="#ITEM#_prop_'.$propId.'_left" data-treevalue="'.$propId.'" style=""></div>'.
						'<div class="bx_slide_right" id="#ITEM#_prop_'.$propId.'_right" data-treevalue="'.$propId.'" style=""></div>'.
						'</div></div>';

					$skuTemplate[$itemId][$propId]['FULL']['START'] = '<div class="bx_item_detail_scu" id="#ITEM#_prop_'.$propId.'_cont">'.
						'<span class="bx_item_section_name_gray">'.htmlspecialcharsbx($prop['NAME']).'</span>'.
						'<div class="bx_scu_scroller_container"><div class="bx_scu"><ul id="#ITEM#_prop_'.$propId.'_list" style="width: #WIDTH#;">';
					$skuTemplate[$itemId][$propId]['FULL']['FINISH'] = '</ul></div>'.
						'<div class="bx_slide_left" id="#ITEM#_prop_'.$propId.'_left" data-treevalue="'.$propId.'" style="display: none;"></div>'.
						'<div class="bx_slide_right" id="#ITEM#_prop_'.$propId.'_right" data-treevalue="'.$propId.'" style="display: none;"></div>'.
						'</div></div>';
					foreach ($prop['VALUES'] as $value)
					{
						$value['NAME'] = htmlspecialcharsbx($value['NAME']);
						$skuTemplate[$itemId][$propId]['ITEMS'][$value['ID']] = '<li data-treevalue="'.$propId.'_'.$value['ID'].
							'" data-onevalue="'.$value['ID'].'" style="width: #WIDTH#; padding-top: #WIDTH#;"><i title="'.$value['NAME'].'"></i>'.
							'<span class="cnt"><span class="cnt_item" style="background-image:url(\''.$value['PICT']['SRC'].'\');" title="'.$value['NAME'].'"></span></span></li>';
					}
					unset($value);
				}
			}
		}
		unset($templateRow, $prop);
	}

	?>
	<div class="bx_item_list_you_looked_horizontal col<?=$arParams['LINE_ELEMENT_COUNT'];?>">
	<div class="bx_item_list_section">
	<div class="bx_item_list_slide active">
	<div class="b-catalog-list clearfix <?=$arParams["CLASS"]?>">
	<? foreach ($arResult['ITEMS'] as $key => $arItem)
	{
		$strMainID = $this->GetEditAreaId($arItem['ID']);

		$arItemIDs = array(
			'ID' => $strMainID,
			'PICT' => $strMainID . '_pict',
			'SECOND_PICT' => $strMainID . '_secondpict',
			'MAIN_PROPS' => $strMainID . '_main_props',

			'QUANTITY' => $strMainID . '_quantity',
			'QUANTITY_DOWN' => $strMainID . '_quant_down',
			'QUANTITY_UP' => $strMainID . '_quant_up',
			'QUANTITY_MEASURE' => $strMainID . '_quant_measure',
			'BUY_LINK' => $strMainID . '_buy_link',
			'SUBSCRIBE_LINK' => $strMainID . '_subscribe',
			'SUBSCRIBE_DELETE_LINK' => $strMainID . '_delete_subscribe',

			'PRICE' => $strMainID . '_price',
			'DSC_PERC' => $strMainID . '_dsc_perc',
			'SECOND_DSC_PERC' => $strMainID . '_second_dsc_perc',

			'PROP_DIV' => $strMainID . '_sku_tree',
			'PROP' => $strMainID . '_prop_',
			'DISPLAY_PROP_DIV' => $strMainID . '_sku_prop',
			'BASKET_PROP_DIV' => $strMainID . '_basket_prop'
		);

		$strObName = 'ob' . preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);

		$strTitle = (
		isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"])
			&& '' != isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"])
			? $arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]
			: $arItem['NAME']
		);
		$showImgClass = $arParams['SHOW_IMAGE'] != "Y" ? "no-imgs" : "";

		?>
	<? $renderImage = CFile::ResizeImageGet($arItem["DETAIL_PICTURE"], Array("width" => 180, "height" => 180), BX_RESIZE_IMAGE_PROPORTIONAL, false, $arFilters ); ?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			?>
			<div class="b-catalog-item clearfix">
				<div class="b-catalog-back"></div>
				<a href="<?=detailPageUrl($arItem["DETAIL_PAGE_URL"])?>" class="b-catalog-img" style="background-image:url('<?=$renderImage["src"]?>');"></a>
				<div class="b-catalog-desc">
					<div class="b-catalog-item-top">
						<h6><a href="<?=detailPageUrl($arItem["DETAIL_PAGE_URL"])?>"><?=$arItem["NAME"]?></a></h6>
						<p class="article b-catalog-item-country"><?=$arItem["PROPERTIES"]["COUNTRY"]["VALUE"]?></p>
					</div>
					<a id="<?=$arItemIDs['SUBSCRIBE_DELETE_LINK'];?>" class="b-btn b-brown-btn btn-link" href="javascript:void(0)">
						Отписаться
					</a>
				</div>
				<?

				$arJSParams = array(
		'PRODUCT_TYPE' => $arItem['CATALOG_TYPE'],
		'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
		'SHOW_ADD_BASKET_BTN' => false,
		'SHOW_BUY_BTN' => true,
		'SHOW_ABSENT' => true,
		'SHOW_SKU_PROPS' => $arItem['OFFERS_PROPS_DISPLAY'],
		'SECOND_PICT' => ($arParams['SHOW_IMAGE'] == "Y" ? $arItem['SECOND_PICT'] : false),
		'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
		'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
		'DEFAULT_PICTURE' => array(
			'PICTURE' => $arItem['PRODUCT_PREVIEW'],
			'PICTURE_SECOND' => $arItem['PRODUCT_PREVIEW_SECOND']
		),
		'VISUAL' => array(
			'ID' => $arItemIDs['ID'],
			'PICT_ID' => $arItemIDs['PICT'],
			'SECOND_PICT_ID' => $arItemIDs['SECOND_PICT'],
			'QUANTITY_ID' => $arItemIDs['QUANTITY'],
			'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
			'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
			'QUANTITY_MEASURE' => $arItemIDs['QUANTITY_MEASURE'],
			'PRICE_ID' => $arItemIDs['PRICE'],
			'TREE_ID' => $arItemIDs['PROP_DIV'],
			'TREE_ITEM_ID' => $arItemIDs['PROP'],
			'BUY_ID' => $arItemIDs['BUY_LINK'],
			'ADD_BASKET_ID' => $arItemIDs['ADD_BASKET_ID'],
			'DSC_PERC' => $arItemIDs['DSC_PERC'],
			'SECOND_DSC_PERC' => $arItemIDs['SECOND_DSC_PERC'],
			'DISPLAY_PROP_DIV' => $arItemIDs['DISPLAY_PROP_DIV'],
			'DELETE_SUBSCRIBE_ID' => $arItemIDs['SUBSCRIBE_DELETE_LINK'],
		),
		'BASKET' => array(
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE']
		),
		'PRODUCT' => array(
			'ID' => $arItem['ID'],
			'NAME' => $arItem['~NAME'],
			'LIST_SUBSCRIBE_ID' => $arParams['LIST_SUBSCRIPTIONS'],
		),
		'OFFERS' => $arItem['JS_OFFERS'],
		'OFFER_SELECTED' => $arItem['OFFERS_SELECTED'],
		'TREE_PROPS' => $arSkuProps,
		'LAST_ELEMENT' => $arItem['LAST_ELEMENT'],
	); ?>
		<script type="text/javascript">
			var <?=$strObName;?> = new JCCatalogProductSubscribeList(
				<?=CUtil::PhpToJSObject($arJSParams, false, true);?>);
		</script>
			</div><?
	}
	?>
	</div>
	<div style="clear: both;"></div>
	</div>
	</div>
	</div>
<?
}
else
{
	if(isset($arParams['GUEST_ACCESS'])):
		echo '<h3>'.Loc::getMessage('CPSL_SUBSCRIBE_NOT_FOUND').'</h3>';
	endif;
}
?>