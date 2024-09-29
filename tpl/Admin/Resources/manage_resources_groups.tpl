{if $resource->GetResourceGroupIds()|default:array()|count == 0}
	{translate key=None}
{/if}
{foreach from=$resource->GetResourceGroupIds() item=resourceGroupId name=eachGroup}
	<span class="resourceGroupId"
		data-value="{$resourceGroupId}">{$ResourceGroupList[$resourceGroupId]->name}</span>{if !$smarty.foreach.eachGroup.last},
	{/if}
{/foreach}