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

<div class="page-change-password">

	{validation_group class="alert alert-danger"}
	{validator id="currentpassword" key="InvalidPassword"}
	{validator id="passwordmatch" key="PwMustMatch"}
	{validator id="passwordcomplexity" key=""}
	{/validation_group}


	{if !$AllowPasswordChange}
		<div class="alert alert-danger">
			<i class="fa fa-warning fa-2x"></i> {translate key=PasswordControlledExternallyError}
		</div>
	{else}
		{if $ResetPasswordSuccess}
			<div class="success alert alert-success col-xs-12 col-sm-8 col-sm-offset-2">
				<span class="glyphicon glyphicon-ok-sign"></span> {translate key=PasswordChangedSuccessfully}
			</div>
		{/if}
		<div id="password-reset-box" class="default-box col-xs-12 col-sm-8 col-sm-offset-2">
			<h1>{translate key="ChangePassword"}</h1>

			<form id="password-reset-form" method="post" action="{$smarty.server.SCRIPT_NAME}">

				<div class="form-group">
					<label for="{FormKeys::CURRENT_PASSWORD}">{translate key="CurrentPassword"}</label>
						{textbox type="password" name="CURRENT_PASSWORD"}
				</div>

				<div class="form-group">
					<label for="{FormKeys::PASSWORD}">{translate key="NewPassword"}</label>
						{textbox type="password" name="PASSWORD"}
				</div>

				<div class="form-group">
					<label for="{FormKeys::PASSWORD_CONFIRM}">{translate key="PasswordConfirmation"}</label>
						{textbox type="password" name="PASSWORD_CONFIRM" value=""}

				</div>

				<div class="form-group">
					<button type="submit" name="{Actions::CHANGE_PASSWORD}" value="{translate key='ChangePassword'}"
							class="btn btn-primary">{translate key='ChangePassword'}</button>
				</div>
				{csrf_token}
			</form>
		</div>
		{setfocus key='CURRENT_PASSWORD'}
	{/if}

</div>
{include file="javascript-includes.tpl"}
{include file='globalfooter.tpl'}