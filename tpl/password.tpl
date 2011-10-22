{include file='globalheader.tpl'}

{validation_group class="error"}
	{validator id="currentpassword" key="InvalidPassword"}
	{validator id="passwordmatch" key="PwMustMatch"}
	{validator id="passwordcomplexity" key="PwComplexity"}
{/validation_group}


{if $ResetPasswordSuccess}
<div class="success">
	{translate key=PasswordChangedSuccessfully}
</div>
{/if}

<div id="registrationbox">
	<form class="register" method="post" action="{$smarty.server.SCRIPT_NAME}">
		<div class="registrationHeader"><h3>{translate key="ChangePassword"}</h3></div>
		<p>
			<label class="reg">{translate key="CurrentPassword"}<br/>
			{textbox type="password" name="CURRENT_PASSWORD" class="input" size="20"}
			</label>
		</p>

		<p>
			<label class="reg">{translate key="NewPassword"}<br/>
			{textbox type="password" name="PASSWORD" class="input" value="" size="20"}
			</label>
		</p>

		<p>
			<label class="reg">{translate key="PasswordConfirmation"}<br/>
			{textbox type="password" name="PASSWORD_CONFIRM" class="input" value="" size="20"}
			</label>
		</p>

		<p class="regsubmit">
			<button type="submit" name="{Actions::CHANGE_PASSWORD}" value="{translate key='ChangePassword'}"
					class="button">{html_image src="tick-circle.png"} {translate key='ChangePassword'}</button>
		</p>
	</form>
</div>
{setfocus key='LOGIN'}
{include file='globalfooter.tpl'}