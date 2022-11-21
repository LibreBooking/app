<div class="dashboard" id="announcementsDashboard">
	<div class="dashboardHeader">
		<div class="pull-left">{translate key="Announcements"} <span class="badge">{$Announcements|default:array()|count}</span></div>
		<div class="pull-right">
			<a href="#" title="{translate key=ShowHide} {translate key="Announcements"}">
				<i class="bi"></i>
                <span class="no-show">Expand/Collapse</span>
            </a>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="dashboardContents">
		<ul>
			{foreach from=$Announcements item=each}
				<li>{$each->Text()|html_entity_decode|url2link|nl2br}</li>
				{foreachelse}
				<div class="noresults">{translate key="NoAnnouncements"}</div>
			{/foreach}
		</ul>
	</div>
</div>
