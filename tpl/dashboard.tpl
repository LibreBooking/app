{include file='globalheader.tpl'}

<ul id="dashboardList">
{foreach from=$items item=dashboardItem}
    <li>{$dashboardItem->PageLoad()}</li>
{/foreach}
</ul>

{include file='globalfooter.tpl'}