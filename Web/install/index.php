<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

define('ROOT_DIR', '../../');
$smartyTemplateCacheDir = ROOT_DIR . 'tpl_c';

/**
 * Checking directory permission
 */
if (SmartyPermissionsAreOk($smartyTemplateCacheDir))
{
	require_once(ROOT_DIR . 'Pages/InstallPage.php');
	$page = new InstallPage();
	$page->PageLoad();
}
else
{
	echo "The web server (such as _www on Mac or apache on Linux) must have write access to $smartyTemplateCacheDir. ";
	echo "<br/>The permissions are currently set is " . substr(sprintf('%o', fileperms($smartyTemplateCacheDir)), -4);
	echo "<br/>You can either change $smartyTemplateCacheDir to group for example: _www/apache accordingly";
	echo "<br/>Or change $smartyTemplateCacheDir to have permission 777 which is only for testing due to security vulnerability.";
}

/**
 * Determine the permission of given directory
 * @param string $smartyTemplateCacheDir location of tpl_c directory
 * @return bool|string bool when writabe, and string otherwise
 */
function SmartyPermissionsAreOk($smartyTemplateCacheDir)
{
	if (!is_writable($smartyTemplateCacheDir))
	{
		// Attempt to change permission of directory to 0770 - 1st section 0 for all storage type.
		return chmod($smartyTemplateCacheDir, 0770); // often the attempt will fail
	}

	return true;
}

?>