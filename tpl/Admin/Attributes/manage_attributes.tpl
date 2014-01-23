{*
Copyright 2012-2014 Nick Korbel

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

{include file='globalheader.tpl' cssFiles='css/admin.css'}

<h1>{translate key=CustomAttributes}</h1>

<div id="customAttributeHeader">

<label>{translate key=Category}:
	<select id="attributeCategory">
		<option value="{CustomAttributeCategory::RESERVATION}">{translate key=CategoryReservation}</option>
		<option value="{CustomAttributeCategory::USER}">{translate key=User}</option>
		<option value="{CustomAttributeCategory::RESOURCE}">{translate key=Resource}</option>
		<option value="{CustomAttributeCategory::RESOURCE_TYPE}">{translate key=ResourceType}</option>
	</select>
</label>

<a href="#" id="addAttributeButton">{html_image src='plus-circle-frame.png'} {translate key=AddAttribute}</a>
</div>

<div id="addAttributeDialog" class="dialog attributeDialog" title="{translate key=AddAttribute}">

	<form id="addAttributeForm" ajaxAction="{ManageAttributesActions::AddAttribute}" method="post">
		<span class="wideLabel">{translate key=Type}:</span>
		<select {formname key=ATTRIBUTE_TYPE} id="attributeType">
			<option value="{CustomAttributeTypes::SINGLE_LINE_TEXTBOX}">{translate key=$Types[CustomAttributeTypes::SINGLE_LINE_TEXTBOX]}</option>
			<option value="{CustomAttributeTypes::MULTI_LINE_TEXTBOX}">{translate key=$Types[CustomAttributeTypes::MULTI_LINE_TEXTBOX]}</option>
			<option value="{CustomAttributeTypes::SELECT_LIST}">{translate key=$Types[CustomAttributeTypes::SELECT_LIST]}</option>
			<option value="{CustomAttributeTypes::CHECKBOX}">{translate key=$Types[CustomAttributeTypes::CHECKBOX]}</option>
		</select>

		<div class="textBoxOptions">
			<div class="attributeLabel">
				<span class="wideLabel">{translate key=DisplayLabel}:</span>
			{textbox name=ATTRIBUTE_LABEL class="required"}
			</div>
			<div class="attributeRequired">
				<span class="wideLabel">{translate key=Required}:</span>
				<input type="checkbox" {formname key=ATTRIBUTE_IS_REQUIRED} />
			</div>
			<div class="attributeUnique">
				<span class="wideLabel">{translate key=AppliesTo}:</span>
				<a href="#" class="appliesTo">{translate key=All}</a>
				<input type="hidden" class="appliesToId" {formname key=ATTRIBUTE_ENTITY} id="addAttributeEntityId" />
			</div>
			<div class="attributeValidationExpression">
				<span class="wideLabel">{translate key=ValidationExpression}:</span>
			{textbox name=ATTRIBUTE_VALIDATION_EXPRESSION}
			</div>
			<div class="attributePossibleValues" style="display:none">
				<span class="wideLabel">{translate key=PossibleValues}:</span>
			{textbox name=ATTRIBUTE_POSSIBLE_VALUES class="required"} <span class="note">({translate key=CommaSeparated})</span>
			</div>
			<div class="attributeSortOrder">
				<span class="wideLabel">{translate key=SortOrder}:</span>
				{textbox name=ATTRIBUTE_SORT_ORDER  maxlength=3 width="40px"}
			</div>
		</div>

		<button type="button" class="button save">{html_image src="plus-button.png"} {translate key=Add}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>

		<input type="hidden" {formname key=ATTRIBUTE_CATEGORY}  id="addCategory" value="" />
	</form>
</div>

<div id="deleteDialog" class="dialog" style="display:none;" title="{translate key=Delete}">
	<form id="deleteForm"  ajaxAction="{ManageAttributesActions::DeleteAttribute}" method="post">
		<div class="error" style="margin-bottom: 25px;">
			<h3>{translate key=DeleteWarning}</h3>
		</div>
		<button type="button" class="button save">{html_image src="cross-button.png"} {translate key='Delete'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<div id="editAttributeDialog" class="dialog attributeDialog" title="{translate key=EditAttribute}">

	<form id="editAttributeForm" ajaxAction="{ManageAttributesActions::UpdateAttribute}" method="post">
		<span class="wideLabel">{translate key=Type}:</span>
		<span class='editAttributeType'
			  id="editType{CustomAttributeTypes::SINGLE_LINE_TEXTBOX}">{translate key=$Types[CustomAttributeTypes::SINGLE_LINE_TEXTBOX]}</span>
		<span class='editAttributeType'
			  id="editType{CustomAttributeTypes::MULTI_LINE_TEXTBOX}">{translate key=$Types[CustomAttributeTypes::MULTI_LINE_TEXTBOX]}</span>
		<span class='editAttributeType'
			  id="editType{CustomAttributeTypes::SELECT_LIST}">{translate key=$Types[CustomAttributeTypes::SELECT_LIST]}</span>
		<span class='editAttributeType'
			  id="editType{CustomAttributeTypes::CHECKBOX}">{translate key=$Types[CustomAttributeTypes::CHECKBOX]}</span>

		<div class="textBoxOptions">
			<div class="attributeLabel">
				<span class="wideLabel">{translate key=DisplayLabel}:</span>
			{textbox name=ATTRIBUTE_LABEL class="required" id='editAttributeLabel'}
			</div>
			<div class="attributeRequired">
				<span class="wideLabel">{translate key=Required}:</span>
				<input type="checkbox" {formname key=ATTRIBUTE_IS_REQUIRED} id='editAttributeRequired'/>
			</div>
			<div class="attributeUnique">
				<span class="wideLabel">{translate key=AppliesTo}:</span>
				<a href="#" class="appliesTo">{translate key=All}</a>
				<input type="hidden" class="appliesToId" {formname key=ATTRIBUTE_ENTITY} id='editAttributeEntityId' />
			</div>
			<div class="attributeValidationExpression">
				<span class="wideLabel">{translate key=ValidationExpression}:</span>
			{textbox name=ATTRIBUTE_VALIDATION_EXPRESSION id='editAttributeRegex'}
			</div>
			<div class="attributePossibleValues" style="display:none">
				<span class="wideLabel">{translate key=PossibleValues}:</span>
			{textbox name=ATTRIBUTE_POSSIBLE_VALUES class="required" id="editAttributePossibleValues"} <span
					class="note">({translate key=CommaSeparated})</span>
			</div>
			<div class="attributeSortOrder">
				<span class="wideLabel">{translate key=SortOrder}:</span>
				{textbox name=ATTRIBUTE_SORT_ORDER  maxlength=3 width="40px" id="editAttributeSortOrder"}
			</div>
		</div>

		<button type="button" class="button save">{html_image src="tick-circle.png"} {translate key=Update}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key=Cancel}</button>
	</form>
</div>
<div style="clear:both"></div>

<div id="attributeList">
</div>

<div id="entityChoices">
</div>

{html_image src="admin-ajax-indicator.gif" class="indicator" id="indicator" style="display:none;"}

<input type="hidden" id="activeId" value=""/>

{jsfile src="admin/edit.js"}
{jsfile src="admin/attributes.js"}
{jsfile src="js/jquery.form-3.09.min.js"}

<script type="text/javascript">

	$(document).ready(function () {
	var attributeOptions = {
		submitUrl: '{$smarty.server.SCRIPT_NAME}',
		changeCategoryUrl: '{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::DATA_REQUEST}=attributes&{QueryStringKeys::ATTRIBUTE_CATEGORY}=',
		singleLine: '{CustomAttributeTypes::SINGLE_LINE_TEXTBOX}',
		multiLine: '{CustomAttributeTypes::MULTI_LINE_TEXTBOX}',
		selectList: '{CustomAttributeTypes::SELECT_LIST}',
		checkbox: '{CustomAttributeTypes::CHECKBOX}',
		allText: "{translate key=All|escape:'javascript'}",
		categories: {
			reservation: {CustomAttributeCategory::RESERVATION},
			resource: {CustomAttributeCategory::RESOURCE},
			user: {CustomAttributeCategory::USER},
			resource_type: {CustomAttributeCategory::RESOURCE_TYPE}
		},
		resourcesUrl: 'manage_resources.php?{QueryStringKeys::DATA_REQUEST}=all',
		usersUrl: 'manage_users.php?{QueryStringKeys::DATA_REQUEST}=all',
		resourceTypesUrl: 'manage_resource_types.php?{QueryStringKeys::DATA_REQUEST}=all'
	};

	var attributeManagement = new AttributeManagement(attributeOptions);
	attributeManagement.init();
	});
</script>
{include file='globalfooter.tpl'}