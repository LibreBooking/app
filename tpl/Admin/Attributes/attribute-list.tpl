<h3>{$Attributes|count} {translate key=Attributes}</h3>
{if $Attributes|count > 0}
	<table class="table">
		<thead>
		<tr>
			<th>ID</th>
			<th>{translate key=SortOrder}</th>
			<th>{translate key=DisplayLabel}</th>
			<th>{translate key=Type}</th>
			<th>{translate key=Required}</th>
			{if $Category != CustomAttributeCategory::RESERVATION}
				<th>{translate key=AppliesTo}</th>
			{/if}
			<th>{translate key=CollectedFor}</th>
			<th>{translate key=ValidationExpression}</th>
			<th>{translate key=PossibleValues}</th>
			{if $Category == CustomAttributeCategory::RESERVATION}
				<th>{translate key=Private}</th>
			{/if}
			<th>{translate key=AdminOnly}</th>
			<th class="action">{translate key=Edit}</th>
			<th class="action">{translate key=Delete}</th>
		</tr>
		</thead>
		<tbody>
		{foreach from=$Attributes item=attribute}
			{cycle values='row0,row1' assign=rowCss}
			<tr class="{$rowCss}" attributeId="{$attribute->Id()}">
				<td>{$attribute->Id()}</td>
				<td>{$attribute->SortOrder()}</td>
				<td>{$attribute->Label()}</td>
				<td>{translate key=$Types[$attribute->Type()]}</td>
				<td>{if $attribute->Required()}
						{translate key=Yes}
					{else}
						{translate key=No}
					{/if}</td>
				{if $Category != CustomAttributeCategory::RESERVATION}
					<td>{if $attribute->UniquePerEntity()}
							{', '|implode:$attribute->EntityDescriptions()}
						{else}
							{translate key=All}
						{/if}
					</td>
				{/if}
				<td>
					{if $attribute->HasSecondaryEntities()}
						{', '|implode:$attribute->SecondaryEntityDescriptions()}
					{else}
						{translate key=All}
					{/if}
				</td>
				<td>{$attribute->Regex()}</td>
				<td>{$attribute->PossibleValues()}</td>
				{if $Category == CustomAttributeCategory::RESERVATION}
					<td>{if $attribute->IsPrivate()}
							{translate key=Yes}
						{else}
							{translate key=No}
						{/if}</td>
				{/if}
				<td>{if $attribute->AdminOnly()}{translate key=Yes}{else}{translate key=No}{/if}</td>
				<td class="action">
					<a href="#" class="update edit">
                        <span class="no-show">{translate key=Edit}</span>
                        <span class="fa fa-edit icon edit"></span>
                    </a>
				</td>
				<td class="action">
					<a href="#" class="update delete" attributeId="{$attribute->Id()}">
                        <span class="no-show">{translate key=Remove}</span>
                        <span class="fa fa-trash icon remove"></span>
                    </a>
				</td>
			</tr>
		{/foreach}
		</tbody>
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
		{if $attribute->EntityIds()|count > 0}
		entityIds: ["{'","'|implode:$attribute->EntityIds()}"],
		{else}
		entityIds: [],
		{/if}
		entityDescriptions: ["{'","'|implode:$attribute->EntityDescriptions()}"],
		adminOnly: {$attribute->AdminOnly()},
		{if $attribute->HasSecondaryEntities()}
		secondaryEntityIds: ["{'","'|implode:$attribute->SecondaryEntityIds()}"],
		secondaryEntityDescriptions: ["{'","'|implode:$attribute->SecondaryEntityDescriptions()}"],
		{else}
		secondaryEntityIds: [],
		secondaryEntityDescriptions: [],
		{/if}
		secondaryCategory: "{$attribute->SecondaryCategory()}",
		isPrivate: "{$attribute->IsPrivate()}"
	};
	{/foreach}

	$('#attributeList').data('list', attributeList);
</script>
