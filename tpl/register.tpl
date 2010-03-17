{include file='header.tpl' DisplayWelcome='false'}
<link rel="stylesheet" id="register-css" href="../css/register.css" type="text/css" media="all" />
<div id="registration-form">
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

        <div class="registrationHeader"><h3>Account Registration (all fields are required)</h3></div>
        <p>
                <label>{translate key="FirstName"}<br />
                {textbox name="FIRST_NAME" class="input" value="FirstName" size="20" tabindex="10"}
                </label>
        </p>
        <p>
                <label>{translate key="LastName"}<br />
                {textbox name="LAST_NAME" class="input" value="LastName" size="20" tabindex="20"}
                </label>
        </p>
        <p>
                <label>{translate key="Email"}<br />
                {textbox name="EMAIL" class="input" value="Email" size="20" tabindex="30"}
                </label>
        </p>
        <p>
                <label>{translate key="Phone"}<br />
                {textbox name="PHONE" class="input" value="Phone" size="20" tabindex="40"}
                </label>
        </p>
        <p>
                <label>{translate key="Timezone"}<br />
                        <select name="{constant echo='FormKeys::TIMEZONE'}" class="input" tabindex="50">
                                {html_options values=$TimezoneValues output=$TimezoneOutput selected=$Timezone}
                        </select>
                </label>
        </p>

        <div class="registrationHeader"><h3>Optional Fields</h3></div>
        <p>
                <label>{translate key="Institution"}<br />
                {textbox name="INSTITUTION" class="input" value="Institution" size="20" tabindex="60"}
                </label>
        </p>
        <p>
                <label>{translate key="Position"}<br />
                {textbox name="POSITION" class="input" value="Position" size="20" tabindex="70"}
                </label>
        </p>

        <div class="registrationHeader"><h3>Login Information (all fields are required)</h3></div>
                {if $UseLoginName}
        <p>
                <label>{translate key="Username"}<br />
                {textbox name="LOGIN" class="input" value="Login" size="20" tabindex="80"}
                </label>
        </p>
        {/if}
        <p>
                <label>{translate key="Password"}<br />
                {textbox type="password" name="PASSWORD" class="input" value="" size="20" tabindex="90"}
                </label>
        </p>
        <p>
                <label>{translate key="PasswordConfirmation"}<br />
                {textbox type="password" name="PASSWORD_CONFIRM" class="input" value="" size="20" tabindex="100"}
                </label>
        </p>
        <p>
                <label>{translate key="DefaultPage"}<br />
                        <select name="{constant echo='FormKeys::DEFAULT_HOMEPAGE'}" class="input" tabindex="110">
                                {html_options values=$HomepageValues output=$HomepageOutput selected=$Homepage}
                        </select>
                </label>
        </p>
        <p class="submit">
                <input type="submit" name="{constant echo='Actions::REGISTER'}" value="{translate key='Register'}" class="button" tabindex="200" />
        </p>
</form>
</div>
{include file='footer.tpl'}
