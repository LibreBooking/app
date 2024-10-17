<div class="form-group {$class}">
	{assign value="{$attribute->Value()}" var="attributeValue"}
	<label class="customAttribute {if $readonly}readonly{elseif $searchmode}search{else}standard{/if} fw-bold"
		for="{$attributeId}">{$attribute->Label()}{if $attribute->Required() && !$searchmode}
			<i class="bi bi-asterisk text-danger align-top text-small"></i>
		{/if}</label>
	{if $readonly}
		<span class="attributeValue {$class}">{formatdate date=$attributeValue key=general_datetime}</span>
	{else}
		<input type="datetime-local" id="{$attributeId}" value="{formatdate date=$attributeValue format='Y-m-d H:i:s'}"
			class="customAttribute form-control {if !$searchmode && $attribute->Required()}has-feedback{/if} {$class}" />
		<input type="hidden" id="formatted{$attributeId}" name="{$attributeName}"
			value="{formatdate date=$attributeValue key=system_datetime}" />
		{control type="DatePickerSetupControl" ControlId="{$attributeId}" AltId="formatted{$attributeId}"
		HasTimepicker=true}
	{/if}
</div>