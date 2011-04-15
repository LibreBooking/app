{include file='globalheader.tpl'}
<style type="text/css">
	@import url({$Path}css/admin.css);
</style>

<h1>Manage Resources</h1>

<div class="admin">
	<div class="title">
		All Resources
	</div>
	{foreach $Resources item=resource}
	{assign var=id value=$resource->GetResourceId()}
	<div class="resourceDetails">
		<div style="float:left;width:40%;">
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
				<h5>Usage Configuration</h5> <a class="update" href="javascript: void(0);">Change Configuration</a>
			</div>
			<div style="float:left">
				<ul>
					<li>
						{if $resource->HasMinLength()}
							Reservations must last at least 30 minutes 
						{else}
							There is no minimum reservation duration
						{/if}
					</li>
					<li>
						{if $resource->HasMaxLength()}
							Reservations cannot last more than 30 minutes 
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
						Reservations must be made at least 30 minutes prior to start time
					{else}
						Reservations can be made up until the current time
					{/if}
				</li>
				<li>
					{if $resource->HasMaxNotice()}
						Reservations must not end more than 30 minutes from the current time
					{else}
						Reservations can end at any point in the future
					{/if}
				</li>
				<li>
					{if $resource->GetAllowMultiday()}
						Reservations cannot be made across days
					{else}
						Reservations can be made across days
					{/if}
				</li>
				<li>
					{if $resource->HasMaxParticipants()}
						This resource has a capacity of 8 people
					{else}
						This resource has unlimited capacity
					{/if}
				</li>
			</ul>
			</div>
		</div>
		<div class="actions">
			{html_image src="admin-ajax-indicator.gif" class="actionIndicator" style="display:none;"}
			<a class="update" href="javascript: void(0);">Take Offline</a> |
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
		<div id="addScheduleResults" class="error" style="display:none;"></div>
		<form id="addScheduleForm" method="post">
			<ul>
				<li>Name<br/> <input type="text" class="textbox required" {formname key=SCHEDULE_NAME} /></li>
				<li>Starts On<br/> 
				<select {formname key=SCHEDULE_WEEKDAY_START} class="textbox">
					{foreach from=$DayNames item="dayName" key="dayIndex"}
						<option value="{$dayIndex}">{$dayName}</option>
					{/foreach} 
				</select>
				</li>
				<li>Number of Days Visible<br/><input type="text" class="textbox required" maxlength="3" size="3" {formname key=SCHEDULE_DAYS_VISIBLE} /> 
				</li>
				<li>Use Same Layout As<br/>
					<select class="textbox" {formname key=SCHEDULE_ID}>
					{foreach $Schedules key=scheduleId item=scheduleName}
						<option value="{$scheduleId}">{$scheduleName}</option>
					{/foreach}
					</select>
				</li>
				<li>
					<button type="button" class="button save">{html_image src="disk-black.png"} Add Schedule</button>
				</li>
			</ul>
		</form>
	</div>
</div>

<input type="hidden" id="activeId" value="" />

<div id="makeDefaultDialog" style="display:none">
	<form id="makeDefaultForm" method="post">
	</form>
</div>

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

<form id="removeImageForm" method="post"></form>

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

<div id="changeSettingsDialog" class="dialog" style="display:none;">
	<form id="settingsForm" method="post">
		Starts On: <select id="dayOfWeek" {formname key=SCHEDULE_WEEKDAY_START} class="textbox">
			{foreach from=$DayNames item="dayName" key="dayIndex"}
				<option value="{$dayIndex}">{$dayName}</option>
			{/foreach} 
		</select>
		<br/>
		Number of Days Visible: <input type="text" class="textbox required" id="daysVisible" maxlength="3" size="3" {formname key=SCHEDULE_DAYS_VISIBLE} /> 
		<br/><br/>
		<button type="button" class="button save">{html_image src="disk-black.png"} Update</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} Cancel</button>
	</form>
</div>

<div id="changeLayoutDialog" class="dialog" style="display:none;">
	<form id="changeLayoutForm" method="post">		
		<div style="float:left;">
			<h5>Reservable Time Slots</h5>
			<textarea id="reservableEdit" {formname key=SLOTS_RESERVABLE}></textarea>
		</div>
		<div style="float:right;">
			<h5>Blocked Time Slots</h5>
			<textarea id="blockedEdit" {formname key=SLOTS_BLOCKED}></textarea>
		</div>
		<div style="clear:both;height:0px;">&nbsp</div>
		<div style="margin-top:5px;">
			<h5>
				{translate key=Timezone} 
				<select {formname key=TIMEZONE} id="layoutTimezone" class="input">
		        	{html_options values=$TimezoneValues output=$TimezoneOutput}
		        </select>
	        </h5>
		</div>
		<div style="margin-top: 5px; padding-top:5px; border-top: solid 1px #f0f0f0;">
			<div style="float:left;">
				<button type="button" class="button save">{html_image src="disk-black.png"} Update</button>
				<button type="button" class="button cancel">{html_image src="slash.png"} Cancel</button>
			</div>
			<div style="float:right;">
				<p>Format: <span style="font-family:courier new;">HH:MM - HH:MM Optional Label</span></p>
				<p>Enter one slot per line.  Slots must be provided for all 24 hours of the day.</p>
			</div>
		</div>
	</form>
	<div id="layoutResults"></div>
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
		changeNotes: '{ManageResourcesActions::ActionChangeNotes}'
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
			minLength: '{$resource->GetMinLength()}',
			maxLength: '{$resource->GetMaxLength()}',
			autoAssign: '{$resource->GetAutoAssign()}',
			requiresApproval: '{$resource->GetRequiresApproval()}',
			allowMultiday: '{$resource->GetAllowMultiday()}',
			maxParticipants: '{$resource->GetMaxParticipants()}',
			scheduleId: '{$resource->GetScheduleId()}'
		};
	
		resourceManagement.add(resource);
	{/foreach}
	
});

</script>


{include file='globalfooter.tpl'}