{include file='header.tpl'}
<form name="register" method="post" action="{$smarty.server.SCRIPT_NAME}">
<div>
{validator id="fname" key="First name is required."}
{validator id="email" key="First name is required."}
</div>

<input type="text" name="{constant echo='FormKeys::FIRST_NAME'}" class="textbox" value="{$FirstName|escape}" />
<select name="{constant echo='FormKeys::TIMEZONE'}" class="textbox">
	{html_options values=$TimezoneValues output=$TimezoneOutput selected=$Timezone}	
</select>
<input type="submit" name="{constant echo='Actions::REGISTER'}" value="{translate key='Register'}" class="button" />
</form>
{include file='footer.tpl'}