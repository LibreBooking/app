<?php
$path = ini_get('include_path');
ini_set('include_path', $path . ';' . 'C:\PHP\PEAR');

define('ROOT_DIR', dirname(__FILE__) . '/../');

require_once 'PHPUnit/TextUI/TestRunner.php';
require_once 'PHPUnit/Framework.php';
require_once ROOT_DIR . 'lib/Timer.class.php';
require_once ROOT_DIR . 'tests/data/namespace.php';
require_once ROOT_DIR . 'tests/fakes/namespace.php';
require_once ROOT_DIR . 'tests/TestBase.php';

$tests = array();
find_files(ROOT_DIR . 'tests', '/.+Tests.php/', 'add_test');

$suite = new PHPUnit_Framework_TestSuite('PHPUnit Framework');

for ($i = 0; $i < count($tests); $i++)
{
	require_once($tests[$i]);
	$fileWithDir = explode('/', $tests[$i]);
	$fileName = $tests[$i];

	if (count($fileWithDir) > 1)
	{
		$fileName = $fileWithDir[count($fileWithDir)-1];
	}

	$name_parts = explode('.', $fileName);
	$name  = $name_parts[0];
	$suite->addTestSuite($name);
}

PHPUnit_TextUI_TestRunner::run($suite);

function find_files($path, $pattern, $callback) 
{
  $path = rtrim(str_replace("\\", "/", $path), '/') . '/';
  $matches = Array();
  $entries = Array();
  $dir = dir($path);
  while (false !== ($entry = $dir->read())) {
    $entries[] = $entry;
  }
  $dir->close();
  foreach ($entries as $entry) {
    $fullname = $path . $entry;
    if ($entry != '.' && $entry != '..' && is_dir($fullname)) 
    {
      find_files($fullname, $pattern, $callback);
    } 
    else if (is_file($fullname) && preg_match($pattern, $entry)) 
    {
      call_user_func($callback, $fullname);
    }
  }
}

function add_test($filename)
{
	$tests[] = $filename;
}
?>