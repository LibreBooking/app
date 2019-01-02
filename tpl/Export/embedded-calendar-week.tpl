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
{extends file="Export/embedded-calendar-container.tpl"}
{block name="calendar"}
    {assign var=weekStart value=$Range->GetBegin()}
    <div class="booked-weekday-names">
        {for $day=0 to 6}
            <div class="booked-weekday-name"style="width:{$Width}">
                {format_date date=$weekStart->AddDays($day) format=D}
            </div>
        {/for}
    </div>
    <div class="booked-calendar-week">
        {foreach from=$Range->Dates() item=date}
            <div class="booked-week-date" style="width:{$Width}">
                <div class="booked-week-date-title {if $date->DateEquals(Date::Now())}booked-today{/if}">
                    <a href="{$ScheduleUrl}{format_date date=$date timezone=$Timezone key=url}"
                       title="{translate key=ViewCalendar}">{format_date date=$date timezone=$Timezone format=d}</a>
                </div>
                {foreach from=$Reservations->OnDate($date)->Reservations() item=r}
                    <div class="booked-day-events">
                        <a class="booked-calendar-event"
                            href="{$ReservationUrl}{$r->ReferenceNumber()}"
                            title="{translate key=ViewReservation}"
                            {if !empty($color)}style="background-color:{$r->GetColor()} !important;color:{$r->GetTextColor()} !important;border-color:{$r->GetBorderColor()} !important"
                            }{/if}>
                            {$TitleFormatter->Format($r, $date)}
                        </a>
                    </div>
                {/foreach}
            </div>
        {/foreach}
    </div>
{/block}