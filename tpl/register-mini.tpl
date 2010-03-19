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

        <div class="registrationHeader"><h3>Account Registration</h3></div>
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
                <label>{translate key="Email"}{if !$UseLoginName} (this will be your username){/if}<br />
                {textbox name="EMAIL" class="input" value="Email" size="20" tabindex="30"}
                </label>
        </p>
                {if $UseLoginName}
        <div class="registrationHeader"><h3>Login Information</h3></div>

        <p>
                <label>{translate key="Username"}<br />
                {textbox name="LOGIN" class="input" value="Login" size="20" tabindex="40"}
                </label>
        </p>
        {/if}
        <p>
                <label>{translate key="Password"}<br />
                {textbox type="password" name="PASSWORD" class="input" value="" size="20" tabindex="50"}
                </label>
        </p>
        <p>
                <label>{translate key="PasswordConfirmation"}<br />
                {textbox type="password" name="PASSWORD_CONFIRM" class="input" value="" size="20" tabindex="60"}
                </label>
        </p>
        <p class="submit">
                <input type="submit" name="{constant echo='Actions::REGISTER'}" value="{translate key='Register'}" class="button" tabindex="200" />
        </p>
</form>
</div>
{setfocus key='FIRST_NAME'}

{include file='footer.tpl'}
