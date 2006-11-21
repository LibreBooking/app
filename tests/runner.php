<?php
require_once('PHPUnit.php');
require_once('PHPUnit/GUI/HTML.php');

$tests = array('ConfigTests.php', 'DatabaseTests.php', 'EmailTests.php', 'Mdb2CommandAdapterTests.php', 'Mdb2ConnectionTests.php', 'Mdb2ReaderTests.php');
$suites = array();

foreach($tests as $test){
	$name_parts = explode('.', $test);
	$suites[] = new PHPUnit_TestSuite($name_parts[0]);
}

$runner = new PHPUnit_GUI_HTML($suites);
$runner->show();
?>