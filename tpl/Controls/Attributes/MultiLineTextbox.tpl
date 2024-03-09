<div class="form-group {if !$searchmode && $attribute->Required()}has-feedback{/if} {$class}">
    <label class="customAttribute {if $readonly}readonly{elseif $searchmode}search{else}standard{/if} fw-bold"
        for="{$attributeId}">{$attribute->Label()}</label>
    {if $readonly}
        <span class="attributeValue {$class}">{$attribute->Value()|nl2br}</span>
    {else}
        <textarea id="{$attributeId}" name="{$attributeName}" rows="2" class="customAttribute form-control {$inputClass}"
            {if $attribute->Required() && !$searchmode}required{/if}>{$attribute->Value()}</textarea>
        {if $attribute->Required() && !$searchmode}
            <i class="bi bi-asterisk form-control-feedback" data-bv-icon-for="{$attributeId}"></i>
        {/if}
        {if $searchmode}
            <span class="searchclear searchclear-label bi bi-x-circle" ref="{$attributeId}"></span>
        {/if}
    {/if}
</div>