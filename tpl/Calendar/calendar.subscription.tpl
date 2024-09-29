<div id="calendarSubscription" class="calendar-subscription text-end">
    {if $IsSubscriptionAllowed && $IsSubscriptionEnabled}
        <a id="subscribeToCalendar" class="link-primary" href="{$SubscriptionUrl}">
            <i class="bi bi-calendar-heart me-1"></i>{translate key=SubscribeToCalendar}</a>
        <br />
        URL:
        <span class="note fst-italic text-secondary">{$SubscriptionUrl}</span>
    {/if}
</div>