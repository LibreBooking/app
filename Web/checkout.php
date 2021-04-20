<?php

define('ROOT_DIR', '../');
require_once(ROOT_DIR . 'Pages/Credits/CheckoutPage.php');

$page = new SecurePageDecorator(new CheckoutPage());
$page->PageLoad();
