{include file='globalheader.tpl' cssFiles='css/admin.css'}

<h1>{translate key=ServerSettings}</h1>

<ul>
	<li>Current Time: {$currentTime}</li>
	<li>Image Upload Physical Directory: {$imageUploadDirectory} (Permissions: {$imageUploadDirPermissions}) <a href="{$smarty.server.SCRIPT_URL}?{QueryStringKeys::ACTION}=changePermissions">Try to change permissions</a></li>
</ul>

{include file='globalfooter.tpl'}