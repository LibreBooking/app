{*
Copyright 2011-2014 Nick Korbel

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

<h1>{translate key=InstallApplication}</h1>

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

		{if $ShowUpToDateMessage}
			<div class="error" style="margin-bottom: 10px;">
				<h3>{translate key=NoUpgradeNeeded}</h3>
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

        {if $ShowDatabasePrompt}
            <ul class="no-style">
                <li>1) {translate key=VerifyInstallSettings args=$ConfigPath}
                    <ul class="no-style" style="margin-left: 20px;">
                        <li><b>{translate key=DatabaseName}:</b> {$dbname}</li>
                        <li><b>{translate key=DatabaseUser}:</b> {$dbuser}</li>
                        <li><b>{translate key=DatabaseHost}:</b> {$dbhost}</li>
                    </ul>
                </li>
                <li>&nbsp;</li>
                <li>2) {translate key=DatabaseCredentials}</li>
                <li>{translate key=MySQLUser}</li>
                <li>{textbox name="INSTALL_DB_USER" class="textbox" size="20"}</li>
                <li>{translate key=Password}</li>
                <li>{textbox type="password" name="INSTALL_DB_PASSWORD" class="textbox" size="20"}</li>
                <li>&nbsp;</li>
				{if $ShowInstallOptions}
					<li>3)<i>{translate key=InstallOptionsWarning}</i></li>
					<li><input type="checkbox" name="create_database" /> {translate key=CreateDatabase} ({$dbname}) <span style="color:Red;">{translate key=DataWipeWarning}</span></li>
					<li><input type="checkbox" name="create_user" /> {translate key=CreateDatabaseUser} ({$dbuser})</li>
					<li><input type="checkbox" name="create_sample_data" /> {translate key=PopulateExampleData}</li>
					<li>
						<br/><button type="submit" name="run_install" class="button" value="submit">{translate key=RunInstallation} {html_image src="arrow_large_right.png"}<br/>
					</li>
				{/if}
				{if $ShowUpgradeOptions}
					<li>3) {translate key=UpgradeNotice args="$CurrentVersion,$TargetVersion"}</li>
					<li>
						<br/><button type="submit" name="run_upgrade" class="button" value="submit">{translate key=RunUpgrade} {html_image src="arrow_large_right.png"}<br/>
					</li>
				{/if}
            </ul>
        {/if}

        <ul class="no-style">
            {foreach from=$installresults item=result}
                <li>{translate key=Executing}: {$result->taskName}</li>
                {if $result->WasSuccessful()}
                    <li style="background-color: #9acd32">{translate key=Success}</li>
                {else}
                    <li style="border: solid red 5px;padding:10px;">
                        {translate key=StatementFailed}
                        <ul class='no-style'>
                            <li>{translate key=SQLStatement} <pre>{$result->sqlText}</pre></li>
                            <li>{translate key=ErrorCode} <pre>{$result->sqlErrorCode}</pre></li>
                            <li>{translate key=ErrorText} <pre>{$result->sqlErrorText}</pre></li>
                        </ul>
                    </li>
                {/if}
            {/foreach}
			<li>&nbsp;</li>
            <li>
                {if $InstallCompletedSuccessfully}
                    {translate key=InstallationSuccess}<br/>
                    <a href="{$Path}{Pages::REGISTRATION}">{translate key=Register}</a> {translate key=RegisterAdminUser args="$ConfigPath"}<br/><br/>
					<a href="{$Path}{Pages::LOGIN}">{translate key=Login}</a> {translate key=LoginWithSampleAccounts}
				{/if}
				{if $UpgradeCompletedSuccessfully}
					{translate key=InstalledVersion args=$TargetVersion}
					<h3><a href="configure.php">{translate key=InstallUpgradeConfig}</a></h3>
				{/if}
                {if $InstallFailed}
                    {translate key=InstallationFailure}
                {/if}
            </li>
        </ul>


    </form>
</div>

{include file='globalfooter.tpl'}