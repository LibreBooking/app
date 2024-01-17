<?php

define('ROOT_DIR', '../');

require_once(ROOT_DIR . 'Pages/Admin/ResourceViewerViewResourcesPage.php');

$page = /*new RoleRestrictedPageDecorator(*/new ResourceViewerViewResourcesPage(new SmartyPage())/*, [RoleLevel::RESOURCE_ADMIN, RoleLevel::SCHEDULE_ADMIN])*/;
$page->PageLoad();