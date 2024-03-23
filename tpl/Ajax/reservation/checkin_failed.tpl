<div>
	<div id="reservation-response-image">
		<i class="bi bi-exclamation-triangle-fill fs-1 text-danger"></i>
	</div>

	<div id="failed-message" class="reservation-message fw-bold fs-4">
		{if $IsCheckingIn}
			{translate key=CheckInFailed}
		{else}
			{translate key=CheckOutFailed}
		{/if}
	</div>

	<div class="error">
		{foreach from=$Errors item=each}
			<div>{$each|nl2br}</div>
		{/foreach}
	</div>

	<div>
		<button id="btnSaveFailed" class="btn btn-warning text-white"><i
				class="bi bi-arrow-left-circle-fill me-1"></i>{translate key='Close'}</button>
	</div>

</div>