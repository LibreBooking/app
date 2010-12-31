{include file='globalheader.tpl' DisplayWelcome='false'}

<style type="text/css">
	@import url({$Path}css/reservation.css);
</style>
<a href="{$ReturnUrl}">&lt; {translate key="BackToCalendar"}</a><br/>
<div id="reservationbox">

<form id="reservationForm" action="ajax/reservation_save.php" method="post">
	<div class="reservationHeader">
		<h3>{translate key=$ReservationHeaderKey args=$ReferenceNumber}</h3>
	</div>
	<div>
		<ul class="no-style">
			<li>
				{$UserName} <input type="hidden" {formname key=USER_ID} value="{$UserId}" />
			</li>
		</ul>
		<ul class="no-style">
        	<li class="inline">
		    	<label>{translate key="ResourceList"}</label><br />
		    		<div id="resourceNames" style="display:inline">{$ResourceName} 
			    		<input type="hidden" {formname key=RESOURCE_ID} value="{$ResourceId}" />
			    		<input type="hidden" {formname key=SCHEDULE_ID} value="{$ScheduleId}" />
		    		</div>
					<a href="#" onclick="$('#dialogAddResources').dialog('open'); return false;">(Add/Change)</a>
					<div id="additionalResources"></div>
        	</li>
        	<li>
				<!--this needs to be changed to handle cross-day reservations-->
				<label>{translate key='BeginDate'} 
				<input type="text" id="BeginDate" {formname key=BEGIN_DATE} class="dateinput" value="{formatdate date=$StartDate}"/>
				</label>
				<select id="BeginPeriod" {formname key=BEGIN_PERIOD}>
					{foreach from=$Periods item=period}
						{if $period->IsReservable()}
							<option value="{$period->Begin()}">{$period->Label()}</option>
						{/if}
					{/foreach}
				</select>
			</li>
			<li>
				<label>{translate key='EndDate'}
				<input type="text" id="EndDate" {formname key=END_DATE} class="dateinput" value="{formatdate date=$EndDate}" />
				</label>
				<select id="EndPeriod" {formname key=END_PERIOD}>
					{foreach from=$Periods item=period}
						{if $previous ne '' and $previous->IsReservable()}
							<option value="{$period->Begin()}">{$period->Label()}</option>
						{/if}
						{assign var=previous value=$period}
					{/foreach}
				</select>
			</li>
			<li>
				<div id="repeatDiv">
					<label>{translate key="RepeatPrompt"}</label>
					<select id="repeatOptions" {formname key=repeat_options}>
						<option value="none">{translate key="DoesNotRepeat"}</option>
						<option value="daily">{translate key="Daily"}</option>
						<option value="weekly">{translate key="Weekly"}</option>
						<option value="monthly">{translate key="Monthly"}</option>
						<option value="yearly">{translate key="Yearly"}</option>
					</select>
					<div id="repeatEveryDiv" style="display:none;" class="days weeks months years">
						<label>{translate key="RepeatEveryPrompt"}</label>
						<select {formname key=repeat_every}>{html_options values=$RepeatEveryOptions output=$RepeatEveryOptions}</select>
						<span class="days">{translate key="days"}</span>
						<span class="weeks">{translate key="weeks"}</span>
						<span class="months">{translate key="months"}</span>
						<span class="years">{translate key="years"}</span>
					</div>
					<div id="repeatOnWeeklyDiv" style="display:none;" class="weeks">
						<label>{translate key="RepeatDaysPrompt"}</label>
						<input type="checkbox" id="repeatDay0" {formname key=repeat_sunday} />{translate key="DaySundaySingle"}
						<input type="checkbox" id="repeatDay1" {formname key=repeat_monday} />{translate key="DayMondaySingle"}
						<input type="checkbox" id="repeatDay2" {formname key=repeat_tuesday} />{translate key="DayTuesdaySingle"}
						<input type="checkbox" id="repeatDay3" {formname key=repeat_wednesday} />{translate key="DayWednesdaySingle"}
						<input type="checkbox" id="repeatDay4" {formname key=repeat_thursday} />{translate key="DayThursdaySingle"}
						<input type="checkbox" id="repeatDay5" {formname key=repeat_friday} />{translate key="DayFridaySingle"}
						<input type="checkbox" id="repeatDay6" {formname key=repeat_saturday} />{translate key="DaySaturdaySingle"}
					</div>
					<div id="repeatOnMonthlyDiv" style="display:none;" class="months">
						<input type="radio" {formname key=REPEAT_MONTHLY_TYPE} value="{constant echo='RepeatMonthlyType::DayOfMonth'}" id="repeatMonthDay" checked="checked" />
						<label for="repeatMonthDay">{translate key="repeatDayOfMonth"}</label>
						<input type="radio" {formname key=REPEAT_MONTHLY_TYPE} value="{constant echo='RepeatMonthlyType::DayOfWeek'}" id="repeatMonthWeek" />
						<label for="repeatMonthWeek">{translate key="repeatDayOfWeek"}</label>
					</div>
					<div id="repeatUntilDiv" style="display:none;">
						{translate key="RepeatUntilPrompt"} 
						<input type="text" id="EndRepeat" {formname key=end_repeat_date} class="dateinput" value="{formatdate date=$RepeatTerminationDate}" />
					</div>
				</div>
			</li>
			<li class="rsv-req">
                <label>{translate key="ReservationTitle"}<br />
                {textbox name="RESERVATION_TITLE" class="input" tabindex="100" value="ReservationTitle"}
                </label>
        	</li>
        	<li class="rsv-box-l">
                <label>{translate key="ReservationDescription"}<br />
	                <textarea name="{constant echo='FormKeys::DESCRIPTION'}" class="input-area" rows="2" cols="52" tabindex="110">{$Description}</textarea>
                </label>
        	</li>
			<li class="rsv-pulldown">
                <label>{translate key="ParticipantList"}<br />
                        <select name="{constant echo='FormKeys::PARTICIPANT_LIST'}" class="pulldown" tabindex="120">
                                {html_options values=$ParticipantListValues output=$ParticipantListOutput}
                        </select>
				<input type="button" value="{translate key="Add"}" class="button" tabindex="130"></input>
				</label>
                
        	</li>
			<!-- The selected participants should be printed here, above the Invitation list pulldown -->
			<li class="rsv-pulldown">
                <label>{translate key="InvitationList"}<br />
                        <select name="{constant echo='FormKeys::INVITATION_LIST'}" class="pulldown" tabindex="150">
                                {html_options values=$InvitationListValues output=$InvitationListOutput}
                        </select>
				<input type="button" value="{translate key="Add"}" class="button" tabindex="160"></input>
				</label>
               
        	</li>
			<!-- The invited users should be printed here above the X -->
			
        </ul>
	</div>
