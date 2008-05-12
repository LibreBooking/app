{include file='header.tpl'}
<div class="dashboardBorder">
	<div id="announcementsHeader" class="dashboardHeader">
		<a href="javascript:void(0);" onclick="showHideDashboard('announcementsDash')" title="{translate key='ShowHide'}">{translate key="Announcements"}</a>
	</div>
	<div id="announcementsDash" style="display:{$AnnouncementsDisplayStyle};">
		<ul>
			{foreach from=$Announcements item=each}
			    <li>{$each}</li>
			{foreachelse}
				{translate key="NoAnnouncements"}
			{/foreach}
		</ul>
	</div>
</div>
{include file='footer.tpl'}