{include file='header.tpl'}
<form name="login" method="post" action="{$SCRIPT_NAME}">
    <table width="350" border="0" cellspacing="0" cellpadding="1" align="center">
        <tr>
            <td bgcolor="#CCCCCC">
                <table width="100%" border="0" cellspacing="0" cellpadding="3">
                    <tr bgcolor="#EDEDED">
                        <td colspan="2" style="border-bottom: solid 1px #CCCCCC;">
                            <h5 align="center">{translate string='Please Log In'}</h5>
                        </td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                        <td width="150">
                            <p>
                                <b>{if $useLogonName} {translate string='Logon name'} {else} {translate string='Email address'} {/if}</b>
                            </p>
                        </td>
                        <td>
                            <input type="text" name="email" class="textbox" />
                        </td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                        <td>
                            <p>
                                <b>{translate string='Password'}</b>
                            </p>
                        </td>
                        <td>
                            <input type="password" name="password" class="textbox" />
                        </td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                        <td>
                            <p>
                                <b>{translate string='Language'}</b>
                            </p>
                        </td>
                        <td>
                       
						<select name="{constant echo='FormKeys::LANGUAGE'}">
							{html_options options=$Languages selected=$CurrentLanguage}	
						</select>
                        </td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                        <td>
                            <p>
                                <b>{translate string='Keep me logged in'}</b>
                            </p>
                        </td>
                        <td>
                            <input type="checkbox" name="setCookie" value="true" />
                        </td>
                    </tr>
                    <tr bgcolor="#FAFAFA">
                        <td colspan="2" style="border-top: solid 1px #CCCCCC;">
                        <p align="center">
                            <input type="submit" name="login" value="{translate string='Log In'}" class="button" />
                            <input type="hidden" name="resume" value="{$ResumeUrl}" />
                        </p>
                        {if $ShowRegisterLink} 
                        <h4 align="center" style="margin-bottom:1px;">
                            <b>{translate string='First time user'}</b>
                            <a href="register.php" title="Some Title">{translate string='Click here to register'}</a>
                        </h4>
                        {/if}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <p align="center">
    <a href="roschedule.php">{translate string='View Schedule'}</a>
    | 
    <a href="forgot_pwd.php">{translate string='I Forgot My Password'}</a>
    | 
    <a href="javascript: help();">{translate string='Help'}</a>
    </p>
</form>
{include file='footer.tpl'}