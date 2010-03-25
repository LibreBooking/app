<?xml version="1.0" encoding="{$Charset}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{$CurrentLanguage}" lang="{$CurrentLanguage}">
	<head>
		<title>{$Title}</title>
		<meta http-equiv="Content-Type" content="text/html; charset={$Charset}" />
		{if $AllowRss && $LoggedIn}
			<link rel="alternate" type="application/rss+xml" title="phpScheduleIt" href="{$ScriptUrl}/rss.php?id={$UserId}" />
		{/if}
		<link rel="shortcut icon" href="favicon.ico"/>
		<link rel="icon" href="favicon.ico"/>
		<script type="text/javascript" src="{$Path}scripts/js/jquery-1.4.2.min.js"></script> 
		<script type="text/javascript" src="{$Path}scripts/js/jquery-ui-1.8rc3.custom.min.js"></script> 
		<script type="text/javascript" src="{$Path}scripts/phpscheduleit.js"></script> 
		<style type="text/css">
			@import url({$Path}css/style.css);
			@import url({$Path}scripts/css/smoothness/jquery-ui-1.8rc3.custom.css);
		</style>
	</head>
	<body>
	{control type="LeaderBoard" DisplayWelcomeMsg=$DisplayWelcome}
	<div id="shadow"></div>
	<div id="content">