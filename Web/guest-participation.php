<?php

define('ROOT_DIR', '../');
require_once(ROOT_DIR . 'Pages/GuestParticipationPage.php');

$page = new GuestParticipationPage();
$page->PageLoad();
