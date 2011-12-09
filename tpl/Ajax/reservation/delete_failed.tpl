{translate key=ReservationFailed}
<ul>
{foreach from=$Errors item=each}
	<li>{$each}</li>
{/foreach}
</ul>

<input type="button" id="btnSaveFailed" value="{translate key='CorrectErrors'}" class="button" />