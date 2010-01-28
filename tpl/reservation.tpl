{include file='header.tpl' DisplayWelcome='false'}
<a href="#">&lt; {translate key="BackToCalendar"}</a><br/>
<form action="undefined.php" method="post">

<input type="submit" value="{translate key="Save"}" class="button"></input>
<input type="button" value="{translate key="Cancel"}" class="button"></input>

<div>
	Resource 1
	<a href="#">(Add more)</a> // modal popup
	<a href="#">(Add Accessories)</a> // modal popup
</div>
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
	<input type="text" id="summary" /> // auto grow
</div>

<div>
	Repeat: 
	<select id="repeatOptions">
		<option>Does Not Repeat</option>
		<option>Daily</option>
		<option>Weekly</option>
		<option>Monthly</option>
		<option>Yearly</option>
	</select>
	<div id="repeatEveryDiv">
		// show/hide
		Every: {html_options options=$RepeatEveryOptions} <span id="repeatEveryText">days</span>
	</div>
	<div id="repeatOnDiv">
		// show/hide
		<input type="checkbox" id="repeatSun" />S
		<input type="checkbox" id="repeatMon" />M
		<input type="checkbox" id="repeatTue" />T
		<input type="checkbox" id="repeatWed" />W
		<input type="checkbox" id="repeatThu" />T
		<input type="checkbox" id="repeatFri" />F
		<input type="checkbox" id="repeatSat" />S
	</div>
	<div id="repeatUntilDiv">
		// show/hide
		Until: 
		<input type="radio" name="repeatEndType" value="none" id="repeatEndNone" />
		<label for="repeatEndNone">No End</label>
		<input type="radio" name="repeatEndType" value="until" id="repeatEndUntil" />
		<label for="repeatEndUntil">Until</label>
		<input type="text" id="EndRepeat" class="textbox" style="width:75px" />
	</div>
</div>

<input type="submit" value="{translate key="Save"}" class="button"></input>
<input type="button" value="{translate key="Cancel"}" class="button"></input>
</form>

{control type="DatePickerSetupControl" ControlId="BeginDate" DefaultDate=$StartDate}
{control type="DatePickerSetupControl" ControlId="EndDate" DefaultDate=$EndDate}
{control type="DatePickerSetupControl" ControlId="EndRepeat" DefaultDate=$StartDate}

{literal}
<script type="text/javascript" src="scripts/js/jquery.autogrow.js" />
<script type="text/javascript">

$('#summary').autogrow();

function MaintainPeriodLength()
{
	alert('change end period');
}

</script>
{/literal}
{include file='footer.tpl'}