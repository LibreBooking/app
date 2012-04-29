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

<form id="addAttributeForm" ajaxAction="{ManageAttributesActions::AddAttribute}" method="post">
	<label>Category:
		<select {formname key=ATTRIBUTE_CATEGORY} id="attributeCategory">
			<option value="{CustomAttributeCategory::RESERVATION}">Reservation</option>
			<option value="{CustomAttributeCategory::USER}">User</option>
			<option value="{CustomAttributeCategory::GROUP}">Group</option>
			<option value="{CustomAttributeCategory::RESOURCE}">Resource</option>
		</select>
	</label>

	<a href="#" id="addAttributeButton">{html_image src='plus-circle-frame.png'} {translate key=AddAttribute}</a>

	<div id="addAttributeDialog" class="dialog" title="{translate key=AddAttribute}">

		<span class="wideLabel">{translate key=Type}:</span><select {formname key=ATTRIBUTE_TYPE}>
		<option value="{CustomAttributeTypes::SINGLE_LINE_TEXTBOX}">Single Line Textbox</option>
		<option>Multiple Line Textbox</option>
		<option>Select List</option>
		<option>Checkbox</option>
	</select>

		<div><span class="wideLabel">{translate key=DisplayLabel}:</span>{textbox name=ATTRIBUTE_LABEL}</div>
		<div id="textBoxOptions">
			<div><span class="wideLabel">{translate key=Required}:</span><input type="checkbox" {formname key=ATTRIBUTE_IS_REQUIRED} />
			</div>
			<div><span class="wideLabel">{translate key=ValidationExpression}:</span>{textbox name=ATTRIBUTE_VALIDATION_EXPRESSION}
			</div>
		</div>

		<button type="button" class="button save">{html_image src="plus-button.png"} {translate key=Add}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</div>
	<div style="clear:both"></div>
</form>

<div id="attributeList">
</div>

{html_image src="admin-ajax-indicator.gif" class="indicator" style="display:none;"}

<script type="text/javascript" src="{$Path}scripts/admin/edit.js"></script>
<script type="text/javascript" src="{$Path}scripts/admin/attributes.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jquery.form-2.43.js"></script>

<script type="text/javascript">

	$(document).ready(function () {
	var attributeOptions = {
	submitUrl: '{$smarty.server.SCRIPT_NAME}',
	changeCategoryUrl: '{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::DATA_REQUEST}=attributes&{QueryStringKeys::ATTRIBUTE_CATEGORY}='
	};

	var attributeManagement = new AttributeManagement(attributeOptions);
	attributeManagement.init();
	});
</script>
{include file='globalfooter.tpl'}