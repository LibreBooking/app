{include file='globalheader.tpl'}
<style type="text/css">
	@import url({$Path}css/admin.css);
</style>

<h1>Manage Schedules</h1>

<table class="admin">
	<tr>
		<th>Name</th>
		<th>Is Default?</th>
		<th>Starts On</th>
		<th>Days Shown</th>
		<th>Action</th>
		<th>Manage</th>
	</tr>
{foreach $Schedules item=schedule}
	{assign var=id value=$schedule->GetId()}
	<tr>
		<td>{$schedule->GetName()}</td>
		<td>{$schedule->GetIsDefault()}</td>
		<td>{$schedule->GetWeekdayStart()}</td>
		<td>{$schedule->GetDaysVisible()}</td>
		<td><a id="showdialog" href="javascript: void(0);">Activate</a>
		<td><a href="javascript: manageSchedule({$id}); void(0);">Manage</a>
	</tr>
{/foreach}
</table>

<div id="example" style="display:none;">

</div>

<script type="text/javascript">

$(document).ready(function() {

	var dialogOpts = {
        title: "Manage Schedule",
        modal: true,
        autoOpen: false,
        height: 500,
        width: 500,
        open: function() {
        	$("#example").load("{$Path}/login.php");}
        };
        
	$("#example").dialog(dialogOpts);    //end dialog
	    
	$('#showdialog').click(function() {
		$("#example").dialog("open");
		return false;
	});
	
});
</script>

{include file='globalfooter.tpl'}