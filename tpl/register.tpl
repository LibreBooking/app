{include file='header.tpl'}

<form name="register" method="post" action="{$smarty.server.SCRIPT_NAME}">

{validation_group class="error"}
	{validator id="fname" key="FirstNameRequired"}
	{validator id="lname" key="LastNameRequired"}
	{validator id="passwordmatch" key="PwMustMatch"}
	{validator id="passwordcomplexity" key="PwComplexity"}
	{validator id="emailformat" key="ValidEmailRequired"}
	{validator id="uniqueemail" key="UniqueEmailRequired"}
	{validator id="uniqueusername" key="UniqueUsernameRequired"}
{/validation_group}

<div class="registration">
	
	<div class="registrationHeader">Account Registration (all fields are required)</div>
	
	<table>
		<tr>
			<td>{translate key="FirstName"}</td>
		</tr>
		<tr>
			<td>{textbox name="FIRST_NAME" class="textbox" value="FirstName"}</td>
		</tr>
		<tr>
			<td>{translate key="LastName"}</td>
		</tr>
		<tr>
			<td>{textbox name="LAST_NAME" class="textbox" value="LastName"}</td>
		</tr>
		<tr>
			<td>{translate key="Email"}</td>
		</tr>
		<tr>
			<td>{textbox name="EMAIL" class="textbox" value="Email"}</td>
		</tr>
		<tr>
			<td>{translate key="Phone"}</td>
		</tr>
		<tr>
			<td>{textbox name="PHONE" class="textbox" value="Phone"}</td>
		</tr>
		<tr>
			<td>{translate key="Timezone"}</td>
		</tr>
		<tr>
			<td colspan="2">
				<select name="{constant echo='FormKeys::TIMEZONE'}" class="textbox">
					{html_options values=$TimezoneValues output=$TimezoneOutput selected=$Timezone}	
				</select>
			</td>
		</tr>
	</table>
	
	<div class="registrationHeader">Optional Fields</div>
	
	<table>
		<tr>
			<td>{translate key="Institution"}</td>
		</tr>
			<tr>
			<td>{textbox name="INSTITUTION" class="textbox" value="Institution"}</td>
		</tr>
		<tr>
			<td>{translate key="Position"}</td>
		</tr>
			<tr>
			<td>{textbox name="POSITION" class="textbox" value="Position"}</td>
		</tr>
	</table>
	
	<div class="registrationHeader">Login Information (all fields are required)</div>
	
	<table>
		<tr>
			<td>{translate key="Username"}</td>
		</tr>
		<tr>
			<td>{textbox name="LOGIN" class="textbox" value="Login"}</td>
		</tr>
		<tr>
			<td>{translate key="Password"}</td>
		</tr>
		<tr>
			<td>{textbox type="password" name="PASSWORD" class="textbox" value="Institution"}</td>
		</tr>	
		<tr>
			<td>{translate key="PasswordConfirmation"}</td>
		</tr>
		<tr>
			<td>{textbox type="password" name="PASSWORD_CONFIRM" class="textbox" value="Institution"}</td>
		</tr>
	</table>
	
	<hr/>
	<input type="submit" name="{constant echo='Actions::REGISTER'}" value="{translate key='Register'}" class="button" />
</div>
</form>
{include file='footer.tpl'}