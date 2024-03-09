<div id="reservation-failed" class="reservationResponseMessage">
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
		<button id="btnSaveFailed" class="btn btn-warning"><i
				class="bi bi-arrow-left-circle-fill me-1"></i>{translate key='ReservationErrors'}</button>

		{if $CanJoinWaitList}
			<button id="btnWaitList" class="btn btn-info"><i
					class="bi bi-bell-fill me-1"></i>{translate key='NotifyWhenAvailable'}</button>
		{/if}

		{if $CanBeRetried}
			<div id="retryParams" class="no-show">
				{foreach from=$RetryParameters item=retryParam}
					<input type="hidden" id="{$retryParam->Name()}"
						name="{FormKeys::RESERVATION_RETRY_PREFIX}[{$retryParam->Name()}]"
						value="{$retryParam->Value()|escape}" />
				{/foreach}
			</div>
			<div id="retryMessages" class="no-show">
				{foreach from=$RetryMessages item=each}
					<div>{$each|nl2br}</div>
				{/foreach}
			</div>
			<button id="btnRetry" class="btn btn-success"><i
					class="bi bi-arrow-repeat me-1"></i>{translate key='RetrySkipConflicts'}
			</button>
		{/if}
	</div>
</div>


<script type="text/javascript">
	$(document).ready(function() {
		$('#reservation-failed').trigger('loaded');
	});
</script>