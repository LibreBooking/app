{include file='globalheader.tpl' DisplayWelcome='false'}

<style type="text/css">
	@import url({$Path}css/reservation.css);
</style>

<a href="{$ReturnUrl}">&lt; {translate key="BackToCalendar"}</a><br/>
<form id="reservationForm" action="ajax/reservation_save.php" method="post">

<div>
	<input type="submit" value="{translate key='Save'}" class="button save"></input>
	<input type="button" value="{translate key='Cancel'}" class="button" onclick="window.location='{$ReturnUrl}'"></input>
</div>
<table cellspacing="0" cellpadding="0">
	<tr>
		<td>
			<div id="resourceNames" style="display:inline">{$ResourceName}</div>
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
<div>
this needs to be changed to handle cross-day reservations
{translate key='BeginDate'}
<input type="text" id="BeginDate" {formname key=BEGIN_DATE} class="textbox" style="width:75px" value="{formatdate date=$StartDate}"/>
<select class="textbox" id="BeginPeriod" {formname key=BEGIN_PERIOD}>
	{foreach from=$Periods item=period}
		{if $period->IsReservable()}
			<option>{$period->Label()}</option>
		{/if}
	{/foreach}
</select>
{translate key='EndDate'}
<input type="text" id="EndDate" {formname key=END_DATE} class="textbox" style="width:75px" value="{formatdate date=$EndDate}" />
<select class="textbox" id="EndPeriod" {formname key=END_PERIOD}>
	{foreach from=$Periods item=period}
		{if $previous ne '' and $previous->IsReservable()}
			<option>{$period->Label()}</option>
		{/if}
		{assign var=previous value=$period}
	{/foreach}
</select>
</div>

<div>
	{translate key='Summary'}<br/>
	<textarea id="summary" {formname key=summary} class="expand50-200" cols="60"></textarea>
</div>

<div id="repeatDiv">
	{translate key="RepeatPrompt"}
	<select id="repeatOptions" {formname key=repeat_options} onchange="ChangeRepeatOptions(this)">
		<option value="none">{translate key="DoesNotRepeat"}</option>
		<option value="daily">{translate key="Daily"}</option>
		<option value="weekly">{translate key="Weekly"}</option>
		<option value="monthly">{translate key="Monthly"}</option>
		<option value="yearly">{translate key="Yearly"}</option>
	</select>
	<div id="repeatEveryDiv" style="display:none;" class="days weeks months years">
		{translate key="RepeatEveryPrompt"} 
		<select {formname key=repeat_every}>{html_options options=$RepeatEveryOptions}</select>
		<span class="days">{translate key="days"}</span>
		<span class="weeks">{translate key="weeks"}</span>
		<span class="months">{translate key="months"}</span>
		<span class="years">{translate key="years"}</span>
	</div>
	<div id="repeatOnWeeklyDiv" style="display:none;" class="weeks">
		{translate key="RepeatDaysPrompt"} 
		<input type="checkbox" id="repeatSun" {formname key=repeat_sunday} />{translate key="DaySundaySingle"}
		<input type="checkbox" id="repeatMon" {formname key=repeat_monday} />{translate key="DayMondaySingle"}
		<input type="checkbox" id="repeatTue" {formname key=repeat_tuesday} />{translate key="DayTuesdaySingle"}
		<input type="checkbox" id="repeatWed" {formname key=repeat_wednesday} />{translate key="DayWednesdaySingle"}
		<input type="checkbox" id="repeatThu" {formname key=repeat_thursday} />{translate key="DayThursdaySingle"}
		<input type="checkbox" id="repeatFri" {formname key=repeat_friday} />{translate key="DayFridaySingle"}
		<input type="checkbox" id="repeatSat" {formname key=repeat_saturday} />{translate key="DaySaturdaySingle"}
	</div>
	<div id="repeatOnMonthlyDiv" style="display:none;" class="months">
		<input type="radio" {formname key=REPEAT_MONTHLY_TYPE} value="dayOfMonth" id="repeatMonthDay" checked="checked" /><label for="repeatMonthDay">{translate key="repeatDayOfMonth"}</label>
		<input type="radio" {formname key=REPEAT_MONTHLY_TYPE} value="dayOfWeek" id="repeatMonthWeek" /><label for="repeatMonthWeek">{translate key="repeatDayOfWeek"}</label>
	</div>
	<div id="repeatUntilDiv" style="display:none;">
		{translate key="RepeatUntilPrompt"} 
		<input type="text" id="EndRepeat" {formname key=end_repeat_date} class="textbox" style="width:75px" value="{formatdate date=$StartDate}" />
	</div>
