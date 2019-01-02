{*
Copyright 2012-2019 Nick Korbel

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

<div id="page-manage-attributes" class="admin-page">
	<h1>{translate key=CustomAttributes}</h1>

	<div id="customAttributeHeader" class="form-group">

		<label>{translate key=Category}:
			<select id="attributeCategory" class="inline form-control">
				<option value="{CustomAttributeCategory::RESERVATION}">{translate key=CategoryReservation}</option>
				<option value="{CustomAttributeCategory::USER}">{translate key=User}</option>
				<option value="{CustomAttributeCategory::RESOURCE}">{translate key=Resource}</option>
				<option value="{CustomAttributeCategory::RESOURCE_TYPE}">{translate key=ResourceType}</option>
			</select>
		</label>

		<a href="#" id="addAttributeButton"><span class="fa fa-plus-circle icon add"></span> {translate key=AddAttribute}</a>
	</div>

	<div class="modal fade" id="addAttributeDialog" tabindex="-1" role="dialog" aria-labelledby="addLabel" aria-hidden="true">
		<div class="modal-dialog">
			<form id="addAttributeForm" ajaxAction="{ManageAttributesActions::AddAttribute}" method="post">
				<input type="hidden" {formname key=ATTRIBUTE_CATEGORY}  id="addCategory" value=""/>

				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="addLabel">{translate key=AddAttribute}</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="attributeType">{translate key=Type}</label>
							<select {formname key=ATTRIBUTE_TYPE} id="attributeType" class="form-control">
								<option value="{CustomAttributeTypes::SINGLE_LINE_TEXTBOX}">{translate key=$Types[CustomAttributeTypes::SINGLE_LINE_TEXTBOX]}</option>
								<option value="{CustomAttributeTypes::MULTI_LINE_TEXTBOX}">{translate key=$Types[CustomAttributeTypes::MULTI_LINE_TEXTBOX]}</option>
								<option value="{CustomAttributeTypes::SELECT_LIST}">{translate key=$Types[CustomAttributeTypes::SELECT_LIST]}</option>
								<option value="{CustomAttributeTypes::CHECKBOX}">{translate key=$Types[CustomAttributeTypes::CHECKBOX]}</option>
								<option value="{CustomAttributeTypes::DATETIME}">{translate key=$Types[CustomAttributeTypes::DATETIME]}</option>
							</select>
						</div>
						<div class="textBoxOptions">
							<div class="attributeLabel form-group has-feedback">
								<label for="ATTRIBUTE_LABEL">{translate key=DisplayLabel}</label>
								{textbox name=ATTRIBUTE_LABEL class="required"}
								<i class="glyphicon glyphicon-asterisk form-control-feedback" data-bv-icon-for="ATTRIBUTE_LABEL"></i>
							</div>

							<div class="attributeValidationExpression form-group">
								<label for="ATTRIBUTE_VALIDATION_EXPRESSION">{translate key=ValidationExpression}</label>
								{textbox name=ATTRIBUTE_VALIDATION_EXPRESSION}
							</div>

							<div class="attributePossibleValues form-group has-feedback" style="display:none">
								<label for="ATTRIBUTE_POSSIBLE_VALUES">{translate key=PossibleValues} <span class="note">({translate key=CommaSeparated})</span></label>
								{textbox name=ATTRIBUTE_POSSIBLE_VALUES class="required"}
								<i class="glyphicon glyphicon-asterisk form-control-feedback" data-bv-icon-for="ATTRIBUTE_POSSIBLE_VALUES"></i>
							</div>

							<div class="attributeSortOrder form-group">
								<label for="ATTRIBUTE_SORT_ORDER">{translate key=SortOrder}</label>
								<input type="number" class="form-control" min="0" {formname key=ATTRIBUTE_SORT_ORDER} maxlength=3 id="ATTRIBUTE_SORT_ORDER"/>
							</div>

							<div class="attributeUnique form-group">
								<label for="addAttributeEntityId">{translate key=AppliesTo}</label>
								<a href="#" id="appliesTo">{translate key=All}</a>
								<div class="appliesToId" id="addAttributeEntityId" style="display:none;"></div>
							</div>

							<div class="attributeRequired form-group">
								<div class="checkbox">
									<input type="checkbox" {formname key=ATTRIBUTE_IS_REQUIRED} id="attributeRequired"/>
									<label for="attributeRequired">{translate key=Required}</label>
								</div>
							</div>

							<div class="attributeAdminOnly form-group">
								<div class="checkbox">
									<input type="checkbox" {formname key=ATTRIBUTE_IS_ADMIN_ONLY} id="ATTRIBUTE_IS_ADMIN_ONLY"/>
									<label for="ATTRIBUTE_IS_ADMIN_ONLY">{translate key=AdminOnly}</label>
								</div>
							</div>
							<div class="attributeIsPrivate form-group">
								<div class="checkbox">
									<input type="checkbox" {formname key=ATTRIBUTE_IS_PRIVATE} id='attributePrivate'/>
									<label for="attributePrivate">{translate key=Private}</label>
								</div>
							</div>

							<div class="secondaryEntities no-show form-group">
								<div class="checkbox">
									<input type="checkbox" class="limitScope" {formname key=ATTRIBUTE_LIMIT_SCOPE} id="attributeLimitScope"/>
									<label for="attributeLimitScope">{translate key=LimitAttributeScope}</label>
								</div>
							</div>
							<div class="attributeSecondary no-show form-group">
                                <label for="attributeSecondaryCategory" class="no-show">{translate key=Category}</label>
								<select class="secondaryAttributeCategory form-control" {formname key=ATTRIBUTE_SECONDARY_CATEGORY}
										id="attributeSecondaryCategory">
									<option value="{CustomAttributeCategory::USER}">{translate key=User}</option>
									<option value="{CustomAttributeCategory::RESOURCE}">{translate key=Resource}</option>
									<option value="{CustomAttributeCategory::RESOURCE_TYPE}">{translate key=ResourceType}</option>
								</select>
							</div>
							<div class="attributeSecondary no-show form-group">
								<label for="attributeSecondaryEntityDescription">{translate key=CollectFor}</label>
								<a href="#" class="secondaryPrompt" id="attributeSecondaryEntityDescription">{translate key=All}</a>

							</div>
						</div>

						<div id="entityChoices"></div>

					</div>
					<div class="modal-footer">
						{cancel_button}
						{add_button}
						{indicator}
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="modal fade" id="editAttributeDialog" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
		<div class="modal-dialog">
			<form id="editAttributeForm" ajaxAction="{ManageAttributesActions::UpdateAttribute}" method="post">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="editLabel">{translate key=EditAttribute}</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>{translate key=Type}</label>
							<span class='editAttributeType'
								  id="editType{CustomAttributeTypes::SINGLE_LINE_TEXTBOX}">{translate key=$Types[CustomAttributeTypes::SINGLE_LINE_TEXTBOX]}</span>
							<span class='editAttributeType'
								  id="editType{CustomAttributeTypes::MULTI_LINE_TEXTBOX}">{translate key=$Types[CustomAttributeTypes::MULTI_LINE_TEXTBOX]}</span>
							<span class='editAttributeType'
								  id="editType{CustomAttributeTypes::SELECT_LIST}">{translate key=$Types[CustomAttributeTypes::SELECT_LIST]}</span>
							<span class='editAttributeType'
								  id="editType{CustomAttributeTypes::CHECKBOX}">{translate key=$Types[CustomAttributeTypes::CHECKBOX]}</span>
						</div>
						<div class="textBoxOptions">
							<div class="form-group attributeLabel has-feedback">
								<label for="editAttributeLabel">{translate key=DisplayLabel}</label>
								{textbox name=ATTRIBUTE_LABEL class="required" id='editAttributeLabel'}
								<i class="glyphicon glyphicon-asterisk form-control-feedback" data-bv-icon-for="editAttributeLabel"></i>
							</div>

							<div class="form-group attributeValidationExpression">
								<label for="editAttributeRegex">{translate key=ValidationExpression}</label>
								{textbox name=ATTRIBUTE_VALIDATION_EXPRESSION id='editAttributeRegex'}
							</div>

							<div class="form-group attributePossibleValues has-feedback" style="display:none">
								<label for="editAttributePossibleValues">{translate key=PossibleValues} <span class="note">({translate key=CommaSeparated}
										)</span></label>
								{textbox name=ATTRIBUTE_POSSIBLE_VALUES class="required" id="editAttributePossibleValues"}
								<i class="glyphicon glyphicon-asterisk form-control-feedback" data-bv-icon-for="editAttributePossibleValues"></i>
							</div>

							<div class="form-group attributeSortOrder">
								<label for="editAttributeSortOrder">{translate key=SortOrder}</label>
								<input type="number" class="form-control" min="0" {formname key=ATTRIBUTE_SORT_ORDER} id="editAttributeSortOrder"/>
							</div>

							<div class="form-group attributeUnique">
								<label for="editAttributeEntityId">{translate key=AppliesTo}</label>
								<a href="#" id="editAppliesTo">{translate key=All}</a>
								<div class="appliesToId" id='editAttributeEntityId' style="display:none;"></div>
							</div>

							<div class="form-group attributeRequired">
								<div class="checkbox">
									<input type="checkbox" {formname key=ATTRIBUTE_IS_REQUIRED} id='editAttributeRequired'/>
									<label for="editAttributeRequired">{translate key=Required}</label>
								</div>
							</div>

							<div class="form-group attributeAdminOnly">
								<div class="checkbox">
									<input type="checkbox" {formname key=ATTRIBUTE_IS_ADMIN_ONLY} id="editAttributeAdminOnly"/>
									<label for="editAttributeAdminOnly">{translate key=AdminOnly}</label>
								</div>
							</div>

							<div class="form-group attributeIsPrivate">
								<div class="checkbox">
									<input type="checkbox" {formname key=ATTRIBUTE_IS_PRIVATE} id='editAttributePrivate'/>
									<label for="editAttributePrivate">{translate key=Private}</label>
								</div>
							</div>

							<div class="form-group secondaryEntities no-show">
								<div class="checkbox">
									<input type="checkbox" class="limitScope" {formname key=ATTRIBUTE_LIMIT_SCOPE} id="editAttributeLimitScope"/>
									<label for="editAttributeLimitScope">{translate key=LimitAttributeScope}</label>
								</div>
							</div>

							<div class="form-group attributeSecondary no-show">
                                <label for="editAttributeSecondaryCategory" class="no-show">{translate key=Category}</label>
                                <select class="secondaryAttributeCategory form-control" {formname key=ATTRIBUTE_SECONDARY_CATEGORY}
										id="editAttributeSecondaryCategory">
									<option value="{CustomAttributeCategory::USER}">{translate key=User}</option>
									<option value="{CustomAttributeCategory::RESOURCE}">{translate key=Resource}</option>
									<option value="{CustomAttributeCategory::RESOURCE_TYPE}">{translate key=ResourceType}</option>
								</select>
							</div>

							<div class="form-group attributeSecondary no-show">
								<label for="editAttributeSecondaryEntityDescription">{translate key=CollectFor}</label>
								<a href="#" class="secondaryPrompt" id="editAttributeSecondaryEntityDescription">{translate key=All}</a>
								{*<input type="hidden" class="secondaryEntityIds" {formname key=ATTRIBUTE_SECONDARY_ENTITY_IDS} id="editAttributeSecondaryEntityIds"/>*}
							</div>
						</div>
						<div id="editEntityChoices"></div>
					</div>
					<div class="modal-footer">
						{cancel_button}
						{update_button}
						{indicator}
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="modal fade" id="deleteDialog" tabindex="-1" role="dialog" aria-labelledby="deleteLabel" aria-hidden="true">
		<div class="modal-dialog">
			<form id="deleteForm" ajaxAction="{ManageAttributesActions::DeleteAttribute}" method="post">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="deleteLabel">{translate key=Delete}</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-danger">
							{translate key=DeleteWarning}
						</div>
					</div>
					<div class="modal-footer">
						{cancel_button}
						{delete_button}
						{indicator}
					</div>
				</div>
			</form>
		</div>
	</div>

	<div id="attributeList">
	</div>

	{csrf_token}
	{indicator id="indicator"}

	<input type="hidden" id="activeId" value=""/>
    {include file="javascript-includes.tpl"}
	{jsfile src="ajax-helpers.js"}
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
				date: '{CustomAttributeTypes::DATETIME}',
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
</div>
{include file='globalfooter.tpl'}
