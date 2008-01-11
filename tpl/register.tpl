{include file='header.tpl'}
<form name="register" method="post" action="{$smarty.server.SCRIPT_NAME}">
<select name="{constant echo='FormKeys::TIMEZONE'}" class="textbox">
	{html_options values=$TimezoneValues output=$TimezoneOutput selected=$Timezone}	
</select>
</form>
{include file='footer.tpl'}