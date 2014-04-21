{*
Copyright 2011-2014 Nick Korbel

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

{include file='globalheader.tpl' cssFiles='css/admin.css,scripts/css/colorbox.css'}

<h1>{translate key='ManageResources'}</h1>

<div class="horizontal-list label-top filterTable main-div-shadow" id="filterTable">
	<form id="filterForm">
		<div class="main-div-header">{translate key=Filter}</div>
		<ul>
			<li>
				<label for="filterResourceName">{translate key=Name}</label>
				<input type="text" id="filterResourceName" class="textbox" {formname key=RESOURCE_NAME}
					   value="{$ResourceNameFilter}"/ />
			</li>
			<li>
				<label for="filterScheduleId">{translate key=Schedule}</label>
				<select id="filterScheduleId" {formname key=SCHEDULE_ID} class="textbox">
					<option value="">{translate key=AllSchedules}</option>
					{object_html_options options=$AllSchedules key='GetId' label="GetName" selected=$ScheduleIdFilter}
				</select>
			</li>

			<li>
				<label for="filterResourceType">{translate key=ResourceType}</label>
				<select id="filterResourceType" class="textbox" {formname key=RESOURCE_TYPE_ID}>
					<option value="">{translate key=All}</option>
					{object_html_options options=$ResourceTypes key='Id' label="Name" selected=$ResourceTypeFilter}
				</select>
			</li>
			<li>
				<label for="resourceStatusIdFilter">{translate key=ResourceStatus}</label>
				<select id="resourceStatusIdFilter" class="textbox" {formname key=RESOURCE_STATUS_ID}>
					<option value="">{translate key=All}</option>
					<option value="{ResourceStatus::AVAILABLE}">{translate key=Available}</option>
					<option value="{ResourceStatus::UNAVAILABLE}">{translate key=Unavailable}</option>
					<option value="{ResourceStatus::HIDDEN}">{translate key=Hidden}</option>
				</select>
			</li>
			<li>
				<label for="resourceReasonIdFilter">{translate key=Reason}</label>
				<select id="resourceReasonIdFilter" class="textbox" {formname key=RESOURCE_STATUS_REASON_ID}>
					<option value="">-</option>
				</select>
			</li>
			<li>
				<label for="filterCapacity">{translate key=MinimumCapacity}</label>
				<input type="text" id="filterCapacity" class="textbox" {formname key=MAX_PARTICIPANTS}
					   value="{$CapacityFilter}"/>
			</li>
			<li>
				<label for="filterRequiresApproval">{translate key='ResourceRequiresApproval'}</label>
				<select id="filterRequiresApproval" class="textbox" {formname key=REQUIRES_APPROVAL}>
					{html_options options=$YesNoOptions selected=$RequiresApprovalFilter}
				</select>
			</li>
			<li>
				<label for="filterAutoAssign">{translate key='ResourcePermissionAutoGranted'}</label>
				<select id="filterAutoAssign" class="textbox" {formname key=AUTO_ASSIGN}>
					{html_options options=$YesNoOptions selected=$AutoPermissionFilter}
				</select>
			</li>
			<li>
				<label for="filterAllowMultiDay">{translate key=ResourceAllowMultiDay}</label>
				<select id="filterAllowMultiDay" class="textbox" {formname key=ALLOW_MULTIDAY}>
					{html_options options=$YesNoOptions selected=$AllowMultiDayFilter}
				</select>
			</li>
			{foreach from=$AttributeFilters item=attribute}
				<li class="customAttribute">
					{control type="AttributeControl" attribute=$attribute searchmode=true}
				</li>
			{/foreach}
		</ul>
	</form>

	<div class="clear">&nbsp;</div>
	<div id="adminFilterButtons">
		<button id="filter" class="button">{html_image src="search.png"} {translate key=Filter}</button>
		<a href="#" id="clearFilter">{translate key=Reset}</a>
	</div>
</div>

{if !empty($Resources)}
	<div>
		<a href="#" id="bulkUpdatePromptButton"
		   class="">{html_image src="ui-check-boxes.png"} {translate key=BulkResourceUpdate}</a>
	</div>
{/if}

{pagination pageInfo=$PageInfo}

<div id="globalError" class="error" style="display:none"></div>
<div class="admin" style="margin-top:10px;">

{foreach from=$Resources item=resource}
	{assign var=id value=$resource->GetResourceId()}
	<div class="resourceDetails" resourceId="{$id}">
	<div style="float:left;max-width:50%;">
		<input type="hidden" class="id" value="{$id}"/>

		<div style="float:left; text-align:center; width:110px;">
			{if $resource->HasImage()}
				<img src="{resource_image image=$resource->GetImage()}" alt="Resource Image" class="image"/>
				<br/>
				<a class="update imageButton" href="javascript: void(0);">{translate key='Change'}</a>
				|
				<a class="update removeImageButton" href="javascript: void(0);">{translate key='Remove'}</a>
			{else}
				<div class="noImage">{translate key='NoImage'}</div>
				<a class="update imageButton" href="javascript: void(0);">{translate key='AddImage'}</a>
			{/if}
		</div>
		<div style="float:right;">
			<ul>
				<li>
					<h4>{$resource->GetName()|escape}</h4>
					<a class="update renameButton" href="javascript:void(0);">{translate key='Rename'}</a> |
					<a class="update deleteButton" href="javascript:void(0);">{translate key='Delete'}</a>
				</li>
				<li>
					{translate key='Status'}
					{if $resource->IsAvailable()}
						{html_image src="status.png"}
						<a class="update changeStatus"
						   href="javascript: void(0);">{translate key='Available'}</a>
					{elseif $resource->IsUnavailable()}
						{html_image src="status-away.png"}
						<a class="update changeStatus"
						   href="javascript: void(0);">{translate key='Unavailable'}</a>
					{else}
						{html_image src="status-busy.png"}
						<a class="update changeStatus"
						   href="javascript: void(0);">{translate key='Hidden'}</a>
					{/if}
					{if array_key_exists($resource->GetStatusReasonId(),$StatusReasons)}
						<span class="resourceValue">{$StatusReasons[$resource->GetStatusReasonId()]->Description()}</span>
					{/if}
				</li>

				<li>
					{translate key='Schedule'} <span
							class="resourceValue">{$Schedules[$resource->GetScheduleId()]}</span>
					<a class="update changeScheduleButton" href="javascript: void(0);">{translate key='Move'}</a>
				</li>
				<li>
					{translate key='ResourceType'}
					{if $resource->HasResourceType()}
						<span class="resourceValue">{$ResourceTypes[$resource->GetResourceTypeId()]->Name()}</span>
					{else}
						<span class="note">{translate key='NoResourceTypeLabel'}</span>
					{/if}
					<a class="update changeResourceType" href="javascript: void(0);">{translate key='Edit'}</a>
				</li>
				<li>
					{translate key=SortOrder}
					<span class="resourceValue">{$resource->GetSortOrder()|default:"-"}</span>
					<a class="update changeSortOrder" href="javascript: void(0);">{translate key='Edit'}</a>
				</li>
				<li>
					{translate key='Location'}
					{if $resource->HasLocation()}
						<span class="resourceValue">{$resource->GetLocation()}</span>
					{else}
						<span class="note">{translate key='NoLocationLabel'}</span>
					{/if}
					<a class="update changeLocationButton" href="javascript: void(0);">{translate key='Edit'}</a>
				</li>
				<li>
					{translate key='Contact'}
					{if $resource->HasContact()}
						<span class="resourceValue">{$resource->GetContact()}</span>
					{else}
						<span class="note">{translate key='NoContactLabel'}</span>
					{/if}
				</li>
				<li>
					{translate key='Description'}
					{if $resource->HasDescription()}
						<span class="resourceValue">{$resource->GetDescription()|truncate:500:"..."}</span>
					{else}
						<span class="note">{translate key='NoDescriptionLabel'}</span>
					{/if}
					<a class="update descriptionButton" href="javascript: void(0);">{translate key='Edit'}</a>
				</li>
				<li>
					{translate key='Notes'}
					{if $resource->HasNotes()}
						<span class="resourceValue">{$resource->GetNotes()|truncate:500:"..."}</span>
					{else}
						<span class="note">{translate key='NoNotesLabel'}</span>
					{/if}
					<a class="update notesButton" href="javascript: void(0);">{translate key='Edit'}</a>
				</li>
				<li>
					{translate key='ResourceAdministrator'}
					{if $resource->HasAdminGroup()}
						<span class="resourceValue">{$GroupLookup[$resource->GetAdminGroupId()]->Name}</span>
					{else}
						<span class="note">{translate key='NoResourceAdministratorLabel'}</span>
					{/if}
					{if $AdminGroups|count > 0}
						<a class="update adminButton" href="javascript: void(0);">{translate key='Edit'}</a>
					{/if}
				</li>
				<li>
					{if $resource->GetIsCalendarSubscriptionAllowed()}
						<a class="update disableSubscription"
						   href="javascript: void(0);">{translate key=TurnOffSubscription}</a>
					{else}
						<a class="update enableSubscription"
						   href="javascript: void(0);">{translate key=TurnOnSubscription}</a>
					{/if}
				</li>
			</ul>
		</div>
	</div>
	<div style="float:right;">
		<div>
			<h5>{translate key='UsageConfiguration'}</h5> <a class="update changeConfigurationButton"
															 href="javascript: void(0);">{translate key='ChangeConfiguration'}</a>
		</div>
		<div style="float:left;width:400px;">
			<ul>
				<li>
					{if $resource->HasMinLength()}
						{translate key='ResourceMinLength' args=$resource->GetMinLength()}
					{else}
						{translate key='ResourceMinLengthNone'}
					{/if}
				</li>
				<li>
					{if $resource->HasMaxLength()}
						{translate key='ResourceMaxLength' args=$resource->GetMaxLength()}
					{else}
						{translate key='ResourceMaxLengthNone'}
					{/if}
				</li>
				<li>
					{if $resource->GetRequiresApproval()}
						{translate key='ResourceRequiresApproval'}
					{else}
						{translate key='ResourceRequiresApprovalNone'}
					{/if}
				</li>
				<li>
					{if $resource->GetAutoAssign()}
						{translate key='ResourcePermissionAutoGranted'}
					{else}
						{translate key='ResourcePermissionNotAutoGranted'}
					{/if}
				</li>
			</ul>
		</div>

		<div style="float:right;width:400px;">
			<ul>
				<li>
					{if $resource->HasMinNotice()}
						{translate key='ResourceMinNotice' args=$resource->GetMinNotice()}
					{else}
						{translate key='ResourceMinNoticeNone'}
					{/if}
				</li>
				<li>
					{if $resource->HasMaxNotice()}
						{translate key='ResourceMaxNotice' args=$resource->GetMaxNotice()}
					{else}
						{translate key='ResourceMaxNoticeNone'}
					{/if}
				</li>
				<li>
					{if $resource->HasBufferTime()}
						{translate key='ResourceBufferTime' args=$resource->GetBufferTime()}
					{else}
						{translate key='ResourceBufferTimeNone'}
					{/if}
				</li>
				<li>
					{if $resource->GetAllowMultiday()}
						{translate key='ResourceAllowMultiDay'}
					{else}
						{translate key='ResourceNotAllowMultiDay'}
					{/if}
				</li>
				<li>
					{if $resource->HasMaxParticipants()}
						{translate key='ResourceCapacity' args=$resource->GetMaxParticipants()}
					{else}
						{translate key='ResourceCapacityNone'}
					{/if}
				</li>
			</ul>
		</div>
	</div>
	{assign var=attributes value=$AttributeList->GetAttributes($id)}
	{if $attributes|count > 0}
		<div class="customAttributes">
			<form method="post" class="attributesForm" ajaxAction="{ManageResourcesActions::ActionChangeAttributes}">
				<h3>{translate key=AdditionalAttributes} <a href="#"
															class="update changeAttributes">{translate key=Edit}</a>
				</h3>

				<div class="validationSummary">
					<ul>
					</ul>
					<div class="clear">&nbsp;</div>
				</div>
				<ul>
					{foreach from=$attributes item=attribute}
						<li class="customAttribute" attributeId="{$attribute->Id()}">
							<div class="attribute-readonly">{control type="AttributeControl" attribute=$attribute readonly=true}</div>
							<div class="attribute-readwrite hidden">{control type="AttributeControl" attribute=$attribute}
						</li>
					{/foreach}
				</ul>
				<div class="attribute-readwrite hidden clear">
					<button type="button"
							class="button save">{html_image src="tick-circle.png"} {translate key='Update'}</button>
					<button type="button"
							class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
				</div>
			</form>
		</div>
		<div class="clear">&nbsp;</div>
	{/if}
	<div class="actions">&nbsp;</div>
	</div>
{/foreach}
</div>

{pagination pageInfo=$PageInfo}

<div class="admin" style="margin-top:30px">
	<div class="title">
		{translate key='AddNewResource'}
	</div>
	<div>
		<div id="addResourceResults" class="error" style="display:none;"></div>
		<form id="addResourceForm" method="post" ajaxAction="{ManageResourcesActions::ActionAdd}">
			<table>
				<tr>
					<th>{translate key='Name'}</th>
					<th>{translate key='Schedule'}</th>
					<th>{translate key='ResourcePermissions'}</th>
					<th>{translate key='ResourceAdministrator'}</th>
					<th>&nbsp;</th>
				</tr>
				<tr>
					<td><input type="text" class="textbox required" maxlength="85"
							   style="width:250px" {formname key=RESOURCE_NAME} />
					</td>
					<td>
						<select class="textbox" {formname key=SCHEDULE_ID} style="width:100px">
							{foreach from=$Schedules item=scheduleName key=scheduleId}
								<option value="{$scheduleId}">{$scheduleName}</option>
							{/foreach}
						</select>
					</td>
					<td>
						<select class="textbox" {formname key=AUTO_ASSIGN} style="width:170px">
							<option value="0">{translate key="ResourcePermissionNotAutoGranted"}</option>
							<option value="1">{translate key="ResourcePermissionAutoGranted"}</option>
						</select>
					</td>
					<td>
						<select class="textbox" {formname key=RESOURCE_ADMIN_GROUP_ID} style="width:170px">
							<option value="">{translate key=None}</option>
							{foreach from=$AdminGroups item=adminGroup}
								<option value="{$adminGroup->Id}">{$adminGroup->Name}</option>
							{/foreach}
						</select>
					</td>
					<td>
						<button type="button"
								class="button save">{html_image src="plus-button.png"} {translate key='AddResource'}</button>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>

<input type="hidden" id="activeId" value="" />

<div id="imageDialog" class="dialog" title="{translate key=AddImage}">
	<form id="imageForm" method="post" enctype="multipart/form-data"
		  ajaxAction="{ManageResourcesActions::ActionChangeImage}">
		<input id="resourceImage" type="file" class="text" size="60" {formname key=RESOURCE_IMAGE} />
		<br/>
		<span class="note">.gif, .jpg, or .png</span>

		<div class="admin-update-buttons">
			<button type="button"
					class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
			<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
		</div>
	</form>
</div>

<div id="renameDialog" class="dialog" title="{translate key=Rename}">
	<form id="renameForm" method="post" ajaxAction="{ManageResourcesActions::ActionRename}">
		{translate key='Name'}: <input id="editName" type="text" class="textbox required" maxlength="85"
									   style="width:250px" {formname key=RESOURCE_NAME} />

		<div class="admin-update-buttons">
			<button type="button"
					class="button save">{html_image src="disk-black.png"} {translate key='Rename'}</button>
			<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
		</div>
	</form>
</div>

<div id="scheduleDialog" class="dialog" title="{translate key=MoveToSchedule}">
	<form id="scheduleForm" method="post" ajaxAction="{ManageResourcesActions::ActionChangeSchedule}">
		{translate key=MoveToSchedule}:
		<select id="editSchedule" class="textbox" {formname key=SCHEDULE_ID}>
			{foreach from=$Schedules item=scheduleName key=scheduleId}
				<option value="{$scheduleId}">{$scheduleName}</option>
			{/foreach}
		</select>

		<div class="admin-update-buttons">
			<button type="button"
					class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
			<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
		</div>
	</form>
</div>

<div id="resourceTypeDialog" class="dialog" title="{translate key=ResourceType}">
	<form id="resourceTypeForm" method="post" ajaxAction="{ManageResourcesActions::ActionChangeResourceType}">
		{translate key=ResourceType}:
		<select id="editResourceType" class="textbox" {formname key=RESOURCE_TYPE_ID}>
			<option value="">-- {translate key=None} --</option>
			{foreach from=$ResourceTypes item=resourceType key=id}
				<option value="{$id}">{$resourceType->Name()}</option>
			{/foreach}
		</select>

		<div class="admin-update-buttons">
			<button type="button"
					class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
			<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
		</div>
	</form>
</div>

<div id="locationDialog" class="dialog" title="{translate key=Location}">
	<form id="locationForm" method="post" ajaxAction="{ManageResourcesActions::ActionChangeLocation}">
		{translate key=Location}:<br/>
		<input id="editLocation" type="text" class="textbox" maxlength="85"
			   style="width:250px" {formname key=RESOURCE_LOCATION} /><br/>
		{translate key=Contact}:<br/>
		<input id="editContact" type="text" class="textbox" maxlength="85"
			   style="width:250px" {formname key=RESOURCE_CONTACT} />

		<div class="admin-update-buttons">
			<button type="button"
					class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
			<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
		</div>
	</form>
</div>

<div id="descriptionDialog" class="dialog" title="{translate key=Description}">
	<form id="descriptionForm" method="post" ajaxAction="{ManageResourcesActions::ActionChangeDescription}">
		{translate key=Description}:<br/>
		<textarea id="editDescription" class="textbox"
				  style="width:460px;height:150px;" {formname key=RESOURCE_DESCRIPTION}></textarea>

		<div class="admin-update-buttons">
			<button type="button"
					class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
			<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
		</div>
	</form>
</div>

<div id="notesDialog" class="dialog" title="{translate key=Notes}">
	<form id="notesForm" method="post" ajaxAction="{ManageResourcesActions::ActionChangeNotes}">
		{translate key=Notes}:<br/>
		<textarea id="editNotes" class="textbox"
				  style="width:460px;height:150px;" {formname key=RESOURCE_NOTES}></textarea>

		<div class="admin-update-buttons">
			<button type="button"
					class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
			<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
		</div>
	</form>
</div>

<div id="configurationDialog" class="dialog" title="{translate key=UsageConfiguration}">
	<form id="configurationForm" method="post" ajaxAction="{ManageResourcesActions::ActionChangeConfiguration}">
		<div style="margin-bottom: 10px;">
			<fieldset>
				<legend>{translate key=Duration}</legend>
				<ul>
					<li>
						<label>
							<input type="checkbox" id="noMinimumDuration"/> {translate key=ResourceMinLengthNone}
						</label>
						<span class="noMinimumDuration">
							<br/>
							{capture name="txtMinDuration" assign="txtMinDuration"}
								<input type='text' id='minDurationDays' size='3' class='days textbox' maxlength='3'/>
								<input type='text' id='minDurationHours' size='2' class='hours textbox' maxlength='2'/>
								<input type='text' id='minDurationMinutes' size='2' class='minutes textbox'
									   maxlength='2'/>
								<input type='hidden' id='minDuration' class='interval' {formname key=MIN_DURATION} />
							{/capture}
							{translate key='ResourceMinLength' args=$txtMinDuration}
						</span>
					</li>
					<li>
						<label>
							<input type="checkbox" id="noMaximumDuration"/> {translate key=ResourceMaxLengthNone}
						</label>
						<span class="noMaximumDuration">
							<br/>
							{capture name="txtMaxDuration" assign="txtMaxDuration"}
								<input type='text' id='maxDurationDays' size='3' class='days textbox' maxlength='3'/>
								<input type='text' id='maxDurationHours' size='2' class='hours textbox' maxlength='2'/>
								<input type='text' id='maxDurationMinutes' size='2' class='minutes textbox'
									   maxlength='2'/>
								<input type='hidden' id='maxDuration' class='interval' {formname key=MAX_DURATION} />
							{/capture}
							{translate key=ResourceMaxLength args=$txtMaxDuration}
						</span>
					</li>
					<li>
						<label>
							<input type="checkbox" id="noBufferTime"/> {translate key=ResourceBufferTimeNone}
						</label>
						<span class="noBufferTime">
							<br/>
							{capture name="txtBufferTime" assign="txtBufferTime"}
								<input type='text' id='bufferTimeDays' size='3' class='days textbox' maxlength='3'/>
								<input type='text' id='bufferTimeHours' size='2' class='hours textbox' maxlength='2'/>
								<input type='text' id='bufferTimeMinutes' size='2' class='minutes textbox'
									   maxlength='2'/>
								<input type='hidden' id='bufferTime' class='interval' {formname key=BUFFER_TIME} />
							{/capture}
							{translate key=ResourceBufferTime args=$txtBufferTime}
						</span>
					</li>
					<li>
						{translate key=ResourceAllowMultiDay}
						<select id="allowMultiday" class="textbox" {formname key=ALLOW_MULTIDAY}>
							<option value="1">{translate key='Yes'}</option>
							<option value="0">{translate key='No'}</option>
						</select>
					</li>
				</ul>
			</fieldset>
			<fieldset>
				<legend>{translate key=Access}</legend>
				<ul>
					<li>
						{translate key='ResourceRequiresApproval'}
						<select id="requiresApproval" class="textbox" {formname key=REQUIRES_APPROVAL}>
							<option value="1">{translate key='Yes'}</option>
							<option value="0">{translate key='No'}</option>
						</select>
					</li>
					<li>
						{translate key='ResourcePermissionAutoGranted'}
						<select id="autoAssign" class="textbox" {formname key=AUTO_ASSIGN}>
							<option value="1">{translate key='Yes'}</option>
							<option value="0">{translate key='No'}</option>
						</select>
					</li>
					<li>
						<label>
							<input type="checkbox" id="noStartNotice" /> {translate key='ResourceMinNoticeNone'}
						</label>
						<span class="noStartNotice">
							<br/>
							{capture name="txtStartNotice" assign="txtStartNotice"}
								<input type='text' id='startNoticeDays' size='3' class='days textbox' maxlength='3'/>
								<input type='text' id='startNoticeHours' size='2' class='hours textbox' maxlength='2'/>
								<input type='text' id='startNoticeMinutes' size='2' class='minutes textbox' maxlength='2'/>
								<input type='hidden' id='startNotice' class='interval' {formname key=MIN_NOTICE} />
							{/capture}
							{translate key='ResourceMinNotice' args=$txtStartNotice}
						</span>
					</li>
					<li>
						<label>
							<input type="checkbox" id="noEndNotice"/> {translate key='ResourceMaxNoticeNone'}
						</label>
						<span class="noEndNotice">
							<br/>
							{capture name="txtEndNotice" assign="txtEndNotice"}
								<input type='text' id='endNoticeDays' size='3' class='days textbox' maxlength='3'/>
								<input type='text' id='endNoticeHours' size='2' class='hours textbox' maxlength='2'/>
								<input type='text' id='endNoticeMinutes' size='2' class='minutes textbox' maxlength='2'/>
								<input type='hidden' id='endNotice' class='interval' {formname key=MAX_NOTICE} />
							{/capture}
							{translate key='ResourceMaxNotice' args=$txtEndNotice}
						</span>
					</li>
				</ul>
			</fieldset>
			<fieldset>
				<legend>{translate key='Capacity'}</legend>
				<ul>
					<li>
						<label>
							<input type="checkbox" id="unlimitedCapacity"/> {translate key='ResourceCapacityNone'}
						</label>
						<span class="unlimitedCapacity">
							<br/>
							{capture name="txtMaxCapacity" assign="txtMaxCapacity"}
								<input type='text' id='maxCapacity' class='textbox' size='5'
									   maxlength='5' {formname key=MAX_PARTICIPANTS} />
							{/capture}
							{translate key='ResourceCapacity' args=$txtMaxCapacity}
						</span>
					</li>
				</ul>
			</fieldset>
		</div>
		<div class="admin-update-buttons">
			<button type="button"
					class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
			<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
		</div>
	</form>
</div>

<div id="groupAdminDialog" class="dialog" title="{translate key=WhoCanManageThisResource}">
	<form method="post" id="groupAdminForm" ajaxAction="{ManageResourcesActions::ActionChangeAdmin}">
		<select id="adminGroupId" {formname key=RESOURCE_ADMIN_GROUP_ID} class="textbox">
			<option value="">-- {translate key=None} --</option>
			{foreach from=$AdminGroups item=adminGroup}
				<option value="{$adminGroup->Id}">{$adminGroup->Name}</option>
			{/foreach}
		</select>

		<div class="admin-update-buttons">
			<button type="button"
					class="button save">{html_image src="tick-circle.png"} {translate key='Update'}</button>
			<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
		</div>
	</form>
</div>

<div id="deleteDialog" class="dialog" title="{translate key=Delete}">
	<form id="deleteForm" method="post" ajaxAction="{ManageResourcesActions::ActionDelete}">
		<div class="error" style="margin-bottom: 25px;">
			<h3>{translate key=DeleteWarning}</h3>
			<br/>{translate key=DeleteResourceWarning}:
			<ul>
				<li>{translate key=DeleteResourceWarningReservations}</li>
				<li>{translate key=DeleteResourceWarningPermissions}</li>
			</ul>
			<br/>
			{translate key=DeleteResourceWarningReassign}
		</div>

		<div class="admin-update-buttons">
			<button type="button"
					class="button save">{html_image src="cross-button.png"} {translate key='Delete'}</button>
			<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
		</div>
	</form>
</div>

<div id="sortOrderDialog" class="dialog" title="{translate key=SortOrder}">
	<form id="sortOrderForm" method="post" ajaxAction="{ManageResourcesActions::ActionChangeSort}">
		{translate key=SortOrder}:
		<input type="text" id="editSortOrder" class="textbox" {formname key=RESOURCE_SORT_ORDER} maxlength="3"
			   style="width:40px"/>

		<div class="admin-update-buttons">
			<button type="button"
					class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
			<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
		</div>
	</form>
</div>

<div id="statusDialog" class="dialog" title="{translate key=Status}">
	<form id="statusForm" method="post" ajaxAction="{ManageResourcesActions::ActionChangeStatus}">

		<select id="statusId" {formname key=RESOURCE_STATUS_ID} class="textbox">
			<option value="{ResourceStatus::AVAILABLE}">{translate key=Available}</option>
			<option value="{ResourceStatus::UNAVAILABLE}">{translate key=Unavailable}</option>
			<option value="{ResourceStatus::HIDDEN}">{translate key=Hidden}</option>
		</select>
		<br/>
		<br/>
		<label for="reasonId">{translate key=Reason}</label> <a href="#"
																id="addStatusReason">{translate key=Add}</a><br/>
		<select id="reasonId" {formname key=RESOURCE_STATUS_REASON_ID} class="textbox">
		</select>

		<div id="newStatusReason" class="hidden">
			<input type="text" class="textbox" {formname key=RESOURCE_STATUS_REASON}  />
		</div>
		<div class="admin-update-buttons">
			<button type="button"
					class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
			<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
		</div>
	</form>
</div>

<div id="bulkUpdateDialog" class="hidden horizontal-list label-top" title="{translate key=BulkResourceUpdate}">
<div class="title">{translate key=Resources}</div>
<form id="bulkUpdateForm" method="post" ajaxAction="{ManageResourcesActions::ActionBulkUpdate}">
<div id="bulkUpdateErrors" class="error hidden"></div>
{async_validator id="bulkAttributeValidator" key=""}
<div id="bulkUpdateList">
</div>
<div>
	<div class="title">{translate key=Common}</div>
	<ul>
		<li>
			<label for="bulkEditSchedule">{translate key=MoveToSchedule}:</label>
			<select id="bulkEditSchedule" class="textbox" {formname key=SCHEDULE_ID}>
				<option value="-1">{translate key=Unchanged}</option>
				{foreach from=$Schedules item=scheduleName key=scheduleId}
					<option value="{$scheduleId}">{$scheduleName}</option>
				{/foreach}
			</select>
		</li>
		<li>
			<label for="bulkEditResourceType">{translate key=ResourceType}:</label>
			<select id="bulkEditResourceType" class="textbox" {formname key=RESOURCE_TYPE_ID}>
				<option value="-1">{translate key=Unchanged}</option>
				<option value="">-- {translate key=None} --</option>
				{foreach from=$ResourceTypes item=resourceType key=id}
					<option value="{$id}">{$resourceType->Name()}</option>
				{/foreach}
			</select>
		</li>
		<li>
			<label for="bulkEditLocation">{translate key=Location}:</label>
			<input id="bulkEditLocation" type="text" class="textbox" maxlength="85"
				   style="width:250px" {formname key=RESOURCE_LOCATION} />

		</li>
		<li>
			<label for="bulkEditContact">{translate key=Contact}:</label>
			<input id="bulkEditContact" type="text" class="textbox" maxlength="85"
				   style="width:250px" {formname key=RESOURCE_CONTACT} />
		</li>
		<li>
			<label for="bulkEditAdminGroupId">{translate key=ResourceAdministrator}:</label>
			<select id="bulkEditAdminGroupId" {formname key=RESOURCE_ADMIN_GROUP_ID} class="textbox">
				<option value="-1">{translate key=Unchanged}</option>
				<option value="">-- {translate key=None} --</option>
				{foreach from=$AdminGroups item=adminGroup}
					<option value="{$adminGroup->Id}">{$adminGroup->Name}</option>
				{/foreach}
			</select>
		</li>
		<li>
			<label for="bulkEditStatusId">{translate key=Status}:</label>
			<select id="bulkEditStatusId" {formname key=RESOURCE_STATUS_ID} class="textbox">
				<option value="-1">{translate key=Unchanged}</option>
				<option value="{ResourceStatus::AVAILABLE}">{translate key=Available}</option>
				<option value="{ResourceStatus::UNAVAILABLE}">{translate key=Unavailable}</option>
				<option value="{ResourceStatus::HIDDEN}">{translate key=Hidden}</option>
			</select>
		</li>
		<li>
			<label for="bulkEditStatusReasonId">{translate key=Reason}:</label>
			<select id="bulkEditStatusReasonId" {formname key=RESOURCE_STATUS_REASON_ID} class="textbox">
			</select>
		</li>
	</ul>
	<ul>
		<li>
			<label for="bulkEditDescription">{translate key=Description}:</label>
			<textarea id="bulkEditDescription" class="textbox"
					  style="width:460px;height:150px;" {formname key=RESOURCE_DESCRIPTION}></textarea>
		</li>
		<li>
			<label for="bulkEditNotes">{translate key=Notes}:</label>
			<textarea id="bulkEditNotes" class="textbox"
					  style="width:460px;height:150px;" {formname key=RESOURCE_NOTES}></textarea>
		</li>
	</ul>
</div>
<div>
	<div class="title">{translate key=Duration}</div>
	<ul>
		<li>
			<label>
				<input type="checkbox" id="bulkEditNoMinimumDuration"
					   value="1" {formname key=MIN_DURATION_NONE}/> {translate key=ResourceMinLengthNone}
			</label>
						<span class="bulkEditNoMinimumDuration">
							<br/>
							{capture name="txtMinDuration" assign="txtMinDuration"}
								<input type='text' id='bulkEditMinDurationDays' size='3' class='days textbox'
									   maxlength='3'/>
								<input type='text' id='bulkEditMinDurationHours' size='2' class='hours textbox'
									   maxlength='2'/>
								<input type='text' id='bulkEditMinDurationMinutes' size='2' class='minutes textbox'
									   maxlength='2'/>
								<input type='hidden' id='bulkEditMinDuration'
									   class='interval' {formname key=MIN_DURATION} />
							{/capture}
							<label>{translate key='ResourceMinLength' args=$txtMinDuration}</label>
						</span>
		</li>
		<li>
			<label for="bulkEditNoMaximumDuration">
				<input type="checkbox" id="bulkEditNoMaximumDuration"
					   value="1" {formname key=MAX_DURATION_NONE}/> {translate key=ResourceMaxLengthNone}
			</label>

					<span class="bulkEditNoMaximumDuration">
						<br/>
						{capture name="txtMaxDuration" assign="txtMaxDuration"}
							<input type='text' id='bulkEditMaxDurationDays' size='3' class='days textbox'
								   maxlength='3'/>
							<input type='text' id='bulkEditMaxDurationHours' size='2' class='hours textbox'
								   maxlength='2'/>
							<input type='text' id='bulkEditMaxDurationMinutes' size='2' class='minutes textbox'
								   maxlength='2'/>
							<input type='hidden' id='bulkEditMaxDuration'
								   class='interval' {formname key=MAX_DURATION} />
						{/capture}
						<label>{translate key=ResourceMaxLength args=$txtMaxDuration}</label>
					</span>
		</li>
		<li>
			<label>
				<input type="checkbox" id="bulkEditNoBufferTime"
					   value="1" {formname key=BUFFER_TIME_NONE}/> {translate key=ResourceBufferTimeNone}
			</label>
				<span class="bulkEditNoBufferTime">
					<br/>
					{capture name="txtBufferTime" assign="txtBufferTime"}
						<input type='text' id='bulkEditBufferTimeDays' size='3' class='days textbox'
							   maxlength='3'/>
						<input type='text' id='bulkEditBufferTimeHours' size='2' class='hours textbox'
							   maxlength='2'/>
						<input type='text' id='bulkEditBufferTimeMinutes' size='2' class='minutes textbox'
							   maxlength='2'/>
						<input type='hidden' id='bulkEditBufferTime'
							   class='interval' {formname key=BUFFER_TIME} />
					{/capture}
					<label>{translate key=ResourceBufferTime args=$txtBufferTime}</label>
				</span>
		</li>
	</ul>
</div>
<div>
	<div class="title">{translate key=Access}</div>
	<ul>
		<li>
			<label>
				<input type="checkbox" id="bulkEditNoStartNotice"
					   value="1" {formname key=MIN_NOTICE_NONE}/> {translate key='ResourceMinNoticeNone'}
			</label>
				<span class="bulkEditNoStartNotice">
					<br/>
					{capture name="txtStartNotice" assign="txtStartNotice"}
						<input type='text' id='bulkEditStartNoticeDays' size='3' class='days textbox'
							   maxlength='3'/>
						<input type='text' id='bulkEditStartNoticeHours' size='2' class='hours textbox'
							   maxlength='2'/>
						<input type='text' id='bulkEditStartNoticeMinutes' size='2' class='minutes textbox'
							   maxlength='2'/>
						<input type='hidden' id='bulkEditStartNotice'
							   class='interval' {formname key=MIN_NOTICE} />
					{/capture}
					<label>{translate key='ResourceMinNotice' args=$txtStartNotice}</label>
				</span>
		</li>
		<li>
			<label>
				<input type="checkbox" id="bulkEditNoEndNotice"
					   value="1" {formname key=MAX_NOTICE_NONE}/> {translate key='ResourceMaxNoticeNone'}
			</label>
				<span class="bulkEditNoEndNotice">
					<br/>
					{capture name="txtEndNotice" assign="txtEndNotice"}
						<input type='text' id='bulkEditEndNoticeDays' size='3' class='days textbox'
							   maxlength='3'/>
						<input type='text' id='bulkEditEndNoticeHours' size='2' class='hours textbox'
							   maxlength='2'/>
						<input type='text' id='bulkEditEndNoticeMinutes' size='2' class='minutes textbox'
							   maxlength='2'/>
						<input type='hidden' id='bulkEditEndNotice'
							   class='interval' {formname key=MAX_NOTICE} />
					{/capture}
					<label>{translate key='ResourceMaxNotice' args=$txtEndNotice}</label>
				</span>
		</li>
	</ul>
	<ul>
		<li>
			<label for="bulkEditAllowMultiday">{translate key=ResourceAllowMultiDay}</label>
			<select id="bulkEditAllowMultiday" class="textbox" {formname key=ALLOW_MULTIDAY}>
				{html_options options=$YesNoUnchangedOptions}
			</select>
		</li>
		<li>
			<label for="bulkEditRequiresApproval">{translate key='ResourceRequiresApproval'}</label>
			<select id="bulkEditRequiresApproval" class="textbox" {formname key=REQUIRES_APPROVAL}>
				{html_options options=$YesNoUnchangedOptions}
			</select>
		</li>
		<li>
			<label for="bulkEditAutoAssign">{translate key='ResourcePermissionAutoGranted'}</label>
			<select id="bulkEditAutoAssign" class="textbox" {formname key=AUTO_ASSIGN}>
				{html_options options=$YesNoUnchangedOptions}
			</select>
		</li>
		<li>
			<label for="bulkEditAllowSubscriptions">{translate key='TurnOnSubscription'}</label>
			<select id="bulkEditAllowSubscriptions" class="textbox" {formname key=ALLOW_CALENDAR_SUBSCRIPTIONS}>
				{html_options options=$YesNoUnchangedOptions}
			</select>
		</li>
	</ul>
</div>
<div>
	<div class="title">{translate key=AdditionalAttributes}</div>
	<ul>
		{foreach from=$AttributeFilters item=attribute}
			{if !$attribute->UniquePerEntity()}
				<li class="customAttribute">
					{control type="AttributeControl" attribute=$attribute searchmode=true}
				</li>
			{/if}
		{/foreach}
	</ul>
</div>
<div class="admin-update-buttons">
	<button type="button"
			class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
	<button type="button" class="button cancelColorbox">{html_image src="slash.png"} {translate key='Cancel'}</button>
</div>
</form>
</div>

{html_image src="admin-ajax-indicator.gif" class="indicator" style="display:none;"}
{jsfile src="js/jquery.watermark.min.js"}
{jsfile src="js/jquery.colorbox-min.js"}
{jsfile src="admin/edit.js"}
{jsfile src="admin/resource.js"}
{jsfile src="js/jquery.form-3.09.min.js"}

<script type="text/javascript">

	$(document).ready(function ()
	{
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
		resourceManagement.init();

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
			reasonId: '{$resource->GetStatusReasonId()}'
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

		resourceManagement.initializeStatusFilter('{$ResourceStatusFilterId}', '{$ResourceStatusReasonFilterId}');
	});

</script>

{include file='globalfooter.tpl'}