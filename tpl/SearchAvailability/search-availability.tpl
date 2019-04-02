{include file='globalheader.tpl' Select2=true Owl=true Timepicker=true}

<div id="page-search-availability" class="row page-search-availability">

    <form role="form" name="searchForm" id="searchForm" method="post"
          action="{$smarty.server.SCRIPT_NAME}?action=search">
        <div class="col s12 m2">
            <label for="anyResource">
                <input type="checkbox" id="anyResource" checked="checked"/>
                <span>{translate key=AnyResource}</span>
            </label>
        </div>
        <div class="col s12 m10">
            <label for="resourceGroups" class="no-show">{translate key=Resources}</label>
            <select id="resourceGroups" class="browser-default"
                    multiple="multiple" {formname key=RESOURCE_ID multi=true}
                    disabled="disabled">
                {foreach from=$Resources item=resource}
                    <option value="{$resource->GetId()}">{$resource->GetName()}</option>
                {/foreach}
            </select>
        </div>

        <div class="clearfix"></div>

        <div class="col s6 m2 input-field">
            <label for="hours">{translate key=Hours}</label>
            <input type="number" min="0" step="1" value="0" class="hours-minutes"
                   id="hours" {formname key=HOURS}" autofocus="autofocus" />
        </div>
        <div class="col s6 m2 input-field">
            <label for="minutes">{translate key=Minutes}</label>
            <input type="number" min="0" step="30" value="30" class="form-control hours-minutes"
                   id="minutes" {formname key=MINUTES}"/>
        </div>
        <div class="col m1 hide-on-small-only">&nbsp;</div>
        <div class="col s12 m7">
            <div class="input-field inline">
                <label for="startTime">{translate key=BeginDate}</label>
                <input {formname key=BEGIN_TIME} type="text" id="startTime"
                                                 class="dateinput inline-block timepicker"
                                                 value="{format_date format='h:00 A' date=now}"
                                                 title="Start time" disabled="disabled"/>
            </div>
            -
            <div class="input-field inline">
                <label for="endTime">{translate key=EndDate}</label>
                <input {formname key=END_TIME} type="text" id="endTime"
                                               class="dateinput inline-block timepicker"
                                               value="{format_date format='h:00 A' date=Date::Now()->AddHours(1)}"
                                               title="End time" disabled="disabled"/>
            </div>
            <div class="inline">
                <label for="specificTime">
                    <input type="checkbox" id="specificTime" {formname key=SPECIFIC_TIME} />
                    <span>{translate key=SpecificTime}</span>
                </label>
            </div>
        </div>

        <div class="col s12 m5">
            <div>
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
        </div>
        <div class="col s12 m7">
            <div class="input-field inline">
                <label for="beginDate" class="no-show">{translate key=BeginDate}</label>
                <input type="text" id="beginDate" class="form-control inline dateinput"
                       placeholder="{translate key=BeginDate}" disabled="disabled"/>
                <input type="hidden" id="formattedBeginDate" {formname key=BEGIN_DATE} />
            </div>
            -
            <div class="input-field inline">
                <label for="endDate" class="no-show">{translate key=EndDate}</label>
                <input type="text" id="endDate" class="form-control inline dateinput"
                       placeholder="{translate key=EndDate}" disabled="disabled"/>
                <input type="hidden" id="formattedEndDate" {formname key=END_DATE} />
            </div>
        </div>

        <div class="col s12">
            <a href="#" id="showHideMoreOptions">{translate key=MoreOptions}</a>
        </div>

        <div style="display:none;" id="advancedSearchOptions">
            <div class="col s12">
                {control type="RecurrenceControl"}
            </div>

            <div class="col s6">
                <label for="maxCapacity" class="hidden">{translate key=MinimumCapacity}</label>
                <input type='number' id='maxCapacity' min='0' size='5' maxlength='5'
                       class="input-sm" {formname key=MAX_PARTICIPANTS}
                       value="{$MaxParticipantsFilter}" placeholder="{translate key=MinimumCapacity}"/>

            </div>
            <div class="col s6">
                <label for="resourceType" class="hidden">{translate key=ResourceType}</label>
                <select id="resourceType" {formname key=RESOURCE_TYPE_ID} {formname key=RESOURCE_TYPE_ID}
                        class="input-sm">
                    <option value="">- {translate key=ResourceType} -</option>
                    {object_html_options options=$ResourceTypes label='Name' key='Id' selected=$ResourceTypeIdFilter}
                </select>
            </div>

            <div class="customAttributes">
                {foreach from=$ResourceAttributes item=attribute}
                    <div class="customAttribute col s12 m4">
                        {control type="AttributeControl" attribute=$attribute align='vertical' searchmode=true namePrefix='r' class="col-sm-6 col-xs-12" inputClass="input-sm"}
                    </div>
                {/foreach}
            </div>

            <div class="customAttributes">
                {foreach from=$ResourceTypeAttributes item=attribute}
                    <div class="customAttribute col s12 m4">
                        {control type="AttributeControl" attribute=$attribute align='vertical' searchmode=true namePrefix='rt' class="col-sm-6 col-xs-12" inputClass="input-sm"}
                    </div>
                {/foreach}
            </div>
        </div>

        <div class="col s12">
            <button type="submit" class="btn btn-primary right"
                    value="submit" {formname key=SUBMIT}>{translate key=FindATime}</button>
            {indicator}
        </div>
    </form>

    <div class="clearfix"></div>

    <div id="availability-results"></div>


    {csrf_token}

    {include file="javascript-includes.tpl" Select2=true Owl=true Timepicker=true}
    {jsfile src="js/tree.jquery.js"}
    {jsfile src="js/jquery.cookie.js"}
    {jsfile src="ajax-helpers.js"}
    {jsfile src="availability-search.js"}
    {jsfile src="resourcePopup.js"}
    {jsfile src="date-helper.js"}
    {jsfile src="recurrence.js"}

    {control type="DatePickerSetupControl" ControlId="beginDate" AltId="formattedBeginDate" DefaultDate=$StartDate}
    {control type="DatePickerSetupControl" ControlId="endDate" AltId="formattedEndDate" DefaultDate=$StartDate}
    {control type="DatePickerSetupControl" ControlId="EndRepeat" AltId="formattedEndRepeat" DefaultDate=$StartDate}

    <script type="text/javascript">

        $(document).ready(function () {

            var recurOpts = {
                repeatType: '',
                repeatInterval: '',
                repeatMonthlyType: '',
                repeatWeekdays: []
            };

            var recurrence = new Recurrence(recurOpts);
            recurrence.init();

            var opts = {
                reservationUrlTemplate: "{$Path}{Pages::RESERVATION}?{QueryStringKeys::RESOURCE_ID}=[rid]&{QueryStringKeys::START_DATE}=[sd]&{QueryStringKeys::END_DATE}=[ed]"
            };
            var search = new AvailabilitySearch(opts);
            search.init();

            $('#resourceGroups').select2({
                placeholder: '{translate key=Resources}'
            });

            $('.timepicker').timepicker({
                timeFormat: '{$TimeFormat}'
            });
        });


    </script>

</div>

{include file='globalfooter.tpl'}
