{assign var=manageResourcesUrl value="{$Path}admin/manage_resources.php"}
{if $CanViewResourceAdmin || $CanViewScheduleAdmin}
	{assign var=manageResourcesUrl value="{$Path}admin/manage_admin_resources.php"}
{/if}
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
									   href="{$manageResourcesUrl}">{translate key="ManageResources"}</a>
			</li>
		</ul>
	</div>

	<h1>{translate key=$ResourcePageTitleKey}</h1>
</div>
