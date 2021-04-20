<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Export/AtomSubscriptionPage.php');

$page = new AtomSubscriptionPage();
if (Configuration::Instance()->GetSectionKey('ics', 'require.login', new BooleanConverter()))
{
    $page = new SecurePageDecorator($page);
}
$page->PageLoad();
