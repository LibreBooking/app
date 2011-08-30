{assign var='DisplayWelcome' value='false'} 
{include file='loginheader.tpl'}
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
				<button type="submit" class="button update prompt" name="{Actions::RESET}"><img src="img/tick-circle.png" />  {translate key='Change Password'}</button>
			    <input type="hidden" name="{FormKeys::RESUME}" value="{$ResumeUrl}" />
			</p>
		</div>
	</form>
</div>

{setfocus key='EMAIL'} 

{include file='globalfooter.tpl'}