<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="b-reg-form">
	<form action="/ajax/?action=REG" method="POST" id="b-form-reg" novalidate="novalidate">
		<div class="b-popup-error"></div>
		<div class="b-popup-form">
			<div class="b-input-container">
				<div class="b-input-string">
					<input type="text" id="email" name="email" placeholder="E-mail" required="">
				</div>
				<div class="b-input-string">
					<input type="password" id="password" name="password" placeholder="Пароль" required="">
				</div>
			</div>
			<input type="text" name="MAIL">
			<input type="submit" style="display:none;">
			<div class="b-btn-container">
				<a href="#" class="b-btn ajax">Готово</a>
			</div>
		</div>
		<a href="#b-popup-success-reg" class="b-thanks-link fancy" style="display:none;"></a>
	</form>
</div>