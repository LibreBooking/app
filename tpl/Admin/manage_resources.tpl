{include file='globalheader.tpl'}
<style type="text/css">
	@import url({$Path}css/admin.css);
</style>

<h1>Manage Resources</h1>

<div id="globalError" class="error" style="display:none"></div>
<div class="admin">
	<div class="title">
		All Resources
	</div>
	{foreach $Resources item=resource}
	{assign var=id value=$resource->GetResourceId()}
	<div class="resourceDetails">
		<div style="float:left;max-width:50%;">
			<input type="hidden" class="id" value="{$id}" />
			<div style="float:left; text-align:center; width:110px;;">
				{if $resource->HasImage()}
					<img src="{$ImageUploadPath}{$resource->GetImage()}" alt="Resource Image" class="image" /><br/>
					<a class="update imageButton" href="javascript: void(0);">Change</a> | 
					<a class="update removeImageButton" href="javascript: void(0);">Remove</a>
				{else}
					<div class="noImage">No Image Assigned</div>
					<a class="update imageButton" href="javascript: void(0);">Add Image</a>
				{/if}
			</div>
			<div style="float:right;">
				<ul>
					<li>
						<h4>{$resource->GetName()}</h4> <a class="update renameButton" href="javascript: void(0);">Rename</a>
					</li>
					<li>
						Appears on {$Schedules[$resource->GetScheduleId()]} <a class="update changeScheduleButton" href="javascript: void(0);">Move</a>
					</li>
					<li>
					 	Located at 
						{if $resource->HasLocation()}
							{$resource->GetLocation()} 
						{else}
							<span class="note">(no location set)</span>
						{/if}
						<a class="update changeLocationButton" href="javascript: void(0);">Change Location Info</a>
					</li>
					<li>
					 	Contact
						{if $resource->HasContact()}
							{$resource->GetContact()} 
						{else}
							<span class="note">(no contact information)</span>
						{/if}
					</li>
					<li>
						Description
						{if $resource->HasDescription()}
							 {$resource->GetDescription()|truncate:500:"..."} 
						{else}
							<span class="note">(no description)</span>
						{/if}
						<a class="update descriptionButton" href="javascript: void(0);">Edit</a>
					</li>
					<li>
						Notes
						{if $resource->HasNotes()}
							 {$resource->GetNotes()|truncate:500:"..."} 
						{else}
							<span class="note">(no notes)</span>
						{/if}
						<a class="update notesButton" href="javascript: void(0);">Edit</a>
					</li>
				</ul>
			</div>
		</div>
		<div style="float:right">
			<div>
				<h5>Usage Configuration</h5> <a class="update changeConfigurationButton" href="javascript: void(0);">Change Configuration</a>
			</div>
			<div style="float:left">
				<ul>
					<li>
						{if $resource->HasMinLength()}
							Reservations must last at least {$resource->GetMinLength()} 
						{else}
							There is no minimum reservation duration
						{/if}
					</li>
					<li>
						{if $resource->HasMaxLength()}
							Reservations cannot last more than {$resource->GetMaxLength()}
						{else}
							There is no maximum reservation duration
						{/if}
					</li>
					<li>
						{if $resource->GetRequiresApproval()}
							Reservations must be approved 
						{else}
							Reservations do not require approval
						{/if}
					</li>
					<li>
						{if $resource->GetAutoAssign()}
							Permission is automatically granted
						{else}
							Permission is not automatically granted
						{/if}
					</li>
				</ul>
			</div>
			
			<div style="float:right">
				<ul>				
				<li>
					{if $resource->HasMinNotice()}
						Reservations must be made at least {$resource->GetMinNotice()} prior to start time
					{else}
						Reservations can be made up until the current time
					{/if}
				</li>
				<li>
					{if $resource->HasMaxNotice()}
						Reservations must not end more than {$resource->GetMinNotice()} from the current time
					{else}
						Reservations can end at any point in the future
					{/if}
				</li>
				<li>
					{if $resource->GetAllowMultiday()}
						Reservations can be made across days
					{else}
						Reservations cannot be made across days
					{/if}
				</li>
				<li>
					{if $resource->HasMaxParticipants()}
						This resource has a capacity of {$resource->GetMaxParticipants()} people
					{else}
						This resource has unlimited capacity
					{/if}
				</li>
			</ul>
			</div>
		</div>
		<div class="actions">
			{html_image src="admin-ajax-indicator.gif" class="actionIndicator" style="display:none;"}
			
			{if $resource->IsOnline()}
				{html_image src="status.png"} <a class="update takeOfflineButton" href="javascript: void(0);">Take Offline</a> |
			{else}
				{html_image src="status-busy.png"} <a class="update bringOnlineButton" href="javascript: void(0);">Bring Online</a> |
			{/if}
			<a class="update deleteButton" href="javascript:void(0);">Delete</a>
		</div>
	</div>
	{/foreach}
