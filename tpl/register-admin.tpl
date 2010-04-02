{include file='header.tpl' DisplayWelcome='false'}
<div id="reg-adminbox">
<form class="reg-admin" method="post" action="{$smarty.server.SCRIPT_NAME}">

{validation_group class="error"}
        {validator id="name" key="NameRequired"}
{/validation_group}

	<div class="reg-adminHeader"><h3>Registration form administration</h3></div>
	<div>
		<table class="reg-admin">
			<tr><th class="admin-fieldHeading">{translate key="FormFields"}</th>
				<th class="admin-radio">{translate key="RadioRequired"}</th>
				<th class="admin-radio">{translate key="RadioOptional"}</th>
				<th class="admin-radio">{translate key="RadioRemoved"}</th>
			</tr>
			<tr>
				<td class="admin-fieldName">{translate key="FirstName"}</td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::FIRST_NAME'}" value="1" checked="checked" tabindex="11" /></td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::FIRST_NAME'}" value="2" tabindex="12" /></td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::FIRST_NAME'}" value="3" tabindex="13" /></td>
			</tr>
			<tr>
				<td class="admin-fieldName">{translate key="LastName"}</td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::LAST_NAME'}" value="1" checked="checked" tabindex="21" /></td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::LAST_NAME'}" value="2" tabindex="22" /></td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::LAST_NAME'}" value="3" tabindex="23" /></td>
			</tr>
			<tr>
				<td class="admin-fieldName">{translate key="Username"}</td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::USERNAME'}" value="1" checked="checked" tabindex="31" /></td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::USERNAME'}" value="2" tabindex="32" /></td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::USERNAME'}" value="3" tabindex="33" /></td>
			</tr>
			<tr>
				<td class="admin-fieldName">{translate key="Email"}</td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::EMAIL'}" value="1" checked="checked" tabindex="41" /></td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::EMAIL'}" value="2" tabindex="42" /></td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::EMAIL'}" value="3" tabindex="43" /></td>
			</tr>
			<tr>
				<td class="admin-fieldName">{translate key="PasswordAndConfirmation"}</td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::PASSWORD'}" value="1" checked="checked" tabindex="51" /></td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::PASSWORD'}" value="2" tabindex="52" /></td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::PASSWORD'}" value="3" tabindex="53" /></td>
			</tr>
			<tr>
				<td class="admin-fieldName">{translate key="OrganizationSelection"}</td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::ORGANIZATION'}" value="1" tabindex="61" /></td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::ORGANIZATION'}" value="2" checked="checked" tabindex="62" /></td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::ORGANIZATION'}" value="3" tabindex="63" /></td>
			</tr>
			<tr>
				<td class="admin-fieldName">{translate key="Group"}</td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::GROUP'}" value="1" tabindex="71" /></td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::GROUP'}" value="2" checked="checked" tabindex="72" /></td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::GROUP'}" value="3" tabindex="73" /></td>
			</tr>
			<tr>
				<td class="admin-fieldName">{translate key="Position"}</td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::POSITION'}" value="1" tabindex="81" /></td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::POSITION'}" value="2" checked="checked" tabindex="82" /></td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::POSITION'}" value="3" tabindex="83" /></td>
			</tr>
			<tr>
				<td class="admin-fieldName">{translate key="Address"}</td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::ADDRESS'}" value="1" tabindex="91" /></td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::ADDRESS'}" value="2" checked="checked" tabindex="92" /></td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::ADDRESS'}" value="3" tabindex="93" /></td>
			</tr>
			<tr>
				<td class="admin-fieldName">{translate key="Phone"}</td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::PHONE'}" value="1" checked="checked" tabindex="101" /></td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::PHONE'}" value="2" checked="checked" tabindex="102" /></td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::PHONE'}" value="3" tabindex="103" /></td>
			</tr>
			<tr>
				<td class="admin-fieldName">{translate key="Homepage"}</td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::DEFAULT_HOMEPAGE'}" value="1" tabindex="111" /></td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::DEFAULT_HOMEPAGE'}" value="2" checked="checked" tabindex="112" /></td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::DEFAULT_HOMEPAGE'}" value="3" tabindex="113" /></td>
			</tr>
			<tr class="admin-lastline">
				<td class="admin-fieldName">{translate key="TimezoneSelection"}</td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::TIMEZONE'}" value="1" tabindex="121" /></td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::TIMEZONE'}" value="2" tabindex="122" /></td>
                <td class="center"><input type="radio" class="admin-radio" name="{constant echo='FormKeys::TIMEZONE'}" value="3" checked="checked" tabindex="123" /></td>
			</tr>
		</table>
	</div>
	<div id="reg-adminbox-footer">
        <p class="reg-adminsubmit">
                <input type="submit" name="{constant echo='Actions::SAVE'}" value="{translate key='Save'}" class="button" tabindex="200" />
        </p>
	</div>
</form>
</div>
{setfocus key='RESOURCE_NAME'}
{include file='footer.tpl'}
