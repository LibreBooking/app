<div id="calendarSubscription" class="calendar-subscription">
    {if $IsSubscriptionAllowed && $IsSubscriptionEnabled}
        <a id="subscribeToCalendar" class="link-primary" href="{$SubscriptionUrl}">
            <i class="bi bi-calendar-heart me-1"></i>{translate key=SubscribeToCalendar}</a>
        <br />
        URL:
        <span class="note">{$SubscriptionUrl}</span>
    {/if}
</div>