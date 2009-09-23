<?php
// @TODO переименовать в Dubug
class Zend_Debug {
    /*
     * Выводит содержимое переменной
     * @param mixed $var
     * @param bool $return TRUE — возвратить строку без вывода, FALSE (по умолчанию) — вывести
     * @return string
     */
    public static function dump($var, $return = FALSE) {
        if ($return) {
            return var_export($var, TRUE);
        } else {
            print "\n<pre>\n";
            var_export($var);
            print "\n</pre>\n";
        }
    }

    public static function log($message) {
        Zend_Registry::get("log")->debug($message);
    }

    /**
     * Dump and Die
     * Выводит все переданные аргументы и останавливает выполнение скрипта.
     * Принимает сколько угодно параметров, в том числе 0.
     */
    public static function dd() {
        foreach (func_get_args() as $arg) {
            self::dump($arg);
        }
        die;
    }

    public static function profile() {
        global $profiler;
        echo '<div style="font-size:12px;">';
        $time = 0;
        $tq = 0;
        $queries = array();

        foreach ( $profiler as $event ) {
            $time += $event->getElapsedSecs();

            @$queries[ $event->getQuery() ][ 'time' ] += $event->getElapsedSecs();
            if ( $event->getName() == 'execute' ) {
                @$queries[ $event->getQuery() ][ 'cnt' ]++;
                $tq++;
            }
        }
        echo "Total time: $time<br />\n";
        echo "Total queries: $tq<br />\n";

        echo "<hr /><pre>";
        foreach ( $queries as $q => $info ) {
            echo @$info[ 'cnt' ]." :: ".sprintf( "%.05f", $info[ 'time' ] ). " => ".$q."\n";
        }
        echo "</pre></div>";
    }
}