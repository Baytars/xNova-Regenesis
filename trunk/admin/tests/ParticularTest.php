#!/usr/bin/php
<?php
require_once realpath(dirname(__FILE__) . "/includes/bootstrap.php");

/**
 * Suite, предназначенный для выборочного запуска одного теста.
 * `./ParticularTest.php CaseTransformer` запустит Test_CaseTransformer.
 * `./ParticularTest.php CaseTransformer nodb` запустит Test_CaseTransformer без предварительной очистки базы данных.
 */
class ParticularTestSuite {
    public static function main() {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite() {
        // Сетапим базу
        if (empty($_SERVER["argv"][2])) {
            $script = new ConsoleScript_Database_Setup();
            $script->run();
        }

        // Настраиваем фильтры
        PHPUnit_Util_Filter::addDirectoryToFilter(TEST_ROOT);
        PHPUnit_Util_Filter::addDirectoryToFilter(ROOT . "/library");

        $suite = new PHPUnit_Framework_TestSuite("ChatRu");

        if (isset($_SERVER["argv"][1])) {
            $class_name = $_SERVER["argv"][1];
            $class_name = str_replace(DIRECTORY_SEPARATOR, "_", $class_name);
            if (substr($class_name, -4) == ".php") {
                $class_name = substr($class_name, 0, -4);
            }
            if (substr($class_name, 0, 5) != "Test_") {
                $class_name = "Test_" . $class_name;
            }
            print "Executing $class_name\n";
            if (class_exists($class_name)) {
                $suite->addTestSuite($class_name);
            } else {
                die("Class $class_name not found\n");
            }
        } else {
            die("You have to specify the test as the command line argument\n");
        }

        return $suite;
    }
}

ParticularTestSuite::main();