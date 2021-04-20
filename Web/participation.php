<?php

define('ROOT_DIR', '../');
require_once(ROOT_DIR . 'Pages/ParticipationPage.php');

$page = new ParticipationPage();
$page->PageLoad();
