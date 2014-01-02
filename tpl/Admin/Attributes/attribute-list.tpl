{*
Copyright 2013-2014 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*}

<h3>{$Attributes|count} {translate key=Attributes}</h3>
{if $Attributes|count > 0}
<table class="list">
	<tr>
		<th>ID</th>
		<th>{translate key=SortOrder}</th>
		<th>{translate key=DisplayLabel}</th>
		<th>{translate key=Type}</th>
		<th>{translate key=Required}</th>
		<th>{translate key=AppliesTo}</th>
		<th>{translate key=ValidationExpression}</th>
		<th>{translate key=PossibleValues}</th>
		<th>{translate key=Delete}</th>
	</tr>
	{foreach from=$Attributes item=attribute}
		{cycle values='row0,row1' assign=rowCss}
		<tr class="{$rowCss} editable" attributeId="{$attribute->Id()}">
			<td>{$attribute->Id()}</td>
			<td>{$attribute->SortOrder()}</td>
			<td>{$attribute->Label()}</td>
			<td>{translate key=$Types[$attribute->Type()]}</td>
			<td>{if $attribute->Required()}
				{translate key=Yes}
				{else}
				{translate key=No}
			{/if}</td>
			<td>{if $attribute->UniquePerEntity()}
				{$attribute->EntityDescription()}
				{else}
				{translate key=All}
			{/if}</td>
			<td>{$attribute->Regex()}</td>
			<td>{$attribute->PossibleValues()}</td>
			<td align="center"><a href="#" class="update delete" attributeId="{$attribute->Id()}">{html_image src='cross-button.png'}</a></td>
		</tr>
	{/foreach}
</table>
{/if}

<script type="text/javascript">
	var attributeList = new Object();

	{foreach from=$Attributes item=attribute}
		attributeList[{$attribute->Id()}] = {
						id: {$attribute->Id()},
						label: "{$attribute->Label()|escape:'javascript'}",
						required: {$attribute->Required()},
						regex: "{$attribute->Regex()|escape:'javascript'}",
						possibleValues: "{$attribute->PossibleValues()|escape:'javascript'}",
						type: "{$attribute->Type()}",
						sortOrder: "{$attribute->SortOrder()}",
						entityId: "{$attribute->EntityId()}",
						entityDescription: "{$attribute->EntityDescription()|escape:'javascript'}"
					};
	{/foreach}

	$('#attributeList').data('list', attributeList);
</script>