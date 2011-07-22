{include file='globalheader.tpl'}
<form>
<ul>
	<li>For resource: <select id="resourceId" class="textbox"><option>Resource 1</option></select></li>
	<li class=""><select class="textbox"><option>Specific Date</option><option>Date Range</option></select></li>
	<li><input type="text" id="reservationDate" class="textbox" /></li>
	<li><input type="text" id="startDate" class="textbox"/> and <input type="text" id="endDate" class="textbox" /></li>
	<li><select class="textbox"><option>Length</option><option>Period</option></select></li>
	<li><input type="text" value="0" /> hours <input type="text" value="0" /> minutes</li>
	<li>Start: <select id="beginPeriod"></select> End: <select id="endPeriod"></select></li>
</ul>
</form>
{include file='globalfooter.tpl'}