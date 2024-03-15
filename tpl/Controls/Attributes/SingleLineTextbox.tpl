<div class="form-group {if isset($class)}{$class}{/if}">
	<label
		class="customAttribute {if isset($readonly) && $readonly}readonly{elseif isset($searchmode) && $searchmode}search{else}standard{/if} fw-bold"
		for="{$attributeId}">{$attribute->Label()}{if $attribute->Required() && !$searchmode}
			<i class="bi bi-asterisk text-danger align-top text-small"></i>
		{/if}</label>
	{if isset($readonly) && $readonly}
		<span class="attributeValue {$class}">{$attribute->Value()}</span>
	{else}
		<input type="search" id="{$attributeId}" name="{$attributeName}" value="{$attribute->Value()}" class="customAttribute form-control {if isset($inputClass)}{$inputClass}{/if}
		{if !$searchmode && $attribute->Required()}has-feedback{/if}"
			{if $attribute->Required() && !$searchmode}required="required" {/if} />
		{*{if isset($searchmode) && $searchmode}
			<span class="searchclear searchclear-label bi bi-x-circle d-none" ref="{$attributeId}"></span>
		{/if}*}
	{/if}
</div>