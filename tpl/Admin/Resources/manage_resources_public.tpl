{if $resource->GetIsCalendarSubscriptionAllowed()}
    <div><a class="update disableSubscription subscriptionButton link-primary"
            href="#">{translate key=TurnOffSubscription}</a>
    </div>
    <div>
        <i class="bi bi-rss-fill link-primary"></i>
        {*{html_image src="feed.png"}*}
        <a target="_blank" href="{$resource->GetSubscriptionUrl()->GetAtomUrl()}" class="link-primary">Atom</a>
        <div class="vr mx-1"></div>
        <a target="_blank" href="{$resource->GetSubscriptionUrl()->GetWebcalUrl()}" class="link-primary">iCalendar</a>
    </div>
    <div>
        <span>{translate key=PublicId}</span>
        <span class="propertyValue fw-bold">{$resource->GetPublicId()}</span>
    </div>
    <div>
        <span>Resource Display</span>
        <span
            class="propertyValue fw-bold">{$ScriptUrl}/{Pages::DISPLAY_RESOURCE}?{QueryStringKeys::RESOURCE_ID}={$resource->GetPublicId()}</span>
    </div>
{else}
    <div>
        <a class="update enableSubscription subscriptionButton link-primary" href="#">{translate key=TurnOnSubscription}</a>
    </div>
{/if}