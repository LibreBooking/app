<div id="calendarSubscription" class="calendar-subscription">
    {if $IsSubscriptionAllowed && $IsSubscriptionEnabled}
        <a id="subscribeToCalendar"
           href="{$SubscriptionUrl}">{html_image src="calendar-share.png"} {translate key=SubscribeToCalendar}</a>
        <br/>
        URL:
        <span class="note">{$SubscriptionUrl}</span>
    {/if}
</div>

