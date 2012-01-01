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

	{if $ShowResetEmailSent}
		<div class="success">
			{translate key=ForgotPasswordEmailSent}<br/>
			<a href="{$Path}{Pages::LOGIN}">{translate key="LogIn"}</a>
		</div>
	{/if}

<div id="forgotbox">
	<form class="forgot" method="post" action="{$smarty.server.SCRIPT_NAME}">
		<div class="forgot_pwdHeader">
			<h3>{translate key='ForgotPassword'}</h3>
		</div>
		<div>
			<p class="forgot">{translate key='YouWillBeEmailedANewPassword'}</p>
			<p>
				<label class="forgot">{translate key='EmailAddress'}<br />
					{textbox name="EMAIL" class="input" size="20" tabindex="10"}</label>
			</p>
			<p class="resetpassword">
				<button type="submit" class="button" name="{Actions::RESET}" value="{Actions::RESET}">{html_image src="tick-circle.png"} {translate key='ChangePassword'}</button>
			</p>
		</div>
	</form>
</div>

{setfocus key='EMAIL'} 

{include file='globalfooter.tpl'}