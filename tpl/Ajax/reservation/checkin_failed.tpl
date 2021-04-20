<div>
	<div id="reservation-response-image">
		<span class="fa fa-warning fa-5x error"></span>
	</div>

	<div id="failed-message" class="reservation-message">
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
		<button id="btnSaveFailed" class="btn btn-warning"><span
					class="fa fa-arrow-circle-left"></span> {translate key='Close'}</button>
	</div>

</div>
