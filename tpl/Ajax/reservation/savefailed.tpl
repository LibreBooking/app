Save Failed
<ul>
{foreach from=$Errors item=each}
	<li>{$each}</li>
{/foreach}
</ul>

<a href="javascript: CloseSaveDialog(); void(0);">Close</a>