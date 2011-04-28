<div>
    {$resourceName}
    {$description}
    {$notes}
    {$contactInformation}
	{$locationInformation}

    
    {if $imageUrl neq ''}
        <img src="{$Path}{$imageUrl}" />
    {/if}
</div>