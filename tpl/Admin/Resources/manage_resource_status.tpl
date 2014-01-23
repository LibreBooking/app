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
{include file='globalheader.tpl' cssFiles='css/admin.css'}

{function name=displayReason}
	{cycle values='row0,row1' assign=rowCss}
	<li class="{$rowCss}" reasonId="{$reason->Id()}">
		<span class="reason-description">{$reason->Description()}</span>
		<div style="float:right">
			<a href="#" class="update edit">{translate key=Edit}</a> | <a href="#" class="update delete">{translate key=Delete}</a>
		</div>
	</li>
{/function}

<h1>{translate key='ManageResourceStatus'}</h1>

<div id="globalError" class="error" style="display:none"></div>

<h2 class="resource-status">{translate key=Available} <a href="#" class="add" add-to="{ResourceStatus::AVAILABLE}">{html_image src="plus-circle.png"}</a></h2>
<ul class="no-style resource-status-reasons">
	{foreach from=$StatusReasons[{ResourceStatus::AVAILABLE}] item=reason}
		{displayReason reason=$reason}
	{/foreach}
</ul>

<h2 class="resource-status">{translate key=Unavailable} <a href="#" class="add" add-to="{ResourceStatus::UNAVAILABLE}">{html_image src="plus-circle.png"}</a></h2>
<ul class="no-style resource-status-reasons">
	{foreach from=$StatusReasons[{ResourceStatus::UNAVAILABLE}] item=reason}
		{displayReason reason=$reason}
	{/foreach}
</ul>

<h2 class="resource-status">{translate key=Hidden} <a href="#" class="add" add-to="{ResourceStatus::HIDDEN}">{html_image src="plus-circle.png"}</a></h2>
<ul class="no-style resource-status-reasons">
	{foreach from=$StatusReasons[{ResourceStatus::HIDDEN}] item=reason}
		{displayReason reason=$reason}
	{/foreach}
</ul>

<input type="hidden" id="activeId" value=""/>

<div id="addDialog" class="dialog" style="display:none;" title="{translate key=Reason}">
	<form id="addForm" method="post" ajaxAction="{ManageResourceStatusActions::Add}">

		<input type="text" class="textbox" id="add-reason-description" {formname key=RESOURCE_STATUS_REASON} />
		<input type="hidden" id="add-reason-status" {formname key=RESOURCE_STATUS_ID} />
		<div class="admin-update-buttons">
			<button type="button" class="button save">{html_image src="disk-black.png"} {translate key='Add'}</button>
			<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
		</div>
	</form>
</div>

<div id="editDialog" class="dialog" style="display:none;" title="{translate key=Reason}">
	<form id="editForm" method="post" ajaxAction="{ManageResourceStatusActions::Update}">

		<input type="text" class="textbox" id="edit-reason-description" {formname key=RESOURCE_STATUS_REASON} />
				<div class="admin-update-buttons">
			<button type="button" class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
			<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
		</div>
	</form>
</div>

<div id="deleteDialog" class="dialog" style="display:none;" title="{translate key=Reason}">
	<form id="deleteForm" method="post" ajaxAction="{ManageResourceStatusActions::Delete}">
		<div class="error" style="margin-bottom: 25px;">
			<h3>{translate key=DeleteWarning}</h3>
		</div>

		<div class="admin-update-buttons">
			<button type="button" class="button save">{html_image src="cross-button.png"} {translate key='Delete'}</button>
			<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
		</div>
	</form>
</div>

{html_image src="admin-ajax-indicator.gif" class="indicator" style="display:none;"}
{jsfile src="admin/edit.js"}
{jsfile src="admin/resource-status.js"}
{jsfile src="js/jquery.form-3.09.min.js"}

<script type="text/javascript">

	$(document).ready(function ()
	{
		var opts = {
			submitUrl: '{$smarty.server.SCRIPT_NAME}',
			saveRedirect: '{$smarty.server.SCRIPT_NAME}'
		};

		var resourceStatus = new ResourceStatusManagement(opts);
		resourceStatus.init();
	})

</script>

{include file='globalfooter.tpl'}