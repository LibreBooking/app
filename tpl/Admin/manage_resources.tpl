{include file='globalheader.tpl' cssFiles='css/admin.css'}

<h1>{translate key='ManageResources'}</h1>

<div id="globalError" class="error" style="display:none"></div>
<div class="admin">
	<div class="title">
	{translate key='AllResources'}
	</div>
{foreach from=$Resources item=resource}
	{assign var=id value=$resource->GetResourceId()}
	<div class="resourceDetails">
		<div style="float:left;max-width:50%;">
			<input type="hidden" class="id" value="{$id}"/>

			<div style="float:left; text-align:center; width:110px;;">
				{if $resource->HasImage()}
					<img src="{$ImageUploadPath}{$resource->GetImage()}" alt="Resource Image" class="image"/><br/>
					<a class="update imageButton" href="javascript: void(0);">{translate key='Change'}</a> |
					<a class="update removeImageButton" href="javascript: void(0);">{translate key='Remove'}</a>
					{else}
					<div class="noImage">{translate key='NoImage'}</div>
					<a class="update imageButton" href="javascript: void(0);">{translate key='AddImage'}</a>
				{/if}
			</div>
			<div style="float:right;">
				<ul>
					<li>
						<h4>{$resource->GetName()}</h4>
						<a class="update renameButton" href="javascript:void(0);">{translate key='Rename'}</a> |
						<a class="update deleteButton" href="javascript:void(0);">{translate key='Delete'}</a>
					</li>
					<li>
						{translate key='Status'}
						{if $resource->IsOnline()}
							{html_image src="status.png"} <a class="update takeOfflineButton"
															 href="javascript: void(0);">{translate key='TakeOffline'}</a>
							{else}
							{html_image src="status-busy.png"} <a class="update bringOnlineButton"
																  href="javascript: void(0);">{translate key='BringOnline'}</a>
						{/if}

					</li>

					<li>
						{translate key='AppearsOn' args=$Schedules[$resource->GetScheduleId()]} {translate key='Schedule'}
						<a class="update changeScheduleButton" href="javascript: void(0);">{translate key='Move'}</a>
					</li>
					<li>
						{translate key='Location'}
						{if $resource->HasLocation()}
							{$resource->GetLocation()}
							{else}
							<span class="note">{translate key='NoLocationLabel'}</span>
						{/if}
						<a class="update changeLocationButton" href="javascript: void(0);">{translate key='Edit'}</a>
					</li>
					<li>
						{translate key='Contact'}
						{if $resource->HasContact()}
							{$resource->GetContact()}
							{else}
							<span class="note">{translate key='NoContactLabel'}</span>
						{/if}
					</li>
					<li>
						{translate key='Description'}
						{if $resource->HasDescription()}
							{$resource->GetDescription()|truncate:500:"..."}
							{else}
							<span class="note">{translate key='NoDescriptionLabel'}</span>
						{/if}
						<a class="update descriptionButton" href="javascript: void(0);">{translate key='Edit'}</a>
					</li>
					<li>
						{translate key='Notes'}
						{if $resource->HasNotes()}
							{$resource->GetNotes()|truncate:500:"..."}
							{else}
							<span class="note">{translate key='NoNotesLabel'}</span>
						{/if}
						<a class="update notesButton" href="javascript: void(0);">{translate key='Edit'}</a>
					</li>
				</ul>
			</div>
		</div>
		<div style="float:right">
			<div>
				<h5>{translate key='UsageConfiguration'}</h5> <a class="update changeConfigurationButton"
																 href="javascript: void(0);">{translate key='ChangeConfiguration'}</a>
			</div>
			<div style="float:left">
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

			<div style="float:right">
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
		<div class="actions">


		</div>
	</div>
{/foreach}
</div>


<div class="admin" style="margin-top:30px">
	<div class="title">
	{translate key='AddNewResource'}
	</div>
	<div>
		<div id="addResourceResults" class="error" style="display:none;"></div>
		<form id="addResourceForm" method="post">
			<table>
				<tr>
					<th>{translate key='Name'}</th>
					<th>{translate key='Schedule'}</th>
					<th>&nbsp;</th>
				</tr>
				<tr>
					<td><input type="text" class="textbox required" maxlength="85"
							   style="width:250px" {formname key=RESOURCE_NAME} /></td>
					<td>
						<select class="textbox" {formname key=SCHEDULE_ID}>
						{foreach from=$Schedules item=scheduleName key=scheduleId}
							<option value="{$scheduleId}">{$scheduleName}</option>
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

<input type="hidden" id="activeId" value=""/>

