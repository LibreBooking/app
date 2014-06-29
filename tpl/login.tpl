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

	<form role="form" name="login" id="login" class="login form-horizontal" method="post"
		  action="{$smarty.server.SCRIPT_NAME}">
		<div class="row">
			<div id="loginbox" class="col-md-offset-4 col-md-4 col-xs-10 col-xs-offset-1 default-box">
				<div>
					{if $ShowUsernamePrompt}
						<div class="input-group margin-bottom-25">
							{*<label class="control-label" for="email">{translate key='Email'}</label>*}
							<span class="input-group-addon">
							<i class="glyphicon glyphicon-user"></i>
							</span>
							<input type="text" required="" class="form-control"
								   id="email" {formname key=EMAIL}
								   placeholder="{translate key=UsernameOrEmail}"/>
						</div>
					{/if}

					{if $ShowPasswordPrompt}
						<div class="input-group margin-bottom-25">
							{*<label class="control-label" for="password">{translate key='Password'}</label>*}
							<span class="input-group-addon">
							<i class="glyphicon glyphicon-lock"></i>
							</span>
							<input type="password" required="" id="password" {formname key=PASSWORD}
								   class="form-control"
								   value="" placeholder="{translate key=Password}"/>
						</div>
					{/if}

					<div>
						<div class="form-group col-xs-8">
							<button type="submit" class="btn btn-primary" name="{Actions::LOGIN}"
									value="submit">{translate key='LogIn'}</button>
							<input type="hidden" {formname key=RESUME} value="{$ResumeUrl}"/>
						</div>

						<div class="pull-right">
							{if $ShowRegisterLink}
								<a href="register.php" class="btn btn-default">{translate key='Register'}</a>
							{/if}
						</div>
					</div>
					<div>
						<div class="form-group col-xs-6 margin-bottom-0">
							{if $ShowPersistLoginPrompt}
								<label>
									<input id="rememberMe" type="checkbox"
										   name="{FormKeys::PERSIST_LOGIN}"
										   value="true"/> {translate key='RememberMe'}
								</label>
							{/if}
						</div>

						<div class="pull-right">
							{if $ShowForgotPasswordPrompt}
								<a href="forgot.php">{translate key='ForgotMyPassword'}</a>
							{/if}
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
		<div class="col-md-offset-4 col-md-4 col-xs-10 col-xs-offset-1">
			<div>
				<div class="form-group pull-right">
					<button type="button" class="btn btn-link" data-toggle="collapse"
							data-target="#change-language-options"><span><i
									class="glyphicon glyphicon-globe"></i></span> {translate key=ChangeLanguage}
					</button>
				</div>
			</div>
			<div class="clearfix"></div>
			<div id="change-language-options" class="form-group collapse pull-right">
				<select {formname key=LANGUAGE} class="form-control input-sm" id="languageDropDown">
					{object_html_options options=$Languages key='GetLanguageCode' label='GetDisplayName' selected=$SelectedLanguage}
				</select>
			</div>
		</div>
	</form>

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