</div>

<div>
	<input type="submit" value="{translate key="Save"}" class="button save"></input>
	<input type="button" value="{translate key="Cancel"}" class="button" onclick="window.location='{$ReturnUrl}'"></input>
</div>
</form>

<div id="dialogAddResources" title="Add Resources" style="display:none;">
	<p>Some text that you want to display to the user.</p>
	{foreach from=$AvailableResources item=resource}
		<input type="checkbox" id="additionalResource{$resource->Id()}" value="{$resource->Id()}" /><label for="additionalResource{$resource->Id()}">{$resource->Name()}</label><br/>
	{/foreach}
	<button id="btnConfirmAddResources" onclick="AddResources('{constant echo=FormKeys::ADDITIONAL_RESOURCES}')">Add Selected</button>
	<button id="btnClearAddResources">Cancel</button>
</div>

<div id="dialogSave" style="display:none;">
	<div id="creatingNotifiation" style="position:relative; top:170px; font-size:16pt;text-align:center;">Creating reservation...<br/><img src="{$RootPath}/img/reservation_submitting.gif" alt="Creating reservation"/></div>
	<div id="result" style="display:none;"></div>
</div>

{control type="DatePickerSetupControl" ControlId="BeginDate" DefaultDate=$StartDate}
{control type="DatePickerSetupControl" ControlId="EndDate" DefaultDate=$EndDate}
{control type="DatePickerSetupControl" ControlId="EndRepeat" DefaultDate=$EndDate}

{literal}
<script type="text/javascript" src="scripts/js/jquery.textarea-expander.js"></script>
<script type="text/javascript" src="scripts/reservation.js"></script>
<script type="text/javascript" src="scripts/js/jquery.form-2.43.js"></script>

<script type="text/javascript">

$(document).ready(function() {
	$('#BeginPeriod').change(function() {
		// handle date change if start time > end time
		// handle end period change if end hasn't been set
	});
	
	var options = { 
        target:        '#result',   // target element(s) to be updated with server response
        beforeSubmit:  preSubmit,  // pre-submit callback 
        success:       showResponse  // post-submit callback 
 
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

function ChangeRepeatOptions(comboBox)
{
	if ($(comboBox).val() != 'none')
	{
		$('#repeatUntilDiv').show();
	}
	else
	{
		$('#repeatDiv div[id!=repeatOptions]').hide();
	}
	
	if ($(comboBox).val() == 'daily')
	{
		$('#repeatDiv .weeks').hide();
		$('#repeatDiv .months').hide();
		$('#repeatDiv .years').hide();
		
		$('#repeatDiv .days').show();	
	}
	
	if ($(comboBox).val() == 'weekly')
	{
		$('#repeatDiv .days').hide();
		$('#repeatDiv .months').hide();
		$('#repeatDiv .years').hide();
		
		$('#repeatDiv .weeks').show();	
	}
	
	if ($(comboBox).val() == 'monthly')
	{
		$('#repeatDiv .days').hide();
		$('#repeatDiv .weeks').hide();
		$('#repeatDiv .years').hide();
		
		$('#repeatDiv .months').show();	
	}
	
	if ($(comboBox).val() == 'yearly')
	{
		$('#repeatDiv .days').hide();
		$('#repeatDiv .weeks').hide();
		$('#repeatDiv .months').hide();
		
		$('#repeatDiv .years').show();	
	}
	
}

</script>


{/literal}

{include file='globalfooter.tpl'}