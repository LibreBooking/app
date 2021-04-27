{extends file="Export/embedded-calendar-container.tpl"}
{block name="calendar"}
<div class="booked-calendar-agenda">
    {if $Reservations->Reservations()|default:array()|count == 0}
        {translate key=NoReservationsFound}
    {/if}
    {assign var=LastDate value=Date::Min()}
    {foreach from=$Reservations->Reservations() item=r}
        {assign var=color value=$r->GetColor()}
        {if !$r->StartDate()->DateEquals($LastDate)}
            <div class="booked-agenda-date">
                <a href="{$ScheduleUrl}{format_date date=$r->StartDate() timezone=$Timezone key=url}"
                   title="{translate key=ViewCalendar}">{format_date date=$r->StartDate() timezone=$Timezone}</a>
            </div>
        {/if}
        <a class="booked-calendar-event"
           href="{$ReservationUrl}{$r->ReferenceNumber()}"
           title="{translate key=ViewReservation}"
            {if !empty($color)}style="background-color:{$r->GetColor()} !important;color:{$r->GetTextColor()} !important;border-color:{$r->GetBorderColor()} !important"}{/if}>
            {$TitleFormatter->Format($r, $r->StartDate())}
            {*{format_date date=$r->StartDate() key=period_time timezone=$Timezone}*}
            {*- {format_date date=$r->EndDate() key=period_time timezone=$Timezone}*}
            {*{$r->Title}*}
        </a>
        {assign var=LastDate value=$r->StartDate()}
    {/foreach}
</div>
{/block}
