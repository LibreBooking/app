{*
Copyright 2011-2019 Nick Korbel

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

{include file='globalheader.tpl' InlineEdit=true Owl=true}

<div id="page-manage-resources" class="admin-page">
	<div>
		<div class="dropdown admin-header-more pull-right">
			<button class="btn btn-default" type="button" id="moreResourceActions" data-toggle="dropdown">
                <span class="no-show">More</span>
				<span class="glyphicon glyphicon-option-horizontal"></span>
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu" role="menu" aria-labelledby="moreResourceActions">

				<li role="presentation">
					<a role="menuitem" href="{$Path}admin/manage_resource_groups.php">{translate key="ManageResourceGroups"}</a>
				</li>
				<li role="presentation">
					<a role="menuitem" href="{$Path}admin/manage_resource_types.php">{translate key="ManageResourceTypes"}</a>
				</li>
				<li role="presentation">
					<a role="menuitem" href="{$Path}admin/manage_resource_status.php">{translate key="ManageResourceStatus"}</a>
				</li>
				<li role="presentation" class="divider"></li>
				<li role="presentation">
					<a role="menuitem" href="#" class="import-resources" id="import-resources">
						{translate key="ImportResources"}
						<span class="glyphicon glyphicon-import"></span>
					</a>
				</li>
				<li role="presentation">
					<a role="menuitem" href="{$ExportUrl}" download="{$ExportUrl}" class="export-resources" id="export-resources" target="_blank">
						{translate key="ExportResources"}
						<span class="glyphicon glyphicon-export"></span>
					</a>
				</li>
				<li role="presentation" class="divider"></li>
				<li role="presentation">
					<a role="menuitem" href="#" class="add-resource" id="add-resource">{translate key="AddResource"}
						<span class="fa fa-plus-circle icon add"></span>
					</a>
				</li>
				{if !empty($Resources)}
					<li role="presentation">
						<a role="menuitem" href="#" id="bulkUpdatePromptButton">{translate key=BulkResourceUpdate}</a>
					</li>
				{/if}
                {if !empty($Resources)}
					<li role="presentation">
						<a role="menuitem" href="#" id="bulkDeletePromptButton">{translate key=BulkResourceDelete}</a>
					</li>
				{/if}
			</ul>
		</div>

		<h1>{translate key='ManageResources'}</h1>
	</div>

	<div class="panel panel-default filterTable" id="filter-resources-panel">
        <form id="filterForm" class="horizontal-list" role="form" method="get">
		<div class="panel-heading"><span
					class="glyphicon glyphicon-filter"></span> {translate key="Filter"} {showhide_icon}
		</div>
		<div class="panel-body">

				{assign var=groupClass value="col-xs-12 col-sm-4 col-md-3"}

				<div class="form-group {$groupClass}">
                    <label for="filterResourceName" class="no-show">{translate key=Resource}</label>
					<input type="text" id="filterResourceName" class="form-control" {formname key=RESOURCE_NAME}
						   value="{$ResourceNameFilter}" placeholder="{translate key=Name}"/>
                    <span class="searchclear glyphicon glyphicon-remove-circle" ref="filterResourceName"></span>

                </div>
				<div class="form-group {$groupClass}">
                    <label for="filterScheduleId" class="no-show">{translate key=Schedule}</label>
                    <select id="filterScheduleId" {formname key=SCHEDULE_ID} class="form-control">
						<option value="">{translate key=AllSchedules}</option>
						{object_html_options options=$AllSchedules key='GetId' label="GetName" selected=$ScheduleIdFilter}
					</select>
				</div>

				<div class="form-group {$groupClass}">
                    <label for="filterResourceType" class="no-show">{translate key=ResourceType}</label>
                    <select id="filterResourceType" class="form-control" {formname key=RESOURCE_TYPE_ID}>
						<option value="">{translate key=AllResourceTypes}</option>
						{object_html_options options=$ResourceTypes key='Id' label="Name" selected=$ResourceTypeFilter}
					</select>
				</div>
				<div class="form-group {$groupClass}">
                    <label for="resourceStatusIdFilter" class="no-show">{translate key=ResourceStatus}</label>
                    <select id="resourceStatusIdFilter" style="width:auto;" class="form-control inline" {formname key=RESOURCE_STATUS_ID}>
						<option value="">{translate key=AllResourceStatuses}</option>
						<option value="{ResourceStatus::AVAILABLE}">{translate key=Available}</option>
						<option value="{ResourceStatus::UNAVAILABLE}">{translate key=Unavailable}</option>
						<option value="{ResourceStatus::HIDDEN}">{translate key=Hidden}</option>
					</select>
                    <label for="resourceReasonIdFilter" class="no-show">{translate key=Reason}</label>
                    <select id="resourceReasonIdFilter" style="width:auto;" class="form-control inline" {formname key=RESOURCE_STATUS_REASON_ID}>
						<option value="">-</option>
					</select>
				</div>
				<div class="form-group {$groupClass}">
                    <label for="filterCapacity" class="no-show">{translate key=MinimumCapacity}</label>
                    <input type="number" min="0" id="filterCapacity" class="form-control" {formname key=MAX_PARTICIPANTS}
						   value="{$CapacityFilter}" placeholder="{translate key=MinimumCapacity}"/>
                    <span class="searchclear glyphicon glyphicon-remove-circle" ref="filterCapacity"></span>
                </div>
				<div class="form-group {$groupClass}">
                    <label for="filterRequiresApproval" class="no-show">{translate key=ResourceRequiresApproval}</label>
                    <select id="filterRequiresApproval" class="form-control" {formname key=REQUIRES_APPROVAL} title="{translate key='ResourceRequiresApproval'}">
                        <option value="">{translate key='ResourceRequiresApproval'}</option>
						{html_options options=$YesNoOptions selected=$RequiresApprovalFilter}
					</select>
				</div>
				<div class="form-group {$groupClass}">
                    <label for="filterAutoAssign" class="no-show">{translate key=ResourcePermissionAutoGranted}</label>
                    <select id="filterAutoAssign" class="form-control" {formname key=AUTO_ASSIGN} title="{translate key='ResourcePermissionAutoGranted'}">
						<option value="">{translate key='ResourcePermissionAutoGranted'}</option>
                        {html_options options=$YesNoOptions selected=$AutoPermissionFilter}
					</select>
				</div>
				<div class="form-group {$groupClass}">
                    <label for="filterAllowMultiDay" class="no-show">{translate key=ResourceAllowMultiDay}</label>
                    <select id="filterAllowMultiDay" class="form-control" {formname key=ALLOW_MULTIDAY} title="{translate key=ResourceAllowMultiDay}">
						<option value="">{translate key=ResourceAllowMultiDay}</option>
                        {html_options options=$YesNoOptions selected=$AllowMultiDayFilter}
					</select>
				</div>
				<div class="clearfix"></div>
				{foreach from=$AttributeFilters item=attribute}
					{control type="AttributeControl" idPrefix="search" attribute=$attribute searchmode=true class="customAttribute filter-customAttribute{$attribute->Id()} {$groupClass}"}
				{/foreach}

		</div>
		<div class="panel-footer">
			{filter_button id="filter" class="btn-sm"}
			{reset_button id="clearFilter" class="btn-sm"}
		</div>
        </form>
	</div>

	{pagination pageInfo=$PageInfo showCount=true}

	<div id="globalError" class="error no-show"></div>

	<div class="panel panel-default admin-panel" id="list-resources-panel">
		<div class="panel-heading">{translate key="Resources"}
			<a href="#" class="add-link add-resource pull-right">{translate key="AddResource"}
				<span class="fa fa-plus-circle icon add"></span>
			</a>
		</div>
		<div class="panel-body no-padding" id="resourceList">

			{foreach from=$Resources item=resource}
				{assign var=id value=$resource->GetResourceId()}
				<div class="resourceDetails" data-resourceId="{$id}">
					<div class="col-xs-12 col-sm-5">
						<input type="hidden" class="id" value="{$id}"/>

						<div class="col-sm-3 col-xs-6 resourceImage">
							<div class="margin-bottom-25">
								{if $resource->HasImage()}
								<div class="owl-carousel owl-theme">
									<div class="item">
										<img src="{resource_image image=$resource->GetImage()}" alt="Resource Image" class="image"/>
									</div>
									{foreach from=$resource->GetImages() item=image}
										<div class="item">
											<img src="{resource_image image=$image}" alt="Resource Image" class="image"/>
										</div>
									{/foreach}
								</div>
									<br/>
									<a class="update imageButton" href="#">{translate key='Change'}</a>
								{else}
									<div class="noImage"><span class="fa fa-image"></span></div>
									<a class="update imageButton" href="#">{translate key='AddImage'}</a>
								{/if}
							</div>
							<div>
								{translate key=ResourceColor}
								<input class="resourceColorPicker" type="color"
									   value='{if $resource->HasColor()}{$resource->GetColor()}{else}#ffffff{/if}'
									   alt="{translate key=ResourceColor}"
									   title="{translate key=ResourceColor}"/>
								<a href="#" class="update clearColor">{translate key=Remove}</a>
							</div>
						</div>
						<div class="col-sm-9 col-xs-6">
							<div>
							<span class="title resourceName" data-type="text" data-pk="{$id}"
								  data-name="{FormKeys::RESOURCE_NAME}">{$resource->GetName()}</span>
								<a class="update renameButton" href="#" title="{translate key='Rename'}">
                                    <span class="no-show">{translate key=Rename}</span>
                                    <i
											class="fa fa-pencil-square-o"></i></a> |
								<a class="update copyButton" href="#" title="{translate key='Copy'}">
                                    <span class="no-show">{translate key=Copy}</span>
                                    <i
											class="fa fa-copy"></i></a> |
								<a class="update deleteButton" href="#" title="{translate key='Delete'}">
                                    <span class="no-show">{translate key=Delete}</span>
                                    <i class="fa fa-trash icon delete"></i>
                                </a>
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
								<a class="update changeResourceType" href="#">
                                    <span class="no-show">{translate key=ResourceType}</span>
                                    <span class="fa fa-pencil-square-o"></span>
                                </a>
							</div>
							<div>
								{translate key=SortOrder}
								<span class="propertyValue sortOrderValue"
									  data-type="number" data-pk="{$id}" data-name="{FormKeys::RESOURCE_SORT_ORDER}">
								{$resource->GetSortOrder()|default:"0"}
							</span>
								<a class="update changeSortOrder" href="#">
                                    <span class="no-show">{translate key=SortOrder}</span>
                                    <span class="fa fa-pencil-square-o"></span>
                                </a>
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
								<a class="update changeLocation" href="#">
                                    <span class="no-show">{translate key=Location}</span>
                                    <span class="fa fa-pencil-square-o"></span>
                                </a>
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
								<a class="update changeContact" href="#">
                                    <span class="no-show">{translate key=Contact}</span>
                                    <span class="fa fa-pencil-square-o"></span></a>
							</div>
							<div>
								{translate key='Description'} <a class="update changeDescription" href="#">
                                    <span class="no-show">{translate key=Description}</span>
                                    <span
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
								{translate key='Notes'} <a class="update changeNotes" href="#">
                                    <span class="no-show">{translate key=Notes}</span>
                                    <span class="fa fa-pencil-square-o"></span>
                                </a>
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
									<a class="update changeResourceAdmin" href="#">
                                        <span class="no-show">{translate key=ResourceAdministrator}</span>
                                        <span class="fa fa-pencil-square-o"></span></a>
								{/if}
							</div>
							<div>
								<a href="{$smarty.server.SCRIPT_NAME}?action={ManageResourcesActions::ActionPrintQR}&rid={$id}"
								   target="_blank">{translate key=PrintQRCode} <i class="fa fa-qrcode"></i></a>
							</div>
						</div>
					</div>

					<div class="col-xs-12 col-sm-7">
						<div class="col-sm-6 col-xs-12">
							<h5 class="inline">{translate key=Duration}</h5>
							<a href="#" class="inline update changeDuration">
                                <span class="no-show">{translate key=Duration}</span>
                                <span class="fa fa-pencil-square-o"></span>
							</a>

							<div class="durationPlaceHolder">
								{include file="Admin/Resources/manage_resources_duration.tpl" resource=$resource}
							</div>

                            {if $CreditsEnabled}
                               <div>
                                    <h5 class="inline">{translate key='Credits'}</h5>
                                    <a href="#" class="inline update changeCredits">
                                        <span class="no-show">{translate key=Credits}</span>
                                        <span class="fa fa-pencil-square-o"></span>
                                    </a>
                                    <div class="creditsPlaceHolder">
                                        {include file="Admin/Resources/manage_resources_credits.tpl" resource=$resource}
                                    </div>
                               </div>
                            {/if}

                            <div>
                                <h5 class="inline">{translate key='Capacity'}</h5>
                                <a href="#" class="inline update changeCapacity">
                                    <span class="no-show">{translate key=Capacity}</span>
                                    <span class="fa fa-pencil-square-o"></span>
                                </a>

                                <div class="capacityPlaceHolder">
                                    {include file="Admin/Resources/manage_resources_capacity.tpl" resource=$resource}
                                </div>
                            </div>
						</div>

						<div class="col-sm-6 col-xs-12">
							<h5 class="inline">{translate key=Access}</h5>
							<a href="#" class="inline update changeAccess">
                                <span class="no-show">{translate key=Access}</span>
                                <span class="fa fa-pencil-square-o"></span>
							</a>

							<div class="accessPlaceHolder">
								{include file="Admin/Resources/manage_resources_access.tpl" resource=$resource}
							</div>
						</div>

						<div class="col-sm-6 col-xs-12">
							<h5>{translate key='Permissions'}</h5>
							<a href="#" class="update changeUserPermission">{translate key=Users}</a> |
							<a href="#" class="update changeGroupPermissions">{translate key=Groups}</a>
						</div>

						<div class="col-sm-6 col-xs-12">
							<h5 class="inline">{translate key='ResourceGroups'}</h5>
							<a href="#" class="inline update changeResourceGroups">
                                <span class="no-show">{translate key=ResourceGroups}</span>
                                <span class="fa fa-pencil-square-o"></span>
							</a>

							<div class="resourceGroupsPlaceHolder">
								{include file="Admin/Resources/manage_resources_groups.tpl" resource=$resource}
							</div>
                            <div class="clearfix">&nbsp;</div>
						</div>

                        <div class="col-sm-6 col-xs-12">
                            <h5 class="inline">{translate key='Public'}</h5>
                            <div class="publicSettingsPlaceHolder">
                                {include file="Admin/Resources/manage_resources_public.tpl" resource=$resource}
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">&nbsp;</div>

					</div>

					<div class="clearfix"></div>
					<div class="customAttributes">
						{if $AttributeList|count > 0}
							{foreach from=$AttributeList item=attribute}
								{include file='Admin/InlineAttributeEdit.tpl' id=$id attribute=$attribute value=$resource->GetAttributeValue($attribute->Id())}
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
			  ajaxAction="{ManageResourcesActions::ActionAdd}"  enctype="multipart/form-data">
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
							<select class="form-control" {formname key=AUTO_ASSIGN} id="permissions">
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
                        <label for="resourceImageAdd">{translate key=Image}</label>
                        <div class="dropzone" id="addResourceImage">
                            <div>
                                <span class="fa fa-image fa-3x"></span><br/>
                                {translate key=ChooseOrDropFile}
                            </div>
                            <input id="resourceImageAdd" type="file" {formname key=RESOURCE_IMAGE}
                                   accept="image/*;capture=camera" />
                        </div>
                        <div class="note">.gif, .jpg, or .png</div>
                    </div>
					<div class="modal-footer">
						{cancel_button}
						{add_button}
						{indicator}
					</div>
				</div>
			</div>
		</form>
	</div>

	<input type="hidden" id="activeId" value=""/>

	<div id="imageDialog" class="modal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel"
		 aria-hidden="true">
		<form id="imageForm" method="post" enctype="multipart/form-data" ajaxAction="{ManageResourcesActions::ActionChangeImage}">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="imageModalLabel">{translate key=ResourceImages}</h4>
					</div>
					<div class="modal-body">

						<div id="resource-images">

						</div>
						<div class="clearfix">&nbsp;</div>

                        <label for="resourceImage" class="off-screen no-show">{translate key=Image}</label>
                        <div class="dropzone" id="changeResourceImage">
                            <div class="dropzone-empty">
                                <span class="fa fa-image fa-3x"></span><br/>
                                {translate key=ChooseOrDropFile}
                            </div>
							<div class="dropzone-preview"></div>
                            <input id="resourceImage" type="file" {formname key=RESOURCE_IMAGE}
                                   accept="image/*;capture=camera" />
                        </div>

						<div class="note">.gif, .jpg, .png</div>
					</div>

					<div class="modal-footer">
						{cancel_button key=Done}
						{indicator}
					</div>
				</div>
			</div>
		</form>
	</div>

	<form id="removeImageForm" method="post"  ajaxAction="{ManageResourcesActions::ActionRemoveImage}">
		<input type="hidden" id="removeImageName" {formname key=RESOURCE_IMAGE} />
	</form>

	<form id="defaultImageForm" method="post"  ajaxAction="{ManageResourcesActions::ActionDefaultImage}">
		<input type="hidden" id="defaultImageName" {formname key=RESOURCE_IMAGE} />
	</form>

	<div id="copyDialog" class="modal" tabindex="-1" role="dialog" aria-labelledby="copyModalLabel"
		 aria-hidden="true">
		<form id="copyForm" method="post" enctype="multipart/form-data"
			  ajaxAction="{ManageResourcesActions::ActionCopyResource}">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="copyModalLabel">{translate key=Copy}</h4>
					</div>
					<div class="modal-body">
						<div class="form-group has-feedback">
							<label for="copyResourceName">{translate key='Name'}</label>
							<input type="text" class="form-control required" maxlength="85" id="copyResourceName"
									{formname key=RESOURCE_NAME} />
							<i class="glyphicon glyphicon-asterisk form-control-feedback"
							   data-bv-icon-for="copyResourceName"></i>

						</div>
					</div>

					<div class="modal-footer">
						{cancel_button}
						{add_button}
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
								<input type='number' size='3' id='minDurationDays' class='days form-control inline'
									   maxlength='3'
									   title='Days' max='999' min='0' placeholder='{translate key=days}'/>
								<input type='number' size='2' id='minDurationHours' class='hours form-control inline'
									   maxlength='2'
									   title='Hours' max='99' min='0' placeholder='{translate key=hours}'/>
								<input type='number' size='2' id='minDurationMinutes'
									   class='minutes form-control inline'
									   maxlength='2' title='Minutes' max='99' min='0'
									   placeholder='{translate key=minutes}'/>
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
								<input type='number' id='maxDurationDays' size='3' class='days form-control inline'
									   maxlength='3'
									   title='Days' max='999' min='0' placeholder='{translate key=days}'/>
								<input type='number' id='maxDurationHours' size='2' class='hours form-control inline'
									   maxlength='2'
									   title='Hours' max='99' min='0' placeholder='{translate key=hours}'/>
								<input type='number' id='maxDurationMinutes' size='2'
									   class='minutes form-control inline'
									   maxlength='2' title='Minutes' max='99' min='0'
									   placeholder='{translate key=minutes}'/>
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
								<input type='number' id='bufferTimeDays'
									   size='3' class='days form-control inline'
									   maxlength='3'
									   title='Days' max='999' min='0' placeholder='{translate key=days}'/>
								<input type='number' id='bufferTimeHours'
									   size='2' class='hours form-control inline'
									   maxlength='2'
									   title='Hours' max='99' min='0' placeholder='{translate key=hours}'/>
								<input type='number' id='bufferTimeMinutes'
									   size='2' class='minutes form-control inline'
									   maxlength='2' title='Minutes' max='99' min='0'
									   placeholder='{translate key=minutes}'/>
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
						{cancel_button}
						{update_button}
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
                                    <label for='maxCapacity' class='no-show'>{translate key=Capacity}</label>
									<input type='number' id='maxCapacity' class='form-control inline mid-number' min='0'
										   max='9999' size='5' {formname key=MAX_PARTICIPANTS} />
								{/capture}
								{translate key='ResourceCapacity' args=$txtMaxCapacity}
							</div>
						</div>
					</div>

					<div class="modal-footer">
						{cancel_button}
						{update_button}
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
						<div class="editStartNoticeAdd">
							<div class="checkbox">
								<input type="checkbox" id="noStartNoticeAdd" class="noStartNoticeAdd"
									   data-related-inputs="#startNoticeInputsAdd"/>
								<label for="noStartNoticeAdd">{translate key=ResourceMinNoticeNone}</label>
							</div>
							{capture name="txtStartNoticeAdd" assign="txtStartNoticeAdd"}
								<input type='number' id='startNoticeAddDays' size='3' class='days form-control inline'
									   maxlength='3'
									   title='Days' max='999' min='0' placeholder='{translate key=days}'/>
								<input type='number' id='startNoticeAddHours' size='2' class='hours form-control inline'
									   maxlength='2' max='99' min='0'
									   title='Hours' placeholder='{translate key=hours}'/>
								<input type='number' id='startNoticeAddMinutes' size='2'
									   class='minutes form-control inline'
									   maxlength='2' max='99' min='0' title='Minutes'
									   placeholder='{translate key=minutes}'/>
								<input type='hidden' id='startNoticeAdd' class='interval' {formname key=MIN_NOTICE_ADD} />
							{/capture}
							<div id='startNoticeInputsAdd'>
								{translate key='ResourceMinNotice' args=$txtStartNoticeAdd}
							</div>
						</div>

                        <div class="editStartNoticeUpdate">
							<div class="checkbox">
								<input type="checkbox" id="noStartNoticeUpdate" class="noStartNoticeUpdate"
									   data-related-inputs="#startNoticeInputsUpdate"/>
								<label for="noStartNoticeUpdate">{translate key=ResourceMinNoticeNoneUpdate}</label>
							</div>
							{capture name="txtStartNoticeUpdate" assign="txtStartNoticeUpdate"}
								<input type='number' id='startNoticeUpdateDays' size='3' class='days form-control inline'
									   maxlength='3'
									   title='Days' max='999' min='0' placeholder='{translate key=days}'/>
								<input type='number' id='startNoticeUpdateHours' size='2' class='hours form-control inline'
									   maxlength='2' max='99' min='0'
									   title='Hours' placeholder='{translate key=hours}'/>
								<input type='number' id='startNoticeUpdateMinutes' size='2'
									   class='minutes form-control inline'
									   maxlength='2' max='99' min='0' title='Minutes'
									   placeholder='{translate key=minutes}'/>
								<input type='hidden' id='startNoticeUpdate' class='interval' {formname key=MIN_NOTICE_UPDATE} />
							{/capture}
							<div id='startNoticeInputsUpdate'>
								{translate key='ResourceMinNoticeUpdate' args=$txtStartNoticeUpdate}
							</div>
						</div>

                        <div class="editStartNoticeDelete">
							<div class="checkbox">
								<input type="checkbox" id="noStartNoticeDelete" class="noStartNoticeDelete"
									   data-related-inputs="#startNoticeInputsDelete"/>
								<label for="noStartNoticeDelete">{translate key=ResourceMinNoticeNoneDelete}</label>
							</div>
							{capture name="txtStartNoticeDelete" assign="txtStartNoticeDelete"}
								<input type='number' id='startNoticeDeleteDays' size='3' class='days form-control inline'
									   maxlength='3'
									   title='Days' max='999' min='0' placeholder='{translate key=days}'/>
								<input type='number' id='startNoticeDeleteHours' size='2' class='hours form-control inline'
									   maxlength='2' max='99' min='0'
									   title='Hours' placeholder='{translate key=hours}'/>
								<input type='number' id='startNoticeDeleteMinutes' size='2'
									   class='minutes form-control inline'
									   maxlength='2' max='99' min='0' title='Minutes'
									   placeholder='{translate key=minutes}'/>
								<input type='hidden' id='startNoticeDelete' class='interval' {formname key=MIN_NOTICE_DELETE} />
							{/capture}
							<div id='startNoticeInputsDelete'>
								{translate key='ResourceMinNoticeDelete' args=$txtStartNoticeDelete}
							</div>
						</div>

						<div class="editEndNotice">
							<div class="checkbox">
								<input type="checkbox" id="noEndNotice" data-related-inputs="#endNoticeInputs"/>
								<label for="noEndNotice">{translate key=ResourceMaxNoticeNone}</label>
							</div>
							{capture name="txtEndNotice" assign="txtEndNotice"}
								<input type='number' id='endNoticeDays' size='3' class='days form-control inline'
									   maxlength='3'
									   title='Days' max='999' min='0' placeholder='{translate key=days}'/>
								<input type='number' id='endNoticeHours' size='2' class='hours form-control inline'
									   maxlength='2'
									   title='Hours' max='99' min='0' placeholder='{translate key=hours}'/>
								<input type='number' id='endNoticeMinutes' size='2' class='minutes form-control inline'
									   maxlength='2' max='99' min='0' title='Minutes'
									   placeholder='{translate key=minutes}'/>
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
								<input type="checkbox" {formname key=AUTO_ASSIGN} id="autoAssign" value="1"/>
								<label for="autoAssign">{translate key=ResourcePermissionAutoGranted}</label>
							</div>
						</div>

						<div class="no-show" id="autoAssignRemoveAllPermissions">
							<div class="checkbox">
								<input type="checkbox" {formname key=AUTO_ASSIGN_CLEAR}
									   id="autoAssignRemoveAllPermissionsChk" value="1"/>
								<label for="autoAssignRemoveAllPermissionsChk">{translate key=RemoveExistingPermissions}</label>
							</div>
						</div>

						<div class="editCheckin">
							<div class="checkbox">
								<input type="checkbox" {formname key=ENABLE_CHECK_IN} id="enableCheckIn"/>
								<label for="enableCheckIn">{translate key=RequiresCheckInNotification}</label>
							</div>
							<div class="no-show" id="autoReleaseMinutesDiv">
								{capture name="txtAutoRelease" assign="txtAutoRelease"}
                                    <label for='autoReleaseMinutes' class='no-show'>Auto Release Minutes</label>
									<input type='number' max='99' min='0' id='autoReleaseMinutes'
										   class='minutes form-control inline' {formname key=AUTO_RELEASE_MINUTES} />
								{/capture}
								{translate key='AutoReleaseNotification' args=$txtAutoRelease}
							</div>
						</div>
					</div>

					<div class="modal-footer">
						{cancel_button}
						{update_button}
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
					<label>{translate key=ReasonText}
						<a href="#" class="pull-right addStatusReason">
                            <span class="no-show">{translate key=ReasonText}</span>
                            <span class="addStatusIcon fa fa-list-alt icon add"></span>
                        </a>
						<input type="text"
							   class="form-control resourceStatusReason" {formname key=RESOURCE_STATUS_REASON} />
					</label>
				</div>
				<div class="form-group existingStatusReason">
					<label>
						{translate key=Reason}
						<a href="#" class="pull-right addStatusReason">
                            <span class="no-show">{translate key=Reason}</span>
                            <span class="addStatusIcon fa fa-plus icon add"></span>
                        </a>
						<select {formname key=RESOURCE_STATUS_REASON_ID} class="form-control reasonId"></select>
					</label>
				</div>

			</div>
			<div class="editable-buttons">
				<button type="button" class="btn btn-primary btn-sm editable-submit save">
                    <span class="no-show">{translate key=Save}</span>
                    <i class="glyphicon glyphicon-ok"></i>
                </button>
				<button type="button" class="btn btn-default btn-sm editable-cancel">
                    <span class="no-show">{translate key=Cancel}</span>
                    <i class="glyphicon glyphicon-remove"></i>
                </button>
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
						{cancel_button}
						{delete_button}
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
						<div>{translate key=Select}
							<a href="#" id="checkAllResources">{translate key=All}</a> |
							<a href="#" id="checkNoResources">{translate key=None}</a>
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

                        <div class="title">{translate key=Capacity}</div>
                        <div>
                            <div class="form-group">
                                <div class="checkbox">
                                    <input type="checkbox" id="bulkEditUnlimitedCapacity" class="unlimitedCapacity"
                                           data-related-inputs="#bulkEditMaxCapacityInputs" {formname key=MAX_PARTICIPANTS_UNLIMITED}/>
                                    <label for="bulkEditUnlimitedCapacity">{translate key=ResourceCapacityNone}</label>
                                </div>
                                <div id='bulkEditMaxCapacityInputs'>
                                    {capture name="txtBulkEditMaxCapacity" assign="txtBulkEditMaxCapacity"}
                                        <label for='bulkEditMaxCapacity' class='no-show'>Capacity</label>
                                        <input type='number' id='bulkEditMaxCapacity' class='form-control inline mid-number' min='0'
                                               max='9999' size='5' {formname key=MAX_PARTICIPANTS} />
                                    {/capture}
                                    {translate key='ResourceCapacity' args=$txtBulkEditMaxCapacity}
                                </div>
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
                                    <label for='bulkEditMinDurationDays' class='no-show'>{translate key=days}</label>
                                    <label for='bulkEditMinDurationHours' class='no-show'>{translate key=hours}</label>
                                    <label for='bulkEditMinDurationMinutes' class='no-show'>{translate key=minutes}</label>
									<input type='number' id='bulkEditMinDurationDays' size='3' class='days form-control inline'
										   maxlength='3' min='0' max='999' placeholder='{translate key=days}'/>
									<input type='number' id='bulkEditMinDurationHours' size='2' class='hours form-control inline'
										   maxlength='2' min='0' max='99' placeholder='{translate key=hours}'/>
									<input type='number' id='bulkEditMinDurationMinutes' size='2'
										   class='minutes form-control inline'
										   maxlength='2' min='0' max='99' placeholder='{translate key=minutes}'/>
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
                                    <label for='bulkEditMaxDurationDays' class='no-show'>{translate key=days}</label>
                                    <label for='bulkEditMaxDurationHours' class='no-show'>{translate key=hours}</label>
                                    <label for='bulkEditMaxDurationMinutes' class='no-show'>{translate key=minutes}</label>
									<input type='number' id='bulkEditMaxDurationDays' size='3'
										   class='days form-control inline'
										   maxlength='3' min='0' max='999' placeholder='{translate key=days}'/>
									<input type='number' id='bulkEditMaxDurationHours' size='2'
										   class='hours form-control inline'
										   maxlength='2' min='0' max='99' placeholder='{translate key=hours}'/>
									<input type='number' id='bulkEditMaxDurationMinutes' size='2'
										   class='minutes form-control inline'
										   maxlength='2' min='0' max='99' placeholder='{translate key=minutes}'/>
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
                                    <label for='bulkEditBufferTimeDays' class='no-show'>{translate key=days}</label>
                                    <label for='bulkEditBufferTimeHours' class='no-show'>{translate key=hours}</label>
                                    <label for='bulkEditBufferTimeMinutes' class='no-show'>{translate key=minutes}</label>
									<input type='number' id='bulkEditBufferTimeDays' size='3' class='days form-control inline'
										   maxlength='3' min='0' max='999' placeholder='{translate key=days}'/>
									<input type='number' id='bulkEditBufferTimeHours' size='2' class='hours form-control inline'
										   maxlength='2' min='0' max='99' placeholder='{translate key=hours}'/>
									<input type='number' id='bulkEditBufferTimeMinutes' size='2'
										   class='minutes form-control inline'
										   maxlength='2' min='0' max='99' placeholder='{translate key=minutes}'/>
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
									<input type="checkbox" id="bulkEditNoStartNoticeAdd"
										   value="1" {formname key=MIN_NOTICE_NONE_ADD}
										   data-related-inputs="#bulkStartNoticeInputsAdd"/>
									<label for="bulkEditNoStartNoticeAdd">{translate key=ResourceMinNoticeNone}</label>
								</div>
								{capture name="txtStartNoticeAdd" assign="txtStartNoticeAdd"}
                                    <label for='bulkEditStartNoticeAddDays' class='no-show'>{translate key=days}</label>
                                    <label for='bulkEditStartNoticeAddHours' class='no-show'>{translate key=hours}</label>
                                    <label for='bulkEditStartNoticeAddMinutes' class='no-show'>{translate key=minutes}</label>
									<input type='number' id='bulkEditStartNoticeAddDays' size='3' class='days form-control inline'
										   maxlength='3' min='0' max='999' placeholder='{translate key=days}'/>
									<input type='number' id='bulkEditStartNoticeAddHours' size='2' class='hours form-control inline'
										   maxlength='2' min='0' max='99' placeholder='{translate key=hours}'/>
									<input type='number' id='bulkEditStartNoticeAddMinutes' size='2'
										   class='minutes form-control inline'
										   maxlength='2' min='0' max='99' placeholder='{translate key=minutes}'/>
									<input type='hidden' id='bulkEditStartNoticeAdd'
										   class='interval' {formname key=MIN_NOTICE_ADD} />
								{/capture}
								<div id='bulkStartNoticeInputsAdd'>
									{translate key='ResourceMinNotice' args=$txtStartNoticeAdd}
								</div>
							</div>

                            <div class="form-group">
								<div class="checkbox">
									<input type="checkbox" id="bulkEditNoStartNoticeUpdate"
										   value="1" {formname key=MIN_NOTICE_NONE_UPDATE}
										   data-related-inputs="#bulkStartNoticeInputsUpdate"/>
									<label for="bulkEditNoStartNoticeUpdate">{translate key=ResourceMinNoticeNoneUpdate}</label>
								</div>
								{capture name="txtStartNoticeUpdate" assign="txtStartNoticeUpdate"}
                                    <label for='bulkEditStartNoticeUpdateDays' class='no-show'>{translate key=days}</label>
                                    <label for='bulkEditStartNoticeUpdateHours' class='no-show'>{translate key=hours}</label>
                                    <label for='bulkEditStartNoticeUpdateMinutes' class='no-show'>{translate key=minutes}</label>
									<input type='number' id='bulkEditStartNoticeUpdateDays' size='3' class='days form-control inline'
										   maxlength='3' min='0' max='999' placeholder='{translate key=days}'/>
									<input type='number' id='bulkEditStartNoticeUpdateHours' size='2' class='hours form-control inline'
										   maxlength='2' min='0' max='99' placeholder='{translate key=hours}'/>
									<input type='number' id='bulkEditStartNoticeUpdateMinutes' size='2'
										   class='minutes form-control inline'
										   maxlength='2' min='0' max='99' placeholder='{translate key=minutes}'/>
									<input type='hidden' id='bulkEditStartNoticeUpdate'
										   class='interval' {formname key=MIN_NOTICE_UPDATE} />
								{/capture}
								<div id='bulkStartNoticeInputsUpdate'>
									{translate key='ResourceMinNoticeUpdate' args=$txtStartNoticeUpdate}
								</div>
							</div>

                            <div class="form-group">
								<div class="checkbox">
									<input type="checkbox" id="bulkEditNoStartNoticeDelete"
										   value="1" {formname key=MIN_NOTICE_NONE_DELETE}
										   data-related-inputs="#bulkStartNoticeInputsDelete"/>
									<label for="bulkEditNoStartNoticeDelete">{translate key=ResourceMinNoticeNoneDelete}</label>
								</div>
								{capture name="txtStartNoticeDelete" assign="txtStartNoticeDelete"}
                                    <label for='bulkEditStartNoticeDeleteDays' class='no-show'>{translate key=days}</label>
                                    <label for='bulkEditStartNoticeDeleteHours' class='no-show'>{translate key=hours}</label>
                                    <label for='bulkEditStartNoticeDeleteMinutes' class='no-show'>{translate key=minutes}</label>
									<input type='number' id='bulkEditStartNoticeDeleteDays' size='3' class='days form-control inline'
										   maxlength='3' min='0' max='999' placeholder='{translate key=days}'/>
									<input type='number' id='bulkEditStartNoticeDeleteHours' size='2' class='hours form-control inline'
										   maxlength='2' min='0' max='99' placeholder='{translate key=hours}'/>
									<input type='number' id='bulkEditStartNoticeDeleteMinutes' size='2'
										   class='minutes form-control inline'
										   maxlength='2' min='0' max='99' placeholder='{translate key=minutes}'/>
									<input type='hidden' id='bulkEditStartNoticeDelete'
										   class='interval' {formname key=MIN_NOTICE_DELETE} />
								{/capture}
								<div id='bulkStartNoticeInputsDelete'>
									{translate key='ResourceMinNoticeDelete' args=$txtStartNoticeDelete}
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
                                    <label for='bulkEditEndNoticeDays' class='no-show'>{translate key=days}</label>
                                    <label for='bulkEditEndNoticeHours' class='no-show'>{translate key=hours}</label>
                                    <label for='bulkEditEndNoticeMinutes' class='no-show'>{translate key=minutes}</label>
									<input type='text' id='bulkEditEndNoticeDays' size='3' class='days form-control inline'
										   maxlength='3' placeholder='{translate key=days}'/>
									<input type='text' id='bulkEditEndNoticeHours' size='2' class='hours form-control inline'
										   maxlength='2' placeholder='{translate key=hours}'/>
									<input type='text' id='bulkEditEndNoticeMinutes' size='2'
										   class='minutes form-control inline'
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
							<label for="bulkEditEnableCheckIn" class="control-label">{translate key=RequiresCheckInNotification}</label>
							<select id="bulkEditEnableCheckIn" class="form-control" {formname key=ENABLE_CHECK_IN}>
								{html_options options=$YesNoUnchangedOptions}
							</select>
							<div class="no-show" id="bulkUpdateAutoReleaseMinutesDiv">
								{capture name="bulkEditTxtAutoRelease" assign="bulkEditTxtAutoRelease"}
                                    <label for='bulkEditAutoReleaseMinutes' class='no-show'>Auto Release minutes</label>
									<input type='number' max='99' min='0' id='bulkEditAutoReleaseMinutes'
										   class='minutes form-control inline' {formname key=AUTO_RELEASE_MINUTES} />
								{/capture}
								{translate key='AutoReleaseNotification' args=$bulkEditTxtAutoRelease}
							</div>
						</div>

						<div class="form-group">
							<label for="bulkEditAllowSubscriptions"
								   class="control-label">{translate key='TurnOnSubscription'}</label>
							<select id="bulkEditAllowSubscriptions"
									class="form-control" {formname key=ALLOW_CALENDAR_SUBSCRIPTIONS}>
								{html_options options=$YesNoUnchangedOptions}
							</select>
						</div>

						{if $CreditsEnabled}
							<div class="title">{translate key=Credits}</div>
							<div class="form-group">
								{capture name="bulkEditCreditsPerSLot" assign="bulkEditCreditsPerSLot"}
                                    <label for='bulkEditCreditsPerSlot' class='no-show'>Credits Per Slot</label>
                                    <input type='number' min='0' step='1' id='bulkEditCreditsPerSlot'
										   class='credits form-control inline' {formname key=CREDITS} />
								{/capture}
								{translate key='CreditUsagePerSlot' args=$bulkEditCreditsPerSLot}
							</div>
							<div class="form-group">
								{capture name="bulkEditPeakCreditsPerSlot" assign="bulkEditPeakCreditsPerSlot"}
                                    <label for='bulkEditPeakCreditsPerSlot' class='no-show'>Peak Credits Per Slot</label>
                                    <input type='number' min='0' step='1' id='bulkEditPeakCreditsPerSlot'
										   class='credits form-control inline' {formname key=PEAK_CREDITS} />
								{/capture}
								{translate key='PeakCreditUsagePerSlot' args=$bulkEditPeakCreditsPerSlot}
							</div>
						{/if}

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
						{cancel_button}
						{update_button}
						{indicator}
					</div>
				</div>
			</div>
			{csrf_token}
		</form>
	</div>

    <div id="bulkDeleteDialog" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="bulkDeleteLabel"
         aria-hidden="true">
        <form id="bulkDeleteForm" method="post" ajaxAction="{ManageResourcesActions::ActionBulkDelete}"
              class="form-vertical"
              role="form">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="bulkDeleteLabel">{translate key=BulkResourceDelete}</h4>
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

                        <div>{translate key=Select}
                            <a href="#" id="checkAllDeleteResources">{translate key=All}</a> |
                            <a href="#" id="checkNoDeleteResources">{translate key=None}</a>
                        </div>
                        <div id="bulkDeleteList"></div>
                    </div>
                    <div class="modal-footer">
                        {cancel_button}
                        {delete_button}
                        {indicator}
                    </div>
                </div>
            </div>
            {csrf_token}
        </form>
    </div>

	<div id="userDialog" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="userPermissionDialogLabel"
		 aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="userPermissionDialogLabel">{translate key=Users}</h4>
				</div>
				<div class="modal-body scrollable-modal-content">
					<div class="form-group">
						<label for="userSearch">{translate key=AddUser}</label>
                        <a href="#" id="browseUsers">{translate key=Browse}</a>
						<input type="text" id="userSearch" class="form-control" size="60"/>
					</div>
					<div id="resourceUserList"></div>
				</div>
			</div>
		</div>
	</div>

	<div id="allUsers" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="browseUsersDialogLabel"
		 aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="browseUsersDialogLabel">{translate key=AllUsers}</h4>
				</div>
				<div class="modal-body scrollable-modal-content">
					<div id="allUsersList"></div>
				</div>
			</div>
		</div>
	</div>

	<form id="changeUserForm" method="post" ajaxAction="{ManageResourcesActions::ActionChangeUserPermission}">
		<input type="hidden" id="changeUserId" {formname key=USER_ID} />
        <input type="hidden" id="changeUserType" {formname key=PERMISSION_TYPE} />
	</form>

	<div id="groupDialog" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="browseGroupsDialogLabel"
		 aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="browseGroupsDialogLabel">{translate key=AllGroups}</h4>
				</div>
				<div class="modal-body scrollable-modal-content">
					<div class="form-group">
						<label for="groupSearch">{translate key=AddGroup}</label>
                        <a href="#" id="browseGroups">{translate key=AllGroups}</a>
						<input type="text" id="groupSearch" class="form-control" size="60"/>
					</div>

					<div id="resourceGroupList"></div>
				</div>
			</div>
		</div>
	</div>

	<div id="allGroups" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="groupPermissionDialogLabel"
		 aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="groupPermissionDialogLabel">{translate key=Groups}</h4>
				</div>
				<div class="modal-body scrollable-modal-content">
					<div id="allGroupsList"></div>
				</div>
			</div>
		</div>
	</div>

    <form id="changeGroupForm" method="post" ajaxAction="{ManageResourcesActions::ActionChangeGroupPermission}">
		<input type="hidden" id="changeGroupId" {formname key=GROUP_ID} />
		<input type="hidden" id="changeGroupType" {formname key=PERMISSION_TYPE} />
	</form>

	<div class="modal fade" id="resourceGroupDialog" tabindex="-1" role="dialog"
		 aria-labelledby="resourceGroupsModalLabel"
		 aria-hidden="true">
		<form id="resourceGroupForm" method="post" ajaxAction="{ManageResourcesActions::ActionChangeResourceGroups}">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="resourceGroupsModalLabel">{translate key=ResourceGroups}</h4>
					</div>
					<div class="modal-body scrollable-modal-content">
						<div id="resourceGroups">{translate key=None}</div>
					</div>
					<div class="modal-footer">
						{cancel_button}
						{update_button}
						{indicator}
					</div>
				</div>
			</div>
		</form>
	</div>

	<form id="colorForm" method="post" ajaxAction="{ManageResourcesActions::ActionChangeColor}">
		<input type="hidden" id="reservationColor" {formname key=RESERVATION_COLOR} />
	</form>

	<div id="creditsDialog" class="modal" tabindex="-1" role="dialog" aria-labelledby="creditsModalLabel"
		 aria-hidden="true">
		<form id="creditsForm" method="post" role="form" ajaxAction="{ManageResourcesActions::ActionChangeCredits}">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="creditsModalLabel">{translate key=Credits}</h4>
					</div>
					<div class="modal-body">
						<div>
							{capture name="creditsPerSLot" assign="creditsPerSLot"}
                                <label for='creditsPerSlot' class='no-show'>Credits Per Slot</label>
								<input type='number' min='0' step='1' id='creditsPerSlot'
									   class='credits form-control inline' {formname key=CREDITS} />
							{/capture}
							{translate key='CreditUsagePerSlot' args=$creditsPerSLot}
						</div>

						<div>
							{capture name="peakCreditsPerSlot" assign="peakCreditsPerSlot"}
                                <label for='peakCreditsPerSlot' class='no-show'>Peak Credits Per Slot</label>
                                <input type='number' min='0' step='1' id='peakCreditsPerSlot'
									   class='credits form-control inline' {formname key=PEAK_CREDITS} />
							{/capture}
							{translate key='PeakCreditUsagePerSlot' args=$peakCreditsPerSlot}
						</div>
					</div>

					<div class="modal-footer">
						{cancel_button}
						{update_button}
						{indicator}
					</div>
				</div>
			</div>
		</form>
	</div>

	<div id="importDialog" class="modal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel"
         aria-hidden="true">
        <form id="importForm" class="form" role="form" method="post" enctype="multipart/form-data"
              ajaxAction="{ManageResourcesActions::ImportResources}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="importModalLabel">{translate key=Import}</h4>
                    </div>
                    <div class="modal-body">
                        <div id="importResults" class="validationSummary alert alert-danger no-show">
                            <ul>
                                {async_validator id="fileExtensionValidator" key=""}
                            </ul>
                        </div>
                        <div id="importErrors" class="alert alert-danger no-show"></div>
                        <div id="importResult" class="alert alert-success no-show">
                            <span>{translate key=RowsImported}</span>

                            <div id="importCount" class="inline bold">0</div>
                            <span>{translate key=RowsSkipped}</span>

                            <div id="importSkipped" class="inline bold">0</div>
                            <a class="" href="{$smarty.server.SCRIPT_NAME}">{translate key=Done}</a>
                        </div>
                        <div class="margin-bottom-25">
                            <label for="resourceImportFile" class="no-show">Resource Import File</label>
                            <input type="file" {formname key=RESOURCE_IMPORT_FILE} id="resourceImportFile" />
                            <div class="checkbox">
                                <input type="checkbox" id="updateOnImport" {formname key=UPDATE_ON_IMPORT}/>
                                <label for="updateOnImport">{translate key=UpdateResourcesOnImport}</label>
                            </div>
                        </div>
                        <div id="importInstructions" class="alert alert-info">
                            <div class="note">{translate key=ResourceImportInstructions}</div>
                            <a href="{$smarty.server.SCRIPT_NAME}?dr=template" download="{$smarty.server.SCRIPT_NAME}?dr=template"
                               target="_blank">{translate key=GetTemplate} <span class="fa fa-download"></span></a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {cancel_button}
                        {add_button key=Import}
                        {indicator}
                    </div>
                </div>
            </div>
        </form>
    </div>

	{csrf_token}

    {include file="javascript-includes.tpl" InlineEdit=true Owl=true Clear=true}
	{jsfile src="ajax-helpers.js"}
	{jsfile src="autocomplete.js"}
	{jsfile src="js/tree.jquery.js"}
	{jsfile src="admin/resource.js"}
	{jsfile src="dropzone.js"}

	<script type="text/javascript">

		function hidePopoversWhenClickAway() {
			$('body').on('click', function (e) {
				$('[rel="popover"]').each(function () {
					if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0)
					{
						$(this).popover('hide');
					}
				});
			});
		}

		function setUpPopovers() {
			$('[rel="popover"]').popover({
				container: 'body', html: true, placement: 'top', content: function () {
					var popoverId = $(this).data('popover-content');
					return $(popoverId).html();
				}
			}).click(function (e) {
				e.preventDefault();
			}).on('show.bs.popover', function () {

			}).on('shown.bs.popover', function () {
				var trigger = $(this);
				var popover = trigger.data('bs.popover').tip();
				popover.find('.editable-cancel').click(function () {
					trigger.popover('hide');
				});
			});
		}

		function setUpEditables() {
			$.fn.editable.defaults.mode = 'popup';
			$.fn.editable.defaults.toggle = 'manual';
			$.fn.editable.defaults.emptyclass = '';
			$.fn.editable.defaults.params = function (params) {
				params.CSRF_TOKEN = $('#csrf_token').val();
				return params;
			};

			var updateUrl = '{$smarty.server.SCRIPT_NAME}?action=';

			$('.resourceName').editable({
				url: updateUrl + '{ManageResourcesActions::ActionRename}', validate: function (value) {
					if ($.trim(value) == '')
					{
						return '{translate key=RequiredValue}';
					}
				}
			});

			$('.scheduleName').editable({
				url: updateUrl + '{ManageResourcesActions::ActionChangeSchedule}', source: [
					{foreach from=$Schedules item=scheduleName key=scheduleId}
					{
						value:{$scheduleId}, text: '{$scheduleName|escape:'javascript'}'
					},
					{/foreach}
				]
			});

			$('.resourceTypeName').editable({
				url: updateUrl + '{ManageResourcesActions::ActionChangeResourceType}',
				emptytext: '{{translate key=NoResourceTypeLabel}|escape:'javascript'}',
				source: [{
					value: '0', text: '' //'-- {translate key=None} --'
				},
					{foreach from=$ResourceTypes item=resourceType key=id}
					{
						value:{$id}, text: '{$resourceType->Name()|escape:'javascript'}'
					},
					{/foreach}
				]
			});

			$('.sortOrderValue').editable({
				url: updateUrl + '{ManageResourcesActions::ActionChangeSort}', emptytext: '0', min: 0, max: 999
			});

			$('.locationValue').editable({
				url: updateUrl + '{ManageResourcesActions::ActionChangeLocation}', emptytext: '{{translate key='NoLocationLabel'}|escape:'javascript'}'
			});

			$('.contactValue').editable({
				url: updateUrl + '{ManageResourcesActions::ActionChangeContact}', emptytext: '{{translate key='NoContactLabel'}|escape:'javascript'}}'
			});

			$('.descriptionValue').editable({
				url: updateUrl + '{ManageResourcesActions::ActionChangeDescription}', emptytext: '{{translate key='NoDescriptionLabel'}|escape:'javascript'}'
			});

			$('.notesValue').editable({
				url: updateUrl + '{ManageResourcesActions::ActionChangeNotes}', emptytext: '{{translate key='NoDescriptionLabel'}|escape:'javascript'}'
			});

			$('.resourceAdminValue').editable({
				url: updateUrl + '{ManageResourcesActions::ActionChangeAdmin}', emptytext: '{{translate key=None}|escape:'javascript'}', source: [{
					value: '0', text: ''
				},
					{foreach from=$AdminGroups item=group key=scheduleId}
					{
						value:{$group->Id()}, text: '{$group->Name()|escape:'javascript'}'
					},
					{/foreach}
				]
			});

			$('.inlineAttribute').editable({
				url: updateUrl + '{ManageResourcesActions::ActionChangeAttribute}', emptytext: '-'
			});

		}

		$(document).ready(function () {
			setUpPopovers();
			hidePopoversWhenClickAway();
			setUpEditables();

            dropzone($("#addResourceImage"));
            dropzone($("#changeResourceImage"), {
				autoSubmit: true
            });

			var actions = {
				enableSubscription: '{ManageResourcesActions::ActionEnableSubscription}',
				disableSubscription: '{ManageResourcesActions::ActionDisableSubscription}'
			};

			var opts = {
				submitUrl: '{$smarty.server.SCRIPT_NAME}',
				saveRedirect: '{$smarty.server.SCRIPT_NAME}',
				actions: actions,
				userAutocompleteUrl: "../ajax/autocomplete.php?type={AutoCompleteType::User}",
				groupAutocompleteUrl: "../ajax/autocomplete.php?type={AutoCompleteType::Group}",
				permissionsUrl: '{$smarty.server.SCRIPT_NAME}',
				copyText: '{{translate key=Copy}|escape:"javascript"}'
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
				startNoticeAdd: {},
                startNoticeUpdate: {},
                startNoticeDelete: {},
				endNotice: {},
				bufferTime: {},
				adminGroupId: '{$resource->GetAdminGroupId()}',
				sortOrder: '{$resource->GetSortOrder()}',
				resourceTypeId: '{$resource->GetResourceTypeId()}',
				statusId: '{$resource->GetStatusId()}',
				reasonId: '{$resource->GetStatusReasonId()}',
				allowSubscription: '{$resource->GetIsCalendarSubscriptionAllowed()}',
				enableCheckin: '{$resource->IsCheckInEnabled()}',
				autoReleaseMinutes: '{$resource->GetAutoReleaseMinutes()}',
				credits: '{$resource->GetCreditsPerSlot()}',
				peakCredits: '{$resource->GetPeakCreditsPerSlot()}'
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

			{if $resource->HasMinNoticeAdd()}
			resource.startNoticeAdd = {
				value: '{$resource->GetMinNoticeAdd()}',
				days: '{$resource->GetMinNoticeAdd()->Days()}',
				hours: '{$resource->GetMinNoticeAdd()->Hours()}',
				minutes: '{$resource->GetMinNoticeAdd()->Minutes()}'
			};
			{/if}

            {if $resource->HasMinNoticeUpdate()}
			resource.startNoticeUpdate = {
				value: '{$resource->GetMinNoticeUpdate()}',
				days: '{$resource->GetMinNoticeUpdate()->Days()}',
				hours: '{$resource->GetMinNoticeUpdate()->Hours()}',
				minutes: '{$resource->GetMinNoticeUpdate()->Minutes()}'
			};
			{/if}

            {if $resource->HasMinNoticeDelete()}
			resource.startNoticeDelete = {
				value: '{$resource->GetMinNoticeDelete()}',
				days: '{$resource->GetMinNoticeDelete()->Days()}',
				hours: '{$resource->GetMinNoticeDelete()->Hours()}',
				minutes: '{$resource->GetMinNoticeDelete()->Minutes()}'
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

			resource.image = null;
			{if ($resource->HasImage())}
				resource.image = '{resource_image image=$resource->GetImage()}';
			{/if}

			resource.images = [];
			{foreach from=$resource->GetImages() item=image}
				resource.images.push('{resource_image image=$image}');
			{/foreach}

			resource.resourceGroupIds = [{$resource->GetResourceGroupIds()|join:','}];

			resourceManagement.add(resource);
			{/foreach}

			{foreach from=$StatusReasons item=reason}
			resourceManagement.addStatusReason('{$reason->Id()}', '{$reason->StatusId()}', '{$reason->Description()|escape:javascript}');
			{/foreach}

			resourceManagement.init();
			resourceManagement.initializeStatusFilter('{$ResourceStatusFilterId}', '{$ResourceStatusReasonFilterId}');
			resourceManagement.addResourceGroups({$ResourceGroups});

			$('#filter-resources-panel').showHidePanel();

			$(".owl-carousel").owlCarousel({
				items:1
			});
		});

	</script>
</div>

{include file='globalfooter.tpl'}