</div>


<div class="admin" style="margin-top:30px">
	<div class="title">
		Add New Resource
	</div>
	<div>
		<div id="addResourceResults" class="error" style="display:none;"></div>
		<form id="addResourceForm" method="post">
			<table>
				<tr>
					<th>Name</th>
					<th>Schedule</th>
					<th>&nbsp;</th>
				</tr>
				<tr>
					<td><input type="text" class="textbox required"  maxlength="85" style="width:250px" {formname key=RESOURCE_NAME} /></td>
					<td>
						<select class="textbox" {formname key=SCHEDULE_ID}>
						{foreach from=$Schedules item=scheduleName key=scheduleId}
							<option value="{$scheduleId}">{$scheduleName}</option>
						{/foreach}
					</select>
					</td>
					<td>
						<button type="button" class="button save">{html_image src="disk-black.png"} Add Resource</button>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>

<input type="hidden" id="activeId" value="" />

<div id="imageDialog" class="dialog" style="display:none;">
	<form id="imageForm" method="post" enctype="multipart/form-data">
      <input id="resourceImage" type="file" class="text" size="60" {formname key=RESOURCE_IMAGE} />
      <br/>
      <span class="note">Only .gif, .jpg, or .png</span>
      <br/><br/>
      <button type="button" class="button async">{html_image src="disk-black.png"} Update</button>
	  <button type="button" class="button cancel">{html_image src="slash.png"} Cancel</button>
  	</form>
</div>

<div id="renameDialog" class="dialog" style="display:none;">
	<form id="renameForm" method="post">
		New Name: <input id="editName" type="text" class="textbox required" maxlength="85" style="width:250px" {formname key=RESOURCE_NAME} />
		<br/><br/>
		<button type="button" class="button save">{html_image src="disk-black.png"} Update</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} Cancel</button>
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
		<button type="button" class="button save">{html_image src="disk-black.png"} Update</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} Cancel</button>
	</form>
</div>

<div id="locationDialog" class="dialog" style="display:none;">
	<form id="locationForm" method="post">
		Location:<br/>
		<input id="editLocation" type="text" class="textbox" maxlength="85" style="width:250px" {formname key=RESOURCE_LOCATION} /><br/>
		Contact Info:<br/>
		<input id="editContact" type="text" class="textbox" maxlength="85" style="width:250px" {formname key=RESOURCE_CONTACT} />
		<br/><br/>
		<button type="button" class="button save">{html_image src="disk-black.png"} Update</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} Cancel</button>
	</form>
</div>

<div id="descriptionDialog" class="dialog" style="display:none;">
	<form id="descriptionForm" method="post">
		Description:<br/>
		<textarea id="editDescription" class="textbox" style="width:460px;height:150px;" {formname key=RESOURCE_DESCRIPTION}></textarea>
		<br/><br/>
		<button type="button" class="button save">{html_image src="disk-black.png"} Update</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} Cancel</button>
	</form>
</div>

