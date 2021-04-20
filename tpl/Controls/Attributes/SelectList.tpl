<div class="form-group {$class} {if !$searchmode && $attribute->Required()}has-feedback{/if}">
    <label class="customAttribute {if $readonly}readonly{elseif $searchmode}search{else}standard{/if}"
           for="{$attributeId}">{$attribute->Label()}</label>
    {if $readonly}
        <span class="attributeValue {$class}">{$attribute->Value()}</span>
    {else}
        <select id="{$attributeId}" name="{$attributeName}" class="customAttribute form-control {$inputClass}"
                {if $attribute->Required() && !$searchmode}required{/if}>
            <option value="">--</option>
            {foreach from=$attribute->PossibleValueList() item=value}
                <option value="{$value}"
                        {if $attribute->Value() == $value}selected="selected"{/if}>{$value}</option>
            {/foreach}
        </select>
        {if $attribute->Required() && !$searchmode}
            <i class="glyphicon glyphicon-asterisk form-control-feedback" data-bv-icon-for="{$attributeId}"></i>
        {/if}
    {/if}
</div>
