{*
Copyright 2013-2014 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*}
{include file='globalheader.tpl' cssFiles='css/admin.css,scripts/css/colorbox.css,scripts/css/colorpicker.css'}

<h1>{translate key=ReservationColors}</h1>

<label for="attributeOption">Attribute</label>
<select class="textbox" id="attributeOption">
	{foreach from=$Attributes item=attribute}
		<option value="{$attribute->Id()}">{$attribute->Label()}</option>
	{/foreach}
	</select>
<button type="button" class="button" id="addRuleButton">
   {html_image src="plus-button.png"} {translate key='AddRule'}
</button>

<table class="list" style="margin-top:15px;">
	<tr>
		<th>{translate key=Attribute}</th>
		<th>{translate key=RequiredValue}</th>
		<th>{translate key=Color}</th>
		<th>{translate key=Remove}</th>
	</tr>
{foreach from=$Rules item=rule}
	{cycle values='row0,row1' assign=rowCss}
	<tr class="{$rowCss}">
		<td>{$rule->AttributeName}</td>
		<td>{$rule->RequiredValue}</td>
		<td style="background-color:#{$rule->Color}">&nbsp;</td>
		<td style="text-align: center;"><a href="#" ruleId="{$rule->Id}" class="delete">{html_image src="cross-button.png"}</td>
	</tr>
{/foreach}
</table>

<div class="dialog" id="addDialog" title="{translate key=AddReservationColorRule}">
	<form id="addForm" action="{$smarty.server.SCRIPT_NAME}" ajaxAction="add" method="post">
		<div>
			{translate key=ReservationCustomRuleAdd args="<div id='attributeFillIn' style='display:inline;'></div>"} <div id="color" style="display:inline;">#{textbox name="RESERVATION_COLOR" class="textbox required" id="reservationColor" maxlength=6}</div>
		</div>
		<div class="admin-update-buttons">
			<button type="button" class="button save" name="{Actions::SAVE}" id="saveButton">
				{html_image src="disk-black.png"} {translate key='Add'}
			</button>
			<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
		</div>
	</form>
</div>

<div id="deleteDialog" class="dialog" title="{translate key=Delete}">
	<form id="deleteForm" action="{$smarty.server.SCRIPT_NAME}" ajaxAction="delete" method="post">
		<div class="error" style="margin-bottom: 25px;">
			<h3>{translate key=DeleteWarning}</h3>
		</div>
		<div class="admin-update-buttons">
			<button type="button" class="button save">{html_image src="cross-button.png"} {translate key='Delete'}</button>
			<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
		</div>
		<input type="hidden" name="{FormKeys::RESERVATION_COLOR_RULE_ID}" id="deleteRuleId" />
	</form>
</div>


<div id="modalDiv" style="display:none;text-align:center; top:15%;position:relative;">
    <h3>{translate key=Working}</h3>
{html_image src="reservation_submitting.gif"}
</div>

{foreach from=$Attributes item=attribute}
	<div id="attribute{$attribute->Id()}" class="hidden">{control type="AttributeControl" attribute=$attribute searchmode=true}</div>
{/foreach}

{jsfile src="admin/edit.js"}
{jsfile src="js/jquery.form-3.09.min.js"}
{jsfile src="js/jquery.colorbox-min.js"}
{jsfile src="ajax-form-submit.js"}
{jsfile src="js/colorpicker.js"}
{jsfile src="admin/reservation-colors.js"}

<script type="text/javascript">
	$('document').ready(function(){

		var mgmt = new ReservationColorManagement();
		mgmt.init();
    });
</script>

{include file='globalfooter.tpl'}