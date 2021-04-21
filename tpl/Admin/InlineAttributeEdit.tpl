
{if $attribute->AppliesToEntity($id)}
	{assign var=attributeId value="inline{$attribute->Id()}{$id}"}
	<div class="updateCustomAttribute" style="margin-bottom:0px">
		{assign var=datatype value='text'}
		{if $attribute->Type() == CustomAttributeTypes::CHECKBOX}
			{assign var=datatype value='checklist'}
		{elseif $attribute->Type() == CustomAttributeTypes::MULTI_LINE_TEXTBOX}
			{assign var=datatype value='textarea'}
		{elseif $attribute->Type() == CustomAttributeTypes::SELECT_LIST}
			{assign var=datatype value='select'}
		{elseif $attribute->Type() == CustomAttributeTypes::DATETIME}
			{assign var=datatype value='combodate'}
			{assign var=value value={formatdate date=$value key=fullcalendar}}
		{/if}
		<h5 class="inline">{$attribute->Label()}</h5>
        <a class="update changeAttribute" href="#"><span class="fa fa-pencil-square-o"></span><span class="no-show">{translate key=Edit}</span></a>
		<span class="inlineAttribute"
			  id="inline{$attributeId}"
			  data-type="{$datatype}"
			  data-pk="{$id}"
			  data-value="{$value}"
			  data-name="{FormKeys::ATTRIBUTE_PREFIX}{$attribute->Id()}"
				{if $attribute->Type() == CustomAttributeTypes::SELECT_LIST}
					data-source='[{if !$attribute->Required()}{ldelim}value:"",text:""{rdelim},{/if}
				  {foreach from=$attribute->PossibleValueList() item=v name=vals}
						{ldelim}value:"{$v}",text:"{$v}"{rdelim}{if not $smarty.foreach.vals.last},{/if}
					{/foreach}]'
				{/if}
				{if $attribute->Type() == CustomAttributeTypes::CHECKBOX}
					data-source='[{ldelim}value:"1",text:"{translate key=Yes}"{rdelim}]'
				{/if}
				>
		</span>
		{if $attribute->Type() == CustomAttributeTypes::DATETIME}
			<script type="text/javascript">
				$(function() {
					$('#inline{$attributeId}').editable({
						url: "{$url}",
						viewformat: "{Resources::GetInstance()->GetDateFormat('momentjs_datetime')}",
						format: "YYYY-M-D H:m",
						template: "{Resources::GetInstance()->GetDateFormat('momentjs_datetime')}",
						combodate: {
							minYear: "{Date::Now()->AddYears(-20)->Format('Y')}",
							maxYear: "{Date::Now()->AddYears(20)->Format('Y')}",
							firstItem: "none"
						},
						emptytext: '-',
						emptyclass: '',
						toggle : 'manual',
						params : function(params) {
							params.CSRF_TOKEN = $('#csrf_token').val();
							return params;
						}
					});
				});
			</script>
		{/if}
	</div>
{/if}
