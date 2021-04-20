{include file='globalheader.tpl'}

{if $Enabled}

	{if $ShowResetEmailSent}
		<div class="alert alert-success">
			{translate key=ForgotPasswordEmailSent}<br/>
			<a href="{$Path}{Pages::LOGIN}">{translate key="LogIn"}</a>
		</div>
	{/if}

<div id="forgotbox">
	<form class="forgot" method="post" action="{$smarty.server.SCRIPT_NAME}">
		<div class="forgot_pwdHeader">
			<h1>{translate key='ForgotPassword'}</h1>
		</div>
		<div>
			<p class="forgot">{translate key='YouWillBeEmailedANewPassword'}</p>
			<p>
				<label class="forgot">{translate key='EmailAddress'}<br />
					{textbox name="EMAIL" class="input" required="required" size="20" tabindex="10"}</label>
			</p>
			<p class="resetpassword">
				<button type="submit" class="btn btn-default" name="{Actions::RESET}" value="{Actions::RESET}">{translate key='ChangePassword'}</button>
			</p>
		</div>
	</form>
</div>

{setfocus key='EMAIL'}
{else}
<div class="error">Disabled</div>
{/if}

{include file="javascript-includes.tpl"}
{include file='globalfooter.tpl'}
