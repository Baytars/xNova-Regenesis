<?php
require_once realpath(dirname(__FILE__) . "/bootstrap.php");

/**
 * Базовый класс, предназначенный для созданий TestSuite. Пример использования см. в AllTests.php
 */
class BasicTestSuite {
    /** @var PHPUnit_Framework_TestSuite формируемый набор тестов */
    private $suite;
    private $root_dir;
    private $root_dir_len;

    /**
     * Подключает все php-файлы в данной директории как тесты
     * @param string $dir директория
     * @param bool $recursive производить ли рекурсивный поиск
     */
    private function addTestsFromDir($dir, $recursive = TRUE) {
        foreach (glob($dir . "*.php") as $file) {
            // Файлы AllTests.php пропускаются, все остальные считаются тестами
            if ("AllTests.php" == substr($file, -12)) {
                continue;
            }
            $test_class_name = "Test_" . str_replace(DIRECTORY_SEPARATOR, "_", substr($file, $this->root_dir_len, -4));
            try {
                print "Подключён тест $test_class_name\n";
                $this->suite->addTestSuite($test_class_name);
            } catch (Exception $e) {
                print "Ошибка при загрузке $test_class_name\n";
            }
        }
        if ($recursive) {
            foreach (glob($dir . "*", GLOB_ONLYDIR | GLOB_MARK) as $file) {
                if ($file{0} == ".") {
                    continue;
                }
                $this->addTestsFromDir($file);
            }
        }
    }

    /**
     * Формирует набор тестов
     * @param string $dir директория
     * @param bool $recursive производить ли рекурсивный поиск
     * @return PHPUnit_Framework_TestSuite
     */
    public function getSuite($dir = ".", $recursive = TRUE) {
        // Сетапим базу
        $script = new ConsoleScript_Database_Setup();
        $script->run();

        // Настраиваем фильтры
        PHPUnit_Util_Filter::addDirectoryToFilter(TEST_ROOT);
        PHPUnit_Util_Filter::addDirectoryToFilter(ROOT . "/library");

        $this->suite = new PHPUnit_Framework_TestSuite("ChatRu");

        $this->root_dir = TEST_ROOT . "/Test/";
        $this->root_dir_len = strlen($this->root_dir);
        $this->addTestsFromDir(realpath($dir) . "/", $recursive);

        return $this->suite;
    }
}