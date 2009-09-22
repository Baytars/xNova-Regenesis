<?php
require_once 'includes/BasicTestSuite.php';

class AllTests {
    public static function main() {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite() {
        $suite = new BasicTestSuite();
        return $suite->getSuite(dirname(__FILE__) . '/Test/'); // это super suite для всех тестов; у обычных suite, которые располагаются в соответствующих директориях, суффикса '/Test/' не будет
    }
}