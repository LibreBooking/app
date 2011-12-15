<div class="dashboard" id="announcementsDashboard">
	<div id="announcementsHeader" class="dashboardHeader">
		<a href="javascript:void(0);" title="{translate key='ShowHide'}">{translate key="Announcements"}</a>
	</div>
	<div class="dashboardContents">
		<ul>
			{foreach from=$Announcements item=each}
			    <li>{$each|html_entity_decode|nl2br}</li>
			{foreachelse}
				<div class="noresults">{translate key="NoAnnouncements"}</div>
			{/foreach}
		</ul>
	</div>
</div>