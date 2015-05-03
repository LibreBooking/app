{*
Copyright 2011-2015 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*}
{include file='globalheader.tpl'}

<h1>{translate key=ConfigureApplication}</h1>

<div>
    <form class="register" method="post" action="{$smarty.server.SCRIPT_NAME}">

        {if $ShowInvalidPassword}
            <div class="error">{translate key=IncorrectInstallPassword}</div>
        {/if}

        {if $InstallPasswordMissing}
            <div class='error'>
				<p>{translate key=SetInstallPassword}</p>
			    <p>{translate key=InstallPasswordInstructions args="$ConfigPath,$ConfigSetting,$SuggestedInstallPassword"}</p>
            </div>
        {/if}

        {if $ShowPasswordPrompt}
            <ul class="no-style">
				<li>{translate key=ProvideInstallPassword}</li>
			    <li>{translate key=InstallPasswordLocation args="$ConfigPath,$ConfigSetting"}</li>
                <li>{textbox type="password" name="INSTALL_PASSWORD" class="textbox" size="20"}
                    <button type="submit" name="" class="button" value="submit">{translate key=Next} {html_image src="arrow_large_right.png"}</button>
                </li>
            </ul>
        {/if}

		{if $ShowConfigSuccess}
			<h3>{translate key=ConfigUpdateSuccess} <a href="{$Path}{Pages::LOGIN}">{translate key=Login}</a></h3>
		{/if}

		{if $ShowManualConfig}
			{translate key=ConfigUpdateFailure}

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