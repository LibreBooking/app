{include file='globalheader.tpl'}

{if $Enabled}

<div id="forgotbox" class="offset-md-3 col-md-6 col-xs-12 center mt-4 shadow-sm border rounded">
	<!-- Aler goes here for a nice width same as form -->
	{if $ShowResetEmailSent}
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			{translate key=ForgotPasswordEmailSent}<br/>
			<a href="{$Path}{Pages::LOGIN}">{translate key="LogIn"}</a>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	{/if}
	<form class="forgot" method="post" action="{$smarty.server.SCRIPT_NAME}">
		<div class="forgot_pwdHeader mt-2">
			<h1>{translate key='ForgotPassword'}</h1>
		</div>
		<div>
			<p class="forgot">{translate key='YouWillBeEmailedANewPassword'}</p>
			<p>
				<label class="forgot">{translate key='EmailAddress'}<br />
					{textbox name="EMAIL" class="input" type="email" required="required" size="20" tabindex="10"}</label>
			</p>
			<p class="resetpassword">
				<button type="submit" class="btn btn-sm btn-primary" name="{Actions::RESET}" value="{Actions::RESET}">{translate key='ChangePassword'}</button>
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
