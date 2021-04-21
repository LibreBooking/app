<div id="reservation-failed" class="reservationResponseMessage">
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
		<button id="btnSaveFailed" class="btn btn-warning"><span
					class="fa fa-arrow-circle-left"></span> {translate key='ReservationErrors'}</button>

        {if $CanJoinWaitList}
            <button id="btnWaitList" class="btn btn-info"><span
					class="fa fa-bell-o"></span> {translate key='NotifyWhenAvailable'}</button>
        {/if}

		{if $CanBeRetried}
			<div id="retryParams" class="no-show">
				{foreach from=$RetryParameters item=retryParam}
					<input type="hidden" id="{$retryParam->Name()}"
						   name="{FormKeys::RESERVATION_RETRY_PREFIX}[{$retryParam->Name()}]"
						   value="{$retryParam->Value()|escape}"/>
				{/foreach}
			</div>
			<div id="retryMessages" class="no-show">
				{foreach from=$RetryMessages item=each}
					<div>{$each|nl2br}</div>
				{/foreach}
			</div>
			<button id="btnRetry" class="btn btn-success"><span class="fa fa-refresh"></span> {translate key='RetrySkipConflicts'}
			</button>
		{/if}
	</div>
</div>


<script type="text/javascript">
	$(document).ready(function () {
		$('#reservation-failed').trigger('loaded');
	});
</script>
