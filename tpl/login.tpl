{*
Copyright 2011-2015 Nick Korbel

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

	<div class="col-md-offset-3 col-md-6 col-xs-10 col-xs-offset-1">
		<div id="login-header" class="default-box-header">
			<span class="sign-in">{translate key=SignIn}</span>
			{if $ShowRegisterLink}<span class="pull-right register">{translate key="FirstTimeUser?"}
				<a href="{$RegisterUrl}" {$RegisterUrlNew}
				   title="{translate key=Register}">{translate key=Register}</a>
				</span>{/if}
		</div>
		<form role="form" name="login" id="login" class="form-horizontal" method="post"
			  action="{$smarty.server.SCRIPT_NAME}">
			<div id="login-box" class="col-xs-12 default-box straight-top">
				{if $ShowUsernamePrompt}
					<div class="col-xs-12">
						<div class="input-group margin-bottom-25">
							<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
							<input type="text" required="" class="form-control"
								   id="email" {formname key=EMAIL}
								   placeholder="{translate key=UsernameOrEmail}"/>
						</div>
					</div>
				{/if}

				{if $ShowPasswordPrompt}
					<div class="col-xs-12">
						<div class="input-group margin-bottom-25">
							<span class="input-group-addon">
							<i class="glyphicon glyphicon-lock"></i>
							</span>
							<input type="password" required="" id="password" {formname key=PASSWORD}
								   class="form-control"
								   value="" placeholder="{translate key=Password}"/>
						</div>
					</div>
				{/if}

				<div class="col-xs-12">
					<button type="submit" class="btn btn-large btn-primary  btn-block" name="{Actions::LOGIN}"
							value="submit">{translate key='LogIn'}</button>
					<input type="hidden" {formname key=RESUME} value="{$ResumeUrl}"/>
				</div>

				<div class="col-xs-12">
					<div class="checkbox">
						<input id="rememberMe" type="checkbox" {formname key=PERSIST_LOGIN}>
						<label for="rememberMe">{translate key=RememberMe}</label>
					</div>
				</div>

				<div class="col-xs-6">
					<a href="https://accounts.google.com/o/oauth2/v2/auth?scope=email%20profile&state=&redirect_uri={$ScriptUrl}/external-auth.php%3Ftype%3Dgoogle&response_type=code&client_id={$GoogleClientId}">
						<img src="img/external/btn_google_signin_dark_normal_web.png" alt="Sign in with Google"/>
					</a>
				</div>

				<div class="col-xs-6">
					<a href="http://localhost/fblogin/fblogin.php?resume={$ScriptUrl}/external-auth.php%3Ftype%3Dfb">Facebook</a>
					{*<fb:login-button scope="public_profile,email" onlogin="checkLoginState();"></fb:login-button>*}
				</div>
			</div>
			<div id="login-footer">
				{if $ShowForgotPasswordPrompt}
					<div id="forgot-password" class="pull-left">
						<a href="{$ForgotPasswordUrl}" {$ForgotPasswordUrlNew} class="btn btn-link"><span><i
										class="glyphicon glyphicon-question-sign"></i></span> {translate key='ForgotMyPassword'}</a>
					</div>
				{/if}
				<div id="change-language" class="pull-right">
					<button type="button" class="btn btn-link" data-toggle="collapse"
							data-target="#change-language-options"><span><i class="glyphicon glyphicon-globe"></i></span>
						{translate key=ChangeLanguage}
					</button>
					<div id="change-language-options" class="collapse">
						<select {formname key=LANGUAGE} class="form-control input-sm" id="languageDropDown">
							{object_html_options options=$Languages key='GetLanguageCode' label='GetDisplayName' selected=$SelectedLanguage}
						</select>
					</div>
				</div>
			</div>


		</form>
	</div>
</div>

{setfocus key='EMAIL'}

<script type="text/javascript">
	var url = 'index.php?{QueryStringKeys::LANGUAGE}=';
	$(document).ready(function () {
		$('#languageDropDown').change(function () {
			window.location.href = url + $(this).val();
		});

		var langCode = readCookie('{CookieKeys::LANGUAGE}');

		if (!langCode)
		{
		}
	});

	// This is called with the results from from FB.getLoginStatus().
	  function statusChangeCallback(response) {
	    console.log('statusChangeCallback');
	    console.log(response);
	    // The response object is returned with a status field that lets the
	    // app know the current login status of the person.
	    // Full docs on the response object can be found in the documentation
	    // for FB.getLoginStatus().
	    if (response.status === 'connected') {
	      // Logged into your app and Facebook.
	      testAPI();
	    } else if (response.status === 'not_authorized') {
	      // The person is logged into Facebook, but not your app.
	      document.getElementById('status').innerHTML = 'Please log ' +
	        'into this app.';
	    } else {
	      // The person is not logged into Facebook, so we're not sure if
	      // they are logged into this app or not.
	      document.getElementById('status').innerHTML = 'Please log ' +
	        'into Facebook.';
	    }
	  }

	  // This function is called when someone finishes with the Login
	  // Button.  See the onlogin handler attached to it in the sample
	  // code below.
	  function checkLoginState() {
	    FB.getLoginStatus(function(response) {
	      statusChangeCallback(response);
	    });
	  }

	  window.fbAsyncInit = function() {
	  FB.init({
	    appId      : '757634334380059',
	    cookie     : true,  // enable cookies to allow the server to access
	                        // the session
	    xfbml      : true,  // parse social plugins on this page
	    version    : 'v2.2' // use version 2.2
	  });

	  // Now that we've initialized the JavaScript SDK, we call
	  // FB.getLoginStatus().  This function gets the state of the
	  // person visiting this page and can return one of three states to
	  // the callback you provide.  They can be:
	  //
	  // 1. Logged into your app ('connected')
	  // 2. Logged into Facebook, but not your app ('not_authorized')
	  // 3. Not logged into Facebook and can't tell if they are logged into
	  //    your app or not.
	  //
	  // These three cases are handled in the callback function.

	  FB.getLoginStatus(function(response) {
	    statusChangeCallback(response);
	  });

	  };

	  // Load the SDK asynchronously
	  (function(d, s, id) {
	    var js, fjs = d.getElementsByTagName(s)[0];
	    if (d.getElementById(id)) return;
	    js = d.createElement(s); js.id = id;
	    js.src = "//connect.facebook.net/en_US/sdk.js";
	    fjs.parentNode.insertBefore(js, fjs);
	  }(document, 'script', 'facebook-jssdk'));

	  // Here we run a very simple test of the Graph API after login is
	  // successful.  See statusChangeCallback() for when this call is made.
	  function testAPI() {
	    console.log('Welcome!  Fetching your information.... ');
	    FB.api('/me', function(response) {
	      console.log('Successful login for: ' + response.name);
	      document.getElementById('status').innerHTML =
	        'Thanks for logging in, ' + response.name + '!';
	    });
	  }
</script>
{include file='globalfooter.tpl'}