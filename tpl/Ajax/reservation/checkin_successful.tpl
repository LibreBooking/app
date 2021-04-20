<div>
	<div id="reservation-response-image">
		<span class="fa fa-check fa-5x success"></span>
	</div>

	{if $IsCheckingIn}
		<div id="checked-in-message" class="reservation-message">{translate key=CheckedInSuccess}</div>
	{else}
		<div id="checked-out-message" class="reservation-message">{translate key=CheckedOutSuccess}</div>
	{/if}

	<input type="button" id="btnSaveSuccessful" value="{translate key='Close'}" class="btn btn-success" />
</div>
