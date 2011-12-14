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
                        <select {formname key='TIMEZONE'} class="input" tabindex="180">
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
            <input type="text" class="input" {formname key=CAPTCHA} size="20"  />
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
{include file='globalfooter.tpl'}