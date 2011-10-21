{assign var='DisplayWelcome' value='false'}
{include file='loginheader.tpl'}

<h1>Install phpScheduleIt</h1>

<div>
<form class="register" method="post" action="{$smarty.server.SCRIPT_NAME}">

{if $ShowInvalidPassword}
	<div class="error">Sorry, that password was incorrect.</div>
{/if}

{if $InstallPasswordMissing}
	<div class='error'>
		<p>You must set an install password before the installation can be run.</p>
		<p>Please set the password as something random and difficult to guess in $conf['settings']['install.password'] in /config/config.php and return to this page.</p>
	</div>
{/if}
	
{if $ShowPasswordPrompt}
	<ul class="no-style">
		<li>Please provide your installation password.</li>
		<li>This can be found at $conf['settings']['install.password'] in /config/config.php </li>
		<li>{textbox type="password" name="INSTALL_PASSWORD" class="textbox" size="20"}
			<button type="submit" name="" class="button" value="submit"> {html_image src="door-open-in.png"} Next &gt;</button>
		</li>
	</ul>
{/if}

{if $ShowDatabasePrompt}
	<ul class="no-style">
		<li>Please provide credentials of a MySQL user who has privileges create databases.</li>
		
		<li>MySQL User: {textbox name="INSTALL_DB_USER" class="textbox" size="20"}</li>
		<li>Password: {textbox type="password" name="INSTALL_DB_PASSWORD" class="textbox" size="20"}</li>
		<li>
			<button type="submit" name="" class="button" value="submit"> {html_image src="door-open-in.png"} Run Installation</button>
		</li>
	</ul>
{/if}

</form>
</div>

{include file='globalfooter.tpl'}