{assign var=manageResourcesUrl value="{$Path}admin/manage_resources.php"}
{if $CanViewResourceAdmin || $CanViewScheduleAdmin}
	{assign var=manageResourcesUrl value="{$Path}admin/manage_admin_resources.php"}
{/if}
<div class="clearfix border-bottom mb-3">
	<div class="dropdown admin-header-more float-end">
		<div class="btn-group" role="group">
			<button class="btn btn-primary dropdown-toggle" type="button" id="moreResourceActions"
				data-bs-toggle="dropdown">
				<span class="visually-hidden">{translate key='More'}</span>
				<i class="bi bi-three-dots-vertical"></i>
			</button>
			<ul class="dropdown-menu" role="menu" aria-labelledby="moreResourceActions">

				<li role="presentation"><a role="menuitem" class="dropdown-item"
						href="{$Path}admin/manage_resource_groups.php">{translate key="ManageResourceGroups"}</a>
				</li>
				<li role="presentation"><a role="menuitem" class="dropdown-item"
						href="{$Path}admin/manage_resource_types.php">{translate key="ManageResourceTypes"}</a>
				</li>
				<li role="presentation"><a role="menuitem" class="dropdown-item"
						href="{$Path}admin/manage_resource_status.php">{translate key="ManageResourceStatus"}</a>
				</li>
				<li>
					<hr class="dropdown-divider">
				</li>
				<li role="presentation"><a role="menuitem" class="dropdown-item"
						href="{$manageResourcesUrl}">{translate key="ManageResources"}</a>
				</li>
			</ul>
		</div>
	</div>

	<h1>{translate key=$ResourcePageTitleKey}</h1>
</div>