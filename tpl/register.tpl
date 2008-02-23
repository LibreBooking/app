{include file='header.tpl'}
<form name="register" method="post" action="{$smarty.server.SCRIPT_NAME}">
<div>
<!-- validation_group class="error" -->
{validator id="fname" key="FirstNameRequired"}
{validator id="lname" key="LastNameRequired"}
{validator id="passwordmatch" key="PwMustMatch"}
{validator id="passwordcomplexity" key="PwComplexity"}
{validator id="emailformat" key="ValidEmailRequired"}
{validator id="uniqueemail" key="UniqueEmailRequired"}
{validator id="uniqueusername" key="UniqueUsernameRequired"}
<!-- /validation_group -->
</div>

<table>
	<tr>
		<td>{translate key="FirstName"}</td>
		<td>{translate key="LastName"}</td>
	</tr>
	<tr>
		<td>{textbox name="FIRST_NAME" class="textbox" value="FirstName"}</td>
		<td><input type="text" name="{constant echo='FormKeys::LAST_NAME'}" class="textbox" value="{$LastName|escape}" /></td>
	</tr>
	<tr>
		<td colspan="2">{translate key="Timezone"}</td>
	</tr>
	<tr>
		<td colspan="2">
			<select name="{constant echo='FormKeys::TIMEZONE'}" class="textbox">
				{html_options values=$TimezoneValues output=$TimezoneOutput selected=$Timezone}	
			</select>
		</td>
	</tr>
</table>

<input type="submit" name="{constant echo='Actions::REGISTER'}" value="{translate key='Register'}" class="button" />
</form>
{include file='footer.tpl'}