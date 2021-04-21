<?php

//$path = ini_get('include_path');
//ini_set('include_path', $path . ';' . 'C:\PHP\PEAR');

if (!defined('ROOT_DIR'))
{
	define('ROOT_DIR', dirname(__FILE__) . '/../');
}

//if (class_exists('PHPUnit')) {
//	require_once 'PHPUnit/Autoload.php';
//}
require_once(ROOT_DIR . 'vendor/autoload.php');
require_once(ROOT_DIR . 'tests/phpstorm.php');
require_once(ROOT_DIR . 'tests/UnitTest.php');
require_once(ROOT_DIR . 'tests/TestHelper.php');
require_once(ROOT_DIR . 'tests/TestBase.php');
require_once(ROOT_DIR . 'tests/fakes/namespace.php');
require_once(ROOT_DIR . 'lib/Common/Helpers/namespace.php');
use PHPUnit\Framework\TestSuite;

class AllTests
{
	public static function suite()
	{
		$suite = new TestSuite();
		self::AddSuites($suite);
		return $suite;
	}

	private static function AddSuites(TestSuite $suite)
	{
		$dir = ROOT_DIR . 'tests';

		$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir), RecursiveIteratorIterator::CHILD_FIRST);

		/** @var $path SplFileInfo  */
		foreach ($iterator as $path)
		{
			if (!$path->isDir())
			{
				$file = $path->getFilename();
				if (BookedStringHelper::EndsWith($file, 'Suite.php'))
				{
					$testName = str_replace('.php', '', $file);
					$fullPath = "{$path->getPath()}/$file";
					require_once($fullPath);
//					$suite = call_user_func("$testName::suite");

//					echo "built";
					$suite->addTestSuite(eval("return $testName::suite();"));
//					$suite->addTest(eval("return $testName::suite();"));
				}
			}
		}
	}
}
