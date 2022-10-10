{if !isset($pageUrl) || $pageUrl == null}
{assign var=pageUrl value={Pages::CALENDAR}}
{/if}
{assign var=pageIdSuffix value="calendar"}
{assign var=subscriptionTpl value="calendar.subscription.tpl"}
{include file="Calendar/calendar-page-base.tpl"}
