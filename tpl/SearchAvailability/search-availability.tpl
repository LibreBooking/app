{include file='globalheader.tpl' Select2=true Owl=true Timepicker=true}

<div class="page-search-availability mt-3">

    <form role="form" name="searchForm" id="searchForm" method="post"
          action="{$smarty.server.SCRIPT_NAME}?action=search">

          <div class="container form-group row gx-3 gy-2">
            <div class="col-6 col-sm-3">
                  <input class="form-check-input" type="checkbox" id="anyResource" checked class="form-control" />
                  <label class="form-check-label" for="anyResource">{translate key=AnyResource}</label>
            </div>
            <div class="col-6 col-sm-3">
              <label for="resourceGroups" class="no-show">{translate key=Resources}</label>
              <select id="resourceGroups" class="form-control" multiple="multiple" {formname key=RESOURCE_ID multi=true}
                      disabled="disabled">
                  {foreach from=$Resources item=resource}
                      <option value="{$resource->GetId()}">{$resource->GetName()}</option>
                  {/foreach}
              </select>
            </div>
          </div>

        <div class="form-group col-6 col-sm-3">
            <div class="input-group mt-3">
                <input type="number" min="0" step="1" value="0" class="form-control inline-block"
                       id="hours" {formname key=HOURS}" />
                <span class="input-group-text me-3">{translate key=Hours}</span>
                <input type="number" min="0" step="5" value="30" class="form-control inline-block"
                       id="minutes" {formname key=MINUTES}"/>
                <span class="input-group-text">{translate key=Minutes}</span>
            </div>
        </div>

        <div class="form-group col-xs-12 col-sm-7 mb-3 mt-3">
            <input {formname key=BEGIN_TIME} type="text" id="startTime"
                                             class="form-control dateinput inline-block timepicker"
                                             value="{format_date format='h:00 A' date=now}"
                                             title="Start time" disabled="disabled"/>
            -
            <input {formname key=END_TIME} type="text" id="endTime"
                                           class="form-control dateinput inline-block timepicker"
                                           value="{format_date format='h:00 A' date=Date::Now()->AddHours(1)}"
                                           title="End time" disabled="disabled"/>
            <div class="checkbox inline">
                <input type="checkbox" id="specificTime" {formname key=SPECIFIC_TIME} />
                <label for="specificTime">{translate key=SpecificTime}</label>
            </div>
        </div>

        <div class="col-6 col-sm-5">
            <div class="btn-group btn-group-sm form-group" role="group" data-bs-toggle="buttons">
                <input type="radio" id="today" class="btn-check" checked
                       value="today" {formname key=AVAILABILITY_RANGE} />
                <label class="btn btn-outline-success" for="today">
                  <div class="d-none d-sm-block">{translate key=Today}</div>
                  <div class="d-block"> {format_date date=$Today key=calendar_dates}</div>
                </label>
                <input type="radio" id="tomorrow" class="btn-check"
                       value="tomorrow" {formname key=AVAILABILITY_RANGE} />
                <label class="btn btn-outline-success" for="tomorrow">
                  <div class="d-none d-sm-block">{translate key=Tomorrow}</div>
                  <div class="d-block"> {format_date date=$Tomorrow key=calendar_dates}</div>
                </label>
                <input type="radio" id="thisweek" class="btn-check" value="thisweek" {formname key=AVAILABILITY_RANGE} />
                <label class="btn btn-outline-success" for="thisweek">
                  <div class="d-none d-sm-block">{translate key=ThisWeek}</div>
                  <div class="d-block">{translate key=Week}</div>
                </label>
                <input type="radio" id="daterange" class="btn-check" value="daterange" {formname key=AVAILABILITY_RANGE} />
                <label class="btn btn-outline-success" for="daterange">
                  <i class="fa fa-calendar"></i><div class="d-none d-sm-block"> {translate key=DateRange}</div>
                </label>
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-7 mb-3 mt-1">
            <label for="beginDate" class="no-show">{translate key=BeginDate}</label>
            <input type="text" id="beginDate" class="form-control inline dateinput"
                   placeholder="{translate key=BeginDate}" disabled="disabled"/>
            <input type="hidden" id="formattedBeginDate" {formname key=BEGIN_DATE} />
            -
            <label for="endDate" class="no-show">{translate key=EndDate}</label>
            <input type="text" id="endDate" class="form-control inline dateinput"
                   placeholder="{translate key=EndDate}" disabled="disabled"/>
            <input type="hidden" id="formattedEndDate" {formname key=END_DATE} />
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-xs-12">
            {control type="RecurrenceControl"}
        </div>

        <div class="form-group col-xs-12">
            <a class="btn-link" data-bs-toggle="collapse" href="#advancedSearchOptions"
               aria-expanded="false" aria-controls="collapseExample">{translate key=MoreOptions}
            </a>
        </div>

        <div class="clearfix"></div>

        <div class="collapse" id="advancedSearchOptions">
            <div class="form-group col-xs-6">
                <label for="maxCapacity" class="hidden">{translate key=MinimumCapacity}</label>
                <input type='number' id='maxCapacity' min='0' size='5' maxlength='5'
                       class="form-control input-sm" {formname key=MAX_PARTICIPANTS}
                       value="{$MaxParticipantsFilter|default:''}" placeholder="{translate key=MinimumCapacity}"/>

            </div>
            <div class="form-group col-xs-6">
                <label for="resourceType" class="hidden">{translate key=ResourceType}</label>
                <select id="resourceType" {formname key=RESOURCE_TYPE_ID} {formname key=RESOURCE_TYPE_ID}
                        class="form-control input-sm">
                    <option value="">- {translate key=ResourceType} -</option>
                    {object_html_options options=$ResourceTypes label='Name' key='Id' selected=$ResourceTypeIdFilter}
                </select>
            </div>

            <div>
                {foreach from=$ResourceAttributes item=attribute}
                    {control type="AttributeControl" attribute=$attribute align='vertical' searchmode=true namePrefix='r' class="col-sm-6 col-xs-12" inputClass="input-sm"}
                {/foreach}
                {if $ResourceAttributes|default:array()|count%2 != 0}
                    <div class="col-sm-6 hidden-xs">&nbsp;</div>
                {/if}
            </div>

            <div>
                {foreach from=$ResourceTypeAttributes item=attribute}
                    {control type="AttributeControl" attribute=$attribute align='vertical' searchmode=true namePrefix='rt' class="col-sm-6 col-xs-12" inputClass="input-sm"}
                {/foreach}
                {if $ResourceTypeAttributes|default:array()|count%2 != 0}
                    <div class="col-sm-6 hidden-xs">&nbsp;</div>
                {/if}
            </div>
        </div>

        <div class="form-group col-xs-12">
            <button type="submit" class="btn btn-outline-success col-xs-12 mt-3 mb-2"
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
    {control type="DatePickerSetupControl" ControlId="RepeatDate" AltId="formattedRepeatDate"}

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
