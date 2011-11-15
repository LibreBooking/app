<?php
define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Export/CalendarExportPage.php');

$page = new CalendarExportPage();
$page->PageLoad();

?>