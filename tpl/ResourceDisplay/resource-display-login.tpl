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

<div id="page-resource-display-shell" class="row">

    <div class="col offset-m3 m6 s12">

        <div id="login-box" class="default-box">
            <form role="form" name="loginForm" id="loginForm" class="form-horizontal" method="post"
                  action="{$smarty.server.SCRIPT_NAME}?action=login">

                <div id="loginError" class="alert alert-danger col-xs-12 no-show">
                    {translate key=LoginError}
                </div>

                <div class="col s12">
                    <div class="input-field">
                        <i class="material-icons prefix">account_circle</i>
                        <label for="email">{translate key=UsernameOrEmail}</label>
                        <input type="text" required="" id="email" {formname key=EMAIL}/>
                    </div>
                </div>

                <div class="col s12">
                    <div class="input-field">
                        <i class="material-icons prefix">lock_outline</i>
                        <input type="password" required="required" id="password" {formname key=PASSWORD}/>
                        <label for="password">{translate key=Password}</label>
                    </div>
                </div>

                <div class="col s12">
                    <button type="submit" class="btn btn-primary waves-effect waves-light" name="{Actions::LOGIN}"
                            value="submit" id="loginButton">{translate key='LogIn'}</button>
                </div>

            </form>
            <div class="clearfix">&nbsp;</div>
        </div>

        <div id="resource-list-box" class="default-box no-show">
            <form role="form" id="activateResourceDisplayForm" method="post"
                  action="{$smarty.server.SCRIPT_NAME}?action=activate">
                <div class="input-field">
                    <label for="resourceList" class="active">{translate key=ResourceDisplayPrompt}</label>
                    <select id="resourceList" {formname key=RESOURCE_ID}>
                        <option value="">-- {translate key=Resource} --</option>
                    </select>
                </div>
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