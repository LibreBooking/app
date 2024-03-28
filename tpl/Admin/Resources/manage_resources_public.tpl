{if $resource->GetIsCalendarSubscriptionAllowed() && $modeEdit}
    <span>Resource Display</span>
    <a href="{$ScriptUrl}/{Pages::DISPLAY_RESOURCE}?{QueryStringKeys::RESOURCE_ID}={$resource->GetPublicId()}"
        class="link-primary">{$ScriptUrl}/{Pages::DISPLAY_RESOURCE}?{QueryStringKeys::RESOURCE_ID}={$resource->GetPublicId()}</a>
{elseif $resource->GetIsCalendarSubscriptionAllowed() && !$modeEdit}
    <div><a class="update disableSubscription subscriptionButton link-primary"
            href="#">{translate key=TurnOffSubscription}</a>
    </div>
    <div>
        <i class="bi bi-rss-fill link-primary"></i>
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
        <a href="{$ScriptUrl}/{Pages::DISPLAY_RESOURCE}?{QueryStringKeys::RESOURCE_ID}={$resource->GetPublicId()}"
            class="link-primary">{$ScriptUrl}/{Pages::DISPLAY_RESOURCE}?{QueryStringKeys::RESOURCE_ID}={$resource->GetPublicId()}</a>
    </div>
{elseif !$resource->GetIsCalendarSubscriptionAllowed() && !$modeEdit}
    <div>
        <a class="update enableSubscription subscriptionButton link-primary" href="#">{translate key=TurnOnSubscription}</a>
    </div>
{else}
    {translate key='None'}
{/if}