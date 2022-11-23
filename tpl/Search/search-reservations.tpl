{include file='globalheader.tpl' Select2=true Qtip=true}

<div class="page-search-reservations mt-2">

    <form role="form" name="searchForm" id="searchForm" method="post"
          action="{$smarty.server.SCRIPT_NAME}?action=search">

      <div class="row g-3 mb-2">
        <div class="col-sm-4">
          <div class="input-group">
            <label for="userFilter" class="no-show">{translate key=User}</label>
            <input id="userFilter" type="search" class="form-control" value="{$UserNameFilter}"
                   placeholder="{translate key=User}"/>
            <span class="searchclear bi bi-x-circle" ref="userFilter,userId"></span>
            <input id="userId" type="hidden" {formname key=USER_ID} value="{$UserIdFilter}"/>
          </div>
        </div>

        <div class="col-sm-4">
            <label for="resources" class="no-show">{translate key=Resources}</label>
            <select id="resources" class="form-select" multiple="multiple" {formname key=RESOURCE_ID multi=true}>
                {foreach from=$Resources item=resource}
                    <option value="{$resource->GetId()}">{$resource->GetName()}</option>
                {/foreach}
            </select>
        </div>

        <div class="col-sm-4">
            <label for="schedules" class="no-show">{translate key=Schedules}</label>
            <select id="schedules" class="form-select" multiple {formname key=SCHEDULE_ID multi=true}>
                {foreach from=$Schedules item=schedule}
                    <option value="{$schedule->GetId()}">{$schedule->GetName()}</option>
                {/foreach}
            </select>
        </div>
      </div>

      <div class="row g-3 mb-2">
        <div class="form-group col-sm-4">
          <div class="input-group">
            <label for="title" class="no-show">{translate key=Title}</label>
            <input type="search" id="title" class="form-control" {formname key=RESERVATION_TITLE}
                   placeholder="{translate key=Title}"/>
            <span class="searchclear bi bi-x-circle" ref="title"></span>
          </div>
        </div>

        <div class="form-group col-sm-4">
          <div class="input-group">
            <label for="description" class="no-show">{translate key=Description}</label>
            <input type="search" id="description" class="form-control" {formname key=DESCRIPTION}
                   placeholder="{translate key=Description}"/>
            <span class="searchclear bi bi-x-circle" ref="description"></span>
          </div>
        </div>

        <div class="form-group col-sm-4">
          <div class="input-group">
            <label for="referenceNumber" class="no-show">{translate key=ReferenceNumber}</label>
            <input type="search" id="referenceNumber" class="form-control" {formname key=REFERENCE_NUMBER}
                   placeholder="{translate key=ReferenceNumber}"/>
            <span class="searchclear bi bi-x-circle" ref="referenceNumber"></span>
          </div>
        </div>
      </div>
      <div class="row g-3 mb-2">
        <div class="col-sm-2">
            <div class="btn-group btn-group-sm" role="group" data-bs-toggle="buttons">
                <input type="radio" id="today" class="btn-check" value="today" {formname key=AVAILABILITY_RANGE} />
                <label class="btn btn-outline-success" for="today">
                    <span class="d-none d-sm-block">{translate key=Today}</span>
                    <span class="d-block"> {format_date date=$Today key=calendar_dates}</span>
                </label>
                <input type="radio" class="btn-check" id="tomorrow" value="tomorrow" {formname key=AVAILABILITY_RANGE} />
                <label class="btn btn-outline-success" for="tomorrow">
                    <span class="d-none d-sm-block">{translate key=Tomorrow}</span>
                    <span class="d-block"> {format_date date=$Tomorrow key=calendar_dates}</span>
                </label>
                <input type="radio" class="btn-check" id="thisweek" value="thisweek" {formname key=AVAILABILITY_RANGE} />
                <label class="btn btn-outline-success" for="thisweek">
                    <span class="d-none d-sm-block">{translate key=ThisWeek}</span>
                    <span class="d-block">{translate key=Week}</span>
                </label>
                <input type="radio" class="btn-check" id="daterange" value="daterange"
                           checked {formname key=AVAILABILITY_RANGE} />
                <label class="btn btn-outline-success" for="daterange">
                    <i class="fa fa-calendar"></i><span class="d-none d-sm-block"> {translate key=DateRange}</span>
                </label>
            </div>
        </div>
        <div class="form-group col-sm-2">
            <label for="beginDate" class="no-show">{translate key=BeginDate}</label>
            <input type="text" id="beginDate" class="form-control inline dateinput"
                   placeholder="{translate key=BeginDate}"/>
            <input type="hidden" id="formattedBeginDate" {formname key=BEGIN_DATE}
                   value="{formatdate date=$BeginDate key=system}"/>
            -
            <label for="endDate" class="no-show">{translate key=EndDate}</label>
            <input type="text" id="endDate" class="form-control inline dateinput"
                   placeholder="{translate key=EndDate}"/>
            <input type="hidden" id="formattedEndDate" {formname key=END_DATE}
                   value="{formatdate date=$EndDate key=system}"/>
        </div>
    </div>
        <div class="col-xs-4"></div>


        <div class="form-group mt-5 mb-3">
            <button type="submit" class="btn btn-success"
                    value="submit" {formname key=SUBMIT}>{translate key=SearchReservations}</button>
            {indicator}
        </div>
    </form>

    <div class="clearfix"></div>
    <div id="reservation-results"></div>

    {csrf_token}

    {include file="javascript-includes.tpl" Select2=true Qtip=2 Clear=true}
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


            $('#resources').select2({
                placeholder: '{translate key=Resources}'
            });

            $('#schedules').select2({
                placeholder: '{translate key=Schedules}'
            });
        });
    </script>

</div>

{include file='globalfooter.tpl'}
