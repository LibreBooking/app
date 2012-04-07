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

<h1>Install backend database phpScheduleIt (MySQL only)</h1>

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

        {if $ShowDatabasePrompt}
            <ul class="no-style">
                <li>1) Verify the following default settings before continuing. Or you can change them in /config/config.php.
                    <ul class="no-style" style="margin-left: 20px;">
                        <li><b>Database Name:</b> {$dbname}</li>
                        <li><b>Database User:</b> {$dbuser} (this is not any application user, but the user for your database: {$dbname})</li>
                        <li><b>Database Host:</b> {$dbhost} (or localhost)</li>
                    </ul>
                </li>
                <li>&nbsp;</li>
                <li>2) You MUST provide credentials of a MySQL user who has privileges to create databases. If you do not know, contact your database admin. In many cases, root will work.</li>
                <li>MySQL User</li>
                <li>{textbox name="INSTALL_DB_USER" class="textbox" size="20"}</li>
                <li>Password</li>
                <li>{textbox type="password" name="INSTALL_DB_PASSWORD" class="textbox" size="20"}</li>
                <li>&nbsp;</li>
				{if $ShowInstallOptions}
					<li>3)<i>The following options will probably not work in a hosted environment.  Please set up the database and user through your provider's database tools.</i></li>
					<li><input type="checkbox" name="create_database" /> Create the database based on configuration /config/config.php ({$dbname}) <span style="color:Red;">Warning: This will delete all existing data</span></span> </li>
					<li><input type="checkbox" name="create_user" /> Create the user based on configuration /config/config.php ({$dbuser})</li>
					<li><input type="checkbox" name="create_sample_data" /> Create sample data admin/password for admin and user/password for user</li>
					<li>
						<br/><button type="submit" name="run_install" class="button" value="submit">Run Installation {html_image src="arrow_large_right.png"}<br/>
					</li>
				{/if}
				{if $ShowUpgradeOptions}
					<li>3) You are upgrading from version <b>{$CurrentVersion}</b> to version <b>{$TargetVersion}</b></li>
					<li>
						<br/><button type="submit" name="run_upgrade" class="button" value="submit">Run Upgrade {html_image src="arrow_large_right.png"}<br/>
					</li>
				{/if}
            </ul>
        {/if}

        <ul class="no-style">
            {foreach from=$installresults item=result}
                <li>Executing: {$result->taskName}</li>
                {if $result->WasSuccessful()}
                    <li style="background-color: #9acd32">Succeeded!</li>
                {else}
                    <li style="border: solid red 5px;padding:10px;">
                        Failed!  Details...
                        <ul class='no-style'>
                            <li>SQL Statement: <pre>{$result->sqlText}</pre></li>
                            <li>Error Code: <pre>{$result->sqlErrorCode}</pre></li>
                            <li>Error Text: <pre>{$result->sqlErrorText}</pre></li>
                        </ul>
                    </li>
                {/if}
            {/foreach}
			<li>&nbsp;</li>
            <li>
                {if $InstallCompletedSuccessfully}
                    Summary: <br/> Installation completed successfully! <br/>
                    1) <a href="{$Path}{Pages::LOGIN}">Login</a> with admin/password for admin user Or user/password for basic user. This is sample data chosen to installed in previous page. Or <br/>
                    2) <a href="{$Path}{Pages::REGISTRATION}">Register</a> your admin user/basic user. This is email authentication method and it requires mail server configured to work successfully.
				{/if}
				{if $UpgradeCompletedSuccessfully}
					You are now running version {$TargetVersion} of phpScheduleIt
					<h3>It is recommended to <a href="configure.php">upgrade your config file</a></h3>
				{/if}
                {if $InstallFailed}
                    Summary: <br/> There were problems with the installation.  Please correct them and retry the installation.
                {/if}
            </li>
        </ul>
		

    </form>
</div>

{include file='globalfooter.tpl'}