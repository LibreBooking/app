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

{validation_group class="error"}
        {validator id="fname" key="FirstNameRequired"}
        {validator id="lname" key="LastNameRequired"}
		{validator id="username" key="UserNameRequired"}
        {validator id="passwordmatch" key="PwMustMatch"}
        {validator id="passwordcomplexity" key="PwComplexity"}
        {validator id="emailformat" key="ValidEmailRequired"}
        {validator id="uniqueemail" key="UniqueEmailRequired"}
        {validator id="uniqueusername" key="UniqueUsernameRequired"}
        {validator id="captcha" key="CaptchaMustMatch"}
{/validation_group}
<div id="registrationbox">
<form class="register" method="post" action="{$smarty.server.SCRIPT_NAME}">
		<div class="registrationHeader"><h3>{translate key=Login} ({translate key=AllFieldsAreRequired})</h3></div>
        <p>
                <label class="reg">{translate key="Username"}<br />
                {textbox name="LOGIN" class="input" value="Login" size="20" tabindex="110"}
                </label>
        </p>
        <p>
                <label class="reg">{translate key="Password"}<br />
                {textbox type="password" name="PASSWORD" class="input" value="" size="20" tabindex="120"}
                </label>
        </p>
        <p>
                <label class="reg">{translate key="PasswordConfirmation"}<br />
                {textbox type="password" name="PASSWORD_CONFIRM" class="input" value="" size="20" tabindex="130"}
                </label>
        </p>
        <p>
                <label class="reg">{translate key="DefaultPage"}<br />
                        <select {formname key='DEFAULT_HOMEPAGE'} class="input" tabindex="140">
                                {html_options values=$HomepageValues output=$HomepageOutput selected=$Homepage}
                        </select>
                </label>
        </p>

        <div class="registrationHeader"><h3>{translate key=Profile} ({translate key=AllFieldsAreRequired})</h3></div>
        <p>
                <label class="reg">{translate key="FirstName"}<br />
                {textbox name="FIRST_NAME" class="input" value="FirstName" size="20" tabindex="150"}
                </label>
        </p>
        <p>
                <label class="reg">{translate key="LastName"}<br />
                {textbox name="LAST_NAME" class="input" value="LastName" size="20" tabindex="160"}
                </label>
        </p>
        <p>
                <label class="reg">{translate key="Email"}<br />
                {textbox name="EMAIL" class="input" value="Email" size="20" tabindex="170"}
                </label>
        </p>
        <p>
                <label class="reg">{translate key="Timezone"}<br />
                        <select {formname key='TIMEZONE'} class="input" tabindex="180" id="timezoneDropDown">
                                {html_options values=$TimezoneValues output=$TimezoneOutput selected=$Timezone}
                        </select>
                </label>
        </p>

        <p style="display:none">
                <label class="reg">{translate key="Language"}<br/>
                        <select {formname key='LANGUAGE'} class="input" tabindex="190">
                                 {html_options values=$LanguageValues output=$LanguageOutput selected=$Language}
                        </select>
                </label>
        
        </p>

        <div class="registrationHeader"><h3>{translate key="AdditionalInformation"} ({translate key=Optional})</h3></div>
        <p>
                <label class="reg">{translate key="Phone"}<br />
                {textbox name="PHONE" class="input" value="Phone" size="20" tabindex="200"}
                </label>
        </p>
		<p>
                <label class="reg">{translate key="Organization"}<br />
                {textbox name="ORGANIZATION" class="input" value="Organization" size="20" tabindex="210"}
                </label>
        </p>
        <p>
                <label class="reg">{translate key="Position"}<br />
                {textbox name="POSITION" class="input" value="Position" size="20" tabindex="220"}
                </label>
        </p>

        {if $EnableCaptcha}
        <p>
            <img src="{$CaptchaImageUrl}" alt='captcha' /><br/>
            <label class="reg">{translate key="SecurityCode"}<br />
            <input type="text" class="input" {formname key=CAPTCHA} size="20" tabindex="230"  />
        </p>
        {else}
            <input type="hidden" {formname key=CAPTCHA} value=""  />
        {/if}

        <p class="regsubmit">
             <button type="submit" name="{Actions::REGISTER}" value="{translate key='Register'}" tabindex="300" class="button"><img src="img/tick-circle.png" /> {translate key='Register'}</button>
        </p>
</form>
</div>
{setfocus key='LOGIN'}

<script src="scripts/js/jstz.min.js"></script>

<script type="text/javascript">
		$(document).ready(function() {
			var timezone = jstz.determine_timezone();
			$('#timezoneDropDown').val(timezone.name());
		});
	</script>

{include file='globalfooter.tpl'}