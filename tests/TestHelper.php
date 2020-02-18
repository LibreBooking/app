<?php

use PHPUnit\Framework\TestSuite;

/**
 * Copyright 2020 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

class TestHelper
{
    public static $Debug = false;

    /**
     * @param string $relativePath
     * @param string[] $ignoreCallback
     * @return TestSuite
     */
    public static function GetSuite($relativePath, $ignoreCallback = array())
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
        $tests = array();

        if ($dh = opendir($directory)) {
            while (($file = readdir($dh)) !== false) {
                if (!self::Ignored($file, $ignoreCallback) && self::endsWith($file, "Tests.php")) {
                    $tests[] = new UnitTest($file);
                    if (self::$Debug) {
                        echo "Adding $file\n";
                    }
                }
                else {
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