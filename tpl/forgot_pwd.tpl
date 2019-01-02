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

{if $Enabled}

	{if $ShowResetEmailSent}
		<div class="alert alert-success">
			{translate key=ForgotPasswordEmailSent}<br/>
			<a href="{$Path}{Pages::LOGIN}">{translate key="LogIn"}</a>
		</div>
	{/if}

<div id="forgotbox">
	<form class="forgot" method="post" action="{$smarty.server.SCRIPT_NAME}">
		<div class="forgot_pwdHeader">
			<h1>{translate key='ForgotPassword'}</h1>
		</div>
		<div>
			<p class="forgot">{translate key='YouWillBeEmailedANewPassword'}</p>
			<p>
				<label class="forgot">{translate key='EmailAddress'}<br />
					{textbox name="EMAIL" class="input" size="20" tabindex="10"}</label>
			</p>
			<p class="resetpassword">
				<button type="submit" class="btn btn-default" name="{Actions::RESET}" value="{Actions::RESET}">{translate key='ChangePassword'}</button>
			</p>
		</div>
	</form>
</div>

{setfocus key='EMAIL'}
{else}
<div class="error">Disabled</div>
{/if}

{include file="javascript-includes.tpl"}
{include file='globalfooter.tpl'}
