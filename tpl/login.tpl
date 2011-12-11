{include file='loginheader.tpl'}

{if $ShowLoginError}
    <div id="loginError">
        {translate key='LoginError'}
    </div>
{/if}

<div id="loginbox"><!--This "$smarty.server.SCRIPT_NAME" sets up the form to post back to the same page that it is on.-->
    <form class="login" method="post" action="{$smarty.server.SCRIPT_NAME}">
        <p>
            <label class="login">{translate key='UsernameOrEmail'}<br/>
                {textbox name="EMAIL" class="input" size="20" tabindex="10"}</label>
        </p>
        <p>
            <label class="login">{translate key='Password'}<br/>
                {textbox type="password" name="PASSWORD" class="input" value="" size="20" tabindex="20"}</label>
        </p>
        <p class="stayloggedin">
            <label class="login"><input type="checkbox" name="{FormKeys::PERSIST_LOGIN}" value="true" tabindex="30" /> {translate key='RememberMe'}</label>
        </p>
        <p class="loginsubmit">
            <button type="submit" name="{Actions::LOGIN}" class="button" tabindex="100" value="submit"><img src="img/door-open-in.png" /> {translate key='LogIn'} </button>
            <input type="hidden" name="{FormKeys::RESUME}" value="{$ResumeUrl}" />
        </p>
    </form>
</div>

<div id="login-links">
    {if $ShowRegisterLink}
        <h4 class="register">
            {translate key='FirstTimeUser?'}
            {html_link href="register.php" key="CreateAnAccount"}
        </h4>
    {/if}

    <p class="login_links">
        <a href="view-schedule.php">{translate key='ViewSchedule'}</a>
        |
        <a href="forgot.php">{translate key='ForgotMyPassword'}</a>
        |
        <a href="javascript: help();">{translate key='Help'}</a>
    </p>
</div>

{setfocus key='EMAIL'}
{include file='globalfooter.tpl'}