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
		<button class="btn btn-default" type="button" id="moreResourceActions" data-toggle="dropdown">
            <span class="no-show">More</span>
			<span class="glyphicon glyphicon-option-vertical"></span>
			<span class="caret"></span>
		</button>
		<ul class="dropdown-menu" role="menu" aria-labelledby="moreResourceActions">

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
			<li role="presentation"><a role="menuitem"
									   href="{$Path}admin/manage_resources.php">{translate key="ManageResources"}</a>
			</li>
		</ul>
	</div>

	<h1>{translate key=$ResourcePageTitleKey}</h1>
</div>