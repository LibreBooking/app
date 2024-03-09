<div>
	<div id="reservation-response-image">
		<i class="bi bi-check-lg fs-1 text-success"></i>
	</div>

	{if $IsCheckingIn}
		<div id="checked-in-message" class="reservation-message fw-bold fs-4">{translate key=CheckedInSuccess}</div>
	{else}
		<div id="checked-out-message" class="reservation-message fw-bold fs-4">{translate key=CheckedOutSuccess}</div>
	{/if}

	<input type="button" id="btnSaveSuccessful" value="{translate key='Close'}" class="btn btn-success" />
</div>