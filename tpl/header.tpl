<?xml version="1.0" encoding="{$Charset}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{$CurrentLanguage}" lang="{$CurrentLanguage}">
	<head>
		<title>{$Title}</title>
		<meta http-equiv="Content-Type" content="text/html; charset={$Charset}" />
		{if $AllowRss && $LoggedIn}
			<link rel="alternate" type="application/rss+xml" title="phpScheduleIt" href="{$ScriptUrl}/rss.php?id={$UserId}" />
		{/if}
		<link rel="shortcut icon" href="favicon.ico"/>
		<link rel="icon" href="favicon.ico"/>
		<script language="JavaScript" type="text/javascript" src="{$Path}scripts/prototype.js"></script> 
		<script language="JavaScript" type="text/javascript" src="{$Path}scripts/scriptaculous.js"></script> 
		<script language="JavaScript" type="text/javascript" src="{$Path}scripts/phpscheduleit.js"></script> 
		<!--
		<script language="JavaScript" type="text/javascript" src="{$Path}functions.js"></script>
		<script language="JavaScript" type="text/javascript" src="{$Path}ajax.js"></script>
		-->
		<style type="text/css">
		@import url({$Path}jscalendar/calendar-blue-custom.css);
		@import url({$Path}style.css);
		</style>
		<script type="text/javascript" src="{$Path}jscalendar/calendar.js"></script>
		<script type="text/javascript" src="{$Path}jscalendar/lang/{$CalendarJSFile}"></script>
		<script type="text/javascript" src="{$Path}jscalendar/calendar-setup.js"></script>
	</head>
	<body>
	{control type="LeaderBoard" DisplayWelcomeMsg=$DisplayWelcome}
	<div id="shadow" style="background:url('{$Path}img/shadow.png');"></div>
	<div id="content">