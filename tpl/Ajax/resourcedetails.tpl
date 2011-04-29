<div id="resourceDetails">
    <ul>
		<li>Description: {$description|url2link|nl2br}</li>
		<li>Notes: {$notes}</li>
		<li>Contact: {$contactInformation}</li>
		<li>Location: {$locationInformation}</li>
    </ul>
    
    {if $imageUrl neq ''}
        <img src="{$imageUrl}" />
    {/if}
</div>