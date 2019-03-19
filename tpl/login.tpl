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

<div id="page-login">
    {if $ShowLoginError}
        <div id="loginError" class="alert alert-danger">
            {translate key='LoginError'}
        </div>
    {/if}

    {if $EnableCaptcha}
        {validation_group class="alert alert-danger"}
        {validator id="captcha" key="CaptchaMustMatch"}
        {/validation_group}
    {/if}

    {if $Announcements|count > 0}
        <div id="announcements" class="col m8 offset-m2 s12">
            {foreach from=$Announcements item=each}
                <div class="announcement">{$each->Text()|html_entity_decode|url2link|nl2br}</div>
            {/foreach}
        </div>
    {/if}

    <div class="row">
        <div class="col offset-m3 s12 m6">
            <form role="form" name="login" id="login" class="form-horizontal" method="post"
                  action="{$smarty.server.SCRIPT_NAME}">
                <div id="login-box" class="col s12 card">
                    <div class="login-icon">
                        {html_image src="$LogoUrl" alt="$Title"}
                    </div>
                    {if $ShowUsernamePrompt}
                        <div class="col s12">
                            <div class="input-field margin-bottom-25">
                                <i class="material-icons prefix">account_circle</i>
                                <input type="text" required="required" id="email" {formname key=EMAIL}/>
                                <label for="email">{translate key=UsernameOrEmail}</label>
                            </div>
                        </div>
                    {/if}

                    {if $ShowPasswordPrompt}
                        <div class="col s12">
                            <div class="input-field margin-bottom-25">
                                <i class="material-icons prefix">lock_outline</i>
                                <input type="password" required="required" id="password" {formname key=PASSWORD}/>
                                <label for="password">{translate key=Password}</label>
                            </div>
                        </div>
                    {/if}

                    {if $EnableCaptcha}
                        <div class="col s12">
                            <div class="margin-bottom-25">
                                {control type="CaptchaControl"}
                            </div>
                        </div>
                    {else}
                        <input type="hidden" {formname key=CAPTCHA} value=""/>
                    {/if}

                    {if $ShowUsernamePrompt && $ShowPasswordPrompt}
                        <div class="col s12 justify-space-between-align-center login-action">
                            <label for="rememberMe">
                                <input id="rememberMe" type="checkbox" {formname key=PERSIST_LOGIN}>
                                <span>{translate key=RememberMe}</span>
                            </label>

                            <button type="submit" class="btn btn-primary waves-effect waves-light" name="{Actions::LOGIN}"
                                    value="submit">{translate key='LogIn'}</button>
                            <input type="hidden" {formname key=RESUME} value="{$ResumeUrl}"/>
                        </div>
                    {/if}

                    {if $ShowRegisterLink}
                        <div class="col s12 register">
                            <span class="bold">{translate key="FirstTimeUser?"}
                            <a href="{$RegisterUrl}" {$RegisterUrlNew}
                               title="{translate key=Register}">{translate key=Register}</a>
                            </span>
                        </div>
                    {/if}

                    {if $AllowGoogleLogin || $AllowFacebookLogin}
                        <div class="divider">&nbsp;</div>
                        <div class="col s12 justify-space-between-align-center login-action">
                            {if $AllowGoogleLogin}
                                <div class="social-login" id="socialLoginGoogle">
                                    <a href="https://accounts.google.com/o/oauth2/v2/auth?scope=email%20profile&state={$GoogleState}&redirect_uri=https://www.social.twinkletoessoftware.com/googleresume.php&response_type=code&client_id=531675809673-3sfvrchh6svd9bfl7m55dao8n4s6cqpc.apps.googleusercontent.com">
                                        <i class="fa fa-google"></i> {translate key=SignInGoogle}
                                    </a>
                                </div>
                            {/if}
                            {if $AllowFacebookLogin}
                                <div class="social-login" id="socialLoginFacebook">
                                    <a href="https://www.social.twinkletoessoftware.com/fblogin.php?protocol={$Protocol}&resume={$ScriptUrlNoProtocol}/external-auth.php%3Ftype%3Dfb%26redirect%3D{$ResumeUrl}">
                                        <i class="fa fa-facebook"></i> {translate key=SignInFacebook}
                                    </a>
                                </div>
                            {/if}
                        </div>
                    {/if}
                </div>

                <div id="login-footer" class="col s12 justify-space-between-align-center">
                    {if $ShowForgotPasswordPrompt}
                        <div id="forgot-password">
                            <a href="{$ForgotPasswordUrl}" {$ForgotPasswordUrlNew} class="">
                                <i class="fa fa-question"></i>
                                {translate key='ForgotMyPassword'}
                            </a>
                        </div>
                    {/if}
                    <div id="change-language">
                        <a href="#" id="change-language-button">
                            <i class="fa fa-globe"></i>
                            {translate key=ChangeLanguage}
                        </a>
                    </div>
                </div>
                <div id="change-language-options" class="no-show">
                    <div class="input-field col s12">
                        <select {formname key=LANGUAGE} id="languageDropDown">
                            {object_html_options options=$Languages key='GetLanguageCode' label='GetDisplayName' selected=$SelectedLanguage}
                        </select>
                        <label for="languageDropDown">{translate key=ChangeLanguage}</label>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {setfocus key='EMAIL'}

    {include file="javascript-includes.tpl"}

    <script type="text/javascript">
        var url = 'index.php?{QueryStringKeys::LANGUAGE}=';
        $(document).ready(function () {
            $('#languageDropDown').change(function () {
                window.location.href = url + $(this).val();
            });

            $('#change-language-button').click(function (e) {
                e.preventDefault();
                $('#change-language-options').toggleClass('no-show');
            });
        });
    </script>
</div>
{include file='globalfooter.tpl'}