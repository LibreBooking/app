<?php
/**
Copyright 2011-2017 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

$path = ini_get('include_path');
ini_set('include_path', $path . ';' . 'C:\PHP\PEAR');

if (!defined('ROOT_DIR'))
{
	define('ROOT_DIR', dirname(__FILE__) . '/../');
}

if (class_exists('PHPUnit')) {
	require_once 'PHPUnit/Autoload.php';
}

require_once(ROOT_DIR . 'tests/TestBase.php');
require_once(ROOT_DIR . 'tests/Fakes/namespace.php');
require_once(ROOT_DIR . 'lib/Common/Helpers/namespace.php');

class AllTests
{
	public static function suite()
	{
		$suite = new PHPUnit_Framework_TestSuite();
		self::AddSuites($suite);
		return $suite;
	}

	private static function AddSuites(PHPUnit_Framework_TestSuite $suite)
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
					$suite->addTest(eval("return $testName::suite();"));
				}
			}
		}
	}
}

class TestHelper
{
	public static $Debug = false;

	/**
	 * @param string $relativePath
	 * @param string[] $ignoreCallback
	 * @return PHPUnit_Framework_TestSuite
	 */
	public static function GetSuite($relativePath, $ignoreCallback = array())
	{
		$testDirectory = ROOT_DIR . $relativePath;
		$tests = TestHelper::GetTests($testDirectory, $ignoreCallback);

		$suite = new PHPUnit_Framework_TestSuite();

		foreach ($tests as $test)
		{
			$test->AddToSuite($suite, $testDirectory);
		}

		return $suite;
	}

	public static function GetTests($directory, $ignoreCallback)
	{
		$tests = array();

		if ($dh = opendir($directory))
		{
			while (($file = readdir($dh)) !== false)
			{
				if (!self::Ignored($file, $ignoreCallback) && self::endsWith($file, "Tests.php"))
				{
					$tests[] = new UnitTest($file);
					if (self::$Debug)
					{
						echo "Adding $file\n";
					}
				}
				else
				{
					if (self::$Debug)
					{
						echo "Ignored $file\n";
					}
				}
			}
			closedir($dh);
		}

		return $tests;
	}

	private static function Ignored($fileName, $ignoreCallback)
	{
		if (empty($ignoreCallback))
		{
			return false;
		}
		return call_user_func($ignoreCallback, $fileName);
	}

	private static function endsWith($haystack, $needle)
	{
		$length = strlen($needle);
		$start = $length * -1; //negative
		return (substr($haystack, $start, $length) === $needle);
	}

}

class UnitTest
{
	public $FileName;
	public $TestName;

	public function __construct($fileName)
	{
		$this->FileName = $fileName;

		$pathinfo = pathinfo($fileName);
		$this->TestName = $pathinfo['filename'];
	}

	public function AddToSuite($suite, $testDirectory)
	{
		$filePath = "$testDirectory/" . $this->FileName;
		if (TestHelper::$Debug)
		{
			echo "Adding test suite: $this->TestName from path: $filePath\n";
		}
		require_once($filePath);
		$suite->addTestSuite($this->TestName);
	}
}

?>