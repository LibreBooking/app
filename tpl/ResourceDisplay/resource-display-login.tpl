{include file='globalheader.tpl' HideNavBar=true}

<div id="page-resource-display-shell">

	<div class="col-md-6 col-12 mx-auto">

		<div id="login-box" class="col-12 default-box straight-top">
			<form role="form" name="loginForm" id="loginForm" class="form-horizontal" method="post"
				action="{$smarty.server.SCRIPT_NAME}?action=login">

				<div id="loginError" class="alert alert-danger col-12 no-show">
					{translate key=LoginError}
				</div>

				<div class="col-12">
					<div class="input-group margin-bottom-25">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input type="text" required="" class="form-control" id="email" {formname key=EMAIL}
							placeholder="{translate key=UsernameOrEmail}" />
					</div>
				</div>

				<div class="col-12">
					<div class="input-group margin-bottom-25">
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-lock"></i>
						</span>
						<input type="password" required="" id="password" {formname key=PASSWORD} class="form-control"
							value="" placeholder="{translate key=Password}" />
					</div>
				</div>

				<div class="col-12">
					<button type="submit" class="btn btn-large btn-primary btn-block" name="{Actions::LOGIN}"
						value="submit" id="loginButton">{translate key='LogIn'}</button>
				</div>

			</form>
		</div>

		<div id="resource-list-box" class="col-12 default-box straight-top no-show">
			<form role="form" id="activateResourceDisplayForm" method="post"
				action="{$smarty.server.SCRIPT_NAME}?action=activate">
				<h2><label for="resourceList">{translate key=ResourceDisplayPrompt}</label></h2>
				<select id="resourceList" {formname key=RESOURCE_ID} class="form-control">
					<option value="">-- {translate key=Resource} --</option>
				</select>
			</form>
		</div>
	</div>
</div>

<div class="modal" id="waitModal" tabindex="-1" role="dialog" aria-labelledby="waitModalLabel" data-bs-backdrop="static"
	aria-hidden="true">
	{include file="wait-box.tpl" translateKey='Working'}
</div>

{include file="javascript-includes.tpl"}
{jsfile src="resourceDisplay.js"}
{jsfile src="ajax-helpers.js"}

<script type="text/javascript">
	$(function() {
		var resourceDisplay = new ResourceDisplay();
		resourceDisplay.init();
	});
</script>

{include file='globalfooter.tpl'}