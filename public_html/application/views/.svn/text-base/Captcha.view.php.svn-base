<?php

class Captcha extends Render{

	public function render(){

		ob_start();
		
		?>
		<div class='captcha-margin'>
			<!--		 pass a session id to the query string of the script to prevent ie caching -->
			<div id='capchaImage'>
				<img alt="<?= Util::getLiteral('loading')?>" title="<?= Util::getLiteral('security_code')?>" src="/core/thirdparty/securimage/securimage_show.php?sid=<?php echo md5(uniqid(time())); ?>">
			</div>
			<div id='completeCaptchaMessage'><label for="captcha_code"><?= Util::getLiteral('enter_security_code')?></label></div>
			<div id='userCaptchaCode'>
				<input id='captcha_code' type="text" name="captcha_code" class="input-text" style="width:50px;" size="4" maxlength="4"/>
			</div>
		</div>

		<?php 
		
		return ob_get_clean();

	}
}