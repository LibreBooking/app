{*
Copyright 2011-2020 Nick Korbel

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

<div id="page-change-password">

    <div class="row">
        <div class="col s12 m8 offset-m2 validationSummary card error no-show" id="validationErrors">
            <ul>
                {validator id="currentpassword" key="InvalidPassword"}
                {validator id="passwordmatch" key="PwMustMatch"}
                {validator id="passwordcomplexity" key=""}
            </ul>
        </div>


        {if !$AllowPasswordChange}
            <div class="card warning col s12 m8 offset-m2 ">
                <ul>
                    <li>
                        <i class="fa fa-warning fa-2x"></i> {translate key=PasswordControlledExternallyError}
                    </li>
                </ul>
            </div>
        {else}
            {if $ResetPasswordSuccess}
                <div class="card success col s12 m8 offset-m2">
                    <ul>
                        <li>
                            <span class="fa fa-check-circle-o"></span> {translate key=PasswordChangedSuccessfully}
                        </li>
                    </ul>
                </div>
            {/if}
            <div id="password-reset-box" class="col s12 m8 offset-m2">
                <h1 class="page-title">{translate key="ChangePassword"}</h1>


                <form id="password-reset-form" method="post" action="{$smarty.server.SCRIPT_NAME}">
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="{FormKeys::CURRENT_PASSWORD}">{translate key="CurrentPassword"}</label>
                            {textbox type="password" name="CURRENT_PASSWORD" required="required"}
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="{FormKeys::PASSWORD}">{translate key="NewPassword"}</label>
                            {textbox type="password" name="PASSWORD" required="required"}
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="{FormKeys::PASSWORD_CONFIRM}">{translate key="PasswordConfirmation"}</label>
                            {textbox type="password" name="PASSWORD_CONFIRM" value="" required="required"}

                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <button type="submit" name="{Actions::CHANGE_PASSWORD}"
                                    value="{translate key='ChangePassword'}"
                                    class="btn btn-primary waves-effect waves-light right">{translate key='ChangePassword'}</button>
                        </div>
                    </div>
                    {csrf_token}
                </form>

            </div>
            {setfocus key='CURRENT_PASSWORD'}
        {/if}
    </div>
</div>
{include file="javascript-includes.tpl"}
{include file='globalfooter.tpl'}