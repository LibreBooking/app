{*
Copyright 2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*}
{include file='globalheader.tpl' cssFiles='css/admin.css'}

<h1>{translate key=CustomAttributes}</h1>

Category:
<select>
	<option>Reservation</option>
	<option>User</option>
	<option>Group</option>
	<option>Resource</option>
</select>

<a href="#">{html_image src='plus-circle-frame.png'} Add an Attribute</a>

<div id="addAttribute">

	<form id="addAttributeForm" ajaxAction="{ManageAttributesActions::AddAttribute}" method="post">
		<span class="wideLabel">Type:</span><select>
			<option>Single Line Textbox</option>
			<option>Multiple Line Textbox</option>
			<option>Select List</option>
			<option>Checkbox</option>
		</select>

		<div><span class="wideLabel">Label:</span><input type="textbox" /></div>
		<div id="textBoxOptions">
			<div><span class="wideLabel">Required:</span><input type="checkbox" /></div>
			<div><span class="wideLabel">Validation Expression:</span><input type="textbox" /></div>
		</div>

		<button type="button" class="button save" style="float:right;">{html_image src="plus-button.png"} {translate key=Add}</button>
	</form>
</div>

{html_image src="admin-ajax-indicator.gif" class="indicator" style="display:none;"}

<script type="text/javascript" src="{$Path}scripts/admin/edit.js"></script>
<script type="text/javascript" src="{$Path}scripts/admin/attributes.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jquery.form-2.43.js"></script>

<script type="text/javascript">

	$(document).ready(function() {
		var attributeOptions = {
			submitUrl: '{$smarty.server.SCRIPT_NAME}'
		};

		var attributeManagement = new AttributeManagement(attributeOptions);
		attributeManagement.init();
	});
</script>
{include file='globalfooter.tpl'}