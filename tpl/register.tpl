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

<div id="page-register">

    <div class="col s12 m8 offset-m2 card-panel error hidden" id="registrationError">
        {translate key=UnknownError}
    </div>

    <div class="col s12 m8 offset-m2 validationSummary card-panel error no-show" id="validationErrors">
        <ul>
            {async_validator id="uniqueemail" key="UniqueEmailRequired"}
            {async_validator id="uniqueusername" key="UniqueUsernameRequired"}
            {async_validator id="username" key="UserNameRequired"}
            {async_validator id="emailformat" key="ValidEmailRequired"}
            {async_validator id="fname" key="FirstNameRequired"}
            {async_validator id="lname" key="LastNameRequired"}
            {async_validator id="passwordmatch" key="PwMustMatch"}
            {async_validator id="passwordcomplexity" key=""}
            {async_validator id="captcha" key="CaptchaMustMatch"}
            {async_validator id="additionalattributes" key=""}
            {async_validator id="requiredEmailDomain" key="InvalidEmailDomain"}
            {async_validator id="termsOfService" key="TermsOfServiceError"}
        </ul>
    </div>

    <div class="row">
        <div id="registration-box" class="default-box col s12 m8 offset-m2">

            <form method="post" ajaxAction="{RegisterActions::Register}" id="form-register"
                  action="{$smarty.server.SCRIPT_NAME}" role="form">

                <h4>{translate key=RegisterANewAccount}</h4>



                <div class="row">
                    <div class="col s12 m6" id="username">
                        <div class="input-field">
                            {textbox name="LOGIN" value="Login" required="required"}
                            <label class="reg" for="login">{translate key="Username"} *</label>
                        </div>
                    </div>

                    <div class="col s12 m6" id="email">
                        <div class="input-field">
                            {textbox type="email" name="EMAIL" class="input" value="Email" required="required"}
                            <label class="reg" for="email">{translate key="Email"} *</label>
                            {*<span class="helper-text" data-error="{translate key=ValidEmailRequired}"*}
                                  {*data-success=""></span>*}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6" id="password">
                        <div class="input-field">
                            {textbox type="password" name="PASSWORD" value="" required="required"}
                            <label class="reg" for="password">{translate key="Password"} *</label>
                        </div>
                    </div>

                    <div class="col s12 m6" id="password-confirm">
                        <div class="input-field">
                            {textbox type="password" name="PASSWORD_CONFIRM" value="" required="required" data-rule-equalto="#{FormKeys::PASSWORD}"}
                            <label class="reg" for="passwordConfirm">{translate key="PasswordConfirmation"} *</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6" id="first-name">
                        <div class="input-field">
                            {textbox name="FIRST_NAME" class="input" value="FirstName" required="required"}
                            <label class="reg" for="fname">{translate key="FirstName"} *</label>
                        </div>
                    </div>
                    <div class="col s12 m6" id="last-name">
                        <div class="input-field">
                            {textbox name="LAST_NAME" class="input" value="LastName" required="required"}
                            <label class="reg" for="lname">{translate key="LastName"} *</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6" id="default-page">
                        <div class="input-field">
                            <select {formname key='DEFAULT_HOMEPAGE'} id="homepage">
                                {html_options values=$HomepageValues output=$HomepageOutput selected=$Homepage}
                            </select>
                            <label class="reg" for="homepage">{translate key="DefaultPage"}</label>
                        </div>
                    </div>

                    <div class="col s12 m6" id="timezone">
                        <div class="input-field">
                            <i id="detectTimezone"
                               class="material-icons prefix clickable tooltipped"
                               data-position="top" data-tooltip="{translate key=DetectTimezone}">access_time</i>
                            <select {formname key='TIMEZONE'} id="timezoneDropDown">
                                {html_options values=$TimezoneValues output=$TimezoneOutput selected=$Timezone}
                            </select>
                            <label class="reg" for="timezoneDropDown">{translate key="Timezone"}</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6" id="phone">
                        <div class="input-field">
                            {textbox name="PHONE" class="input" value="Phone" size="20"}
                            <label class="reg" for="phone">{translate key="Phone"}</label>
                        </div>
                    </div>

                    <div class="col s12 m6" id="organization">
                        <div class="input-field">
                            {textbox name="ORGANIZATION" class="input" value="Organization" size="20" id="txtOrganization"}
                            <label class="reg" for="txtOrganization">{translate key="Organization"}</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6" id="position">
                        <div class="input-field">
                            <label class="reg" for="txtPosition">{translate key="Position"}</label>
                            {textbox name="POSITION" class="input" value="Position" size="20" id="txtPosition"}
                        </div>
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

                {if $EnableCaptcha}
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field">
                                {control type="CaptchaControl"}
                            </div>
                        </div>
                    </div>
                {else}
                    <input type="hidden" {formname key=CAPTCHA} value=""/>
                {/if}

                {if $Terms != null}
                    <div class="row" id="termsAndConditions">
                        <div class="col s12">
                            <input type="checkbox"
                                   id="termsAndConditionsAcknowledgement" {formname key=TOS_ACKNOWLEDGEMENT}/>
                            <label for="termsAndConditionsAcknowledgement">{translate key=IAccept}</label>
                            <a href="{$Terms->DisplayUrl()}" style="vertical-align: middle"
                               target="_blank">{translate key=TheTermsOfService}</a>
                        </div>
                    </div>
                {/if}

                <div class="col s12">
                    <button type="submit" name="{Actions::REGISTER}" value="{translate key='Register'}"
                            class="btn btn-primary waves-effect waves-light right"
                            id="btnUpdate">{translate key='Register'}</button>
                </div>
                <div class="clearfix">&nbsp;</div>
            </form>
        </div>
    </div>

    {include file="javascript-includes.tpl" Validator=true}

    {jsfile src="ajax-helpers.js"}
    {jsfile src="autocomplete.js"}
    {jsfile src="registration.js"}

    <script type="text/javascript">

        function enableButton() {
            $('#form-register').find('button').removeAttr('disabled');
        }

        $(document).ready(function () {
            $('#detectTimezone').tooltip();
            $('#detectTimezone').click(function (e) {
                e.preventDefault();
                $('#timezoneDropDown').changeDropdown(Intl.DateTimeFormat().resolvedOptions().timeZone);
            });

            var messages = {
                {FormKeys::LOGIN}: {
                    required: '{{translate key=UserNameRequired}|escape:javascript}'
                },
                {FormKeys::EMAIL}: {
                    required: '{{translate key=ValidEmailRequired}|escape:javascript}',
                    email: '{{translate key=ValidEmailRequired}|escape:javascript}'
                },
                {FormKeys::PASSWORD}: {
                    required: '{{translate key=PasswordRequired}|escape:javascript}'
                },
                {FormKeys::PASSWORD_CONFIRM}: {
                    equalTo: '{{translate key=PwMustMatch}|escape:javascript}'
                },
                {FormKeys::FIRST_NAME}: {
                    required: '{{translate key=FirstNameRequired}|escape:javascript}'
                },
                {FormKeys::LAST_NAME}: {
                    required: '{{translate key=LastNameRequired}|escape:javascript}'
                },
            };

            var registrationPage = new Registration();
            registrationPage.init(messages);

            $('#txtOrganization').orgAutoComplete("ajax/autocomplete.php?type={AutoCompleteType::Organization}");

        });
    </script>

    <div id="colorbox">
        <div id="modalDiv" class="wait-box">
            <h5>{translate key=Working}</h5>
            {html_image src="reservation_submitting.gif"}
        </div>
    </div>

</div>
{include file='globalfooter.tpl'}
