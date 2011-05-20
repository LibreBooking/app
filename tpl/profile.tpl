{include file='globalheader.tpl'}
<div id="registrationbox">
<form class="register" method="post" action="{$smarty.server.SCRIPT_NAME}">

{validation_group class="error"}
        {validator id="fname" key="FirstNameRequired"}
        {validator id="lname" key="LastNameRequired"}
        {validator id="passwordmatch" key="PwMustMatch"}
        {validator id="emailformat" key="ValidEmailRequired"}
        {validator id="uniqueemail" key="UniqueEmailRequired"}
        {validator id="uniqueusername" key="UniqueUsernameRequired"}
{/validation_group}

		<div class="registrationHeader"><h3>Login (all fields are required)</h3></div>
        <p>
                <label class="reg">{translate key="Username"}<br />
                {textbox name="USERNAME" class="input" value="Username" size="20" tabindex="80"}
                </label>
        </p>
        <p>
                <label class="reg">{translate key="DefaultPage"}<br />
                        <select {formname key='DEFAULT_HOMEPAGE'} class="input" tabindex="110">
                                {html_options values=$HomepageValues output=$HomepageOutput selected=$Homepage}
                        </select>
                </label>
        </p>
        <div class="registrationHeader"><h3>Profile (all fields are required)</h3></div>
        <p>
                <label class="reg">{translate key="FirstName"}<br />
                {textbox name="FIRST_NAME" class="input" value="FirstName" size="20" tabindex="10"}
                </label>
        </p>
        <p>
                <label class="reg">{translate key="LastName"}<br />
                {textbox name="LAST_NAME" class="input" value="LastName" size="20" tabindex="20"}
                </label>
        </p>
        <p>
                <label class="reg">{translate key="Email"}<br />
                {textbox name="EMAIL" class="input" value="Email" size="20" tabindex="30"}
                </label>
        </p>
        <p>
                <label class="reg">{translate key="Phone"}<br />
                {textbox name="PHONE" class="input" value="Phone" size="20" tabindex="40"}
                </label>
        </p>
        <p>
                <label class="reg">{translate key="Timezone"}<br />
                        <select {formname key='TIMEZONE'} class="input" tabindex="50">
                                {html_options values=$TimezoneValues output=$TimezoneOutput selected=$Timezone}
                        </select>
                </label>
        </p>

        <div class="registrationHeader"><h3>Optional Fields</h3></div>
        <p>
                <label class="reg">{translate key="Organization"}<br />
                {textbox name="ORGANIZATION" class="input" value="Organization" size="20" tabindex="60"}
                </label>
        </p>
        <p>
                <label class="reg">{translate key="Position"}<br />
                {textbox name="POSITION" class="input" value="Position" size="20" tabindex="70"}
                </label>
        </p>


        <p class="regsubmit">
               
        </p>
</form>
</div>
{setfocus key='FIRST_NAME'}
{include file='globalfooter.tpl'}
