{include file='globalheader.tpl' cssFiles='css/admin.css'}

<h1>{translate key=ManageReservations}</h1>

<div>
	Between
	<input type="textbox" class="datepicker textbox" value="{formatdate date=$StartDate}"/> and
	<input type="textbox" class="datepicker textbox" value="{formatdate date=$EndDate}"/>
	<button class="button">{html_image src="search.png"} Filter</button>
</div>

<table class="list">
	<tr>
		<th class="id">&nbsp;</th>
		<th>{translate key='Name'}</th>
		<th>{translate key='Resource'}</th>
		<th>{translate key='Start'}</th>
		<th>{translate key='End'}</th>
		<th>{translate key='Delete'}</th>
	</tr>
	{foreach from=$reservations item=reservation}
	{cycle values='row0,row1' assign=rowCss}
	<tr class="{$rowCss} editable">
		<td>{$reservation->ReferenceNumber}</td>
	</tr>
	{/foreach}
</table>

{pagination pageInfo=$PageInfo}

{literal}
<script type="text/javascript">

$(document).ready(function() {

	$('.datepicker').datepicker();
});
</script>
{/literal}
{include file='globalfooter.tpl'}