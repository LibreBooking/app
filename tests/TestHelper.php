<?php

use PHPUnit\Framework\TestSuite;

class TestHelper
{
    public static $Debug = false;

    /**
     * @param string $relativePath
     * @param string[] $ignoreCallback
     * @return TestSuite
     */
    public static function GetSuite($relativePath, $ignoreCallback = [])
    {
        $testDirectory = ROOT_DIR . $relativePath;
        $tests = TestHelper::GetTests($testDirectory, $ignoreCallback);

        $suite = new TestSuite();

        /** @var UnitTest $test */
        foreach ($tests as $test) {
            if (self::$Debug) {
                echo "Adding " . get_class($test) . "\n";
            }
            $test->AddToSuite($suite, $testDirectory);
        }

        return $suite;
    }

    public static function GetTests($directory, $ignoreCallback)
    {
        $tests = [];

        if ($dh = opendir($directory)) {
            while (($file = readdir($dh)) !== false) {
                if (!self::Ignored($file, $ignoreCallback) && self::endsWith($file, "Tests.php")) {
                    $tests[] = new UnitTest($file);
                    if (self::$Debug) {
                        echo "Adding $file\n";
                    }
                } else {
                    if (self::$Debug) {
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
        if (empty($ignoreCallback)) {
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
