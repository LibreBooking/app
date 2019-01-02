{*
Copyright 2011-2019 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*}
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