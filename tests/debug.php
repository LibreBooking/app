<?php
define('ROOT_DIR', dirname(__FILE__) . '/../');
require_once(ROOT_DIR . 'tests/AllTests.php');
$suite = AllTests::suite();

$suite->run();
?>