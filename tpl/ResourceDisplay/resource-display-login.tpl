{*
Copyright 2017-2019 Nick Korbel

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

{include file='globalheader.tpl' HideNavBar=true}

<div id="page-resource-display-shell">

	<div class="col-md-offset-3 col-md-6 col-xs-12">

		<div id="login-box" class="col-xs-12 default-box straight-top">
			<form role="form" name="loginForm" id="loginForm" class="form-horizontal" method="post"
				  action="{$smarty.server.SCRIPT_NAME}?action=login">

				<div id="loginError" class="alert alert-danger col-xs-12 no-show">
					{translate key=LoginError}
				</div>

				<div class="col-xs-12">
					<div class="input-group margin-bottom-25">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input type="text" required="" class="form-control"
							   id="email" {formname key=EMAIL}
							   placeholder="{translate key=UsernameOrEmail}"/>
					</div>
				</div>

				<div class="col-xs-12">
					<div class="input-group margin-bottom-25">
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-lock"></i>
						</span>
						<input type="password" required="" id="password" {formname key=PASSWORD}
							   class="form-control"
							   value="" placeholder="{translate key=Password}"/>
					</div>
				</div>

				<div class="col-xs-12">
					<button type="submit" class="btn btn-large btn-primary btn-block" name="{Actions::LOGIN}"
							value="submit" id="loginButton">{translate key='LogIn'}</button>
				</div>

			</form>
		</div>

		<div id="resource-list-box" class="col-xs-12 default-box straight-top no-show">
			<form role="form" id="activateResourceDisplayForm" method="post"
							  action="{$smarty.server.SCRIPT_NAME}?action=activate">
				<h2><label for="resourceList">{translate key=ResourceDisplayPrompt}</label></h2>
				<select id="resourceList" {formname key=RESOURCE_ID} class="form-control">
					<option value="">-- {translate key=Resource} --</option>
				</select>
			</form>
		</div>
	</div>
</div>

<div id="wait-box" class="wait-box">
	{indicator id="waitIndicator"}
</div>

{include file="javascript-includes.tpl"}
{jsfile src="resourceDisplay.js"}
{jsfile src="ajax-helpers.js"}

<script type="text/javascript">
	$(function () {
		var resourceDisplay = new ResourceDisplay();
		resourceDisplay.init();
	});
</script>

{include file='globalfooter.tpl'}