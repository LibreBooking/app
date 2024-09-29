<div id="calendarSubscription" class="calendar-subscription text-end">
    {if $IsSubscriptionAllowed && $IsSubscriptionEnabled}
        <a href="#" id="turnOffSubscription" class="link-primary d-none"><i class="bi bi-toggle-off"></i>
            <!--{html_image src="switch-minus.png"}-->
            {translate key=TurnOffSubscription}
        </a>
        {if $IsSubscriptionEnabled}
            <a id="subscribeToCalendar" href="{$SubscriptionUrl}" class="link-primary"><i class="bi bi-calendar-heart"></i>
                <!--{html_image src="calendar-share.png"}-->
                {translate key=SubscribeToCalendar}
            </a>
            <br />
            URL:
            <span class="note fst-italic text-secondary">{$SubscriptionUrl}</span>
        {/if}
    {elseif $IsSubscriptionEnabled}
        <a href="#" id="turnOnSubscription" class="link-primary"><i class="bi bi-toggle-on"></i>
            <!--{html_image src="switch-plus.png"}-->
            {translate key=TurnOnSubscription}
        </a>
    {/if}
</div>