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

<div id="page-login">
	{if $ShowLoginError}
		<div id="loginError" class="alert alert-danger">
			{translate key='LoginError'}
		</div>
	{/if}

	<div class="col-md-offset-3 col-md-6 col-xs-10 col-xs-offset-1">
		<div id="login-header" class="default-box-header">
			<span class="sign-in">{translate key=SignIn}</span>
			{if $ShowRegisterLink}<span class="pull-right register">{translate key="FirstTimeUser?"} <a href="register.php"
																	   title="{translate key=Register}">{translate key=Register}</a>
				</span>{/if}
		</div>
		<form role="form" name="login" id="login" class="form-horizontal" method="post"
			  action="{$smarty.server.SCRIPT_NAME}">
			<div id="login-box" class="default-box straight-top">
				{if $ShowUsernamePrompt}
					<div class="input-group margin-bottom-25">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input type="text" required="" class="form-control"
							   id="email" {formname key=EMAIL}
							   placeholder="{translate key=UsernameOrEmail}"/>
					</div>
				{/if}

				{if $ShowPasswordPrompt}
					<div class="input-group margin-bottom-25">
					<span class="input-group-addon">
					<i class="glyphicon glyphicon-lock"></i>
					</span>
						<input type="password" required="" id="password" {formname key=PASSWORD}
							   class="form-control"
							   value="" placeholder="{translate key=Password}"/>
					</div>
				{/if}
				<button type="submit" class="btn btn-large btn-primary  btn-block" name="{Actions::LOGIN}"
						value="submit">{translate key='LogIn'}</button>
				<input type="hidden" {formname key=RESUME} value="{$ResumeUrl}"/>

				{control type=CheckboxControl id=rememberMe name-key=PERSIST_LOGIN label-key=RememberMe}

			</div>
			<div id="login-footer">
				{if $ShowForgotPasswordPrompt}
				<div id="forgot-password" class="pull-left">
					<a href="forgot.php" class="btn btn-link"><span><i class="glyphicon glyphicon-question-sign"></i></span> {translate key='ForgotMyPassword'}</a>
				</div>
				{/if}
				<div id="change-language" class="pull-right">
					<button type="button" class="btn btn-link" data-toggle="collapse"
							data-target="#change-language-options"><span><i class="glyphicon glyphicon-globe"></i></span>
						{translate key=ChangeLanguage}
					</button>
					<div id="change-language-options" class="collapse">
						<select {formname key=LANGUAGE} class="form-control input-sm" id="languageDropDown">
							{object_html_options options=$Languages key='GetLanguageCode' label='GetDisplayName' selected=$SelectedLanguage}
						</select>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

{setfocus key='EMAIL'}

<script type="text/javascript">
	var url = 'index.php?{QueryStringKeys::LANGUAGE}=';
	$(document).ready(function ()
	{
		$('#languageDropDown').change(function ()
		{
			window.location.href = url + $(this).val();
		});

		var langCode = readCookie('{CookieKeys::LANGUAGE}');

		if (!langCode)
		{
		}
	});
</script>
{include file='globalfooter.tpl'}