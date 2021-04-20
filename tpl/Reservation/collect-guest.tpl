{include file='globalheader.tpl'}
<div class="page-guest-collect">

	{validation_group class="alert alert-danger"}
		{validator id="emailformat" key="ValidEmailRequired"}
		{validator id="uniqueemail" key="UniqueEmailRequired"}
	{/validation_group}

	<div class="default-box col-xs-12 col-sm-8 col-sm-offset-2">
		<h2>{translate key=WeNeedYourEmailAddress}</h2>

		<form method="post" id="form-guest-collect" action="{$smarty.server.REQUEST_URI|escape:'html'}" role="form">

			<div class="row">
				<div class="col-xs-12">
					<div class="form-group">
						<label class="reg" for="email">{translate key="Email"}</label>
						{textbox type="email" name="EMAIL" class="input" value="Email" required="required"}
					</div>
				</div>
			</div>

			<div>
				<button type="submit" class="update btn btn-primary col-xs-12" name="" id="btnUpdate">
					{translate key='Continue'}
				</button>
			</div>
		</form>
	</div>
	{setfocus key='EMAIL'}

    {include file="javascript-includes.tpl"}
	{jsfile src="ajax-helpers.js"}

	<div id="wait-box" class="wait-box">
		<h3>{translate key=Working}</h3>
		{html_image src="reservation_submitting.gif"}
	</div>

</div>
{include file='globalfooter.tpl'}
