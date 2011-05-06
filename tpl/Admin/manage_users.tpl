{include file='globalheader.tpl'}
<style type="text/css">
	@import url({$Path}css/admin.css);
</style>

<h1>Manage Users</h1>

<p>{$totalResults} Total Users</p>

<table>
{foreach from=$users item=user}
	{cycle values='row0,row1' assign=rowCss}
	<tr class="{$rowCss}">
		<td>{$user->Id}</td>
		<td>{$user->First}</td>
		<td>{$user->Email}</td>
		<td>{$user->LastLogin}</td>
	 </tr>
{/foreach}
</table>

<p>
Page {$page} of {$totalPages}

{foreach from=$pages item=page}
	<!-- put $PageUrl on Page object or create |page filter -->
	<a class="page" href="">{$page}</a>&nbsp;
{/foreach}
</p>

{include file='globalfooter.tpl'}