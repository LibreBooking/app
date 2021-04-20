<div>
	<div id="reservation-response-image">
		<span class="fa fa-warning fa-5x error"></span>
	</div>

	<div id="failed-message" class="reservation-message">{translate key=ReservationFailed}</div>

	<div class="error">
		{foreach from=$Errors item=each}
			<div>{$each|nl2br}</div>
		{/foreach}
	</div>

	<div>
		<button id="btnSaveFailed" class="btn btn-warning"><span class="fa fa-arrow-circle-left"></span> {translate key='ReservationErrors'}</button>
	</div>

</div>
