{include file='header.tpl'}

<select name="type_id">
    {object_html_options options=$Schedules key="GetId" label="GetName"}
</select>

{include file='footer.tpl'}