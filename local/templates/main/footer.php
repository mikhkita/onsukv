		<? if( !$GLOBALS["notBText"] ): ?>
			</div><!-- .b-text -->
		<? endif; ?>

	<? if( !$GLOBALS["isMain"] ): ?>
		<? if( $GLOBALS["isCatalog"] || $GLOBALS["isPersonal"] ): ?>
			</div><!-- .b-catalog-item -->
		<? endif; ?>
		</div><!-- .b-block -->
	</div><!-- .b-content-block -->
	<? endif; ?>
	<div class="b-advantages-block">
		<div class="b-block">
			<div class="b-abv-list">
				<div class="b-adv-item">
					<div class="b-adv-icon"></div>
					<div class="b-adv-text">Более 9 000 наименований<br>товаров на складе.</div>
				</div>
				<div class="b-adv-item">
					<div class="b-adv-icon"></div>
					<div class="b-adv-text">2 000 пунктов самовывоза<br>по всей России.</div>
				</div>
				<div class="b-adv-item">
					<div class="b-adv-icon"></div>
					<div class="b-adv-text">15 лет успешной работы<br>на Российском рынке.</div>
				</div>
				<div class="b-adv-item">
					<div class="b-adv-icon"></div>
					<div class="b-adv-text">Доставка товара в течение<br>12 часов с момента заказа.</div>
				</div>
				<div class="b-adv-item">
					<div class="b-adv-icon"></div>
					<div class="b-adv-text">Гарантия качества: не понравился товар – вернем деньги.</div>
				</div>
			</div>
		</div>
	</div>
	<div class="b-footer wave-top">
		<div class="b-block">
			<div class="b-footer-container">
				<div class="b-footer-block">
					<div class="b-footer-phone"><a href="tel:+74959225055">+7 495 922 50 55</a></div>
					<div class="b-footer-phone"><a href="tel:+74956447572">+7 495 644 75 72</a></div>
					<div class="b-footer-mail"><a href="mailto:info@nevkusno.ru">info@nevkusno.ru</a></div>
					<div class="b-underfooter-yandex">
						<a href="//clck.yandex.ru/redir/dtype=stred/pid=47/cid=2508/*https://market.yandex.ru/shop/89827/reviews"><img src="//clck.yandex.ru/redir/dtype=stred/pid=47/cid=2505/*https://grade.market.yandex.ru/?id=89827&amp;action=image&amp;size=0" border="0" width="88" height="31" alt="Читайте отзывы покупателей и оценивайте качество магазина на Яндекс.Маркете"></a>
					</div>
				</div>
				<div class="b-footer-block">
					<ul>
						<li><a href="/sale/">Распродажа</a></li>
						<li><a href="/discounts/">Акции и скидки</a></li>
						<li><a href="/delivery/">Доставка и оплата</a></li>
						<li><a href="/news/">Новости магазина</a></li>
						<!-- <li><a href="#">Новости магазина</a></li> -->
					</ul>
				</div>
				<div class="b-footer-block">
					<ul>
						<li><a href="/about/">О компании</a></li>
						<li><a href="/reviews/">Отзывы и пожелания</a></li>
						<li><a href="/magazin/">Розничный магазин</a></li>
						<li><a href="/rukovodstvo/">Связь с руководством</a></li>
					</ul>
				</div>
				<div class="b-footer-block">
					<div class="b-footer-soc">
						<div class="b-footer-soc-text">Присоединяйтесь к нам в соцсетях</div>
						<div class="b-footer-soc-container">
							<div class="b-footer-cat"></div>
							<a href="https://vk.com/nevkusno_ru" target="_blank" class="b-footer-vk"></a>
						</div>
					</div>
				</div>
			</div>
			<div class="b-underfooter">
				<div class="b-underfooter-item left-underfooter-item">
					© 2009–2019 <a href="http://nevkusno.ru" target="_blank" class="underline underfooter-link">nevkusno.ru</a> – ООО «Вкусный магазин»
				</div>
				<div class="b-underfooter-item center-underfooter-item">
					Все права защищены.
				</div>
				<div class="b-underfooter-item right-underfooter-item">
					<a href="/politics" class="underline politics-link">Политика конфиденциальности</a>
				</div>
			</div>
		</div>
	</div>
	<div class="b-menu-overlay" id="b-menu-overlay" style="display: none;"></div>
