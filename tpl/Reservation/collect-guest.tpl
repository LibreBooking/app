{include file='globalheader.tpl'}
<div class="page-guest-collect">

	{validation_group class="alert alert-danger"}
	{validator id="emailformat" key="ValidEmailRequired"}
	{validator id="uniqueemail" key="UniqueEmailRequired"}
	{/validation_group}

	<div class="card shadow col-12 col-sm-8 mx-auto">
		<div class="card-body">
			<h2 class="text-center">{translate key=WeNeedYourEmailAddress}</h2>

			<form method="post" id="form-guest-collect" action="{$smarty.server.REQUEST_URI|escape:'html'}" role="form">

				<div class="mb-3">
					<div class="form-group">
						<label class="reg fw-bold" for="email">{translate key="Email"}</label>
						{textbox type="email" name="EMAIL" class="input" value="Email" required="required"}
					</div>
				</div>

				<div class="d-grid">
					<button type="submit" class="update btn btn-primary" name="" id="btnUpdate">
						{translate key='Continue'}
					</button>
				</div>
			</form>
		</div>
	</div>
	{setfocus key='EMAIL'}

	{include file="javascript-includes.tpl"}
	{jsfile src="ajax-helpers.js"}

	<div id="wait-box" class="wait-box">
		{include file="wait-box.tpl" translateKey='Working'}
	</div>

</div>
{include file='globalfooter.tpl'}