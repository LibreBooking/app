<?php

define('ROOT_DIR', '../../');
$smartyTemplateCacheDir = ROOT_DIR . 'tpl_c';

/*
 * Checking directory permission
 */
if (SmartyPermissionsAreOk($smartyTemplateCacheDir)) {
    require_once(ROOT_DIR . 'Pages/InstallPage.php');

    $page = new InstallPage();
    $page->PageLoad();
} else {
    echo "The web server must have write access to $smartyTemplateCacheDir. ";
    echo "The permissions are currently set to " . substr(sprintf('%o', fileperms($smartyTemplateCacheDir)), -4);
}

/*
 * Determine the permission of given directory
 * @param string $smartyTemplateCacheDir location of tpl_c directory
 * @return bool|string bool when writabe, and string otherwise
 */
function SmartyPermissionsAreOk($smartyTemplateCacheDir) {
    if (!is_writable($smartyTemplateCacheDir)) {
        // Attempt to change permission of directory to 0770 - 1st section 0 for all storage type.
        return chmod($smartyTemplateCacheDir, 0770);    // often the attempt will fail
    }
    // @todo Why Nick returns false?
    return true; // false;
}

?>