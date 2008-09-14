{include file='header.tpl'}
{if $ShowLoginError}
	<div id="loginError">
		{translate key='Login Error'}
	</div>
{/if}
<form name="login" method="post" action="{$smarty.server.SCRIPT_NAME}">
    <table width="450" border="0" cellspacing="0" cellpadding="1" align="center">
        <tr>
            <td class="loginTableBorder">
                <table width="100%" border="0" cellspacing="0" cellpadding="3" class="loginTable">
                    <tr id="header">
                        <td colspan="2">
                            <h5 align="center">{translate key='Log In'}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td width="150">
                            <p>
                                <b>{if $UseLogonName} {translate key='Logon name'} {else} {translate key='Email address'} {/if}</b>
                            </p>
                        </td>
                        <td>
                        	{textbox name="EMAIL" class="textbox"}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>
                                <b>{translate key='Password'}</b>
                            </p>
                        </td>
                        <td>
                        	{textbox name="PASSWORD" class="textbox"}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>
                                <b>{translate key='Language'}</b>
                            </p>
                        </td>
                        <td>                      
							<select name="{constant echo='FormKeys::LANGUAGE'}" class="textbox">
								{html_options options=$Languages selected=$CurrentLanguage}	
							</select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>
                                <b>{translate key='Keep me logged in'}</b>
                            </p>
                        </td>
                        <td>
                            <input type="checkbox" name="{constant echo='FormKeys::PERSIST_LOGIN'}" value="true" />
                        </td>
                    </tr>
                    <tr id="footer">
                        <td colspan="2">
	                        <p align="center">
	                            <input type="submit" name="{constant echo='Actions::LOGIN'}" value="{translate key='Log In'}" class="button" />
	                            <input type="hidden" name="{constant echo='FormKeys::RESUME'}" value="{$ResumeUrl}" />
	                        </p>
	                        {if $ShowRegisterLink} 
	                        <h4 align="center" style="margin-bottom:1px;">
	                            <b>{translate key='First time user'}</b>
	                            {html_link href="register.php" key="Click here to register"}
	                        </h4>
                        {/if}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <p align="center">
    <a href="roschedule.php">{translate key='View Schedule'}</a>
    | 
    <a href="forgot_pwd.php">{translate key='I Forgot My Password'}</a>
    | 
    <a href="javascript: help();">{translate key='Help'}</a>
    </p>
</form>
{setfocus key='EMAIL'}
{include file='footer.tpl'}