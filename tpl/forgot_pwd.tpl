{assign var='DisplayWelcome' value='false'} 
{include file='loginheader.tpl'}

	{if $ShowResetEmailSent}
		<div class="success">
			{translate key=ForgotPasswordEmailSent}<br/>
			<a href="{$Path}{Pages::LOGIN}">{translate key="LogIn"}</a>
		</div>
	{/if}

<div id="forgotbox">
	<form class="forgot" method="post"
		action="{$smarty.server.SCRIPT_NAME}">
		<div class="forgot_pwdHeader">
			<h3>{translate key='Forgot Password'}</h3>
		</div>
		<div>
			<p class="forgot">{translate key='This will change your password to a new, randomly generated one.'}
			</p>
			<p class="forgot">{translate key='your new password will be set'}</p>
			<p>
				<label class="forgot">{translate key='Email address'}<br />
					{textbox name="EMAIL" class="input" size="20" tabindex="10"}</label>
			</p>
			<p class="resetpassword">
				<button type="submit" class="button" name="{Actions::RESET}" value="{Actions::RESET}">{html_image src="tick-circle.png"} {translate key='Change Password'}</button>
			</p>
		</div>
	</form>
</div>

{setfocus key='EMAIL'} 

{include file='globalfooter.tpl'}