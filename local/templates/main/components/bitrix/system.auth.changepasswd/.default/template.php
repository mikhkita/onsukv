<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="bx-auth">
	<form action="<?=$arResult["AUTH_FORM"]?>" name="bform" method="POST" class="b-confirm-form">
		<div class="b-popup-error"></div>
		<div class="b-popup-form">
			<div class="b-input-container">
				<div class="b-input-string">
					<input class="bx-auth-input" type="password" id="USER_PASSWORD" name="USER_PASSWORD" placeholder="Пароль" autocomplete="off" required/>
				</div>
				<div class="b-input-string">
					<input class="bx-auth-input" type="password" id="USER_CONFIRM_PASSWORD" name="USER_CONFIRM_PASSWORD" placeholder="Подтверждение пароля" autocomplete="off" required/>
				</div>
			</div>
			<input type="text" name="MAIL"/>
			<input type="submit" name="change_pwd" style="display:none;">
			<div class="b-btn-container">
				<a href="#" class="b-btn ajax">Готово</a>
			</div>
		</div>
		<a href="#b-popup-success-reg" class="b-thanks-link fancy" style="display:none;"></a>
	</form>

<p><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>
<p><span class="starrequired">*</span><?=GetMessage("AUTH_REQ")?></p>
<p>
<a href="<?=$arResult["AUTH_AUTH_URL"]?>"><b><?=GetMessage("AUTH_AUTH")?></b></a>
</p>

</form>

<script type="text/javascript">
document.bform.USER_LOGIN.focus();
</script>
</div>