<!--
<table cellspacing="0" cellpadding="0">
	<tr>
		<td>
			<a href="#" onclick="$('#dialogAddResources').dialog('open'); return false;">(Add more)</a>
		</td>
		<td>
		<a href="#">(Add Accessories)</a> // modal popup
		</td>
	</tr>
	<tr>
		<td><div id="additionalResources"></div></td>
		<td></td>
	</tr>
</table>

<div>
	{$UserName}
	<a href="#">(Add Participants)</a> // modal popup
	<a href="#">(Invite Guests)</a> // modal popup
</div>
-->
<input type="hidden" {formname key=reservation_id} value="{$ReservationId}" />
<input type="hidden" {formname key=reference_number} value="{$ReferenceNumber}" />
<input type="hidden" {formname key=reservation_action} value="{$ReservationAction}" />
<div>
	<input type="button" value="{translate key="Cancel"}" class="button" onclick="window.location='{$ReturnUrl}'"></input>
	<input type="submit" {formname key=SERIES_UPDATE_SCOPE} value="{translate key="Save"}" class="button save"></input>
</div>
</form>

<div id="dialogAddResources" title="Add Resources" style="display:none;">
	<p>Some text that you want to display to the user.</p>
	{foreach from=$AvailableResources item=resource}
		{assign var='checked' value=''}
		{if is_array($AdditionalResourceIds) && in_array($resource->Id(), $AdditionalResourceIds)}
			{assign var='checked' value='checked="checked"'}	
		{/if}
		
		<input type="checkbox" {formname key=ADDITIONAL_RESOURCES multi=true} id="additionalResource{$resource->Id()}" value="{$resource->Id()}" {$checked} /><label for="additionalResource{$resource->Id()}">{$resource->Name()}</label><br/>
		
	{/foreach}
	<button id="btnConfirmAddResources">Add Selected</button>
	<button id="btnClearAddResources">Cancel</button>
