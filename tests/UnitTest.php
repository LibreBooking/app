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

    /**
     * @param TestSuite $suite
     * @param string $testDirectory
     */
    public function AddToSuite($suite, $testDirectory)
    {
        $filePath = "$testDirectory/" . $this->FileName;
        if (TestHelper::$Debug) {
            echo "Adding test suite: $this->TestName from path: $filePath\n";
        }
        require_once($filePath);
        $suite->addTestSuite($this->TestName);
    }
}