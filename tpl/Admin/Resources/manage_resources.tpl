{*
Copyright 2011-2015 Nick Korbel

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

{include file='globalheader.tpl' InlineEdit=true}

<div id="page-manage-resources" class="admin-page">
	<div>
		<div class="dropdown admin-header-more pull-right">
			<button class="btn btn-default" type="button" id="moreResourceActions" data-toggle="dropdown">
				<span class="glyphicon glyphicon-option-vertical"></span>
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu" role="menu" aria-labelledby="moreResourceActions">
				<li role="presentation"><a role="menuitem"
										   href="#" class="add-resource" id="add-resource">{translate key="AddResource"}
						<span
								class="fa fa-plus-circle icon add"></span></a>
				</li>
				<li role="presentation"><a role="menuitem"
										   href="{$Path}admin/manage_resource_groups.php">{translate key="ManageResourceGroups"}</a>
				</li>
				<li role="presentation"><a role="menuitem"
										   href="{$Path}admin/manage_resource_types.php">{translate key="ManageResourceTypes"}</a>
				</li>
				<li role="presentation"><a role="menuitem"
										   href="{$Path}admin/manage_resource_status.php">{translate key="ManageResourceStatus"}</a>
				</li>
				<li role="presentation" class="divider"></li>
				{if !empty($Resources)}
				<li role="presentation"><a role="menuitem" href="#"
										   id="bulkUpdatePromptButton">{translate key=BulkResourceUpdate}</a>
					{/if}
			</ul>
		</div>

		<h1>{translate key='ManageResources'}</h1>
	</div>

	<div class="panel panel-default filterTable" id="filterTable">
		<div class="panel-heading"><span class="glyphicon glyphicon-filter"></span> {translate key="Filter"} <a href=""><span
						class="icon black show-hide glyphicon"></span></a>
		</div>
		<div class="panel-body">
			<form id="filterForm" class="horizontal-list form-inline" role="form">
				{assign var=groupClass value="col-xs-12 col-sm-4 col-md-3"}

				<div class="form-group {$groupClass}">
					<input type="text" id="filterResourceName" class="form-control" {formname key=RESOURCE_NAME}
						   value="{$ResourceNameFilter}" placeholder="{translate key=Name}"/>
				</div>
				<div class="form-group {$groupClass}">
					<select id="filterScheduleId" {formname key=SCHEDULE_ID} class="form-control">
						<option value="">{translate key=AllSchedules}</option>
						{object_html_options options=$AllSchedules key='GetId' label="GetName" selected=$ScheduleIdFilter}
					</select>
				</div>

				<div class="form-group {$groupClass}">
					<select id="filterResourceType" class="form-control" {formname key=RESOURCE_TYPE_ID}>
						<option value="">{translate key=AllResourceTypes}</option>
						{object_html_options options=$ResourceTypes key='Id' label="Name" selected=$ResourceTypeFilter}
					</select>
				</div>
				<div class="form-group {$groupClass}">
					<select id="resourceStatusIdFilter" class="form-control" {formname key=RESOURCE_STATUS_ID}>
						<option value="">{translate key=AllResourceStatuses}</option>
						<option value="{ResourceStatus::AVAILABLE}">{translate key=Available}</option>
						<option value="{ResourceStatus::UNAVAILABLE}">{translate key=Unavailable}</option>
						<option value="{ResourceStatus::HIDDEN}">{translate key=Hidden}</option>
					</select>
					<select id="resourceReasonIdFilter" class="form-control" {formname key=RESOURCE_STATUS_REASON_ID}>
						<option value="">-</option>
					</select>
				</div>
				<div class="form-group {$groupClass}">
					<input type="text" id="filterCapacity" class="form-control" {formname key=MAX_PARTICIPANTS}
						   value="{$CapacityFilter}" placeholder="{translate key=MinimumCapacity}"/>
				</div>
				<div class="form-group {$groupClass}">
					<label class="control-label"
						   for="filterRequiresApproval">{translate key='ResourceRequiresApproval'}</label>
					<select id="filterRequiresApproval" class="form-control" {formname key=REQUIRES_APPROVAL}>
						{html_options options=$YesNoOptions selected=$RequiresApprovalFilter}
					</select>
				</div>
				<div class="form-group {$groupClass}">
					<label class="control-label"
						   for="filterAutoAssign">{translate key='ResourcePermissionAutoGranted'}</label>
					<select id="filterAutoAssign" class="form-control" {formname key=AUTO_ASSIGN}>
						{html_options options=$YesNoOptions selected=$AutoPermissionFilter}
					</select>
				</div>
				<div class="form-group {$groupClass}">
					<label class="control-label" for="filterAllowMultiDay">{translate key=ResourceAllowMultiDay}</label>
					<select id="filterAllowMultiDay" class="form-control" {formname key=ALLOW_MULTIDAY}>
						{html_options options=$YesNoOptions selected=$AllowMultiDayFilter}
					</select>
				</div>
				<div class="clearfix"></div>
				{foreach from=$AttributeFilters item=attribute}
					{control type="AttributeControl" attribute=$attribute searchmode=true class="customAttribute filter-customAttribute{$attribute->Id()} {$groupClass}"}
				{/foreach}
			</form>
		</div>
		<div class="panel-footer">
			<button id="filter" class="btn btn-primary btn-sm"><span
						class="glyphicon glyphicon-search"></span> {translate key=Filter}</button>
			<button id="clearFilter" class="btn btn-link btn-sm">{translate key=Reset}</button>
		</div>
	</div>

	{pagination pageInfo=$PageInfo showCount=false}

	<div id="globalError" class="error no-show"></div>

	<div class="panel panel-default admin-panel" id="list-reservations-panel">
		<div class="panel-heading">{translate key="Resources"}
			<a href="#" class="add-link add-resource pull-right">{translate key="AddResource"}
				<span class="fa fa-plus-circle icon add"></span>
			</a>
		</div>
		<div class="panel-body no-padding" id="resourceList">

			{foreach from=$Resources item=resource}
				{assign var=id value=$resource->GetResourceId()}
				<div class="resourceDetails" data-resourceId="{$id}">
					<div class="col-xs-5">
						<input type="hidden" class="id" value="$id}"/>

						<div class="col-xs-3 resourceImage">
							{if $resource->HasImage()}
								<img src="{resource_image image=$resource->GetImage()}" alt="Resource Image"
									 class="image"/>
								<br/>
								<a class="update imageButton" href="#">{translate key='Change'}</a>
								|
								<a class="update removeImageButton" href="#">{translate key='Remove'}</a>
								{indicator id=removeImageIndicator}
							{else}
								<div class="noImage"><span class="fa fa-image"></span></div>
								<a class="update imageButton" href="#">{translate key='AddImage'}</a>
							{/if}
						</div>
						<div class="col-xs-9">
							<div>
							<span class="title" data-type="text" data-pk="{$id}"
								  data-name="{FormKeys::RESOURCE_NAME}">{$resource->GetName()|escape}</span>
								<a class="update renameButton" href="#">{translate key='Rename'}</a> |
								<a class="update deleteButton" href="#">{translate key='Delete'}</a>
							</div>
							<div>
								{translate key='Status'}
								{if $resource->IsAvailable()}
									{html_image src="status.png"}
									<a class="update changeStatus"
									   href="#" rel="popover"
									   data-popover-content="#statusDialog">{translate key='Available'}</a>
								{elseif $resource->IsUnavailable()}
									{html_image src="status-away.png"}
									<a class="update changeStatus"
									   href="#" rel="popover"
									   data-popover-content="#statusDialog">{translate key='Unavailable'}</a>
								{else}
									{html_image src="status-busy.png"}
									<a class="update changeStatus"
									   href="#" rel="popover"
									   data-popover-content="#statusDialog">{translate key='Hidden'}</a>
								{/if}
								{if array_key_exists($resource->GetStatusReasonId(),$StatusReasons)}
									<span class="statusReason">{$StatusReasons[$resource->GetStatusReasonId()]->Description()}</span>
								{/if}
							</div>

							<div>
								{translate key='Schedule'}
								<span class="propertyValue scheduleName"
									  data-type="select" data-pk="{$id}" data-value="{$resource->GetScheduleId()}"
									  data-name="{FormKeys::SCHEDULE_ID}">{$Schedules[$resource->GetScheduleId()]}</span>
								<a class="update changeScheduleButton" href="#">{translate key='Move'}</a>
							</div>
							<div>
								{translate key='ResourceType'}
								<span class="propertyValue resourceTypeName"
									  data-type="select" data-pk="{$id}" data-value="{$resource->GetResourceTypeId()}"
									  data-name="{FormKeys::RESOURCE_TYPE_ID}">
									{if $resource->HasResourceType()}
										{$ResourceTypes[$resource->GetResourceTypeId()]->Name()}
									{else}
										{translate key='NoResourceTypeLabel'}
									{/if}
								</span>
								<a class="update changeResourceType" href="#"><span
											class="fa fa-pencil-square-o"></span></a>
							</div>
							<div>
								{translate key=SortOrder}
								<span class="propertyValue sortOrderValue"
									  data-type="number" data-pk="{$id}" data-name="{FormKeys::RESOURCE_SORT_ORDER}">
								{$resource->GetSortOrder()|default:"0"}
							</span>
								<a class="update changeSortOrder" href="#"><span
											class="fa fa-pencil-square-o"></span></a>
							</div>
							<div>
								{translate key='Location'}
								<span class="propertyValue locationValue"
									  data-type="text" data-pk="{$id}" data-value="{$resource->GetLocation()}"
									  data-name="{FormKeys::RESOURCE_LOCATION}">
							{if $resource->HasLocation()}
								{$resource->GetLocation()}
							{else}
								{translate key='NoLocationLabel'}
							{/if}
							</span>
								<a class="update changeLocation" href="#"><span
											class="fa fa-pencil-square-o"></span></a>
							</div>
							<div>
								{translate key='Contact'}
								<span class="propertyValue contactValue"
									  data-type="text" data-pk="{$id}" data-value="{$resource->GetContact()}"
									  data-name="{FormKeys::RESOURCE_CONTACT}">
							{if $resource->HasContact()}
								{$resource->GetContact()}
							{else}
								{translate key='NoContactLabel'}
							{/if}
							</span>
								<a class="update changeContact" href="#"><span class="fa fa-pencil-square-o"></span></a>
							</div>
							<div>
								{translate key='Description'} <a class="update changeDescription" href="#"><span
											class="fa fa-pencil-square-o"></span></a>
								{if $resource->HasDescription()}
									{assign var=description value=$resource->GetDescription()}
								{else}
									{assign var=description value=''}
								{/if}
								{strip}
									<div class="descriptionValue"
										 data-type="textarea" data-pk="{$id}" data-value="{$description|escape}"
										 data-name="{FormKeys::RESOURCE_DESCRIPTION}">
										{if $resource->HasDescription()}
											{$description}
										{else}
											{translate key='NoDescriptionLabel'}
										{/if}
									</div>
								{/strip}
							</div>
							<div>
								{translate key='Notes'} <a class="update changeNotes" href="#"><span
											class="fa fa-pencil-square-o"></span></a>
								{if $resource->HasNotes()}
									{assign var=notes value=$resource->GetNotes()}
								{else}
									{assign var=notes value=''}
								{/if}
								{strip}
									<div class="notesValue"
										 data-type="textarea" data-pk="{$id}" data-value="{$notes|escape}"
										 data-name="{FormKeys::RESOURCE_NOTES}">
										{if $resource->HasNotes()}
											{$notes}
										{else}
											{translate key='NoNotesLabel'}
										{/if}
									</div>
								{/strip}
							</div>
							<div>
								{translate key='ResourceAdministrator'}
								<span class="propertyValue resourceAdminValue"
									  data-type="select" data-pk="{$id}" data-value="{$resource->GetAdminGroupId()}"
									  data-name="{FormKeys::RESOURCE_ADMIN_GROUP_ID}">{$GroupLookup[$resource->GetAdminGroupId()]->Name}</span>
								{if $AdminGroups|count > 0}
									<a class="update changeResourceAdmin" href="#"><span
												class="fa fa-pencil-square-o"></span></a>
								{/if}
							</div>
							<div>
								<a class="update disableSubscription hide subscriptionButton"
								   href="#">{translate key=TurnOffSubscription}</a>
								<a class="update enableSubscription hide subscriptionButton"
								   href="#">{translate key=TurnOnSubscription}</a>
								{indicator id=subscriptionIndicator}
							</div>
						</div>
					</div>

					<div class="col-xs-7">
						<div class="col-xs-6">
							<h5 class="inline">{translate key=Duration}</h5>
							<a href="#" class="inline update changeDuration">
								<span class="fa fa-pencil-square-o"></span>
							</a>

							<div class="durationPlaceHolder">
								{include file="Admin/Resources/manage_resources_duration.tpl" resource=$resource}
							</div>

							<h5 class="inline">{translate key='Capacity'}</h5>
							<a href="#" class="inline update changeCapacity">
								<span class="fa fa-pencil-square-o"></span>
							</a>

							<div class="capacityPlaceHolder">
								{include file="Admin/Resources/manage_resources_capacity.tpl" resource=$resource}
							</div>
						</div>

						<div class="col-xs-6">
							<h5 class="inline">{translate key=Access}</h5>
							<a href="#" class="inline update changeAccess">
								<span class="fa fa-pencil-square-o"></span>
							</a>

							<div class="accessPlaceHolder">
								{include file="Admin/Resources/manage_resources_access.tpl" resource=$resource}
							</div>
						</div>
					</div>

					<div class="clearfix"></div>
					<div class="customAttributes">
						{if $AttributeList|count > 0}
							{foreach from=$AttributeList item=attribute}

								{if $attribute->AppliesToEntity($id)}
									<div class="updateCustomAttribute">
										{assign var=datatype value='text'}
										{if $attribute->Type() == CustomAttributeTypes::CHECKBOX}
											{assign var=datatype value='checklist'}
										{elseif $attribute->Type() == CustomAttributeTypes::MULTI_LINE_TEXTBOX}
											{assign var=datatype value='textarea'}
										{elseif $attribute->Type() == CustomAttributeTypes::SELECT_LIST}
											{assign var=datatype value='select'}
										{/if}
										<label>{$attribute->Label()}</label>
							<span class="inlineAttribute"
								  data-type="{$datatype}"
								  data-pk="{$id}"
								  data-value="{$resource->GetAttributeValue($attribute->Id())}"
								  data-name="{FormKeys::ATTRIBUTE_PREFIX}{$attribute->Id()}"
									{if $attribute->Type() == CustomAttributeTypes::SELECT_LIST}
										data-source='[{if !$attribute->Required()}{ldelim}value:"",text:""{rdelim},{/if}
									  {foreach from=$attribute->PossibleValueList() item=v name=vals}
											{ldelim}value:"{$v}",text:"{$v}"{rdelim}{if not $smarty.foreach.vals.last},{/if}
										{/foreach}]'
									{/if}
									{if $attribute->Type() == CustomAttributeTypes::CHECKBOX}
										data-source='[{ldelim}value:"1",text:"{translate key=Yes}"{rdelim}]'
									{/if}
									>
							</span>
										<a class="update changeAttribute" href="#"><span
													class="fa fa-pencil-square-o"></span></a>
									</div>
								{/if}

							{/foreach}
						{/if}
					</div>
					<div class="clearfix"></div>
				</div>
			{/foreach}
		</div>
	</div>

	{pagination pageInfo=$PageInfo}

	<div id="add-resource-dialog" class="modal" tabindex="-1" role="dialog" aria-labelledby="addResourceModalLabel"
		 aria-hidden="true">
		<form id="addResourceForm" class="form" role="form" method="post"
			  ajaxAction="{ManageResourcesActions::ActionAdd}">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="addResourceModalLabel">{translate key=AddNewResource}</h4>
					</div>
					<div class="modal-body">
						<div id="addResourceResults" class="alert alert-danger no-show"></div>

						<div class="form-group has-feedback">
							<label for="resourceName">{translate key='Name'}</label>
							<input type="text" class="form-control required" maxlength="85" id="resourceName"
									{formname key=RESOURCE_NAME} />
							<i class="glyphicon glyphicon-asterisk form-control-feedback"
							   data-bv-icon-for="resourceName"></i>

						</div>
						<div class="form-group">
							<label for="scheduleId">{translate key='Schedule'}</label>
							<select class="form-control" {formname key=SCHEDULE_ID} id="scheduleId">
								{foreach from=$Schedules item=scheduleName key=scheduleId}
									<option value="{$scheduleId}">{$scheduleName}</option>
								{/foreach}
							</select>
						</div>
						<div class="form-group">
							<label for="permissions">{translate key='ResourcePermissions'}</label>
							<select class="form-control" {formname key=AUTO_ASSIGN}  id="permissions">
								<option value="1">{translate key="ResourcePermissionAutoGranted"}</option>
								<option value="0">{translate key="ResourcePermissionNotAutoGranted"}</option>
							</select>
						</div>
						<div class="form-group">
							<label for="resourceAdminGroupId">{translate key='ResourceAdministrator'}</label>
							<select class="form-control" {formname key=RESOURCE_ADMIN_GROUP_ID}
									id="resourceAdminGroupId">
								<option value="">{translate key=None}</option>
								{foreach from=$AdminGroups item=adminGroup}
									<option value="{$adminGroup->Id}">{$adminGroup->Name}</option>
								{/foreach}
							</select>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default"
								data-dismiss="modal">{translate key='Cancel'}</button>
						<button type="button" class="btn btn-success save"><span
									class="glyphicon glyphicon-ok-circle"></span>
							{translate key='AddResource'}</button>
						{indicator}
					</div>
				</div>
			</div>
		</form>
	</div>

	<input type="hidden" id="activeId" value=""/>

	<div id="imageDialog" class="modal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel"
		 aria-hidden="true">
		<form id="imageForm" method="post" enctype="multipart/form-data"
			  ajaxAction="{ManageResourcesActions::ActionChangeImage}">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="imageModalLabel">{translate key=AddImage}</h4>
					</div>
					<div class="modal-body">
						<label for="resourceImage" class="off-screen">Image file</label>
						<input id="resourceImage" type="file" class="text" size="60" {formname key=RESOURCE_IMAGE} />

						<div class="note">.gif, .jpg, or .png</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default"
								data-dismiss="modal">{translate key='Cancel'}</button>
						<button type="button" class="btn btn-success save"><span
									class="glyphicon glyphicon-ok-circle"></span>
							{translate key='Update'}</button>
						{indicator}
					</div>
				</div>
			</div>
		</form>
	</div>

	<div id="durationDialog" class="modal" tabindex="-1" role="dialog" aria-labelledby="durationModalLabel"
		 aria-hidden="true">
		<form id="durationForm" method="post" role="form" ajaxAction="{ManageResourcesActions::ActionChangeDuration}">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="durationModalLabel">{translate key=Duration}</h4>
					</div>
					<div class="modal-body">
						<div class="editMinDuration">
							<div class="checkbox">
								<input type="checkbox" id="noMinimumDuration" class="noMinimumDuration"
									   data-related-inputs="#minDurationInputs"/>
								<label for="noMinimumDuration">{translate key=ResourceMinLengthNone}</label>
							</div>
							{capture name="txtMinDuration" assign="txtMinDuration"}
								<input type='text' size='3' id='minDurationDays' class='days form-control' maxlength='3'
									   title='Days' placeholder='{translate key=days}'/>
								<input type='text' size='2' id='minDurationHours' class='hours form-control'
									   maxlength='2'
									   title='Hours' placeholder='{translate key=hours}'/>
								<input type='text' size='2' id='minDurationMinutes' class='minutes form-control'
									   maxlength='2' title='Minutes' placeholder='{translate key=minutes}'/>
								<input type='hidden' id='minDuration'
									   class='interval minDuration' {formname key=MIN_DURATION} />
							{/capture}
							<div id='minDurationInputs'>
								{translate key='ResourceMinLength' args=$txtMinDuration}
							</div>
						</div>

						<div class="editMaxDuration">
							<div class="checkbox">
								<input type="checkbox" id="noMaximumDuration" data-related-inputs="#maxDurationInputs"/>
								<label for="noMaximumDuration">{translate key=ResourceMaxLengthNone}</label>
							</div>
							{capture name="txtMaxDuration" assign="txtMaxDuration"}
								<input type='text' id='maxDurationDays' size='3' class='days form-control' maxlength='3'
									   title='Days' placeholder='{translate key=days}'/>
								<input type='text' id='maxDurationHours' size='2' class='hours form-control'
									   maxlength='2'
									   title='Hours' placeholder='{translate key=hours}'/>
								<input type='text' id='maxDurationMinutes' size='2' class='minutes form-control'
									   maxlength='2' title='Minutes' placeholder='{translate key=minutes}'/>
								<input type='hidden' id='maxDuration' class='interval' {formname key=MAX_DURATION} />
							{/capture}
							<div id='maxDurationInputs'>
								{translate key=ResourceMaxLength args=$txtMaxDuration}
							</div>
						</div>

						<div class="editBuffer">
							<div class="checkbox">
								<input type="checkbox" id="noBufferTime" data-related-inputs="#bufferInputs"/>
								<label for="noBufferTime">{translate key=ResourceBufferTimeNone}</label>
							</div>

							{capture name="txtBufferTime" assign="txtBufferTime"}
								<input type='text' id='bufferTimeDays'
									   size='3' class='days form-control'
									   maxlength='3'
									   title='Days' placeholder='{translate key=days}'/>
								<input type='text' id='bufferTimeHours'
									   size='2' class='hours form-control'
									   maxlength='2'
									   title='Hours' placeholder='{translate key=hours}'/>
								<input type='text' id='bufferTimeMinutes'
									   size='2' class='minutes form-control'
									   maxlength='2' title='Minutes' placeholder='{translate key=minutes}'/>
								<input type='hidden' id='bufferTime'
									   class='interval' {formname key=BUFFER_TIME} />
							{/capture}
							<div id='bufferInputs'>
								{translate key=ResourceBufferTime args=$txtBufferTime}
							</div>
						</div>

						<div class="editMultiDay">
							<div class="checkbox">
								<input type="checkbox" {formname key=ALLOW_MULTIDAY} id="allowMultiDay"/>
								<label for="allowMultiDay">{translate key=ResourceAllowMultiDay}</label>
							</div>
						</div>

					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default"
								data-dismiss="modal">{translate key='Cancel'}</button>
						<button type="button" class="btn btn-success save"><span
									class="glyphicon glyphicon-ok-circle"></span>
							{translate key='Update'}</button>
						{indicator}
					</div>
				</div>
			</div>
		</form>
	</div>

	<div id="capacityDialog" class="modal" tabindex="-1" role="dialog" aria-labelledby="capacityModalLabel"
		 aria-hidden="true">
		<form id="capacityForm" method="post" role="form" ajaxAction="{ManageResourcesActions::ActionChangeCapacity}">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="capacityModalLabel">{translate key=Capacity}</h4>
					</div>
					<div class="modal-body">
						<div class="editCapacity">
							<div class="checkbox">
								<input type="checkbox" id="unlimitedCapacity" class="unlimitedCapacity"
									   data-related-inputs="#maxCapacityInputs"/>
								<label for="unlimitedCapacity">{translate key=ResourceCapacityNone}</label>
							</div>
							<div id='maxCapacityInputs'>
								{capture name="txtMaxCapacity" assign="txtMaxCapacity"}
									<input type='number' id='maxCapacity' class='form-control inline mid-number' min='0'
										   max='9999' size='5' {formname key=MAX_PARTICIPANTS} />
								{/capture}
								{translate key='ResourceCapacity' args=$txtMaxCapacity}
							</div>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default"
								data-dismiss="modal">{translate key='Cancel'}</button>
						<button type="button" class="btn btn-success save"><span
									class="glyphicon glyphicon-ok-circle"></span>
							{translate key='Update'}</button>
						{indicator}
					</div>
				</div>
			</div>
		</form>
	</div>

	<div id="accessDialog" class="modal" tabindex="-1" role="dialog" aria-labelledby="accessModalLabel"
		 aria-hidden="true">
		<form id="accessForm" method="post" role="form" ajaxAction="{ManageResourcesActions::ActionChangeAccess}">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="accessModalLabel">{translate key=Access}</h4>
					</div>
					<div class="modal-body">
						<div class="editStartNotice">
							<div class="checkbox">
								<input type="checkbox" id="noStartNotice" class="noStartNotice"
									   data-related-inputs="#startNoticeInputs"/>
								<label for="noStartNotice">{translate key=ResourceMinLengthNone}</label>
							</div>
							{capture name="txtStartNotice" assign="txtStartNotice"}
								<input type='text' id='startNoticeDays' size='3' class='days form-control' maxlength='3'
									   title='Days' placeholder='{translate key=days}'/>
								<input type='text' id='startNoticeHours' size='2' class='hours form-control'
									   maxlength='2'
									   title='Hours' placeholder='{translate key=hours}'/>
								<input type='text' id='startNoticeMinutes' size='2' class='minutes form-control'
									   maxlength='2' title='Minutes' placeholder='{translate key=minutes}'/>
								<input type='hidden' id='startNotice' class='interval' {formname key=MIN_NOTICE} />
							{/capture}
							<div id='startNoticeInputs'>
								{translate key='ResourceMinNotice' args=$txtStartNotice}
							</div>
						</div>

						<div class="editEndNotice">
							<div class="checkbox">
								<input type="checkbox" id="noEndNotice" data-related-inputs="#endNoticeInputs"/>
								<label for="noEndNotice">{translate key=ResourceMaxNoticeNone}</label>
							</div>
							{capture name="txtEndNotice" assign="endNoticeInputs"}
								<input type='text' id='endNoticeDays' size='3' class='days form-control' maxlength='3'
									   title='Days' placeholder='{translate key=days}'/>
								<input type='text' id='endNoticeHours' size='2' class='hours form-control' maxlength='2'
									   title='Hours' placeholder='{translate key=hours}'/>
								<input type='text' id='endNoticeMinutes' size='2' class='minutes form-control'
									   maxlength='2' title='Minutes' placeholder='{translate key=minutes}'/>
								<input type='hidden' id='endNotice' class='interval' {formname key=MAX_NOTICE} />
							{/capture}
							<div id='endNoticeInputs'>
								{translate key='ResourceMaxNotice' args=$txtEndNotice}
							</div>
						</div>
						<div class="editRequiresApproval">
							<div class="checkbox">
								<input type="checkbox" {formname key=REQUIRES_APPROVAL} id="requiresApproval"/>
								<label for="requiresApproval">{translate key=ResourceRequiresApproval}</label>
							</div>
						</div>

						<div class="editAutoAssign">
							<div class="checkbox">
								<input type="checkbox" {formname key=AUTO_ASSIGN} id="autoAssign"/>
								<label for="autoAssign">{translate key=ResourcePermissionAutoGranted}</label>
							</div>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default"
								data-dismiss="modal">{translate key='Cancel'}</button>
						<button type="button" class="btn btn-success save"><span
									class="glyphicon glyphicon-ok-circle"></span>
							{translate key='Update'}</button>
						{indicator}
					</div>
				</div>
			</div>
		</form>
	</div>

	<div id="statusDialog" class="hide">
		<form class="statusForm" method="post" ajaxAction="{ManageResourcesActions::ActionChangeStatus}">
			<div class="control-group form-group">
				<div class="form-group">
					<label>{translate key=Status}
						<select {formname key=RESOURCE_STATUS_ID} class="statusId form-control">
							<option value="{ResourceStatus::AVAILABLE}">{translate key=Available}</option>
							<option value="{ResourceStatus::UNAVAILABLE}">{translate key=Unavailable}</option>
							<option value="{ResourceStatus::HIDDEN}">{translate key=Hidden}</option>
						</select>
					</label>
				</div>

				<div class="form-group no-show newStatusReason">
					<label>Reason text
						<a href="#" class="pull-right addStatusReason"><span
									class="addStatusIcon fa fa-list-alt icon add"></span></a>
						<input type="text"
							   class="form-control resourceStatusReason" {formname key=RESOURCE_STATUS_REASON} />
					</label>
				</div>
				<div class="form-group existingStatusReason">
					<label>
						{translate key=Reason}
						<a href="#" class="pull-right addStatusReason"><span
									class="addStatusIcon fa fa-plus icon add"></span></a>
						<select {formname key=RESOURCE_STATUS_REASON_ID} class="form-control reasonId"></select>
					</label>
				</div>

			</div>
			<div class="editable-buttons">
				<button type="button" class="btn btn-primary btn-sm editable-submit save"><i
							class="glyphicon glyphicon-ok"></i></button>
				<button type="button" class="btn btn-default btn-sm editable-cancel"><i
							class="glyphicon glyphicon-remove"></i></button>
				{indicator}
			</div>
		</form>
	</div>

	<div id="deletePrompt" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteResourceDialogLabel"
		 aria-hidden="true">
		<form id="deleteForm" method="post" ajaxAction="{ManageResourcesActions::ActionDelete}">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="deleteResourceDialogLabel">{translate key=Delete}</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-warning">
							<div>{translate key=DeleteWarning}</div>
							{translate key=DeleteResourceWarning}:
							<ul>
								<li>{translate key=DeleteResourceWarningReservations}</li>
								<li>{translate key=DeleteResourceWarningPermissions}</li>
							</ul>

							{translate key=DeleteResourceWarningReassign}
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default cancel"
								data-dismiss="modal">{translate key='Cancel'}</button>
						<button type="button" class="btn btn-danger save">{translate key='Delete'}</button>
						{indicator}
					</div>
				</div>
			</div>
		</form>
	</div>

	<div id="bulkUpdateDialog" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="bulkUpdateLabel"
		 aria-hidden="true">
		<form id="bulkUpdateForm" method="post" ajaxAction="{ManageResourcesActions::ActionBulkUpdate}"
			  class="form-vertical"
			  role="form">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="bulkUpdateLabel">{translate key=BulkResourceUpdate}</h4>
					</div>
					<div class="modal-body">
						<div id="bulkUpdateErrors" class="error no-show">
							{async_validator id="bulkAttributeValidator" key=""}
						</div>
						<div id="bulkUpdateList"></div>
						<div>
							<div class="title">{translate key=Common}</div>
							<div class="form-group">
								<label for="bulkEditSchedule" class="control-label">{translate key=MoveToSchedule}
									:</label>
								<select id="bulkEditSchedule" class="form-control" {formname key=SCHEDULE_ID}>
									<option value="-1">{translate key=Unchanged}</option>
									{foreach from=$Schedules item=scheduleName key=scheduleId}
										<option value="{$scheduleId}">{$scheduleName}</option>
									{/foreach}
								</select>
							</div>
							<div class="form-group">
								<label for="bulkEditResourceType" class="control-label">{translate key=ResourceType}
									:</label>
								<select id="bulkEditResourceType" class="form-control" {formname key=RESOURCE_TYPE_ID}>
									<option value="-1">{translate key=Unchanged}</option>
									<option value="">-- {translate key=None} --</option>
									{foreach from=$ResourceTypes item=resourceType key=id}
										<option value="{$id}">{$resourceType->Name()}</option>
									{/foreach}
								</select>
							</div>
							<div class="form-group">
								<label for="bulkEditLocation" class="control-label">{translate key=Location}:</label>
								<input id="bulkEditLocation" type="text" class="form-control"
									   maxlength="85" {formname key=RESOURCE_LOCATION} />
							</div>
							<div class="form-group">
								<label for="bulkEditContact" class="control-label">{translate key=Contact}:</label>
								<input id="bulkEditContact" type="text" class="form-control"
									   maxlength="85" {formname key=RESOURCE_CONTACT} />
							</div>
							<div class="form-group">
								<label for="bulkEditAdminGroupId"
									   class="control-label">{translate key=ResourceAdministrator}:</label>
								<select id="bulkEditAdminGroupId" {formname key=RESOURCE_ADMIN_GROUP_ID}
										class="form-control">
									<option value="-1">{translate key=Unchanged}</option>
									<option value="">-- {translate key=None} --</option>
									{foreach from=$AdminGroups item=adminGroup}
										<option value="{$adminGroup->Id}">{$adminGroup->Name}</option>
									{/foreach}
								</select>
							</div>
							<div class="form-group">
								<label for="bulkEditStatusId" class="control-label">{translate key=Status}:</label>
								<select id="bulkEditStatusId" {formname key=RESOURCE_STATUS_ID} class="form-control">
									<option value="-1">{translate key=Unchanged}</option>
									<option value="{ResourceStatus::AVAILABLE}">{translate key=Available}</option>
									<option value="{ResourceStatus::UNAVAILABLE}">{translate key=Unavailable}</option>
									<option value="{ResourceStatus::HIDDEN}">{translate key=Hidden}</option>
								</select>
							</div>
							<div class="form-group">
								<label for="bulkEditStatusReasonId" class="control-label">{translate key=Reason}
									:</label>
								<select id="bulkEditStatusReasonId" {formname key=RESOURCE_STATUS_REASON_ID}
										class="form-control">
								</select>
							</div>
						</div>
						<div>
							<div class="form-group">
								<label for="bulkEditDescription" class="control-label">{translate key=Description}
									:</label>
								<textarea id="bulkEditDescription"
										  class="form-control" {formname key=RESOURCE_DESCRIPTION}></textarea>
							</div>
							<div class="form-group">
								<label for="bulkEditNotes" class="control-label">{translate key=Notes}:</label>
								<textarea id="bulkEditNotes"
										  class="form-control" {formname key=RESOURCE_NOTES}></textarea>
							</div>
						</div>

						<div class="title">{translate key=Duration}</div>
						<div>
							<div class="form-group">
								<div class="checkbox">
									<input type="checkbox" id="bulkEditNoMinimumDuration"
										   value="1" {formname key=MIN_DURATION_NONE}
										   data-related-inputs="#bulkMinDuration"/>
									<label for="bulkEditNoMinimumDuration">{translate key=ResourceMinLengthNone}</label>
								</div>

								{capture name="txtMinDuration" assign="txtMinDuration"}
									<input type='text' id='bulkEditMinDurationDays' size='3' class='days form-control'
										   maxlength='3' placeholder='{translate key=days}'/>
									<input type='text' id='bulkEditMinDurationHours' size='2' class='hours form-control'
										   maxlength='2' placeholder='{translate key=hours}'/>
									<input type='text' id='bulkEditMinDurationMinutes' size='2'
										   class='minutes form-control'
										   maxlength='2' placeholder='{translate key=minutes}'/>
									<input type='hidden' id='bulkEditMinDuration'
										   class='interval' {formname key=MIN_DURATION} />
								{/capture}
								<div id="bulkMinDuration">{translate key='ResourceMinLength' args=$txtMinDuration}</div>
							</div>
							<div class="form-group">
								<div class="checkbox">
									<input type="checkbox" id="bulkEditNoMaximumDuration"
										   value="1" {formname key=MAX_DURATION_NONE}
										   data-related-inputs="#bulkMaxDuration"/>
									<label for="bulkEditNoMaximumDuration">{translate key=ResourceMaxLengthNone}</label>
								</div>

								{capture name="txtMaxDuration" assign="txtMaxDuration"}
									<input type='text' id='bulkEditMaxDurationDays' size='3'
										   class='days form-control'
										   maxlength='3' placeholder='{translate key=days}'/>
									<input type='text' id='bulkEditMaxDurationHours' size='2'
										   class='hours form-control'
										   maxlength='2' placeholder='{translate key=hours}'/>
									<input type='text' id='bulkEditMaxDurationMinutes' size='2'
										   class='minutes form-control'
										   maxlength='2' placeholder='{translate key=minutes}'/>
									<input type='hidden' id='bulkEditMaxDuration'
										   class='interval' {formname key=MAX_DURATION} />
								{/capture}
								<div id="bulkMaxDuration">{translate key=ResourceMaxLength args=$txtMaxDuration}</div>

							</div>
							<div class="form-group">
								<div class="checkbox">
									<input type="checkbox" id="bulkEditNoBufferTime"
										   value="1" {formname key=BUFFER_TIME_NONE}
										   data-related-inputs="#bulkBufferTime"/>
									<label for="bulkEditNoBufferTime">{translate key=ResourceBufferTimeNone}</label>
								</div>

								{capture name="txtBufferTime" assign="txtBufferTime"}
									<input type='text' id='bulkEditBufferTimeDays' size='3' class='days form-control'
										   maxlength='3' placeholder='{translate key=days}'/>
									<input type='text' id='bulkEditBufferTimeHours' size='2' class='hours form-control'
										   maxlength='2' placeholder='{translate key=hours}'/>
									<input type='text' id='bulkEditBufferTimeMinutes' size='2'
										   class='minutes form-control'
										   maxlength='2' placeholder='{translate key=minutes}'/>
									<input type='hidden' id='bulkEditBufferTime'
										   class='interval' {formname key=BUFFER_TIME} />
								{/capture}
								<div id="bulkBufferTime">
									{translate key=ResourceBufferTime args=$txtBufferTime}
								</div>

							</div>
						</div>

						<div class="title">{translate key=Access}</div>
						<div>
							<div class="form-group">
								<div class="checkbox">
									<input type="checkbox" id="bulkEditNoStartNotice"
										   value="1" {formname key=MIN_NOTICE_NONE}
										   data-related-inputs="#bulkStartNoticeInputs"/>
									<label for="bulkEditNoStartNotice">{translate key=ResourceMinNoticeNone}</label>
								</div>


								{capture name="txtStartNotice" assign="txtStartNotice"}
									<input type='text' id='bulkEditStartNoticeDays' size='3' class='days form-control'
										   maxlength='3' placeholder='{translate key=days}'/>
									<input type='text' id='bulkEditStartNoticeHours' size='2' class='hours form-control'
										   maxlength='2' placeholder='{translate key=hours}'/>
									<input type='text' id='bulkEditStartNoticeMinutes' size='2'
										   class='minutes form-control'
										   maxlength='2' placeholder='{translate key=minutes}'/>
									<input type='hidden' id='bulkEditStartNotice'
										   class='interval' {formname key=MIN_NOTICE} />
								{/capture}
								<div id='bulkStartNoticeInputs'>
									{translate key='ResourceMinNotice' args=$txtStartNotice}
								</div>
							</div>
							<div class="form-group">
								<div class="checkbox">
									<input type="checkbox" id="bulkEditNoEndNotice"
										   value="1" {formname key=MAX_NOTICE_NONE}
										   data-related-inputs="#bulkEndNotice"/>
									<label for="bulkEditNoEndNotice">{translate key=ResourceMaxNoticeNone}</label>
								</div>


								{capture name="txtEndNotice" assign="txtEndNotice"}
									<input type='text' id='bulkEditEndNoticeDays' size='3' class='days form-control'
										   maxlength='3' placeholder='{translate key=days}'/>
									<input type='text' id='bulkEditEndNoticeHours' size='2' class='hours form-control'
										   maxlength='2' placeholder='{translate key=hours}'/>
									<input type='text' id='bulkEditEndNoticeMinutes' size='2'
										   class='minutes form-control'
										   maxlength='2' placeholder='{translate key=minutes}'/>
									<input type='hidden' id='bulkEditEndNotice'
										   class='interval' {formname key=MAX_NOTICE} />
								{/capture}
								<div id="bulkEndNotice">{translate key='ResourceMaxNotice' args=$txtEndNotice}</div>
							</div>
						</div>

						<div class="form-group">
							<label for="bulkEditAllowMultiday"
								   class="control-label">{translate key=ResourceAllowMultiDay}</label>
							<select id="bulkEditAllowMultiday" class="form-control" {formname key=ALLOW_MULTIDAY}>
								{html_options options=$YesNoUnchangedOptions}
							</select>
						</div>

						<div class="form-group">
							<label for="bulkEditRequiresApproval"
								   class="control-label">{translate key='ResourceRequiresApproval'}</label>
							<select id="bulkEditRequiresApproval"
									class="form-control input-sm" {formname key=REQUIRES_APPROVAL}>
								{html_options options=$YesNoUnchangedOptions}
							</select>
						</div>

						<div class="form-group">
							<label for="bulkEditAutoAssign"
								   class="control-label">{translate key='ResourcePermissionAutoGranted'}</label>
							<select id="bulkEditAutoAssign" class="form-control" {formname key=AUTO_ASSIGN}>
								{html_options options=$YesNoUnchangedOptions}
							</select>
						</div>

						<div class="form-group">

							<label for="bulkEditAllowSubscriptions"
								   class="control-label">{translate key='TurnOnSubscription'}</label>
							<select id="bulkEditAllowSubscriptions"
									class="form-control" {formname key=ALLOW_CALENDAR_SUBSCRIPTIONS}>
								{html_options options=$YesNoUnchangedOptions}
							</select>
						</div>

						<div class="title">{translate key=AdditionalAttributes}</div>
						<div>
							{foreach from=$AttributeFilters item=attribute}
								{if !$attribute->UniquePerEntity()}
									<div class="customAttribute">
										{control type="AttributeControl" attribute=$attribute searchmode=true}
									</div>
								{/if}
							{/foreach}
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary save">Save changes</button>
					</div>
				</div>
			</div>
		</form>
	</div>

	{jsfile src="admin/edit.js"}
	{jsfile src="admin/resource.js"}

	<script type="text/javascript">

		function hidePopoversWhenClickAway()
		{
			$('body').on('click', function (e)
			{
				$('[rel="popover"]').each(function ()
				{
					if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0)
					{
						$(this).popover('hide');
					}
				});
			});
		}

		function setUpPopovers()
		{
			$('[rel="popover"]').popover({
				container: 'body',
				html: true,
				placement: 'top',
				content: function ()
				{
					var popoverId = $(this).data('popover-content');
					return $(popoverId).html();
				}
			}).click(function (e)
			{
				e.preventDefault();
			}).on('show.bs.popover', function ()
			{

			}).on('shown.bs.popover', function ()
			{
				var trigger = $(this);
				var popover = trigger.data('bs.popover').tip();
				popover.find('.editable-cancel').click(function ()
				{
					trigger.popover('hide');
				});
			});
		}

		function setUpEditables()
		{
			$.fn.editable.defaults.mode = 'popup';
			$.fn.editable.defaults.toggle = 'manual';
			$.fn.editable.defaults.emptyclass = '';

			var updateUrl = '{$smarty.server.SCRIPT_NAME}?action=';

			$('.resourceName').editable({
				url: updateUrl + '{ManageResourcesActions::ActionRename}',
				validate: function (value)
				{
					if ($.trim(value) == '')
					{
						return '{translate key=RequiredValue}';
					}
				}
			});

			$('.scheduleName').editable({
				url: updateUrl + '{ManageResourcesActions::ActionChangeSchedule}',
				source: [
					{foreach from=$Schedules item=scheduleName key=scheduleId}
					{
						value:{$scheduleId}, text: '{$scheduleName}'
					},
					{/foreach}
				]
			});

			$('.resourceTypeName').editable({
				url: updateUrl + '{ManageResourcesActions::ActionChangeResourceType}',
				emptytext: '{translate key=NoResourceTypeLabel}',
				source: [
					{
						value: '0', text: '' //'-- {translate key=None} --'
					},
					{foreach from=$ResourceTypes item=resourceType key=id}
					{
						value:{$id}, text: '{$resourceType->Name()}'
					},
					{/foreach}
				]
			});

			$('.sortOrderValue').editable({
				url: updateUrl + '{ManageResourcesActions::ActionChangeSort}',
				emptytext: '0',
				min: 0,
				max: 999
			});

			$('.locationValue').editable({
				url: updateUrl + '{ManageResourcesActions::ActionChangeLocation}',
				emptytext: '{translate key='NoLocationLabel'}'
			});

			$('.contactValue').editable({
				url: updateUrl + '{ManageResourcesActions::ActionChangeContact}',
				emptytext: '{translate key='NoContactLabel'}'
			});

			$('.descriptionValue').editable({
				url: updateUrl + '{ManageResourcesActions::ActionChangeDescription}',
				emptytext: '{translate key='NoDescriptionLabel'}'
			});

			$('.notesValue').editable({
				url: updateUrl + '{ManageResourcesActions::ActionChangeNotes}',
				emptytext: '{translate key='NoDescriptionLabel'}'
			});

			$('.resourceAdminValue').editable({
				url: updateUrl + '{ManageResourcesActions::ActionChangeAdmin}',
				emptytext: '{translate key=None}',
				source: [
					{
						value: '0', text: ''
					},
					{foreach from=$AdminGroups item=group key=scheduleId}
					{
						value:{$group->Id()}, text: '{$group->Name()}'
					},
					{/foreach}
				]
			});

			$('.inlineAttribute').editable({
				url: updateUrl + '{ManageResourcesActions::ActionChangeAttribute}',
				emptytext: '-'
			});

		}

		$(document).ready(function ()
		{
			setUpPopovers();

			hidePopoversWhenClickAway();

			setUpEditables();

			var actions = {
				enableSubscription: '{ManageResourcesActions::ActionEnableSubscription}',
				disableSubscription: '{ManageResourcesActions::ActionDisableSubscription}',
				removeImage: '{ManageResourcesActions::ActionRemoveImage}'
			};

			var opts = {
				submitUrl: '{$smarty.server.SCRIPT_NAME}',
				saveRedirect: '{$smarty.server.SCRIPT_NAME}',
				actions: actions
			};

			var resourceManagement = new ResourceManagement(opts);

			{foreach from=$Resources item=resource}
			var resource = {
				id: '{$resource->GetResourceId()}',
				name: "{$resource->GetName()|escape:'javascript'}",
				location: "{$resource->GetLocation()|escape:'javascript'}",
				contact: "{$resource->GetContact()|escape:'javascript'}",
				description: "{$resource->GetDescription()|escape:'javascript'}",
				notes: "{$resource->GetNotes()|escape:'javascript'}",
				autoAssign: '{$resource->GetAutoAssign()}',
				requiresApproval: '{$resource->GetRequiresApproval()}',
				allowMultiday: '{$resource->GetAllowMultiday()}',
				maxParticipants: '{$resource->GetMaxParticipants()}',
				scheduleId: '{$resource->GetScheduleId()}',
				minLength: {},
				maxLength: {},
				startNotice: {},
				endNotice: {},
				bufferTime: {},
				adminGroupId: '{$resource->GetAdminGroupId()}',
				sortOrder: '{$resource->GetSortOrder()}',
				resourceTypeId: '{$resource->GetResourceTypeId()}',
				statusId: '{$resource->GetStatusId()}',
				reasonId: '{$resource->GetStatusReasonId()}',
				allowSubscription: '{$resource->GetIsCalendarSubscriptionAllowed()}'
			};

			{if $resource->HasMinLength()}
			resource.minLength = {
				value: '{$resource->GetMinLength()}',
				days: '{$resource->GetMinLength()->Days()}',
				hours: '{$resource->GetMinLength()->Hours()}',
				minutes: '{$resource->GetMinLength()->Minutes()}'
			};
			{/if}

			{if $resource->HasMaxLength()}
			resource.maxLength = {
				value: '{$resource->GetMaxLength()}',
				days: '{$resource->GetMaxLength()->Days()}',
				hours: '{$resource->GetMaxLength()->Hours()}',
				minutes: '{$resource->GetMaxLength()->Minutes()}'
			};
			{/if}

			{if $resource->HasMinNotice()}
			resource.startNotice = {
				value: '{$resource->GetMinNotice()}',
				days: '{$resource->GetMinNotice()->Days()}',
				hours: '{$resource->GetMinNotice()->Hours()}',
				minutes: '{$resource->GetMinNotice()->Minutes()}'
			};
			{/if}

			{if $resource->HasMaxNotice()}
			resource.endNotice = {
				value: '{$resource->GetMaxNotice()}',
				days: '{$resource->GetMaxNotice()->Days()}',
				hours: '{$resource->GetMaxNotice()->Hours()}',
				minutes: '{$resource->GetMaxNotice()->Minutes()}'
			};
			{/if}

			{if $resource->HasBufferTime()}
			resource.bufferTime = {
				value: '{$resource->GetBufferTime()}',
				days: '{$resource->GetBufferTime()->Days()}',
				hours: '{$resource->GetBufferTime()->Hours()}',
				minutes: '{$resource->GetBufferTime()->Minutes()}'
			};
			{/if}

			resourceManagement.add(resource);
			{/foreach}

			{foreach from=$StatusReasons item=reason}
			resourceManagement.addStatusReason('{$reason->Id()}', '{$reason->StatusId()}', '{$reason->Description()|escape:javascript}');
			{/foreach}

			resourceManagement.init();
			resourceManagement.initializeStatusFilter('{$ResourceStatusFilterId}', '{$ResourceStatusReasonFilterId}');

			$('#filterTable').showHidePanel();
		});

	</script>
</div>

{include file='globalfooter.tpl'}