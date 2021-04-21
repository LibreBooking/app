<?php

use PHPUnit\Framework\TestSuite;

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
