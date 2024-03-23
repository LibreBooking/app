<div>
	<div id="reservation-response-image">
		<i class="bi bi-exclamation-triangle-fill fs-1 text-danger"></i>
	</div>

	<div id="failed-message" class="reservation-message fw-bold fs-4">{translate key=ReservationFailed}</div>

	<div class="error">
		{foreach from=$Errors item=each}
			<div>{$each|nl2br}</div>
		{/foreach}
	</div>

	<div>
		<button id="btnSaveFailed" class="btn btn-warning text-white"><i
				class="bi bi-arrow-left-circle-fill me-1"></i>{translate key='ReservationErrors'}</button>
	</div>

</div>