<?php
if (!defined('PHPUnit2_MAIN_METHOD')) {
    define('PHPUnit2_MAIN_METHOD', 'AllTests::main');
}
 
$path = ini_get('include_path');
ini_set('include_path', $path . ';' . 'C:\PHP\PEAR');

define('ROOT_DIR', dirname(__FILE__) . '/../');

require_once 'PHPUnit/Framework/TestSuite.php';
require_once 'PHPUnit/TextUI/TestRunner.php';
 
require_once 'Framework/AllTests.php';

class AllTests {
    public static function main() {
        PHPUnit2_TextUI_TestRunner::run(self::suite());
    }
 
    public static function suite() {
        $suite = new PHPUnit2_Framework_TestSuite('PHPUnit');
 
        $suite->addTest(Framework_AllTests::suite());
        // ...
 
        return $suite;
    }
}
 
if (PHPUnit2_MAIN_METHOD == 'AllTests::main') {
    AllTests::main();
}
?>
?>
