{include file='header.tpl' DisplayWelcome='false'}
<a href="#">&lt; {translate key="BackToCalendar"}</a><br/>
<form action="undefined.php" method="post">

<input type="submit" value="{translate key="Save"}" class="button"></input>
<input type="button" value="{translate key="Cancel"}" class="button"></input>

<div>
	Resource 1
	<a href="#">+</a>
</div>
<div>
	Nick Korbel
</div>
<div>
{translate key='BeginDate'}<input type="text id="BeginDate" />
</div>

<input type="submit" value="{translate key="Save"}" class="button"></input>
<input type="button" value="{translate key="Cancel"}" class="button"></input>
</form>
{control type="DatePickerSetupControl" ControlId="BeginDate"}
{include file='footer.tpl'}