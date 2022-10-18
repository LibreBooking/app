<div class="form-group {if !$searchmode && $attribute->Required()}has-feedback{/if} {if isset($class)}{$class}{/if}">
	<label class="customAttribute {if isset($readonly) && $readonly}readonly{elseif isset($searchmode) && $searchmode}search{else}standard{/if}" for="{$attributeId}">{$attribute->Label()}</label>
	{if isset($readonly) && $readonly}
		<span class="attributeValue {$class}">{$attribute->Value()}</span>
	{else}
		<input type="text" id="{$attributeId}" name="{$attributeName}" value="{$attribute->Value()}"
			   class="customAttribute form-control {if isset($inputClass)}{$inputClass}{/if}" {if $attribute->Required() && !$searchmode}required{/if}/>
		{if $attribute->Required() && !$searchmode}
		<i class="glyphicon glyphicon-asterisk form-control-feedback" data-bv-icon-for="{$attributeId}"></i>
		{/if}
        {if isset($searchmode) && $searchmode}
            <span class="searchclear searchclear-label glyphicon glyphicon-remove-circle" ref="{$attributeId}"></span>
        {/if}
	{/if}
</div>
