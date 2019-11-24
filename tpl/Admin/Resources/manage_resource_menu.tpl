{*
Copyright 2017-2019 Nick Korbel

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
<div>
    <div class="dropdown admin-header-more pull-right">
        <button class="btn btn-flat" type="button" id="moreResourceActions" data-target="dropdown-menu">
            <span class="fa fa-bars"></span>
            <span class="no-show">Expand</span>
        </button>
        <ul id="dropdown-menu" class="dropdown-content" role="menu" aria-labelledby="moreResourceActions">
			<li><a href="{$Path}admin/manage_resource_groups.php">{translate key="ManageResourceGroups"}</a></li>
			<li><a href="{$Path}admin/manage_resource_types.php">{translate key="ManageResourceTypes"}</a></li>
			<li><a href="{$Path}admin/manage_resource_status.php">{translate key="ManageResourceStatus"}</a></li>
			<li class="divider"></li>
			<li><a href="{$Path}admin/manage_resources.php">{translate key="ManageResources"}</a></li>
		</ul>
	</div>

	<h4>{translate key=$ResourcePageTitleKey}</h4>
</div>