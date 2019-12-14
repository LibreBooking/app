{*
Copyright 2017-2019 Nick Korbel

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

{include file='globalheader.tpl' Qtip=true}

<div class="page-search-reservations row" id="page-search-reservations">

    <form role="form" name="searchForm" id="searchForm" method="post"
          action="{$smarty.server.SCRIPT_NAME}?action=search">

        <div class="card">
            <div class="card-content">
                <div class="col s12 m4">
                    <label for="userFilter">{translate key=User}</label>
                    <input id="userFilter" type="search" class="" value="{$UserNameFilter}" />
                    <input id="userId" type="hidden" {formname key=USER_ID} value="{$UserIdFilter}"/>
                </div>

                <div class="col s12 m4">
                    <label for="resources">{translate key=Resources}</label>
                    <select id="resources"
                            multiple="multiple" {formname key=RESOURCE_ID multi=true}>
                        {foreach from=$Resources item=resource}
                            <option value="{$resource->GetId()}">{$resource->GetName()}</option>
                        {/foreach}
                    </select>
                </div>

                <div class="col s12 m4">
                    <label for="schedules">{translate key=Schedules}</label>
                    <select id="schedules"
                            multiple="multiple" {formname key=SCHEDULE_ID multi=true}>
                        {foreach from=$Schedules item=schedule}
                            <option value="{$schedule->GetId()}">{$schedule->GetName()}</option>
                        {/foreach}
                    </select>
                </div>

                <div class="clearfix"></div>

                <div class="col s12 m4">
                    <label for="title">{translate key=Title}</label>
                    <input type="search" id="title" class="" {formname key=RESERVATION_TITLE} />
                </div>

                <div class="col s12 m4">
                    <label for="description">{translate key=Description}</label>
                    <input type="search" id="description" class="" {formname key=DESCRIPTION} />
                </div>

                <div class="col s12 m4">
                    <label for="referenceNumber">{translate key=ReferenceNumber}</label>
                    <input type="search" id="referenceNumber" class="" {formname key=REFERENCE_NUMBER} />
                </div>

                <div class="clearfix"></div>

                <div class="col s12 m5">
                    <label class="">
                        <input type="radio" id="today" checked="checked"
                               value="today" {formname key=AVAILABILITY_RANGE} />
                        <span> <span
                                    class="hide-on-small-only">{translate key=Today}</span> {format_date date=$Today key=calendar_dates}</span>
                    </label>
                    <label class="">
                        <input type="radio" id="tomorrow" value="tomorrow" {formname key=AVAILABILITY_RANGE} />

                        <span><span class="hide-on-small-only">{translate key=Tomorrow}</span> {format_date date=$Tomorrow key=calendar_dates}</span>
                    </label>
                    <label class="">
                        <input type="radio" id="thisweek" value="thisweek" {formname key=AVAILABILITY_RANGE} />
                        <span><span class="hide-on-small-only">{translate key=ThisWeek}</span><span
                                    class="hide-on-med-and-up">{translate key=Week}</span></span>
                    </label>
                    <label class="">
                        <input type="radio" id="daterange" value="daterange" {formname key=AVAILABILITY_RANGE} />
                        <span><span class="hide-on-small-only"><i
                                        class="fa fa-calendar"></i></span> {translate key=DateRange}</span>
                    </label>
                </div>
                <div class="col s12 m7">
                    <div class="input-field inline">
                        <label for="beginDate">{translate key=BeginDate}</label>
                        <input type="text" id="beginDate" class="form-control inline dateinput"
                               disabled="disabled"/>
                        <input type="hidden" id="formattedBeginDate" {formname key=BEGIN_DATE} />
                    </div>
                    -
                    <div class="input-field inline">
                        <label for="endDate">{translate key=EndDate}</label>
                        <input type="text" id="endDate" class="form-control inline dateinput"
                                disabled="disabled"/>
                        <input type="hidden" id="formattedEndDate" {formname key=END_DATE} />
                    </div>
                </div>

                <div class="col s4"></div>

                <div class="clearfix"></div>
            </div>
        </div>
        <div class="card-action align-right">
            <button type="submit" class="btn btn-primary"
                    value="submit" {formname key=SUBMIT}>{translate key=SearchReservations}</button>
            {indicator}
        </div>
    </form>

    <div class="clearfix"></div>
    <div id="reservation-results"></div>

    {csrf_token}

    {include file="javascript-includes.tpl" Qtip=2 Clear=true}
    {jsfile src="js/jquery.cookie.js"}
    {jsfile src="ajax-helpers.js"}
    {jsfile src="resourcePopup.js"}
    {jsfile src="autocomplete.js"}
    {jsfile src="reservationPopup.js"}
    {jsfile src="reservation-search.js"}

    {control type="DatePickerSetupControl" ControlId="beginDate" AltId="formattedBeginDate" DefaultDate=$BeginDate}
    {control type="DatePickerSetupControl" ControlId="endDate" AltId="formattedEndDate" DefaultDate=$EndDate}

    <script type="text/javascript">

        $(document).ready(function () {
            var opts = {
                autocompleteUrl: "{$Path}ajax/autocomplete.php?type={AutoCompleteType::User}",
                reservationUrlTemplate: "{$Path}reservation.php?{QueryStringKeys::REFERENCE_NUMBER}=[refnum]",
                popupUrl: "{$Path}ajax/respopup.php"
            };

            var search = new ReservationSearch(opts);
            search.init();

        });
    </script>
</div>

{include file='globalfooter.tpl'}
