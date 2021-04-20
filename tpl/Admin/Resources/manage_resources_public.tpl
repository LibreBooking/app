{if $resource->GetIsCalendarSubscriptionAllowed()}
    <div><a class="update disableSubscription subscriptionButton"
            href="#">{translate key=TurnOffSubscription}</a>
    </div>
    <div>
        {html_image src="feed.png"}
        <a target="_blank" href="{$resource->GetSubscriptionUrl()->GetAtomUrl()}">Atom</a>
        |
        <a target="_blank" href="{$resource->GetSubscriptionUrl()->GetWebcalUrl()}">iCalendar</a>
    </div>
    <div>
        <span>{translate key=PublicId}</span>
        <span class="propertyValue">{$resource->GetPublicId()}</span>
    </div>
    <div>
        <span>Resource Display</span>
        <span class="propertyValue">{$ScriptUrl}/{Pages::DISPLAY_RESOURCE}?{QueryStringKeys::RESOURCE_ID}={$resource->GetPublicId()}</span>
    </div>
{else}
    <div>
        <a class="update enableSubscription subscriptionButton"
           href="#">{translate key=TurnOnSubscription}</a>
    </div>
{/if}
