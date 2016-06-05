<div id="calendarSubscription" class="calendar-subscription">
    {if $IsSubscriptionAllowed && $IsSubscriptionEnabled}
        <a id="subscribeToCalendar"
           href="{$SubscriptionUrl}">{html_image src="calendar-share.png"} {translate key=SubscribeToCalendar}</a>
        <br/>
        URL:
        <span class="note">{$SubscriptionUrl}</span>
    {/if}
</div>
<div id="calendar"></div>
<div id="dayDialog" class="default-box-shadow">
    <a href="#" id="dayDialogCreate">{html_image src="tick.png"}{translate key=CreateReservation}</a>
    <a href="#" id="dayDialogView">{html_image src="search.png"}{translate key=ViewDay}</a>
    <a href="#" id="dayDialogCancel">{html_image src="slash.png"}{translate key=Cancel}</a>
</div>
