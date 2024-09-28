{include file='globalheader.tpl'}
<div id="forgotbox" class="mx-auto col-md-6 col-12 mt-4">
	{if $Enabled}

		<div class="card shadow">
			<div class="card-body text-center">
				<form class="forgot" method="post" action="{$smarty.server.SCRIPT_NAME}">
					<div class="forgot_pwdHeader mt-2">
						<h1 class="border-bottom mb-2">{translate key='ForgotPassword'}</h1>
					</div>
					<div>
						<p class="forgot">{translate key='YouWillBeEmailedANewPassword'}</p>
						<!-- Alert goes here for a nice width same as form -->
						{if $ShowResetEmailSent}
							<div class="alert alert-success alert-dismissible fade show" role="alert">
								{translate key=ForgotPasswordEmailSent}<br />
								<a class="link-success" href="{$Path}{Pages::LOGIN}">{translate key="LogIn"}</a>
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
						{/if}
						<p>
							<label class="forgot fw-bold">{translate key='EmailAddress'}<br />
								{textbox name="EMAIL" class="input" type="email" required="required" size="20" tabindex="10"}</label>
						</p>
						<p class="resetpassword">
							<button type="submit" class="btn btn-primary" name="{Actions::RESET}"
								value="{Actions::RESET}">{translate key='ChangePassword'}</button>
						</p>
					</div>
				</form>
			</div>
		</div>

		{setfocus key='EMAIL'}
	{else}
		<h2 class="alert alert-danger alert-dismissible fade show text-center error">Disabled</h2>
	{/if}
</div>
{include file="javascript-includes.tpl"}
{include file='globalfooter.tpl'}