<div id="notesDialog" class="dialog" style="display:none;">
	<form id="notesForm" method="post">
		Notes:<br/>
		<textarea id="editNotes" class="textbox" style="width:460px;height:150px;" {formname key=RESOURCE_NOTES}></textarea>
		<br/><br/>
		<button type="button" class="button save">{html_image src="disk-black.png"} Update</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} Cancel</button>
	</form>
</div>

<div id="configurationDialog" class="dialog" style="display:none;">
	<form id="configurationForm" method="post">
		<div style="margin-bottom: 10px;">
			<fieldset><legend>Duration</legend>
				<ul>
					<li>
						<label>
							<input type="checkbox" id="noMinimumDuration" /> There is no minimum reservation duration
						</label>
						<span class="noMinimumDuration">
							<br/>
							Reservations must last at least <input type="text" id="minDuration" class="textbox" size="5" maxlength="5" {formname key=MIN_DURATION} /> 
						</span>
					</li>
					<li>
						<label>
							<input type="checkbox" id="noMaximumDuration" /> There is no maximum reservation duration
						</label>
						<span class="noMaximumDuration">
							<br/>
							Reservations cannot last more than <input type="text" id="maxDuration" class="textbox" size="5" maxlength="5" {formname key=MAX_DURATION} /> 
						</span>
					</li>
					<li>
						Reservations can be made across days:
						<select id="allowMultiday" class="textbox" {formname key=ALLOW_MULTIDAY}>
							<option value="1">Yes</option>
							<option value="0">No</option>
						</select>
					</li>
				</ul>
			</fieldset>
			<fieldset><legend>Access</legend>
				<ul>
					<li>
						Reservations must be approved:
						<select id="requiresApproval" class="textbox" {formname key=REQUIRES_APPROVAL}>
							<option value="1">Yes</option>
							<option value="0">No</option>
						</select>
					</li>
					<li>
						Automatically grant user permission:
						<select id="autoAssign" class="textbox" {formname key=AUTO_ASSIGN}>
							<option value="1">Yes</option>
							<option value="0">No</option>
						</select>
					</li>			
					<li>
						<label>
							<input type="checkbox" id="noStartNotice" /> Reservations can be made up until the current time
						</label>
						<span class="noStartNotice">
							<br/>
							Reservations must be made at least 
							<input type="text" id="startNotice" class="textbox" size="5" maxlength="5" {formname key=MIN_NOTICE} /> 
							prior to start time
						</span>
					</li>
					<li>
						<label>
							<input type="checkbox" id="noEndNotice" /> Reservations can end at any point in the future
						</label>					
						<span class="noEndNotice">
							<br/>
							Reservations must not end more than
							<input type="text" id="endNotice" class="textbox" size="5" maxlength="5" {formname key=MAX_NOTICE}  />
							from the current time
						</span>
					</li>
				</ul>
			</fieldset>
			<fieldset><legend>Capacity</legend>
				<ul>
					<li>
						<label>
							<input type="checkbox" id="unlimitedCapactiy" /> This resource has unlimited capacity
						</label>					
						<span class="unlimitedCapactiy">
							<br/>
							This resource has a capacity of <input type="text" id="maxCapactiy" class="textbox" size="5" maxlength="5" {formname key=MAX_PARTICIPANTS} />people
						</span>
					</li>
				</ul>
			</fieldset>
		</div>
		<button type="button" class="button save">{html_image src="disk-black.png"} Update</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} Cancel</button>
	</form>
</div>

<div id="deleteDialog" class="dialog" style="display:none;">
	<form id="deleteForm" method="post">
		<div class="error" style="margin-bottom: 25px;">
			<h3>This action is permanent and irrecoverable!</h3>
			<br/>Deleting this resource will delete all associated data, including:
			<ul>
				<li>all past, current and future reservations assoicated with it</li>
				<li>all permission assignments</li>
			</ul>
			<br/>
			Please reassign anything that you do not want to be deleted before proceeding
		</div>

		<button type="button" class="button save">{html_image src="cross-button.png"} Delete Resource</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} Cancel</button>
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
	
	{foreach $Resources item=resource}
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