{extends file="schedule.tpl"}

{block name="header"}
{include file='globalheader.tpl' cssFiles='css/schedule.css,css/view-schedule.css'}
{/block}

{block name="scripts"}
<script type="text/javascript" src="scripts/js/jquery.qtip.min.js"></script>
<script type="text/javascript" src="scripts/schedule.js"></script>

<script type="text/javascript">

$(document).ready(function() {
	var schedule = new Schedule();
	schedule.initNavigation();
});
</script>

{/block}