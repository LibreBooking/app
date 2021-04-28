{include file='globalheader.tpl' Validator=true}

<div id="page-register">

    <div class="error hidden" id="registrationError">
        {translate key=UnknownError}
    </div>

    <div id="registration-box" class="default-box col-xs-12 col-sm-8 col-sm-offset-2">

        <form method="post" ajaxAction="{RegisterActions::Register}" id="form-register"
              action="{$smarty.server.SCRIPT_NAME}" role="form"
              data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
              data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
              data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
              data-bv-feedbackicons-required="glyphicon glyphicon-asterisk"
              data-bv-submitbuttons='button[type="submit"]'
              data-bv-onerror="enableButton"
              data-bv-onsuccess="enableButton"
              data-bv-live="enabled">

            <h1>{translate key=RegisterANewAccount}</h1>

            <div class="validationSummary alert alert-danger no-show" id="validationErrors">
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
                    {async_validator id="phoneRequired" key="PhoneRequired"}
                    {async_validator id="positionRequired" key="PositionRequired"}
                    {async_validator id="organizationRequired" key="OrganizationRequired"}
                </ul>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-6" id="username">
                    <div class="form-group">
                        <label class="reg" for="login">{translate key="Username"}</label>
                        {textbox name="LOGIN" value="Login" required="required"
                        data-bv-notempty="true"
                        data-bv-notempty-message="{translate key=UserNameRequired}"}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6" id="email">
                    <div class="form-group">
                        <label class="reg" for="email">{translate key="Email"}</label>
                        {textbox type="email" name="EMAIL" class="input" value="Email" required="required"
                        data-bv-notempty="true"
                        data-bv-notempty-message="{translate key=ValidEmailRequired}"
                        data-bv-emailaddress="true"
                        data-bv-emailaddress-message="{translate key=ValidEmailRequired}" }
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-6" id="password">
                    <div class="form-group">
                        <label class="reg" for="password">{translate key="Password"}</label>
                        {textbox type="password" name="PASSWORD" value="" required="required"
                        data-bv-notempty="true"
                        data-bv-notempty-message="{translate key=PwMustMatch}"
                        data-bv-identical="true"
                        data-bv-identical-field="{FormKeys::PASSWORD_CONFIRM}"
                        data-bv-identical-message="{translate key=PwMustMatch}" }
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6" id="password-confirm">
                    <div class="form-group">
                        <label class="reg" for="passwordConfirm">{translate key="PasswordConfirmation"}</label>
                        {textbox type="password" name="PASSWORD_CONFIRM" value="" required="required"
                        data-bv-notempty="true"
                        data-bv-notempty-message="{translate key=PwMustMatch}"
                        data-bv-identical="true"
                        data-bv-identical-field="{FormKeys::PASSWORD}"
                        data-bv-identical-message="{translate key=PwMustMatch}"}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-6" id="first-name">
                    <div class="form-group">
                        <label class="reg" for="fname">{translate key="FirstName"}</label>
                        {textbox name="FIRST_NAME" class="input" value="FirstName" required="required"
                        data-bv-notempty="true"
                        data-bv-notempty-message="{translate key=FirstNameRequired}"}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6" id="last-name">
                    <div class="form-group">
                        <label class="reg" for="lname">{translate key="LastName"}</label>
                        {textbox name="LAST_NAME" class="input" value="LastName" required="required" data-bv-notempty="true"
                        data-bv-notempty-message="{translate key=LastNameRequired}"}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-6" id="default-page">
                    <div class="form-group">
                        <label class="reg" for="homepage">{translate key="DefaultPage"}</label>
                        <select {formname key='DEFAULT_HOMEPAGE'} id="homepage" class="form-control">
                            {html_options values=$HomepageValues output=$HomepageOutput selected=$Homepage}
                        </select>
                    </div>

                </div>
                <div class="col-xs-12 col-sm-6" id="timezone">
                    <label class="reg" for="timezoneDropDown">{translate key="Timezone"}</label>

                    <div class="input-group">
                        <span class="input-group-addon"><a href="#" id="detectTimezone"
                                                           title="{translate key=Detect}"><i class="fa fa-clock-o"></i></a></span>
                        <select {formname key='TIMEZONE'} class="form-control" id="timezoneDropDown">
                            {html_options values=$TimezoneValues output=$TimezoneOutput selected=$Timezone}
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-6" id="phone">
                    <div class="form-group">
                        <label class="reg" for="phone">{translate key="Phone"}</label>
                        <input type="text" id="phone" {formname key="PHONE"} class="form-control" size="20"
                                {if $RequirePhone}required="required"
                                    data-bv-notempty="true"
                                    data-bv-notempty-message="{translate key=PhoneRequired}"{/if}
                        />
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6" id="organization">
                    <div class="form-group">
                        <label class="reg" for="txtOrganization">{translate key="Organization"}</label>
                        <input type="text" id="txtOrganization" {formname key="ORGANIZATION"} class="form-control"
                               size="20"
                                {if $RequireOrganization}required="required"
                                    data-bv-notempty="true"
                                    data-bv-notempty-message="{translate key=OrganizationRequired}"{/if}/>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-6" id="position">
                    <div class="form-group">
                        <label class="reg" for="txtPosition">{translate key="Position"}</label>
                        <input type="text" id="txtPosition" {formname key="POSITION"} class="form-control"
                               size="20" {if $RequirePosition}required="required"
                            data-bv-notempty="true"
                            data-bv-notempty-message="{translate key=PositionRequired}"{/if}/>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6">
                    {if $Attributes|default:array()|count > 0}
                        {control type="AttributeControl" attribute=$Attributes[0]}
                    {/if}
                </div>

            </div>

            {if $Attributes|default:array()|count > 1}
                {for $i=1 to $Attributes|default:array()|count-1}
                    {if $i%2==1}
                        <div class="row">
                    {/if}
                    <div class="col-xs-12 col-sm-6">
                        {control type="AttributeControl" attribute=$Attributes[$i]}
                    </div>
                    {if $i%2==0 || $i==$Attributes|default:array()|count-1}
                        </div>
                    {/if}
                {/for}
            {/if}

            {if $EnableCaptcha}
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            {control type="CaptchaControl"}
                        </div>
                    </div>
                </div>
            {else}
                <input type="hidden" {formname key=CAPTCHA} value=""/>
            {/if}

            {if $Terms != null}
                <div class="row" id="termsAndConditions">
                    <div class="col-xs-12">
                        <div class="checkbox">
                            <input type="checkbox"
                                   id="termsAndConditionsAcknowledgement" {formname key=TOS_ACKNOWLEDGEMENT}/>
                            <label for="termsAndConditionsAcknowledgement">{translate key=IAccept}</label>
                            <a href="{$Terms->DisplayUrl()}" style="vertical-align: middle"
                               target="_blank">{translate key=TheTermsOfService}</a>
                        </div>
                    </div>
                </div>
            {/if}

            <div>
                <button type="submit" name="{Actions::REGISTER}" value="{translate key='Register'}"
                        class="btn btn-primary col-xs-12" id="btnUpdate">{translate key='Register'}</button>
            </div>
        </form>
    </div>

    {include file="javascript-includes.tpl" Validator=true}

    {jsfile src="js/jstz.min.js"}
    {jsfile src="ajax-helpers.js"}
    {jsfile src="autocomplete.js"}
    {jsfile src="registration.js"}

    <script type="text/javascript">

        function enableButton() {
            $('#form-register').find('button').removeAttr('disabled');
        }

        $(document).ready(function () {
            $('#detectTimezone').click(function (e) {
                e.preventDefault();

                if (Intl.DateTimeFormat) {
                    var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
                } else {
                    var timezone = jstz.determine_timezone().name();
                }

                $('#timezoneDropDown').val(timezone);
            });

            var registrationPage = new Registration();
            registrationPage.init();

            var $frmRegister = $('#form-register');

            $frmRegister.on('init.field.bv', function (e, data) {
                var $parent = data.element.parents('.form-group');
                var $icon = $parent.find('.form-control-feedback[data-bv-icon-for="' + data.field + '"]');
                var validators = data.bv.getOptions(data.field).validators;

                if (validators.notEmpty) {
                    $icon.addClass('glyphicon glyphicon-asterisk').show();
                }
            })
                .off('success.form.bv')
                .on('success.form.bv', function (e) {
                    e.preventDefault();
                });

            $frmRegister.bootstrapValidator();

            $('#txtOrganization').orgAutoComplete("ajax/autocomplete.php?type={AutoCompleteType::Organization}");

        });
    </script>

    <div id="colorbox">
        <div id="modalDiv" class="wait-box">
            <h3>{translate key=Working}</h3>
            {html_image src="reservation_submitting.gif"}
        </div>
    </div>

</div>
{include file='globalfooter.tpl'}
