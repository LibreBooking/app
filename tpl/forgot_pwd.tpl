{assign var='DisplayWelcome' value='false'}
{include file='loginheader.tpl'}
<div id="forgotbox">

<form class="forgot" method="post" action="{$smarty.server.SCRIPT_NAME}">
	<div class="forgot_pwdHeader"><h3>Reset forgotten password</h3></div>
<div>
	<p class="forgot">You can reset your password to a new, randomly generated one by pressing the <strong>Reset</strong> button.</p>
	<p class="forgot">The new password will be emailed to the address written below.</p>
<p>
        <label class="forgot">{translate key='Email address'}<br />
        {textbox name="EMAIL" class="input" size="20" tabindex="10"}</label>
</p>
<p class="resetpassword">
        <input type="submit" name="{constant echo='Actions::RESET'}" value="{translate key='Reset'}" class="button" tabindex="100" />
        <input type="hidden" name="{constant echo='FormKeys::RESUME'}" value="{$ResumeUrl}" />
</p>
</div>
</form>
</div>

{setfocus key='EMAIL'}

{include file='footer.tpl'}