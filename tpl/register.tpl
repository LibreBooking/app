{*
Copyright 2011-2014 Nick Korbel

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
{include file='globalheader.tpl' cssFiles='scripts/css/colorbox.css'}

<div class="page-register">

	<div class="validationSummary error" id="validationErrors">
		<ul>
			{async_validator id="fname" key="FirstNameRequired"}
			{async_validator id="lname" key="LastNameRequired"}
			{async_validator id="username" key="UserNameRequired"}
			{async_validator id="passwordmatch" key="PwMustMatch"}
			{async_validator id="passwordcomplexity" key="PwComplexity"}
			{async_validator id="emailformat" key="ValidEmailRequired"}
			{async_validator id="uniqueemail" key="UniqueEmailRequired"}
			{async_validator id="uniqueusername" key="UniqueUsernameRequired"}
			{async_validator id="captcha" key="CaptchaMustMatch"}
			{async_validator id="additionalattributes" key=""}
		</ul>
	</div>

	<div class="error" id="registrationError" style="display:none;">
		{translate key=UnknownError}
	</div>

	<div id="registrationbox">
		<form class="register" method="post" ajaxAction="{RegisterActions::Register}" id="frmRegister"
			  action="{$smarty.server.SCRIPT_NAME}" role="form">
			<div class="registrationHeader"><h3>{translate key=Login} ({translate key=AllFieldsAreRequired})</h3></div>
			<div class="form-group">
				<label class="reg" for="login">{translate key="Username"}</label>
				{textbox name="LOGIN" value="Login" size="20"}
			</div>

			<div class="form-group">
				<label class="reg" for="password">{translate key="Password"}</label>
				{textbox type="password" name="PASSWORD" value="" size="20"}
			</div>

			<div class="form-group">
				<label class="reg" for="passwordConfirm">{translate key="PasswordConfirmation"}</label>
				{textbox type="password" name="PASSWORD_CONFIRM" value="" size="20"}
			</div>

			<div class="form-group">
				<label class="reg" for="homepage">{translate key="DefaultPage"}</label>
				<select {formname key='DEFAULT_HOMEPAGE'} id="homepage" class="form-control">
					{html_options values=$HomepageValues output=$HomepageOutput selected=$Homepage}
				</select>
			</div>

			<div class="registrationHeader"><h3>{translate key=Profile} ({translate key=AllFieldsAreRequired})</h3>
			</div>
			<div class="form-group">
				<label class="reg" for="fname">{translate key="FirstName"}</label>
				{textbox name="FIRST_NAME" class="input" value="FirstName" size="20"}
			</div>

			<div class="form-group">
				<label class="reg" for="lname">{translate key="LastName"}</label>
				{textbox name="LAST_NAME" class="input" value="LastName" size="20"}
			</div>

			<div class="form-group">
				<label class="reg" for="email">{translate key="Email"}</label>
				{textbox name="EMAIL" class="input" value="Email" size="20"}
			</div>

			<div class="form-group">
				<label class="reg" for="timezoneDropDown">{translate key="Timezone"}</label>
				<select {formname key='TIMEZONE'} class="form-control" id="timezoneDropDown">
					{html_options values=$TimezoneValues output=$TimezoneOutput selected=$Timezone}
				</select>
			</div>

			<div class="registrationHeader"><h3>{translate key="AdditionalInformation"} ({translate key=Optional})</h3>
			</div>
			<div class="form-group">
				<label class="reg" for="phone">{translate key="Phone"}</label>
				{textbox name="PHONE" class="input" value="Phone" size="20"}
			</div>

			<div class="form-group">
				<label class="reg" for="organization">{translate key="Organization"}</label>
				{textbox name="ORGANIZATION" class="input" value="Organization" size="20"}
			</div>

			<div class="form-group">
				<label class="reg" for="position">{translate key="Position"}</label>
				{textbox name="POSITION" class="input" value="Position" size="20"}
			</div>

			{if $Attributes|count > 0}
				<div class="registrationHeader"><h3>{translate key=AdditionalAttributes}</h3></div>
				{foreach from=$Attributes item=attribute}
					<div class="customAttribute">
						{control type="AttributeControl" attribute=$attribute}
					</div>
				{/foreach}
			{/if}

			{if $EnableCaptcha}
				<div class="registrationHeader"><h3>{translate key=SecurityCode}</h3></div>
				<div class="form-group">
					{control type="CaptchaControl"}
				</div>
			{else}
				<input type="hidden" {formname key=CAPTCHA} value=""/>
			{/if}

			<div class="regsubmit">
				<button type="submit" name="{Actions::REGISTER}" value="{translate key='Register'}"
						class="btn btn-primary" id="btnUpdate">{translate key='Register'}</button>
			</div>
		</form>
	</div>
	{setfocus key='LOGIN'}

	{jsfile src="js/jstz.min.js"}
	{jsfile src="admin/edit.js"}
	{jsfile src="js/jquery.form-3.09.min.js"}
	{jsfile src="js/jquery.colorbox-min.js"}
	{jsfile src="profile.js"}
	{jsfile src="registration.js"}


	<script type="text/javascript">
		$(document).ready(function ()
		{
			var timezone = jstz.determine_timezone();
			$('#timezoneDropDown').val(timezone.name());

			var registrationPage = new Registration()
			registrationPage.init();
		});
	</script>

	<div id="modalDiv" style="display:none;text-align:center; top:15%;position:relative;">
		<h3>{translate key=Working}</h3>
		{html_image src="reservation_submitting.gif"}
	</div>

</div>
{include file='globalfooter.tpl'}
