
<div id="calendarSubscription" class="calendar-subscription">
    {if $IsSubscriptionAllowed && $IsSubscriptionEnabled}
        <a href="#" id="turnOffSubscription">{html_image src="switch-minus.png"} {translate key=TurnOffSubscription}</a>
        {if $IsSubscriptionEnabled}
            <a id="subscribeToCalendar"
               href="{$SubscriptionUrl}">{html_image src="calendar-share.png"} {translate key=SubscribeToCalendar}</a>
            <br/>
            URL:
            <span class="note">{$SubscriptionUrl}</span>
        {/if}
    {elseif $IsSubscriptionEnabled}
        <a href="#" id="turnOnSubscription">{html_image src="switch-plus.png"} {translate key=TurnOnSubscription}</a>
    {/if}
</div>