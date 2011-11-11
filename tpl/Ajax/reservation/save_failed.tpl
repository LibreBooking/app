<h2 style="text-align: center;">{translate key=ReservationFailed}</h2>

<div class="error">
	<ul>
	{foreach from=$Errors item=each}
		<li>{$each|nl2br}</li>
	{/foreach}
	</ul>
</div>

<div style="margin: auto;text-align: center;">
	<button id="btnSaveFailed" class="button">{html_image src="arrow_large_left.png"} {translate key='CorrectErrors'}</button>
</div>