{include file='globalheader.tpl'}
<style type="text/css">
	@import url({$Path}css/dashboard.css);
	@import url({$Path}css/jquery.qtip.css);
</style>

<ul id="dashboardList">
{foreach from=$items item=dashboardItem}
    <li>{$dashboardItem->PageLoad()}</li>
{/foreach}
</ul>

<script type="text/javascript" src="scripts/js/jquery.qtip.min.js"></script>
<script type="text/javascript" src="{$Path}scripts/dashboard.js"></script>

<script type="text/javascript">
$(document).ready(function() {

	var dashboardOpts = {
		reservationUrl: "{Pages::RESERVATION}?{QueryStringKeys::REFERENCE_NUMBER}=",
		summaryPopupUrl: "ajax/respopup.php"
	};

	var dashboard = new Dashboard(dashboardOpts);
	dashboard.init();   
});
</script>
{include file='globalfooter.tpl'}