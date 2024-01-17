{include file='globalheader.tpl'}

<div id="page-login">
	{if $ShowLoginError}
		<div id="loginError" class="alert alert-danger">
			{translate key='LoginError'}
		</div>
	{/if}

    {if $EnableCaptcha}
        {validation_group class="alert alert-danger"}
        {validator id="captcha" key="CaptchaMustMatch"}
        {/validation_group}
    {/if}

    {if $Announcements|default:array()|count > 0}
        <div id="announcements" class="col-sm-8 col-sm-offset-2 col-xs-12">
        {foreach from=$Announcements item=each}
            <div class="announcement">{$each->Text()|html_entity_decode|url2link|nl2br}</div>
        {/foreach}
        </div>
    {/if}

	<div class="col-md-offset-3 col-md-6 col-xs-12 ">
		<form role="form" name="login" id="login" class="form-horizontal" method="post"
			  action="{$smarty.server.SCRIPT_NAME}">
			<div id="login-box" class="col-xs-12 default-box">
				<div class="col-xs-12 login-icon">
					{html_image src="$LogoUrl?{$Version}" alt="$Title"}
				</div>
				{if $ShowUsernamePrompt}
					<div class="col-xs-12">
						<div class="input-group margin-bottom-25">
							<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
							<input type="text" required="" class="form-control"
								   id="email" {formname key=EMAIL}
								   placeholder="{translate key=UsernameOrEmail}"/>
						</div>
					</div>
				{/if}

				{if $ShowPasswordPrompt}
					<div class="col-xs-12">
						<div class="input-group margin-bottom-25">
							<span class="input-group-addon">
							<i class="glyphicon glyphicon-lock"></i>
							</span>
							<input type="password" required="" id="password" {formname key=PASSWORD}
								   class="form-control"
								   value="" placeholder="{translate key=Password}"/>
						</div>
					</div>
				{/if}

                {if $EnableCaptcha}
                    <div class="col-xs-12">
                        <div class="margin-bottom-25">
                        {control type="CaptchaControl"}
                        </div>
                    </div>
                {else}
                    <input type="hidden" {formname key=CAPTCHA} value=""/>
                {/if}

				{if $ShowUsernamePrompt &&  $ShowPasswordPrompt}
				<div class="col-xs-12">
					<button type="submit" class="btn btn-large btn-primary  btn-block" name="{Actions::LOGIN}"
							value="submit">{translate key='LogIn'}</button>
					<input type="hidden" {formname key=RESUME} value="{$ResumeUrl}"/>
				</div>
				{/if}

				{if $ShowUsernamePrompt &&  $ShowPasswordPrompt}
				<div class="col-xs-12 {if $ShowRegisterLink}col-sm-6{/if}">
					<div class="checkbox">
						<input id="rememberMe" type="checkbox" {formname key=PERSIST_LOGIN}>
						<label for="rememberMe">{translate key=RememberMe}</label>
					</div>
				</div>
				{/if}

                {if $ShowRegisterLink}
                    <div class="col-xs-12 col-sm-6 register">
                    <span class="bold">{translate key="FirstTimeUser?"}
                    <a href="{$RegisterUrl}" {if isset($RegisterUrlNew)}{$RegisterUrlNew}{/if}
                       title="{translate key=Register}">{translate key=Register}</a>
                    </span>
                    </div>
                {/if}

				<div class="clearfix"></div>

				{if $AllowGoogleLogin && $AllowFacebookLogin && $AllowMicrosoftLogin}
					{assign var=socialClass value="col-sm-12 col-md-6"}
				{else}
					{assign var=socialClass value="col-sm-12"}
				{/if}
				<section style="display:flex; margin-top:8px;">
					{if $AllowGoogleLogin}
						<div class="{$socialClass} social-login" id="socialLoginGoogle">
							<a href="{$GoogleUrl}">
									<img src="img/external/btn_google_signin_dark_normal_web.png" alt="Sign in with Google"/>
							</a>
						</div>
					{/if}
					{if $AllowMicrosoftLogin}
						<div class="{$socialClass} social-login" id="socialLoginOffice" class="container">
							<a href="{$MicrosoftUrl}">
								<img style="max-height:42px;" src="img/external/microsoft-logo.jpeg" alt="Sign in with Microsoft"/>
							</a>
						</div>
					{/if}
					{if $AllowFacebookLogin}
						<div class="{$socialClass} social-login" id="socialLoginFacebook">
							<a href="{$FacebookUrl}">
								<img style="max-height:42px" src="img/external/facebook-logo.png" alt="Sign in with Facebook"/>
							</a>
						</div>
					{/if}
				</section>
				{if $facebookError}
					<p style="text-align:center; margin-top:10px; margin-bottom:auto" class="text-primary"> {translate key="FacebookLoginErrorMessage"} </p>
				{/if}
			</div>
			<div id="login-footer" class="col-xs-12">
				{if $ShowForgotPasswordPrompt}
					<div id="forgot-password" class="col-xs-12 col-sm-6">
						<a href="{$ForgotPasswordUrl}" {if isset($ForgotPasswordUrlNew)}{$ForgotPasswordUrlNew}{/if} class="btn btn-link pull-left-sm"><span><i
										class="glyphicon glyphicon-question-sign"></i></span> {translate key='ForgotMyPassword'}</a>
					</div>
				{/if}
				<div id="change-language" class="col-xs-12 col-sm-6">
					<button type="button" class="btn btn-link pull-right-sm" data-toggle="collapse"
							data-target="#change-language-options"><span><i class="glyphicon glyphicon-globe"></i></span>
						{translate key=ChangeLanguage}
					</button>
					<div id="change-language-options" class="collapse">
						<select {formname key=LANGUAGE} class="form-control input-sm" id="languageDropDown">
							{object_html_options options=$Languages key='GetLanguageCode' label='GetDisplayName' selected=$SelectedLanguage}
						</select>
					</div>
				</div>
			</div>


		</form>
	</div>
</div>

{setfocus key='EMAIL'}

{include file="javascript-includes.tpl"}

<script type="text/javascript">
	var url = 'index.php?{QueryStringKeys::LANGUAGE}=';
	$(document).ready(function () {
		$('#languageDropDown').change(function () {
			window.location.href = url + $(this).val();
		});

		var langCode = readCookie('{CookieKeys::LANGUAGE}');

		if (!langCode)
		{
			langCode = (navigator.language+"").replace("-", "_").toLowerCase();

			var availableLanguages = [{foreach from=$Languages item=lang}"{$lang->GetLanguageCode()}",{/foreach}];
			if (langCode !== "" && langCode != '{$SelectedLanguage|lower}') {
				if (availableLanguages.indexOf(langCode) !== -1)
				{
					window.location.href = url + langCode;
				}
			}
		}
	});
</script>
{include file='globalfooter.tpl'}
