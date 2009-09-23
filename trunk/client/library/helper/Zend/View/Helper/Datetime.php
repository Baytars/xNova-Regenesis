<?php
class Zend_View_Helper_Datetime extends Zend_View_Helper_Abstract {
    /**
     * Дата и/или время
     *
     * @param integer|string $datetime
     * @param double|null $timezone
     * @param boolean $show_date
     * @param boolean $show_time
     *
     * @return string
     */
    public function datetime($datetime, $timezone = NULL, $show_date = TRUE, $show_time = TRUE) {
        if (empty($datetime)) {
            return "";
        }

        if (is_string($datetime) && ((string)(integer)$datetime != $datetime)) {
            $datetime = strtotime($datetime);
        }

        if (!is_null($timezone)) {
            $zone = new DateTimeZone(date_default_timezone_get());
            $datetime = $datetime + $timezone * HOUR - $zone->getOffset(new DateTime("now"));
        }

        $result = array();
        if ($show_date) {
            $result []= date("d.m.Y", $datetime);
        }
        if ($show_time) {
            $result []= date("H:i", $datetime);
        }
        return implode(" ", $result);
    }
}