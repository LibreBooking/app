<div class="form-group {if !$searchmode && $attribute->Required()}has-feedback{/if} {$class}">
	<label class="customAttribute {if $readonly}readonly{elseif $searchmode}search{else}standard{/if}" for="{$attributeId}">{$attribute->Label()}</label>
	{if $readonly}
		<span class="attributeValue {$class}">{$attribute->Value()}</span>
	{else}
		<input type="text" id="{$attributeId}" name="{$attributeName}" value="{$attribute->Value()}"
			   class="customAttribute form-control {$inputClass}" {if $attribute->Required() && !$searchmode}required{/if}/>
		{if $attribute->Required() && !$searchmode}
		<i class="glyphicon glyphicon-asterisk form-control-feedback" data-bv-icon-for="{$attributeId}"></i>
		{/if}
        {if $searchmode}
            <span class="searchclear searchclear-label glyphicon glyphicon-remove-circle" ref="{$attributeId}"></span>
        {/if}
	{/if}
</div>
