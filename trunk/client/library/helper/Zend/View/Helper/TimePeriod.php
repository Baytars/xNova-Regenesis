<?php
/**
 * Tool to display time in UNIXTIMESTAMP in the natural language form
 *
 * @author besisland <besisland@gmail.com>
 */
class Zend_View_Helper_TimePeriod extends Zend_View_Helper_Abstract {
    private static $ranges = array( # перечислять надо по убыванию
        DAY     => array( "day", "days", "days" ),
        HOUR    => array( "hour", "hour", "hours" ),
        MINUTE  => array( "minute", "minute", "minutes" ),
        SECOND  => array( "second", "second", "seconds" ),
    );

    /**
     * Срок (продолжительность): 2 часа; 7 дней…
     *
     * @param integer $time количество секунд
     *
     * @return string
     */
    public function timePeriod( $time ) {
        $time = (int)$time;
        foreach ( self::$ranges as $range => $names ) {
            if ( $time >= $range ) {
                $number = round( $time / $range );
                return $number . " " . $this->view->escape( declOfNum( $number, $names ) );
            }
        }
        return $time . " с"; # на всякий случай
    }
}