<section class="login">
	<header>
		<a href="<?=_cfg('site')?>" target="_blank"><img src="<?=_cfg('cmsimg')?>/logo.png" /></a>
	</header>
    
    <div class="body">
        <? if (isset($this->data->login_error) && $this->data->login_error == 1) { ?>
            <div class="errmsg">
                <div class="msgs_text"><?=$this->messages['login_error']?></div>
    		</div>
    	<? } ?>
        
        <form method="post">
            <input type="text" name="login" id="login" placeholder="Login" />
            <input type="password" name="password" id="password" placeholder="Password" />
            
            <? if (isset($_SESSION['recaptcha_login']) && $_SESSION['recaptcha_login'] >= _cfg('availableLoginAttempts')) { ?>
                <div class="recaptcha">
                    Too many fail attempts, please prove that you're not a robot!
                    <div class="g-recaptcha" data-sitekey="<?=_cfg('recaptchaSiteKey')?>"></div>
                </div>
            <? } ?>
            
            <input type="submit" value="Enter" name="submit_login" onclick="$(this).attr('readonly', 'readonly');" class="enter" />
            
            <? if (_cfg('demo') == 1) { ?>
			<div id="login_guest_form">
				<button onclick="$('#login').val('Demo'); $('#password').val('demo'); $('.enter').trigger('click'); return false;">Login as Demo</button>
			</div>
            <? } ?>
		</form>
    </div>
    
    <footer>
        <div class="fleft"><a href="http://www.themages.net/" target="_blank">CMS Version: <?=$this->data->cmsSettings['version']?></a></div>
    	<div class="fright"><a href="http://www.maxorlovsky.net" target="_blank">Max Orlovsky <span>&copy;</span> 2011-<?=date('Y')?></a></div>
    	<div class="clear"></div>
    </footer>
    
</section>

<? if (isset($_SESSION['recaptcha_login']) && $_SESSION['recaptcha_login'] >= _cfg('availableLoginAttempts')) { ?>
<script src='https://www.google.com/recaptcha/api.js'></script>
<? } ?>