</div>

<div id="dialogSave" style="display:none;">
	<div id="creatingNotifiation" style="position:relative; top:170px; font-size:16pt;text-align:center;">
		Creating reservation...<br/>
		<img src="{$Path}img/reservation_submitting.gif" alt="Creating reservation"/>
	</div>
	<div id="result" style="display:none;"></div>
</div>
<!-- reservationbox ends -->
</div>

{control type="DatePickerSetupControl" ControlId="BeginDate" DefaultDate=$StartDate}
{control type="DatePickerSetupControl" ControlId="EndDate" DefaultDate=$EndDate}
{control type="DatePickerSetupControl" ControlId="EndRepeat" DefaultDate=$EndDate}


<script type="text/javascript" src="scripts/js/jquery.textarea-expander.js"></script>
<script type="text/javascript" src="scripts/reservation.js"></script>
<script type="text/javascript" src="scripts/js/jquery.form-2.43.js"></script>

<script type="text/javascript">
var _additionalResourceId = '{constant echo=FormKeys::ADDITIONAL_RESOURCES}';
var _repeatType = '{$RepeatType}';
var _repeatInterval = '{$RepeatInterval}';
var _repeatMonthlyType = '{$RepeatMonthlyType}';
var _repeatWeekdays = "[{foreach from=$RepeatWeekdays item=day}$day,{/foreach}]";
var _returnUrl = "{$ReturnUrl}";

{literal}
$(document).ready(function() {
	$('#BeginPeriod').change(function() {
		// handle date change if start time > end time
		// handle end period change if end hasn't been set
	});

	var reservationOpts = {
		additionalResourceElementId: _additionalResourceId,
		repeatType: _repeatType,
		repeatInterval: _repeatInterval,
		repeatMonthlyType: _repeatMonthlyType,
		repeatWeekdays: _repeatWeekdays,
		returnUrl: _returnUrl,
	};

	var reservation = new Reservation(reservationOpts);
	reservation.init();
	
	var options = { 
        target:        '#result',   // target element(s) to be updated with server response
        beforeSubmit:  reservation.preSubmit,  // pre-submit callback 
        success:       reservation.showResponse  // post-submit callback 
 
        // other available options: 
        //url:       url         // override for form's 'action' attribute 
        //type:      type        // 'get' or 'post', override for form's 'method' attribute 
        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
        //clearForm: true        // clear all form fields after successful submit 
        //resetForm: true        // reset the form after successful submit 
 
        // $.ajax options can be used here too, for example: 
        //timeout:   3000 
    }; 
    
    $('#reservationForm').submit(function() { 
        $(this).ajaxSubmit(options); 
 		return false; 
    });

   
});

// pre-submit callback 
function preSubmit(formData, jqForm, options) { 
    $('#result').hide();
    $('#creatingNotifiation').show();
    
    return true; 
} 

// post-submit callback 
function showResponse(responseText, statusText, xhr, $form)  { 
    $('#creatingNotifiation').hide();
    $('#result').show();
}

{/literal}

</script>

{include file='globalfooter.tpl'}