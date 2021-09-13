<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Integrate/SlackPage.php');

$page = new SlackPage();
$page->PageLoad();
