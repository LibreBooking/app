{*
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*}
{include file='globalheader.tpl'}

{if $ProfileUpdated}
	<div class="success">{translate key=YourProfileWasUpdated}</div>
{/if}

	{validation_group class="error"}
			{validator id="fname" key="FirstNameRequired"}
			{validator id="lname" key="LastNameRequired"}
			{validator id="username" key="UserNameRequired"}
			{validator id="emailformat" key="ValidEmailRequired"}
			{validator id="uniqueemail" key="UniqueEmailRequired"}
			{validator id="uniqueusername" key="UniqueUsernameRequired"}
	{/validation_group}

<div id="registrationbox">
<form class="register" method="post" action="{$smarty.server.SCRIPT_NAME}">
    <div class="registrationHeader"><h3>{translate key=Login} ({translate key=AllFieldsAreRequired})</h3></div>
	<p>
		<label class="reg">{translate key="Username"}<br />
		{textbox name="USERNAME" class="input" value="Username" size="20"}
		</label>
	</p>
	<p>
		<label class="reg">{translate key="DefaultPage"}<br />
				<select {formname key='DEFAULT_HOMEPAGE'} class="input">
						{html_options values=$HomepageValues output=$HomepageOutput selected=$Homepage}
				</select>
		</label>
	</p>
	<div class="registrationHeader"><h3>{translate key=Profile} ({translate key=AllFieldsAreRequired})</h3></div>
	<p>
		<label class="reg">{translate key="FirstName"}<br />
		{textbox name="FIRST_NAME" class="input" value="FirstName" size="20"}
		</label>
	</p>
	<p>
		<label class="reg">{translate key="LastName"}<br />
		{textbox name="LAST_NAME" class="input" value="LastName" size="20"}
		</label>
	</p>
	<p>
		<label class="reg">{translate key="Email"}<br />
		{textbox name="EMAIL" class="input" value="Email" size="20"}
		</label>
	</p>
	<p>
		<label class="reg">{translate key="Timezone"}<br />
				<select {formname key='TIMEZONE'} class="input">
						{html_options values=$TimezoneValues output=$TimezoneOutput selected=$Timezone}
				</select>
		</label>
	</p>

	<div class="registrationHeader"><h3>{translate key=AdditionalInformation} ({translate key=Optional})</h3></div>
	<p>
		<label class="reg">{translate key="Phone"}<br />
		{textbox name="PHONE" class="input" value="Phone" size="20"}
		</label>
	</p>
	<p>
		<label class="reg">{translate key="Organization"}<br />
		{textbox name="ORGANIZATION" class="input" value="Organization" size="20"}
		</label>
	</p>
	<p>
		<label class="reg">{translate key="Position"}<br />
		{textbox name="POSITION" class="input" value="Position" size="20"}
		</label>
	</p>


	<p class="regsubmit">
        <button type="submit" class="button update prompt" name="{Actions::SAVE}">
			<img src="img/tick-circle.png" />{translate key='Update'}
	    </button>
	</p>
</form>
</div>
{setfocus key='FIRST_NAME'}
{include file='globalfooter.tpl'}