{*
Copyright 2011-2019 Nick Korbel

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

<div id="page-install">
	<h1>{translate key=InstallApplication}</h1>

    {if $ShowScriptUrlWarning}
        <div class="alert alert-danger">
            {translate key=ScriptUrlWarning args="$CurrentScriptUrl,$SuggestedScriptUrl"}
        </div>
    {/if}

	<div>
		<form class="register" method="post" action="{$smarty.server.SCRIPT_NAME}" role="form">

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
				<div class="form-group">
					<div>{translate key=ProvideInstallPassword}</div>
					<div>{translate key=InstallPasswordLocation args="$ConfigPath,$ConfigSetting"}</div>
					<div>{textbox type="password" name="INSTALL_PASSWORD" size="20"}</div>
					<div>
						<button type="submit" name="" class="btn"
								value="submit">{translate key=Next} {html_image src="arrow_large_right.png"}</button>
					</div>
				</div>
			{/if}

			{if $ShowDatabasePrompt}
				<div class="">
					<div>1) {translate key=VerifyInstallSettings args=$ConfigPath}
						<div style="margin-left: 20px;">
							<div><b>{translate key=DatabaseName}:</b> {$dbname}</div>
							<div><b>{translate key=DatabaseUser}:</b> {$dbuser}</div>
							<div><b>{translate key=DatabaseHost}:</b> {$dbhost}</div>
						</div>
					</div>
					<div>&nbsp;</div>
					<div>2) {translate key=DatabaseCredentials}</div>
					<div class="form-group">
						<label for="dbUser">{translate key=MySQLUser}</label>
						{textbox name="INSTALL_DB_USER" size="20" id=dbUser}
					</div>
					<div class="form-group">
						<label for="dbPassword">{translate key=Password}</label>
						{textbox type="password" name="INSTALL_DB_PASSWORD" size="20" id=dbPassword}
					</div>
					<div>&nbsp;</div>
					{if $ShowInstallOptions}
						<div>3)<i>{translate key=InstallOptionsWarning}</i></div>
						<div><input type="checkbox" name="create_database"/> {translate key=CreateDatabase} ({$dbname})
							<span style="color:Red;">{translate key=DataWipeWarning}</span></div>
						<div><input type="checkbox" name="create_user"/> {translate key=CreateDatabaseUser} ({$dbuser})
						</div>
						<div><input type="checkbox" name="create_sample_data"/> {translate key=PopulateExampleData}
						</div>
						<div>
							<br/>
							<button type="submit" name="run_install" class="btn"
									value="submit">{translate key=RunInstallation} {html_image src="arrow_large_right.png"}
								<br/>
						</div>
					{/if}
					{if $ShowUpgradeOptions}
						<div>3) {translate key=UpgradeNotice args="$CurrentVersion,$TargetVersion"}</div>
						<div>
							<br/>
							<button type="submit" name="run_upgrade" class="btn"
									value="submit">{translate key=RunUpgrade} {html_image src="arrow_large_right.png"}
								<br/>
						</div>
					{/if}
				</div>
			{/if}

			<div class="no-style">
				{foreach from=$installresults item=result}
					<div>{translate key=Executing}: {$result->taskName}</div>
					{if $result->WasSuccessful()}
						<div style="background-color: #9acd32">{translate key=Success}</div>
					{else}
						<div style="border: solid red 5px;padding:10px;">
							{translate key=StatementFailed}
							<div class='no-style'>
								<div>{translate key=SQLStatement}
									<pre>{$result->sqlText}</pre>
								</div>
								<div>{translate key=ErrorCode}
									<pre>{$result->sqlErrorCode}</pre>
								</div>
								<div>{translate key=ErrorText}
									<pre>{$result->sqlErrorText}</pre>
								</div>
							</div>
						</div>
					{/if}
				{/foreach}
				<div>&nbsp;</div>
				<div>
					{if $InstallCompletedSuccessfully}
						{translate key=InstallationSuccess}
						<br/>
						<a href="{$Path}{Pages::REGISTRATION}">{translate key=Register}</a>
						{translate key=RegisterAdminUser args="$ConfigPath"}
						<br/>
						<br/>
						<a href="{$Path}{Pages::LOGIN}">{translate key=Login}</a>
						{translate key=LoginWithSampleAccounts}
					{/if}
					{if $UpgradeCompletedSuccessfully}
						{translate key=InstalledVersion args=$TargetVersion}
						<h3><a href="configure.php">{translate key=InstallUpgradeConfig}</a></h3>
					{/if}
					{if $InstallFailed}
						{translate key=InstallationFailure}
					{/if}
				</div>
			</div>


		</form>
	</div>

</div>

{include file="javascript-includes.tpl"}
{include file='globalfooter.tpl'}