{include file='header.tpl'}

<select name="type_id">
    {object_html_options options=$Schedules key="GetId" label="GetName"}
</select>

<table>
{section loop=$Resources name=test}
	<tr>
		<td>{$Resources[test]->GetName()}</td>
	</tr>
{/section}

{foreach from=$Resources item=resource name=resource_loop}
	<tr>
		<td>{$resource->GetName()}</td>
	</tr>
{/foreach}
<table>

{include file='footer.tpl'}