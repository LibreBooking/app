{include file='globalheader.tpl' DisplayWelcome='false'}

<style type="text/css">
	@import url({$Path}css/reservation.css);
</style>

<a href="{$ReturnUrl}">&lt; {translate key="BackToCalendar"}</a><br/>
<form action="undefined.php" method="post">

<input type="submit" value="{translate key="Save"}" class="button"></input>
<input type="button" value="{translate key="Cancel"}" class="button" onclick="window.location='{$ReturnUrl}'"></input>

<table cellspacing="0" cellpadding="0">
	<tr>
		<td>
			<div id="resourceNames" style="display:inline">{$ResourceName}</div>
			<a href="#" onclick="$('#dialogAddResources').dialog('open'); return false;">(Add more)</a>
		<td>
		<td>
		<a href="#">(Add Accessories)</a> // modal popup
		</td>
	</tr>
	<tr>
		<td><div id="additionalResources"></div></td>
		<td></td>
</table>

<div>
	{$UserName}
	<a href="#">(Add Participants)</a> // modal popup
	<a href="#">(Invite Guests)</a> // modal popup
</div>
<div>
{translate key='BeginDate'}
<input type="text" id="BeginDate" class="textbox" style="width:75px" value="{formatdate date=$StartDate}"/>
<select class="textbox" id="BeginPeriod" onchange="MaintainPeriodLength();">
	{foreach from=$Periods item=period}
		{if $period->IsReservable()}
			<option>{$period->Label()}</option>
		{/if}
	{/foreach}
</select>
{translate key='EndDate'}
<input type="text" id="EndDate" class="textbox" style="width:75px" value="{formatdate date=$EndDate}" />
<select class="textbox" id="EndPeriod">
	{foreach from=$Periods item=period}
		{if $period->IsReservable()}
			<option>{$period->Label()}</option>
		{/if}
	{/foreach}
</select>
</div>

<div>
	{translate key='Summary'}<br/>
	<textarea id="summary" class="expand50-200" cols="60"></textarea>
</div>

<div id="repeatDiv">
	{translate key="RepeatPrompt"}
	<select id="repeatOptions" onchange="ChangeRepeatOptions(this)">
		<option value="none">{translate key="DoesNotRepeat"}</option>
		<option value="daily">{translate key="Daily"}</option>
		<option value="weekly">{translate key="Weekly"}</option>
		<option value="monthly">{translate key="Monthly"}</option>
		<option value="yearly">{translate key="Yearly"}</option>
	</select>
	<div id="repeatEveryDiv" style="display:none;" class="days weeks months years">
		{translate key="RepeatEveryPrompt"} <select>{html_options options=$RepeatEveryOptions}</select>
		<span class="days">{translate key="days"}</span>
		<span class="weeks">{translate key="weeks"}</span>
		<span class="months">{translate key="months"}</span>
		<span class="years">{translate key="years"}</span>
	</div>
	<div id="repeatOnWeeklyDiv" style="display:none;" class="weeks">
		{translate key="RepeatDaysPrompt"} <input type="checkbox" id="repeatSun" />{translate key="DaySundaySingle"}
		<input type="checkbox" id="repeatMon" />{translate key="DayMondaySingle"}
		<input type="checkbox" id="repeatTue" />{translate key="DayTuesdaySingle"}
		<input type="checkbox" id="repeatWed" />{translate key="DayWednesdaySingle"}
		<input type="checkbox" id="repeatThu" />{translate key="DayThursdaySingle"}
		<input type="checkbox" id="repeatFri" />{translate key="DayFridaySingle"}
		<input type="checkbox" id="repeatSat" />{translate key="DaySaturdaySingle"}
	</div>
	<div id="repeatOnMonthlyDiv" style="display:none;" class="months">
		<input type="radio" name="repeatMonthlyType" value="dayOfMonth" id="repeatMonthDay" checked="checked" /><label for="repeatMonthDay">{translate key="repeatDayOfMonth"}</label>
		<input type="radio" name="repeatMonthlyType" value="dayOfWeek" id="repeatMonthWeek" /><label for="repeatMonthWeek">{translate key="repeatDayOfWeek"}</label>
	</div>
	<div id="repeatUntilDiv" style="display:none;">
		{translate key="RepeatUntilPrompt"} 
		<input type="text" id="EndRepeat" class="textbox" style="width:75px" value="{formatdate date=$StartDate}" />
	</div>
</div>

<input type="submit" value="{translate key="Save"}" class="button"></input>
<input type="button" value="{translate key="Cancel"}" class="button" onclick="window.location='{$ReturnUrl}'"></input>

<div id="dialogAddResources" title="Add Resources">
	<p>Some text that you want to display to the user.</p>
	{foreach from=$AvailableResources item=resource}
		<input type="checkbox" name="additionalResources[]" id="additionalResource{$resource->Id()}" value="{$resource->Id()}" /><label for="additionalResource{$resource->Id()}">{$resource->Name()}</label><br/>
	{/foreach}
	<button id="btnConfirmAddResources" onclick="$('#dialogAddResources').dialog('close')">Add Selected</button>
	<button id="btnClearAddResources">Cancel</button>
</div>

</form>

{control type="DatePickerSetupControl" ControlId="BeginDate" DefaultDate=$StartDate}
{control type="DatePickerSetupControl" ControlId="EndDate" DefaultDate=$EndDate}
{control type="DatePickerSetupControl" ControlId="EndRepeat" DefaultDate=$EndDate}

{literal}
<script type="text/javascript" src="scripts/js/jquery.textarea-expander.js"></script>
<script type="text/javascript" src="scripts/reservation.js"></script>


<script type="text/javascript">

function MaintainPeriodLength()
{
	alert('change end period');
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