</div>
	<div style="display:none;">
		<noindex>
			<a href="#b-popup-error" class="b-error-link fancy" style="display:none;"></a>
			<div class="b-popup b-popup-auth" id="b-popup-auth">
				<div class="b-popup-header"><h3>Войдите</h3> или <a href="#b-popup-reg" onclick="$.fancybox.close();" class="fancy dashed">зарегистрируйтесь</a></div>
				<form action="/personal/?action=authSite&login=yes" method="POST" id="b-form-auth">
					<div class="b-popup-error"></div>
					<div class="b-popup-form">
						<input type="hidden" name="AUTH_FORM" value="Y">
		                <input type="hidden" name="TYPE" value="AUTH">
		                <input type="hidden" name="Login" value="Войти">
						<div class="b-input-container">
							<div class="b-input-string">
								<input type="text" id="login" name="USER_LOGIN" placeholder="Логин" required/>
							</div>
							<div class="b-input-string">
								<input type="password" id="password" name="USER_PASSWORD" placeholder="Пароль" required/>
							</div>
						</div>
						<a href="#b-popup-forget-password" class="fancy dashed forget" onclick="$.fancybox.close();">Забыли пароль?</a>
						<input type="submit" style="display:none;">
						<div class="b-btn-container">
							<a href="#" class="b-btn ajax">Войти</a>
						</div>
						<!-- <a href="#b-popup-success" class="b-thanks-link fancy" style="display:none;"></a> -->
					</div>
				</form>
			</div>
			<div class="b-popup" id="b-popup-reg">
				<div class="b-popup-header"><h3>Регистрация</h3></div>
				<form action="/ajax/?action=REG"method="POST" id="b-form-reg">
					<div class="b-popup-error"></div>
					<div class="b-popup-form">
						<div class="b-input-container">
							<div class="b-input-string">
								<input type="text" id="email" name="email" placeholder="E-mail" required/>
							</div>
							<div class="b-input-string">
								<input type="password" id="password" name="password" placeholder="Пароль" required/>
							</div>
						</div>
						<input type="text" name="MAIL"/>
						<input type="submit" style="display:none;">
						<div class="b-btn-container">
							<a href="#" class="b-btn ajax">Готово</a>
						</div>
					</div>
					<a href="#b-popup-success-reg" class="b-thanks-link fancy" style="display:none;"></a>
				</form>
			</div>
			<div class="b-popup" id="b-popup-ask">
				<div class="b-popup-header"><h3>У Вас есть вопрос?</h3>Спросите - мы обязательно вам ответим!</div>
				<form action="/ajax/?action=ASK" method="POST" id="b-form-ask">
					<div class="b-popup-form">
						<div class="b-input-container">
							<div class="b-input-string">
								<input type="text" id="name" name="name" placeholder="Имя" required/>
							</div>
							<div class="b-input-string">
								<input type="text" id="email" name="email" placeholder="E-mail" required/>
							</div>
							<div class="b-input-string">
								<input type="text" id="phone" name="phone" placeholder="Телефон" required/>
							</div>
							<div class="b-input-string">
								<textarea name="question" id="question" placeholder="Ваш вопрос" rows="5"></textarea>
							</div>
							<div class="b-input-string">
								<div class="b-checkbox">
			                        <input id="politics3" type="checkbox" name="politics" checked required>
			                        <label for="politics3">Настоящим подтверждаю, что я ознакомлен и согласен с <a href="/politics/">политикой по обработке персональных данных</a></label>
			                    </div>
							</div>
							<input type="text" name="MAIL">
						</div>
						<input type="submit" style="display:none;">
						<div class="b-btn-container">
							<a href="#" class="b-btn ajax">Отправить</a>
						</div>
						<a href="#b-popup-success" class="b-thanks-link fancy" style="display:none;"></a>
					</div>
				</form>
			</div>
			<div class="b-popup" id="b-popup-phone">
				<div class="b-popup-header"><h3>Не дозвонились?</h3>Оставьте заявку - мы обязательно вам перезвоним!</div>
				<form action="/ajax/?action=PHONE" method="POST" id="b-form-ask">
					<div class="b-popup-form">
						<div class="b-input-container">
							<div class="b-input-string">
								<input type="text" id="name" name="name" placeholder="Имя" required/>
							</div>
							<div class="b-input-string">
								<input type="text" id="phone" name="phone" placeholder="Телефон" required/>
							</div>
							<div class="b-input-string">
								<div class="b-checkbox">
			                        <input id="politics2" type="checkbox" name="politics" checked required>
			                        <label for="politics2">Настоящим подтверждаю, что я ознакомлен и согласен с <a href="/politics/">политикой по обработке персональных данных</a></label>
			                    </div>
			                </div>
							<input type="text" name="MAIL">
						</div>
						<input type="submit" style="display:none;">
						<div class="b-btn-container">
							<a href="#" class="b-btn ajax">Отправить</a>
						</div>
						<a href="#b-popup-success" class="b-thanks-link fancy" style="display:none;"></a>
					</div>
				</form>
			</div>
			<div class="b-popup b-popup-forget-password" id="b-popup-forget-password">
				<div class="b-popup-header"><h3>Восстановление пароля</h3></div>
				<form action="/personal/?forgot_password=yes"method="POST" id="b-form-ask">
					<input type="hidden" name="backurl" value="/personal/">
					<input type="hidden" name="AUTH_FORM" value="Y">
					<input type="hidden" name="TYPE" value="SEND_PWD">
					<input type="hidden" name="send_account_info" value="Y">
					<div class="b-popup-form">
						<div class="b-input-container">
							<div class="b-input-string">
								<input type="text" id="name" name="USER_EMAIL" placeholder="E-mail" required/>
							</div>
						</div>
						<input type="submit" style="display:none;">
						<div class="b-btn-container">
							<a href="#" class="b-btn not-ajax">Отправить</a>
						</div>
						<!-- <a href="#b-popup-success" class="b-thanks-link fancy" style="display:none;"></a> -->
					</div>
				</form>
			</div>
			<div class="b-popup b-review-popup" id="b-review-form">
				<div class="b-popup-header"><h3>Оставьте отзыв</h3></div>
				<?if ($urlArr[2] == "assortment"):?>
				<form action="/ajax/?action=ADDREVIEW&review_id=1835" method="POST" id="b-form-review">
				<?elseif($urlArr[2] == "quality"):?>
				<form action="/ajax/?action=ADDREVIEW&review_id=1834" method="POST" id="b-form-review">
				<?else:?>
				<form action="/ajax/?action=ADDREVIEW&product_id=" method="POST" data-file-action="/local/templates/main/addFile.php" id="b-form-review">
				<?endif;?>
				<?if ($urlArr[1] == "catalog"):?>
					<div class="b-review-input">
						Насколько вы довольны покупкой?
						<div class="b-stars-detail">
							<div class="b-star"></div>
							<div class="b-star"></div>
							<div class="b-star"></div>
							<div class="b-star"></div>
							<div class="b-star"></div>
						</div>
						<input type="text" name="item-quality" required>
					</div>
				<?else:?>
					<div class="b-review-input">
						Насколько вы довольны магазином?
						<div class="b-stars-detail">
							<div class="b-star"></div>
							<div class="b-star"></div>
							<div class="b-star"></div>
							<div class="b-star"></div>
							<div class="b-star"></div>
						</div>
						<input type="text" name="store-quality" required>
					</div>
					<div class="b-review-input">
						Оцените качество товара.
						<div class="b-stars-detail">
							<div class="b-star"></div>
							<div class="b-star"></div>
							<div class="b-star"></div>
							<div class="b-star"></div>
							<div class="b-star"></div>
						</div>
						<input type="text" name="goods-quality" required>
					</div>
					<div class="b-review-input">
						Оцените вежливость и профессионализм операторов и менеджеров.
						<div class="b-stars-detail">
							<div class="b-star"></div>
							<div class="b-star"></div>
							<div class="b-star"></div>
							<div class="b-star"></div>
							<div class="b-star"></div>
						</div>
						<input type="text" name="manager-quality" required>
					</div>
					<div class="b-review-input">
						Оцените качество упаковки.
						<div class="b-stars-detail">
							<div class="b-star"></div>
							<div class="b-star"></div>
							<div class="b-star"></div>
							<div class="b-star"></div>
							<div class="b-star"></div>
						</div>
						<input type="text" name="pack-quality" required>
					</div>
					<div class="b-review-input">
						Оцените быстроту доставки и качество работы курьеров.
						<div class="b-stars-detail">
							<div class="b-star"></div>
							<div class="b-star"></div>
							<div class="b-star"></div>
							<div class="b-star"></div>
							<div class="b-star"></div>
						</div>
						<input type="text" name="courier-quality" required>
					</div>
				<?endif;?>
					<div class="b-input-string b-review-textarea">
						<textarea name="comment" cols="30" rows="5" placeholder="Поделитесь своим мнением о товаре, ваш отзыв поможет другим покупателям в выборе" required></textarea>
					</div>
					<div class="b-popup-form">
						<? if(!isAuth()): ?>
						<div class="b-input-container">
							<div class="b-input-string">
								<input type="text" name="name" placeholder="Ваше имя*" required/>
							</div>
							<div class="b-input-string">
								<input type="text" name="phone" placeholder="Ваш телефон*" required/>
							</div>
						</div>
						<?endif;?>
						<?if ($urlArr[1] == "catalog"):?>
						<div id="pluploadCont" class="b-btn b-brown-btn">
							<input id="original_filename" type="hidden" name="original_filename">
							<input id="random_filename" type="hidden" name="random_filename">
							<a class="attach" href="javascript:;" id="pickfiles">
								Выберите файл
							</a>
						</div>
					<?endif;?>
						<input type="text" name="MAIL">
						<input type="submit" style="display:none;">
						<div class="b-btn-container">
							<a href="#" class="b-btn ajax">Отправить</a>
						</div>
						<a href="#b-popup-success-review" class="b-thanks-link fancy" style="display:none;"></a>
					</div>
				</form>
			</div>
			<div class="b-thanks b-popup" id="b-popup-success">
				<div class="b-popup-header">
					<h3>Спасибо!</h3>
					<p>Ваша заявка успешно отправлена.<br/>Наш менеджер свяжется с Вами в течение часа.</p>
				</div>
				<div class="b-btn-container">
					<a href="#" class="b-btn ajax" onclick="$.fancybox.close(); return false;">Закрыть</a>
				</div>
			</div>
			<div class="b-thanks b-popup" id="b-popup-error">
				<div class="b-popup-header">
					<h3>Ошибка!</h3>
					<p>Ваша заявка успешно отправлена.<br/>Наш менеджер свяжется с Вами в течение часа.</p>
				</div>
				<div class="b-btn-container">
					<a href="#" class="b-btn ajax" onclick="$.fancybox.close(); return false;">Закрыть</a>
				</div>
			</div>
			<div class="b-thanks b-popup" id="b-popup-success-review">
				<div class="b-popup-header">
					<h3>Спасибо!</h3>
					<p>Ваш отзыв успешно отправлен и будет опубликован после проверки модератором.</p>
				</div>
				<div class="b-btn-container">
					<a href="#" class="b-btn ajax" onclick="$.fancybox.close(); return false;">Закрыть</a>
				</div>
			</div>
			<div class="b-thanks b-popup" id="b-popup-success-reg">
				<div class="b-popup-header">
					<h3>Спасибо!</h3>
					<p>Ссылка для активации аккаунта была отправлена на Ваш e-mail.</p>
				</div>
				<div class="b-btn-container">
					<a href="#" class="b-btn ajax" onclick="$.fancybox.close(); return false;">Закрыть</a>
				</div>
			</div>
			<!-- <div class="b-thanks b-popup" id="b-popup-error">
				<div class="b-popup-header">
					<h3>Ошибка отправки!</h3>
					<p>Приносим свои извинения. Пожалуйста, попробуйте отправить Вашу заявку позже.</p>
				</div>
				<div class="b-btn-container">
					<a href="#" class="b-btn ajax" onclick="$.fancybox.close(); return false;">Закрыть</a>
				</div>
			</div> -->
		</noindex>
	</div>

	<script type="text/javascript" src="http://pickpoint.ru/select/postamat.js" charset="utf-8"></script>
	
		<? /* ?><script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery-3.2.1.min.js"></script><? */ ?>
		<script type="text/javascript" src="/bitrix/js/main/jquery/jquery-1.8.3.min.js"></script>

	<?if($urlArr[2]=="addresses" && isset($urlArr[4]) || $urlArr[2]=="order"): ?>

			<script type="text/javascript" src="https://api-maps.yandex.ru/2.1.41/?load=package.full&lang=ru-RU"></script>

		<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/AddressDeliveryClass.js"></script>
		<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/address.js"></script>
	<?endif;?>

	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery.fancybox.min.js"></script>
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery.formstyler.min.js"></script>
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery.touch.min.js"></script>
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery.maskedinput.min.js"></script>
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/plupload.full.min.js"></script>
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/KitAnimate.js"></script>
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/KitProgress.js"></script>
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/slideout.min.js"></script>
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/autosize.min.js"></script>
	<? if( !(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE')!==false || strpos($_SERVER['HTTP_USER_AGENT'],'rv:11.0')!==false) ): ?>
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/mask.js"></script>
	<? endif; ?>
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/KitSend.js?<?=$GLOBALS["version"]?>"></script>
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/slick.js"></script>
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/main.js?<?=$GLOBALS["version"]?>"></script>
	<!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (d, w, c) { (w[c] = w[c] || []).push(function() { try {
        w.yaCounter44125994 = new Ya.Metrika({ id:44125994, clickmap:true, trackLinks:true,
        accurateTrackBounce:true, webvisor:true, ecommerce:"dataLayer" }); } catch(e) { } }); var n =
        d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () {
        n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src =
        "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window,
        "yandex_metrika_callbacks");
    </script>
    <noscript>
        <div>
            <img src="https://mc.yandex.ru/watch/44125994" style="position:absolute; left:-9999px;" alt=""/>
        </div>
    </noscript> <!-- /Yandex.Metrika counter -->
</body>
</html>