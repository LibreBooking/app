
{* All of the slot display formatting *}

{function name=displayGeneralReserved}
    <td {$spantype|default:'col'}span="{$Slot->PeriodSpan()}" class="reserved">&nbsp;</td>
{/function}

{function name=displayMyReserved}
    {call name=displayGeneralReserved Slot=$Slot ResourceId=$ResourceId}
{/function}

{function name=displayAdminReserved}
    {call name=displayGeneralReserved Slot=$Slot ResourceId=$ResourceId}
{/function}

{function name=displayMyParticipating}
    {call name=displayGeneralReserved Slot=$Slot ResourceId=$ResourceId}
{/function}

{function name=displayReserved}
    {call name=displayGeneralReserved Slot=$Slot ResourceId=$ResourceId}
{/function}

{function name=displayPastTime}
    <td {$spantype|default:'col'}span="{$Slot->PeriodSpan()}"
        class="pasttime slot">&nbsp;
    </td>
{/function}

{function name=displayReservable}
    <td {$spantype|default:'col'}span="{$Slot->PeriodSpan()}" ref="{$SlotRef}" class="reservable slot">&nbsp;
    </td>
{/function}

{function name=displayRestricted}
    <td {$spantype|default:'col'}span="{$Slot->PeriodSpan()}">&nbsp;</td>
{/function}

{function name=displayUnreservable}
    <td {$spantype|default:'col'}span="{$Slot->PeriodSpan()}"
        class="unreservable slot">&nbsp;
    </td>
{/function}

{function name=displaySlot}
    {call name=$DisplaySlotFactory->GetFunction($Slot, true) Slot=$Slot ResourceId=$ResourceId}
{/function}

{*<div id="availability-highlighter"></div>*}

<a href="#" id="btnHideAvailability" class="pull-right"><i class="fa fa-arrow-circle-left"></i> {translate key="ReservationDetails"}</a>
{* End slot display formatting *}
{assign var=TodaysDate value=Date::Now()}
{foreach from=$BoundDates item=date}
    {assign var=ts value=$date->Timestamp()}
    {$periods.$ts = $DailyLayout->GetPeriods($date)}
    <div>
        <table id="reservations-{formatdate date=$date format='Y-m-d'}" data-date="{formatdate date=$date format='Y-m-d'}" class="reservations" border="1" cellpadding="0" width="100%">
            <thead>
            <tr>
                <td class="resdate">{formatdate date=$date key="schedule_daily"}</td>
                {foreach from=$periods.$ts item=period}
                    <td class="reslabel" colspan="{$period->Span()}" data-start="{$period->Begin()->Hour()*60+$period->Begin()->Minute()}" data-end="{$period->End()->Hour()*60+$period->End()->Minute()}">{$period->Label($date)}</td>
                {/foreach}
            </tr>
            </thead>
            <tbody>
            {foreach from=$Resources item=resource name=resource_loop}
                {assign var=slots value=$DailyLayout->GetLayout($date, $resource->GetId())}
                <tr class="slots">
                    <td class="resourcename">
                        <span>{$resource->GetName()}</span>
                    </td>
                    {foreach from=$slots item=slot}
                        {displaySlot Slot=$slot ResourceId=$resource->GetId()}
                    {/foreach}
                </tr>
            {/foreach}

            {assign var=slots value=$DailyLayout->GetLayout($date, $User->UserId*-1)}
            <tr class="slots">
                <td class="resourcename">
                    <span>{$User->FullName}</span>
                </td>
                {foreach from=$slots item=slot}
                    {displaySlot Slot=$slot ResourceId=$User->UserId*-1}
                {/foreach}
            </tr>

            {foreach from=$Participants item=participant name=participant_loop}
                {assign var=slots value=$DailyLayout->GetLayout($date, $participant->UserId*-1)}
                <tr class="slots">
                    <td class="resourcename">
                        <span>{$participant->FullName}</span>
                    </td>
                    {foreach from=$slots item=slot}
                        {displaySlot Slot=$slot ResourceId=$participant->UserId*-1}
                    {/foreach}
                </tr>
            {/foreach}

            {foreach from=$Invitees item=invitee name=participant_loop}
                {assign var=slots value=$DailyLayout->GetLayout($date, $invitee->UserId*-1)}
                <tr class="slots">
                    <td class="resourcename">
                        <span>{$invitee->FullName}</span>
                    </td>
                    {foreach from=$slots item=slot}
                        {displaySlot Slot=$slot ResourceId=$invitee->UserId*-1}
                    {/foreach}
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
{/foreach}