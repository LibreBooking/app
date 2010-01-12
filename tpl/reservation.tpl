{include file='header.tpl' DisplayWelcome='false'}
<a href="#">&lt; {translate key="BackToCalendar"}</a><br/>
<form action="undefined.php" method="post">

<input type="submit" value="{translate key="Save"}" class="button"></input>
<input type="button" value="{translate key="Cancel"}" class="button"></input>

<div>
	Resource 1
	<a href="#">(Add more)</a>
</div>
<div>
	Nick Korbel
</div>
<div>
{translate key='BeginDate'}
<input type="text" id="BeginDate" class="textbox" style="width:75px" />
<select class="textbox" id="BeginPeriod" onchange="MaintainPeriodLength();"><option>Period 1</option></select>
{translate key='EndDate'}
<input type="text" id="EndDate" class="textbox" style="width:75px" />
<select class="textbox" id="EndPeriod"><option>Period 2</option></select>
</div>

<div>
	{translate key='Summary'}<br/>
	<input type="text" id="summary" />
</div>
<input type="submit" value="{translate key="Save"}" class="button"></input>
<input type="button" value="{translate key="Cancel"}" class="button"></input>
</form>

{control type="DatePickerSetupControl" ControlId="BeginDate"}
{control type="DatePickerSetupControl" ControlId="EndDate"}

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