{include file='globalheader.tpl' DisplayWelcome='false'}
<div id="reportingbox">
<form class="reports" method="post" action="{$smarty.server.SCRIPT_NAME}">

{validation_group class="error"}
        {validator id="name" key="NameRequired"}
{/validation_group}

	<div class="reportingHeader"><h3>Scheduler report generator</h3></div>
	<div>
		<table class="reportingn">
			<tr><th class="admin-fieldHeading">{translate key="FormFields"}</th>
				<th class="reporting">{translate key="Included"}</th>
			</tr>
			<tr>
				<td class="admin-fieldName">{translate key="FirstName"}</td>
                <td class="center"><input type="checkbox" class="admin-radio" name="{constant echo='FormKeys::FIRST_NAME'}" value="1" checked="checked" tabindex="11" /></td>
			</tr>
			<tr>
				<td class="admin-fieldName">{translate key="LastName"}</td>
                <td class="center"><input type="checkbox" class="admin-radio" name="{constant echo='FormKeys::LAST_NAME'}" value="1" checked="checked" tabindex="11" /></td>
			</tr>
			<tr>
				<td class="admin-fieldName">{translate key="Username"}</td>
				<td class="center"><input type="checkbox" class="admin-radio" name="{constant echo='FormKeys::USERNAME'}" value="1" checked="checked" tabindex="11" /></td>
			</tr>
			<tr>
				<td class="admin-fieldName">{translate key="OrganizationSelection"}</td>
				<td class="center"><input type="checkbox" class="admin-radio" name="{constant echo='FormKeys::ORGANIZATION'}" value="1" checked="checked" tabindex="11" /></td>
			</tr>
			<tr>
				<td class="admin-fieldName">{translate key="Group"}</td>
				<td class="center"><input type="checkbox" class="admin-radio" name="{constant echo='FormKeys::GROUP'}" value="1" checked="checked" tabindex="11" /></td>
			</tr>
		</table>
	</div>
	<div id="reportingbox-footer">
        <p class="reporting-submit">
                <input type="submit" name="{constant echo='Actions::GET_REPORT'}" value="{translate key='GetReport'}" class="button" tabindex="200" />
        </p>
	</div>
</form>
</div>
{setfocus key='RESOURCE_NAME'}
{include file='globalfooter.tpl'}
