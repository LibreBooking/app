<div class="dashboard dashboard availabilityDashboard" id="availabilityDashboard">
    <div class="dashboardHeader">
        <div class="pull-left">{translate key="ResourceAvailability"}</div>
        <div class="pull-right">
            <a href="#" title="{translate key=ShowHide} {translate key="ResourceAvailability"}">
                <i class="glyphicon"></i>
                <span class="no-show">Expand/Collapse</span>
            </a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="dashboardContents">
        <div class="header">{translate key=Available}</div>
        {foreach from=$Schedules item=s}
            {assign var=availability value=$Available[$s->GetId()]}
            {if is_array($availability) && $availability|default:array()|count > 0}
                <h5>{$s->GetName()}</h5>
                {foreach from=$availability item=i}
                    <div class="availabilityItem">
                        <div class="col-xs-12 col-sm-5">
                            <i resource-id="{$i->ResourceId()}" class="resourceNameSelector fa fa-info-circle"></i>
                            <div class="resourceName" style="background-color:{$i->GetColor()};color:{$i->GetTextColor()};">
                                <a href="{$Path}{Pages::RESERVATION}?{QueryStringKeys::RESOURCE_ID}={$i->ResourceId()}"
                                resource-id="{$i->ResourceId()}"
                                class="resourceNameSelector" style="color:{$i->GetTextColor()}">{$i->ResourceName()}</a>
                            </div>
                        </div>
                        <div class="availability col-xs-12 col-sm-4">
                            {if $i->NextTime() != null}
                                {translate key=AvailableUntil}
                                {format_date date=$i->NextTime() timezone=$Timezone key=dashboard}
                            {else}
                                <span class="no-data">{translate key=AllNoUpcomingReservations args=30}</span>
                            {/if}
                        </div>
                        <div class="reserveButton col-xs-12 col-sm-3">
                            <a class="btn btn-xs col-xs-12"
                            href="{$Path}{Pages::RESERVATION}?{QueryStringKeys::RESOURCE_ID}={$i->ResourceId()}">{translate key=Reserve}</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                {/foreach}
            {/if}
        {/foreach}

        {if empty($Available)}
            <div class="no-data" style="text-align: center;">{translate key=None}</div>
        {/if}

        <div class="header">{translate key=Unavailable}</div>

        {foreach from=$Schedules item=s}
            {assign var=availability value=$Unavailable[$s->GetId()]}
            {if is_array($availability) && $availability|default:array()|count > 0}
                <h5>{$s->GetName()}</h5>
                {foreach from=$availability item=i}
                    <div class="availabilityItem">
                        <div class="col-xs-12 col-sm-5">
                            <i resource-id="{$i->ResourceId()}" class="resourceNameSelector fa fa-info-circle"></i>
                            <div class="resourceName" style="background-color:{$i->GetColor()};color:{$i->GetTextColor()};">
                                <a href="{$Path}{Pages::RESERVATION}?{QueryStringKeys::RESOURCE_ID}={$i->ResourceId()}"
                                resource-id="{$i->ResourceId()}"
                                class="resourceNameSelector" style="color:{$i->GetTextColor()}">{$i->ResourceName()}</a>
                            </div>
                        </div>
                        <div class="availability col-xs-12 col-sm-4">
                            {translate key=AvailableBeginningAt} {format_date date=$i->ReservationEnds() timezone=$Timezone key=dashboard}
                        </div>
                        <div class="reserveButton col-xs-12 col-sm-3">
                            <a class="btn btn-xs col-xs-12"
                            href="{$Path}{Pages::RESERVATION}?{QueryStringKeys::RESOURCE_ID}={$i->ResourceId()}&{QueryStringKeys::START_DATE}={format_date date=$i->ReservationEnds() timezone=$Timezone key=url_full}">{translate key=Reserve}</a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                {/foreach}
            {/if}
        {/foreach}

        {if empty($Unavailable)}
            <div class="no-data" style="text-align: center;">{translate key=None}</div>
        {/if}

        <div class="header">{translate key=UnavailableAllDay}</div>
        {foreach from=$Schedules item=s}
            {assign var=availability value=$UnavailableAllDay[$s->GetId()]}
            {if is_array($availability) && $availability|default:array()|count > 0}
                <h5>{$s->GetName()}</h5>
                {foreach from=$availability item=i}
                    <div class="availabilityItem">
                        <div class="col-xs-12 col-sm-5">
                            <i resource-id="{$i->ResourceId()}" class="resourceNameSelector fa fa-info-circle"></i>
                            <div class="resourceName" style="background-color:{$i->GetColor()};color:{$i->GetTextColor()};">
                                <a href="{$Path}{Pages::RESERVATION}?{QueryStringKeys::RESOURCE_ID}={$i->ResourceId()}"
                                resource-id="{$i->ResourceId()}"
                                class="resourceNameSelector" style="color:{$i->GetTextColor()}">{$i->ResourceName()}</a>
                            </div>
                        </div>
                        <div class="availability col-xs-12 col-sm-4">
                            {translate key=AvailableAt} {format_date date=$i->ReservationEnds() timezone=$Timezone key=dashboard}
                        </div>
                        <div class="reserveButton col-xs-12 col-sm-3">
                            <a class="btn btn-xs col-xs-12"
                            href="{$Path}{Pages::RESERVATION}?{QueryStringKeys::RESOURCE_ID}={$i->ResourceId()}&{QueryStringKeys::START_DATE}={format_date date=$i->ReservationEnds() timezone=$Timezone key=url_full}">{translate key=Reserve}</a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                {/foreach}
            {/if}
        {/foreach}
        
        {if empty($UnavailableAllDay)}
            <div class="no-data" style="text-align:center;">{translate key=None}</div>
        {/if}
    </div>
</div>
