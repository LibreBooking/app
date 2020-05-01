{*
Copyright 2020 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*}
<div class="row">
	<div id="updateUserResults" class="alert alert-danger no-show validationSummary">
		<ul>
            {async_validator id="emailformat" key="ValidEmailRequired"}
            {async_validator id="uniqueemail" key="UniqueEmailRequired"}
            {async_validator id="uniqueusername" key="UniqueUsernameRequired"}
            {async_validator id="updateAttributeValidator" key=""}
		</ul>
	</div>
	<div class="col s12 m6">
		<div class="input-field">
			<label for="username" class="active">{translate key="Username"} *</label>
			<input type="text" {formname key="USERNAME"} class="required" required
				   id="username" value="{$User->Username()|escape:html}"/>
		</div>
	</div>

	<div class="col s12 m6">
		<div class="input-field">
			<label for="email" class="active">{translate key="Email"} *</label>
			<input type="text" {formname key="EMAIL"} class="required" required
				   id="email" value="{$User->EmailAddress()|escape:html}"/>
		</div>
	</div>

	<div class="col s12 m6">
		<div class="input-field">
			<label for="fname" class="active">{translate key="FirstName"} *</label>
			<input type="text" {formname key="FIRST_NAME"} class="required" required
				   id="fname" value="{$User->FirstName()|escape:html}"/>
		</div>
	</div>

	<div class="col s12 m6">
		<div class="input-field">
			<label for="lname" class="active">{translate key="LastName"} *</label>
			<input type="text" {formname key="LAST_NAME"} class="required" required
				   id="lname" value="{$User->LastName()|escape:html}"/>
		</div>
	</div>

	<div class="col s12 m6">
		<div class="input-field">
			<label for="timezone" class="active">{translate key="Timezone"}</label>
			<select {formname key='TIMEZONE'} id='timezone' class="">
                {html_options values=$Timezones output=$Timezones selected="{$User->Timezone()}"}
			</select>
		</div>
	</div>

	<div class="col s12 m6">
		<div class="input-field">
			<label for="phone" class="active">{translate key="Phone"}</label>
			<input type="text" {formname key="PHONE"} class="" id="phone" value="{$User->GetAttribute(UserAttribute::Phone)|escape:html}"/>
		</div>
	</div>

	<div class="col s12 m6">
		<div class="input-field">
			<label for="organization" class="active">{translate key="Organization"}</label>
			<input type="text" {formname key="ORGANIZATION"} class=""
				   id="organization" value="{$User->GetAttribute(UserAttribute::Organization)|escape:html}"/>
		</div>
	</div>

	<div class="col s12 m6">
		<div class="input-field" class="active">
			<label for="position">{translate key="Position"}</label>
			<input type="text" {formname key="POSITION"} class="" id="position" value="{$User->GetAttribute(UserAttribute::Position)|escape:html}"/>
		</div>
	</div>

	{foreach from=$Attributes item=attribute}
		<div class="col s12 m6">
			{control type="AttributeControl" attribute=$attribute value={$User->GetAttributeValue($attribute->Id())} }
		</div>
	{/foreach}
		<div class="clearfix">&nbsp;</div>
</div>