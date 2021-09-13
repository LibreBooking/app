<?php

define('ROOT_DIR', '../../');
require_once(ROOT_DIR . 'Pages/Ajax/AutoCompletePage.php');

$page = new AutoCompletePage();
if ($page->GetType() != AutoCompleteType::Organization) {
    $page = new SecurePageDecorator($page);
}
$page->PageLoad();
