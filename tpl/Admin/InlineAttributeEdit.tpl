{*
Copyright 2015 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*}

{if $attribute->AppliesToEntity($id)}
	<div class="updateCustomAttribute">
		{assign var=datatype value='text'}
		{if $attribute->Type() == CustomAttributeTypes::CHECKBOX}
			{assign var=datatype value='checklist'}
		{elseif $attribute->Type() == CustomAttributeTypes::MULTI_LINE_TEXTBOX}
			{assign var=datatype value='textarea'}
		{elseif $attribute->Type() == CustomAttributeTypes::SELECT_LIST}
			{assign var=datatype value='select'}
		{/if}
		<label>{$attribute->Label()}</label>
		<span class="inlineAttribute"
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
		<a class="update changeAttribute" href="#"><span
					class="fa fa-pencil-square-o"></span></a>
	</div>
{/if}