{*
Copyright 2011-2019 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*}

{extends file="Schedule/schedule.tpl"}

{block name="legend"}{/block}

{block name="reservations"}

    {function name=displayGeneralReservedMobile}
        {assign var=badge value=''}
        {if $Slot->IsNew()}{assign var=badge value='<span class="reservation-new">'|cat:{translate key="New"}|cat:'</span>'}{/if}
        {if $Slot->IsUpdated()}{assign var=badge value='<span class="reservation-updated">'|cat:{translate key="Updated"}|cat:'</span>'}{/if}

        {if $Slot->IsPending()}
            {assign var=class value='pending'}
        {elseif $Slot->HasCustomColor()}
            {assign var=color value='style="background-color:'|cat:$Slot->Color()|cat:' !important;color:'|cat:$Slot->TextColor()|cat:' !important;"'}
        {/if}
        <div class="reserved {$class} {$OwnershipClass} clickres"
             resid="{$Slot->Id()}" {$color}
             id="{$Slot->Id()}|{$Slot->Date()->Format('Ymd')}"><i class="fa fa-info-circle"></i>
            {formatdate date=$Slot->BeginDate() key=period_time} - {formatdate date=$Slot->EndDate() key=period_time}
            {$badge}{$Slot->Label($SlotLabelFactory)|escapequotes}</div>
    {/function}

    {function name=displayAdminReservedMobile}
        {call name=displayGeneralReservedMobile Slot=$Slot Href=$Href OwnershipClass='admin'}
    {/function}

    {function name=displayMyReservedMobile}
        {call name=displayGeneralReservedMobile Slot=$Slot Href=$Href SlotRef=$SlotRef OwnershipClass='mine'}
    {/function}

    {function name=displayMyParticipatingMobile}
        {call name=displayGeneralReservedMobile Slot=$Slot Href=$Href SlotRef=$SlotRef OwnershipClass='participating'}
    {/function}

    {function name=displayReservedMobile}
        {call name=displayGeneralReservedMobile Slot=$Slot Href=$Href SlotRef=$SlotRef OwnershipClass=''}
    {/function}

    {function name=displayPastTimeMobile}
    {/function}

    {function name=displayReservableMobile}
    {/function}

    {function name=displayRestrictedMobile}
    {/function}

    {function name=displayUnreservableMobile}
        <div class="unreservable"
             resid="{$Slot->Id()}" {$color}
             id="{$Slot->Id()}|{$Slot->Date()->Format('Ymd')}"><i class="fa fa-info-circle"></i>
            {formatdate date=$Slot->BeginDate() key=period_time} - {formatdate date=$Slot->EndDate() key=period_time}
            {$Slot->Label($SlotLabelFactory)|escapequotes}</div>
    {/function}

    {function name=displaySlotMobile}
        {call name=$DisplaySlotFactory->GetFunction($Slot, $AccessAllowed, 'Mobile') Slot=$Slot Href=$Href SlotRef=$SlotRef}
    {/function}

    {assign var=TodaysDate value=Date::Now()}
    <table class="reservations mobile" border="1" cellpadding="0" style="width:100%;">

        {foreach from=$BoundDates item=date}
            {assign var=ts value=$date->Timestamp()}
            {$periods.$ts = $DailyLayout->GetPeriods($date)}
            {if $periods[$ts]|count == 0}{continue}{*dont show if there are no slots*}{/if}
            <tr>
                {assign var=class value=""}
                {if $TodaysDate->DateEquals($date) eq true}
                    {assign var=class value="today"}
                {/if}
                <td class="resdate {$class}" colspan="2">{formatdate date=$date key="schedule_daily"}</td>
            </tr>
            {foreach from=$Resources item=resource name=resource_loop}
                <tr>
                    {assign var=resourceId value=$resource->Id}
                    {assign var=href value="{Pages::RESERVATION}?rid={$resourceId}&sid={$ScheduleId}&rd={formatdate date=$date key=url}"}
                    <td class="resourcename"
                        {if $resource->HasColor()}style="background-color:{$resource->GetColor()} !important"{/if}>
                        {if $resource->CanAccess}
                            <i resourceId="{$resourceId}" class="resourceNameSelector fa fa-info-circle"
                               {if $resource->HasColor()}style="color:{$resource->GetTextColor()} !important"{/if}></i>
                            <a href="{$href}" resourceId="{$resourceId}"
                               {if $resource->HasColor()}style="color:{$resource->GetTextColor()} !important"{/if}>{$resource->Name}</a>
                        {else}
                            <i resourceId="{$resourceId}" class="resourceNameSelector fa fa-info-circle"
                               {if $resource->HasColor()}style="color:{$resource->GetTextColor()} !important"{/if}></i>
                            <span {if $resource->HasColor()}style="color:{$resource->GetTextColor()} !important"{/if}>{$resource->Name}</span>
                        {/if}
                    </td>

                    {assign var=slots value=$DailyLayout->GetLayout($date, $resourceId)}
                    {assign var=summary value=$DailyLayout->GetSummary($date, $resourceId)}


                    {if $summary->NumberOfItems() > 0}
                        <td class="slot">
                            <div class="reservable clickres" ref="{$href}&rd={formatdate date=$date key=url}"
                                 data-href="{$href}" data-start="{$date->Format('Y-m-d H:i:s')|escape:url}"
                                 data-end="{$date->Format('Y-m-d H:i:s')|escape:url}">
                                <i class="fa fa-plus-circle"></i> {translate key=CreateReservation}
                                <input type="hidden" class="href" value="{$href}"/>
                            </div>
                            {foreach from=$slots item=slot}
                                {call name=displaySlotMobile Slot=$slot Href="$href" AccessAllowed=$resource->CanAccess SlotRef=$slotRef}
                            {/foreach}
                        </td>
                    {else}
                        {assign var=href value="{Pages::RESERVATION}?rid={$resource->Id}&sid={$ScheduleId}&rd={formatdate date=$date key=url}"}
                        <td class="reservable clickres slot" data-href="{$href}"
                            data-start="{$date->Format('Y-m-d H:i:s')|escape:url}"
                            data-resourceId="{$resourceId}">
                            <div class="reservable clickres" ref="{$href}&rd={formatdate date=$date key=url}"
                                 data-href="{$href}" data-start="{$date->Format('Y-m-d H:i:s')|escape:url}"
                                 data-end="{$date->Format('Y-m-d H:i:s')|escape:url}">
                                <i class="fa fa-plus-circle"></i> {translate key=CreateReservation}
                                <input type="hidden" class="href" value="{$href}"/>
                            </div>
                            <input type="hidden" class="href" value="{$href}"/>
                        </td>
                    {/if}
                </tr>
            {/foreach}
        {/foreach}
    </table>
{/block}