<div id="imageDialog" class="dialog" style="display:none;">
	<form id="imageForm" method="post" enctype="multipart/form-data">
		<input id="resourceImage" type="file" class="text" size="60" {formname key=RESOURCE_IMAGE} />
		<br/>
		<span class="note">.gif, .jpg, or .png</span>
		<br/><br/>
		<button type="button" class="button async">{html_image src="disk-black.png"} {translate key='Update'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<div id="renameDialog" class="dialog" style="display:none;">
	<form id="renameForm" method="post">
	{translate key='Name'}: <input id="editName" type="text" class="textbox required" maxlength="85"
								   style="width:250px" {formname key=RESOURCE_NAME} />
		<br/><br/>
		<button type="button" class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<div id="scheduleDialog" class="dialog" style="display:none;">
	<form id="scheduleForm" method="post">
		Move to schedule:
		<select id="editSchedule" class="textbox" {formname key=SCHEDULE_ID}>
		{foreach from=$Schedules item=scheduleName key=scheduleId}
			<option value="{$scheduleId}">{$scheduleName}</option>
		{/foreach}
		</select>
		<br/><br/>
		<button type="button" class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<div id="locationDialog" class="dialog" style="display:none;">
	<form id="locationForm" method="post">
		Location:<br/>
		<input id="editLocation" type="text" class="textbox" maxlength="85"
			   style="width:250px" {formname key=RESOURCE_LOCATION} /><br/>
		Contact Info:<br/>
		<input id="editContact" type="text" class="textbox" maxlength="85"
			   style="width:250px" {formname key=RESOURCE_CONTACT} />
		<br/><br/>
		<button type="button" class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<div id="descriptionDialog" class="dialog" style="display:none;">
	<form id="descriptionForm" method="post">
		Description:<br/>
		<textarea id="editDescription" class="textbox"
				  style="width:460px;height:150px;" {formname key=RESOURCE_DESCRIPTION}></textarea>
		<br/><br/>
		<button type="button" class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<div id="notesDialog" class="dialog" style="display:none;">
	<form id="notesForm" method="post">
		Notes:<br/>
		<textarea id="editNotes" class="textbox"
				  style="width:460px;height:150px;" {formname key=RESOURCE_NOTES}></textarea>
		<br/><br/>
		<button type="button" class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<div id="configurationDialog" class="dialog" style="display:none;">
	<form id="configurationForm" method="post">
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
							<input type='text' id='minDuration' class='textbox' size='5'
								   maxlength='5' {formname key=MIN_DURATION} />
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
							<input type='text' id='maxDuration' class='textbox' size='5'
								   maxlength='5' {formname key=MAX_DURATION} />
						{/capture}
						{translate key=ResourceMaxLength args=$txtMaxDuration}
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
							<input type="checkbox" id="noStartNotice"/> {translate key='ResourceMinNoticeNone'}
						</label>
						<span class="noStartNotice">
							<br/>
						{capture name="txtStartNotice" assign="txtStartNotice"}
							<input type='text' id='startNotice' class='textbox' size='5'
								   maxlength='5' {formname key=MIN_NOTICE} />
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
							<input type='text' id='endYears' size='2' maxlength='2'/>
							<input type='text' id='endDays' size='2' maxlength='2'/>
							<input type='text' id='endHours' size='2' maxlength='2'/>
							<input type='text' id='endMinutes' size='2' maxlength='2'/>
							<input type='hidden' id='endNotice' class='textbox'  {formname key=MAX_NOTICE}  />
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
							<input type="checkbox" id="unlimitedCapactiy"/> {translate key='ResourceCapacityNone'}
						</label>					
						<span class="unlimitedCapactiy">
							<br/>
						{capture name="txtMaxCapacity" assign="txtMaxCapacity"}
							<input type='text' id='maxCapactiy' class='textbox' size='5'
								   maxlength='5' {formname key=MAX_PARTICIPANTS} />
						{/capture}
						{translate key='ResourceCapacity' args=$txtMaxCapacity}
						</span>
					</li>
				</ul>
			</fieldset>
		</div>
		<button type="button" class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<div id="deleteDialog" class="dialog" style="display:none;">
	<form id="deleteForm" method="post">
		<div class="error" style="margin-bottom: 25px;">
			<h3>This action is permanent and irrecoverable!</h3>
			<br/>Deleting this resource will delete all associated data, including:
			<ul>
				<li>all past, current and future reservations associated with it</li>
				<li>all permission assignments</li>
			</ul>
			<br/>
			Please reassign anything that you do not want to be deleted before proceeding
		</div>

		<button type="button" class="button save">{html_image src="cross-button.png"} {translate key='Delete'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

{html_image src="admin-ajax-indicator.gif" class="indicator" style="display:none;"}
<script type="text/javascript" src="{$Path}scripts/admin/edit.js"></script>
<script type="text/javascript" src="{$Path}scripts/admin/resource.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jquery.form-2.43.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/ajaxfileupload.js"></script>

<script type="text/javascript">

	$(document).ready(function() {

	var actions = {
	rename: '{ManageResourcesActions::ActionRename}',
	changeImage: '{ManageResourcesActions::ActionChangeImage}',
	removeImage: '{ManageResourcesActions::ActionRemoveImage}',
	changeSchedule: '{ManageResourcesActions::ActionChangeSchedule}',
	changeLocation: '{ManageResourcesActions::ActionChangeLocation}',
	changeDescription: '{ManageResourcesActions::ActionChangeDescription}',
	changeNotes: '{ManageResourcesActions::ActionChangeNotes}',
	add: '{ManageResourcesActions::ActionAdd}',
	deleteResource: '{ManageResourcesActions::ActionDelete}',
	takeOffline: '{ManageResourcesActions::ActionTakeOffline}',
	bringOnline: '{ManageResourcesActions::ActionBringOnline}',
	changeConfiguration: '{ManageResourcesActions::ActionChangeConfiguration}'
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
	minLength: '',
	maxLength: '',
	startNotice: '',
	endNotice: ''
	};

		{if $resource->HasMinLength()}
		resource.minLength = '{$resource->GetMinLength()}';
		{/if}

		{if $resource->HasMaxLength()}
		resource.maxLength = '{$resource->GetMaxLength()}';
		{/if}

		{if $resource->HasMinNotice()}
		resource.startNotice = '{$resource->GetMinNotice()}';
		{/if}

		{if $resource->HasMaxNotice()}
		resource.endNotice = '{$resource->GetMaxNotice()}';
		{/if}

	resourceManagement.add(resource);
	{/foreach}
	});

</script>

{include file='globalfooter.tpl'}