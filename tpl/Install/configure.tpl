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

<h1>Configure phpScheduleIt</h1>

<div>
    <form class="register" method="post" action="{$smarty.server.SCRIPT_NAME}">

        {if $ShowInvalidPassword}
            <div class="error">Sorry, that password was incorrect.</div>
        {/if}

        {if $InstallPasswordMissing}
            <div class='error'>
                <p>You must set an install password before the installation can be run.</p>
                <p>In /config/config.php please set $conf['settings']['install.password'] to a password which is random and difficult to guess, then return to this page.</p>
            </div>
        {/if}

        {if $ShowPasswordPrompt}
            <ul class="no-style">
                <li>Please provide your installation password.</li>
                <li>This can be found at $conf['settings']['install.password'] in /config/config.php.</li>
                <li>{textbox type="password" name="INSTALL_PASSWORD" class="textbox" size="20"}
                    <button type="submit" name="" class="button" value="submit">Next {html_image src="arrow_large_right.png"}</button>
                </li>
            </ul>
        {/if}

		{if $ShowConfigSuccess}
			<h3>Your config file is now up to date!</h3>
		{/if}

		{if $ShowManualConfig}
			We could not automatically update your config file. Please overwrite the contents of config.php with the following:

			<div style="font-family: courier; border: solid 1px #666;padding: 10px;margin-top: 20px;background-color: #eee">
				&lt;?php<br/>
				error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);<br/>
				{$ManualConfig|nl2br}
				?&gt;
			</div>
		{/if}

    </form>
</div>

{include file='globalfooter.tpl'}