{assign var='DisplayWelcome' value='false'}
{include file='loginheader.tpl'}

<h1>Install phpScheduleIt (MySQL only)</h1>

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
		<li>This can be found at $conf['settings']['install.password'] in /config/config.php </li>
		<li>{textbox type="password" name="INSTALL_PASSWORD" class="textbox" size="20"}
			<button type="submit" name="" class="button" value="submit">Next {html_image src="arrow_large_right.png"} </button>
		</li>
	</ul>
{/if}

{if $ShowDatabasePrompt}
	<ul class="no-style">
		<li>Verify the following settings before continuing.
			<ul class="no-style" style="margin-left: 20px;">
				<li>Database Name: {$dbname}</li>
				<li>Database User: {$dbuser}</li>
				<li>Database Host: {$dbhost}</li>
			</ul>
		</li>
		<li>&nbsp;</li>
		<li>Please provide credentials of a MySQL user who has privileges create databases.</li>
		<li>MySQL User</li>
		<li>{textbox name="INSTALL_DB_USER" class="textbox" size="20"}</li>
		<li>Password</li>
		<li>{textbox type="password" name="INSTALL_DB_PASSWORD" class="textbox" size="20"}</li>
		<li> <i>The following options will not work in a hosted environment.  Please set up the database and user through your provider's database tools.</i></li>
		<li><input type="checkbox" name="create_database" /> Create the database ({$dbname})</li>
		<li><input type="checkbox" name="create_user" /> Create the user ({$dbuser})</li>
		<li>
			<button type="submit" name="run_install" class="button" value="submit">Run Installation {html_image src="arrow_large_right.png"}</button>
		</li>
	</ul>
{/if}

<ul class="no-style">
{foreach from=$installresults item=result}
	<li>Executing: {$result->taskName}</li>
	{if $result->WasSuccessful()}
		<li style="background-color: #9acd32">Succeeded!</li>
	{else}
		<li style="border: solid red 5px;">
			Failed!  Details...
			<ul class='no-style'>
				<li>SQL Statement: <pre>{$result->sqlText}</pre></li>
				<li>Error Code: <pre>{$result->sqlErrorCode}</pre></li>
				<li>Error Text: <pre>{$result->sqlErrorText}</pre></li>
			</ul>
		</li>
	{/if}
{/foreach}
<li>
	{if $InstallCompletedSuccessfully}
		Installation complete. <a href="{$Path}{Pages::REGISTRATION}">Register your admin user</a>
	{/if}
	{if $InstallFailed}
		There were problems with the installation.  Please correct them and retry the installation.
	{/if}
</li>
</ul>
</form>
</div>

{include file='globalfooter.tpl'}