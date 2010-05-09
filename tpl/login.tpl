{assign var='DisplayWelcome' value='false'}
{include file='loginheader.tpl'}
{if $ShowLoginError}
        <div id="loginError">
                {translate key='Login Error'}
        </div>
{/if}
<div id="loginbox">

<form class="login" method="post" action="{$smarty.server.SCRIPT_NAME}">
<p>
        <label class="login">{if $UseLogonName} {translate key='Logon name'} {else} {translate key='Email address'} {/if}<br />
        {textbox name="EMAIL" class="input" size="20" tabindex="10"}</label>
</p>
<p>
        <label class="login">{translate key='Password'}<br />
        {textbox type="password" name="PASSWORD" class="input" value="" size="20" tabindex="20"}</label>
</p>
<p class="stayloggedin">
        <label class="login"><input type="checkbox" name="{constant echo='FormKeys::PERSIST_LOGIN'}" value="true" tabindex="30" /> {translate key='Keep me logged in'}</label>
</p>
<p class="loginsubmit">
        <input type="submit" name="{constant echo='Actions::LOGIN'}" value="{translate key='Log In'}" class="button" tabindex="100" />
        <input type="hidden" name="{constant echo='FormKeys::RESUME'}" value="{$ResumeUrl}" />
</p>
</form>
</div>

<div id="login-links">
{if $ShowRegisterLink} 
        <h4 class="register">
                {translate key='First time user'}
                {html_link href="reg.php" key="Click here to register"}
        </h4>
{/if}

<p class="login_links">
    <a href="sched.php">{translate key='View Schedule'}</a>
    | 
    <a href="forgot_pwd.php">{translate key='I Forgot My Password'}</a>
    | 
    <a href="javascript: help();">{translate key='Help'}</a>
</p>
</div>

{setfocus key='EMAIL'}

{include file='footer.tpl'}