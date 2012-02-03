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

{if $ShowLoginError}
<div id="loginError">
	{translate key='LoginError'}
</div>
{/if}

<div id="loginbox">
	<!--This "$smarty.server.SCRIPT_NAME" sets up the form to post back to the same page that it is on.-->
	<form class="login" method="post" action="{$smarty.server.SCRIPT_NAME}">
		<div>
			<p>
				<label class="login">{translate key='UsernameOrEmail'}<br/>
				{textbox name="EMAIL" class="input" size="20" tabindex="10"}</label>
			</p>

			<p>
				<label class="login">{translate key='Password'}<br/>
				{textbox type="password" name="PASSWORD" class="input" value="" size="20" tabindex="20"}</label>
			</p>

			<p>
				<label class="login">{translate key='Language'}<br/>
					<select {formname key='LANGUAGE'} class="input-small" id="languageDropDown">
					{object_html_options options=$Languages key='GetLanguageCode' label='GetDisplayName' selected=$SelectedLanguage}
					</select>
			</p>

			<p class="stayloggedin">
				<label class="login"><input type="checkbox" name="{FormKeys::PERSIST_LOGIN}" value="true"
											tabindex="30"/> {translate key='RememberMe'}</label>

			</p>

			<p class="loginsubmit">
				<button type="submit" name="{Actions::LOGIN}" class="button" tabindex="100" value="submit"><img
						src="img/door-open-in.png"/> {translate key='LogIn'} </button>
				<input type="hidden" name="{FormKeys::RESUME}" value="{$ResumeUrl|replace:"&amp;amp;":"&amp;"}"/>
			</p>
		</div>
		<div style="clear:both;">&nbsp;</div>
	{if $ShowRegisterLink}
		<h4 class="register">
			{translate key='FirstTimeUser?'}
				{html_link href="register.php" key="CreateAnAccount"}
		</h4>
	{/if}
	</form>
</div>

<div id="login-links">
	<p>
		<a href="view-schedule.php">{translate key='ViewSchedule'}</a>
		|
		<a href="forgot.php">{translate key='ForgotMyPassword'}</a>
	</p>
</div>

{setfocus key='EMAIL'}

<script type="text/javascript">
	var url = 'index.php?{QueryStringKeys::LANGUAGE}=';
	$(document).ready(function () {
		$('#languageDropDown').change(function()
		{
			window.location.href = url + $(this).val();
		});

		var langCode = readCookie('{CookieKeys::LANGUAGE}');

		if (!langCode) {
		}
	});
</script>
{include file='globalfooter.tpl'}