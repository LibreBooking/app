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

{validation_group class="error"}
	{validator id="currentpassword" key="InvalidPassword"}
	{validator id="passwordmatch" key="PwMustMatch"}
	{validator id="passwordcomplexity" key="PwComplexity"}
{/validation_group}


{if $ResetPasswordSuccess}
<div class="success">
	{translate key=PasswordChangedSuccessfully}
</div>
{/if}

<div id="registrationbox">
	<form class="register" method="post" action="{$smarty.server.SCRIPT_NAME}">
		<div class="registrationHeader"><h3>{translate key="ChangePassword"}</h3></div>
		<p>
			<label class="reg">{translate key="CurrentPassword"}<br/>
			{textbox type="password" name="CURRENT_PASSWORD" class="input" size="20"}
			</label>
		</p>

		<p>
			<label class="reg">{translate key="NewPassword"}<br/>
			{textbox type="password" name="PASSWORD" class="input" value="" size="20"}
			</label>
		</p>

		<p>
			<label class="reg">{translate key="PasswordConfirmation"}<br/>
			{textbox type="password" name="PASSWORD_CONFIRM" class="input" value="" size="20"}
			</label>
		</p>

		<p class="regsubmit">
			<button type="submit" name="{Actions::CHANGE_PASSWORD}" value="{translate key='ChangePassword'}"
					class="button">{html_image src="tick-circle.png"} {translate key='ChangePassword'}</button>
		</p>
	</form>
</div>
{setfocus key='CURRENT_PASSWORD'}
{include file='globalfooter.tpl'}