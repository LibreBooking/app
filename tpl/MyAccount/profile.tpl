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
{include file='globalheader.tpl' Validator=true}

<div id="page-profile">

    <div class="row">
        <div class="hidden col s12 m8 offset-m2 card success" id="profileUpdatedMessage">
            <ul>
                <li>
                    <span class="fa fa-check-circle-o"></span> {translate key=YourProfileWasUpdated}
                </li>
            </ul>
        </div>

        <div class="col s12 m8 offset-m2 validationSummary card error no-show" id="validationErrors">
            <ul>
                {async_validator id="fname" key="FirstNameRequired"}
                {async_validator id="lname" key="LastNameRequired"}
                {async_validator id="username" key="UserNameRequired"}
                {async_validator id="emailformat" key="ValidEmailRequired"}
                {async_validator id="uniqueemail" key="UniqueEmailRequired"}
                {async_validator id="uniqueusername" key="UniqueUsernameRequired"}
                {async_validator id="additionalattributes" key=""}
            </ul>
        </div>

        <div id="profile-box" class="col s12 m8 offset-m2">

            <form method="post" ajaxAction="{ProfileActions::Update}" id="form-profile"
                  action="{$smarty.server.SCRIPT_NAME}"
                  role="form">

                <h1 class="page-title">{translate key=EditProfile}</h1>

                <div class="row">
                    <div class="col s12 m6 input-field">
                        <label class="reg" for="username">{translate key="Username"} *</label>
                        {if $AllowUsernameChange}
                            {textbox name="USERNAME" value="Username" required="required" class="validate"}
                        {else}
                            <span>{$Username}</span>
                            <input type="hidden" {formname key=USERNAME} value="{$Username}"/>
                        {/if}
                    </div>

                    <div class="col s12 m6 input-field">
                        <label class="reg" for="email">{translate key="Email"} *</label>
                        {if $AllowEmailAddressChange}
                            {textbox type="email" name="EMAIL" value="Email" required="required" class="validate"}
                        {else}
                            <span>{$Email}</span>
                            <input type="hidden" {formname key=EMAIL} value="{$Email}"/>
                        {/if}
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 input-field">
                        <label class="reg" for="fname">{translate key="FirstName"} *</label>
                        {if $AllowNameChange}
                            {textbox name="FIRST_NAME" value="FirstName" required="required" class="validate"}
                        {else}
                            <span>{$FirstName}</span>
                            <input type="hidden" {formname key=FIRST_NAME} value="{$FirstName}" class="validate"/>
                        {/if}
                    </div>
                    <div class="col s12 m6 input-field">
                        <label class="reg" for="lname">{translate key="LastName"} *</label>
                        {if $AllowNameChange}
                            {textbox name="LAST_NAME" value="LastName" required="required" class="validate" }
                        {else}
                            <span>{$LastName}</span>
                            <input type="hidden" {formname key=LAST_NAME} value="{$LastName}"/>
                        {/if}
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 input-field">
                        <label class="reg active" for="homepage">{translate key="DefaultPage"}</label>
                        <select {formname key='DEFAULT_HOMEPAGE'} id="homepage">
                            {html_options values=$HomepageValues output=$HomepageOutput selected=$Homepage}
                        </select>
                    </div>
                    <div class="col s12 m6 input-field">
                        <label class="reg active" for="timezoneDropDown">{translate key="Timezone"}</label>
                        <select {formname key='TIMEZONE'} id="timezoneDropDown">
                            {html_options values=$TimezoneValues output=$TimezoneOutput selected=$Timezone}
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 input-field">
                        <label class="reg" for="phone">{translate key="Phone"}</label>
                        {if $AllowPhoneChange}
                            {textbox name="PHONE" value="Phone"}
                        {else}
                            <span>{$Phone}</span>
                            <input type="hidden" {formname key=PHONE} value="{$Phone}"/>
                        {/if}
                    </div>

                    <div class="col s12 m6 input-field">
                        <label class="reg" for="txtOrganization">{translate key="Organization"}</label>
                        {if $AllowOrganizationChange}
                            {textbox name="ORGANIZATION" value="Organization" id="txtOrganization"}
                        {else}
                            <span>{$Organization}</span>
                            <input type="hidden" {formname key=ORGANIZATION} value="{$Organization}"/>
                        {/if}
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 input-field">
                        <label class="reg" for="txtPosition">{translate key="Position"}</label>
                        {if $AllowPositionChange}
                            {textbox name="POSITION" value="Position" id="txtPosition"}
                        {else}
                            <span>{$Position}</span>
                            <input type="hidden" {formname key=POSITION} value="{$Position}"/>
                        {/if}
                    </div>

                    <div class="col s12 m6">
                        {if $Attributes|count > 0}
                            {control type="AttributeControl" attribute=$Attributes[0]}
                        {/if}
                    </div>

                </div>

                {if $Attributes|count > 1}
                    {for $i=1 to $Attributes|count-1}
                        {if $i%2==1}
                            <div class="row">
                        {/if}
                        <div class="col s12 m6">
                            {control type="AttributeControl" attribute=$Attributes[$i]}
                        </div>
                        {if $i%2==0 || $i==$Attributes|count-1}
                            </div>
                        {/if}
                    {/for}
                {/if}

                <div class="col s12">
                    <button type="submit" class="btn btn-primary waves-effect waves-light right" name="{Actions::SAVE}"
                            id="btnUpdate">
                        {translate key='Update'}
                    </button>
                </div>
                <div class="clearfix">&nbsp;</div>
                {csrf_token}
            </form>
        </div>
    </div>
    {setfocus key='FIRST_NAME'}

    {include file="javascript-includes.tpl" Validator=true}
    {jsfile src="ajax-helpers.js"}
    {jsfile src="autocomplete.js"}
    {jsfile src="profile.js"}

    <script type="text/javascript">

        function enableButton() {
            $('#form-profile').find('button').removeAttr('disabled');
        }

        $(document).ready(function () {
            var messages = {
            {FormKeys::LOGIN}:
            {
                required: '{{translate key=UserNameRequired}|escape:javascript}'
            }
        ,
            {FormKeys::EMAIL}:
            {
                required: '{{translate key=ValidEmailRequired}|escape:javascript}',
                    email
            :
                '{{translate key=ValidEmailRequired}|escape:javascript}'
            }
        ,
            {FormKeys::PASSWORD}:
            {
                required: '{{translate key=PasswordRequired}|escape:javascript}'
            }
        ,
            {FormKeys::PASSWORD_CONFIRM}:
            {
                equalTo: '{{translate key=PwMustMatch}|escape:javascript}'
            }
        ,
            {FormKeys::FIRST_NAME}:
            {
                required: '{{translate key=FirstNameRequired}|escape:javascript}'
            }
        ,
            {FormKeys::LAST_NAME}:
            {
                required: '{{translate key=LastNameRequired}|escape:javascript}'
            }
        ,
        }
            ;

            var profilePage = new Profile();
            profilePage.init(messages);


            $('#txtOrganization').orgAutoComplete("ajax/autocomplete.php?type={AutoCompleteType::Organization}");
        });
    </script>

    <div id="wait-box" class="wait-box">
        <h5>{translate key=Working}</h5>
        {html_image src="reservation_submitting.gif"}
    </div>

</div>
{include file='globalfooter.tpl'}