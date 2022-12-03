{include file='globalheader.tpl'}

<div class="page-change-password">

		<div id="password-reset-box" class="offset-md-3 col-md-3 col-xs-12 center mt-4 shadow-sm border rounded px-4">
			<h1 class="mt-2">{translate key="ChangePassword"}</h1>
			{validation_group class="alert alert-danger alert-dismissible fade show text-start"}
			{validator id="currentpassword" key="InvalidPassword"}
			{validator id="passwordmatch" key="PwMustMatch"}
			{validator id="passwordcomplexity" key=""}
			{/validation_group}

			{if !$AllowPasswordChange}
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<i class="bi bi-exclamation-triangle-fill"></i> {translate key=PasswordControlledExternallyError}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			{else}
				{if isset($ResetPasswordSuccess) && $ResetPasswordSuccess}
					<div class="success alert alert-success alert-dismissible fade show" role="alert">
						<span class="glyphicon glyphicon-ok-sign"></span> {translate key=PasswordChangedSuccessfully}
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				{/if}

			<form id="password-reset-form" method="post" action="{$smarty.server.SCRIPT_NAME}">

				<div class="form-group mb-2">
					<label for="{FormKeys::CURRENT_PASSWORD}">{translate key="CurrentPassword"}</label>
						{textbox type="password" name="CURRENT_PASSWORD"}
				</div>

				<div class="form-group mb-2">
					<label for="{FormKeys::PASSWORD}">{translate key="NewPassword"}</label>
						{textbox type="password" name="PASSWORD"}
				</div>

				<div class="form-group mb-2">
					<label for="{FormKeys::PASSWORD_CONFIRM}">{translate key="PasswordConfirmation"}</label>
						{textbox type="password" name="PASSWORD_CONFIRM" value=""}

				</div>

				<div class="form-group mt-3 mb-4">
					<button type="submit" name="{Actions::CHANGE_PASSWORD}" value="{translate key='ChangePassword'}"
							class="btn btn-primary">{translate key='ChangePassword'}</button>
				</div>
				{csrf_token}
			</form>
		</div>
		{setfocus key='CURRENT_PASSWORD'}
	{/if}

</div>
{include file="javascript-includes.tpl"}
{include file='globalfooter.tpl'}
