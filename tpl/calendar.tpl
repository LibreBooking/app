{include file='globalheader.tpl' cssFiles='css/calendar.css,css/jquery.qtip.css,scripts/css/fullcalendar.css'}

<div id="filter">
{translate key="ChangeCalendar"}
<select id="calendarFilter" class="textbox">
{foreach from=$filters->GetFilters() item=filter}
	<option value="{$filter->Id()}" class="schedule" {if $filter->Selected()}selected="selected"{/if}>{$filter->Name()}</option>
	{foreach from=$filter->GetFilters() item=subfilter}
		<option value="{$subfilter->Id()}" class="resource" {if $subfilter->Selected()}selected="selected"{/if}>{$subfilter->Name()}</option>
	{/foreach}
{/foreach}

</select>
</div>

{include file='mycalendar.common.tpl' view='month'}

{include file='globalfooter.tpl'}
