<div class="form-group {if !$searchmode && $attribute->Required()}has-feedback{/if} {$class}">
	{assign value="{$attribute->Value()}" var="attributeValue"}
	<label class="customAttribute {if $readonly}readonly{elseif $searchmode}search{else}standard{/if} fw-bold"
		for="{$attributeId}">{$attribute->Label()}</label>
	{if $readonly}
		<span class="attributeValue {$class}">{formatdate date=$attributeValue key=general_datetime}</span>
	{else}
		<input type="text" id="{$attributeId}" value="{formatdate date=$attributeValue key=general_datetime}"
			class="customAttribute form-control {$class}" />
		<input type="hidden" id="formatted{$attributeId}" name="{$attributeName}"
			value="{formatdate date=$attributeValue key=system_datetime}" />
		{if $attribute->Required() && !$searchmode}
			<i class="bi bi-asterisk form-control-feedback" data-bv-icon-for="{$attributeId}"></i>
		{/if}
		{control type="DatePickerSetupControl" ControlId="{$attributeId}" AltId="formatted{$attributeId}"
		HasTimepicker=true}
	{/if}
</div>