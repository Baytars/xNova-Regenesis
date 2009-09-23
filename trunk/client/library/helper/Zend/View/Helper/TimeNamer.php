<?php
class Zend_View_Helper_TimeNamer extends Zend_View_Helper_Abstract {

    private static $_patterns = array(
        "ago" => "%u %s назад",
        "after" => "через %u %s",
        "moments_after" => "вот-вот",
        "moments_ago" => "только что",
        "tommorow" => "завтра %s",
        "yeasterday" => "вчера %s",
        "today" => "сегодня %s",
        "two_days_ago" => "позавчера %s",
        "two_days_after" => "послезавтра %s"
    );

    public static function timeNamer( $time ) {
        $event_time = $time;

        $date = explode( ' ', date( "d-m-Y H:i", $time ) );
        $cdate = explode( ' ', date( "d-m-Y H:i", time() ) );

        list( $date, $time ) = array(
            array_map( "intval", explode( "-", $date[ 0 ] ) ),
            array_map( "intval", explode( ":", $date[ 1 ] ) )
        );
        list( $cdate, $ctime ) = array(
            array_map( "intval", explode( "-", $cdate[ 0 ] ) ),
            array_map( "intval", explode( ":", $cdate[ 1 ] ) )
        );

        $years = $cdate[ 2 ] - $date[ 2 ];

        if ( $years > 2 || $years < -2 ) {
            $result = self::getPrint( $years, array(
                _( "год" ),
                _( "года" ),
                _( "лет" )
            ) );
        } else {
            $monthes = $years * 12 + $cdate[ 1 ] - $date[ 1 ];
            if ( $monthes > 2 || $monthes < -2 ) {
                $result = self::getPrint( $monthes, array(
                    _( "месяц" ),
                    _( "месяца" ),
                    _( "месяцев" )
                ) );

            } else {
                $days = $monthes * 30 + $cdate[ 0 ] - $date[ 0 ];

                if ( $days > 2 || $days < -2 ) {
                    $result = self::getPrint( $days, array(
                        _( "день" ),
                        _( "дня" ),
                        _( "дней" )
                    ) );
                    $hint = "time_date";
                } else {
                    $time_of_day = self::getTimeOfDay( $time[ 0 ] );

                    if ( $days == 1 || $days == -1 ) {
                        $result = self::getPrint( $days, null, "day", $time_of_day );
                    } else if ( $days == 2 || $days == -2 ) {
                        $result = self::getPrint( $days, null, "day", $time_of_day );
                    } else {
                        $hours = $days * 24 + $ctime[ 0 ] - $time[ 0 ];

                        if ( $hours >= 2 || $hours <= -2 ) {
                            $result = self::getPrint(
                                $hours,
                                array(
                                    _( "час" ),
                                    _( "часа" ),
                                    _( "часов" )
                                ) );
                        } else {
                            $minutes = $hours * 60 + $ctime[ 1 ] - $time[ 1 ];

                            if ( $minutes >= 2 || $minutes <= -2 ) {
                                $result = self::getPrint(
                                    $minutes,
                                    array(
                                        _( "минуту" ),
                                        "минуты",
                                        "минут"
                                    ) );
                            } else {
                                $result = self::getPrint( $minutes, null, "time" );
                            }
                        }

                        $hint = "time";
                    }
                }
            }
        }
        return self::decorateResult( $event_time, $result, !empty($hint) ? $hint : "date" );

    }

    private static function decorateResult( $time, $result, $hint ) {
        switch ( $hint ) {
            case 'time' :
                $hint = date( "H:i:s", $time );
            break;
            case 'date' :
                $hint = date( "d.m.Y", $time );
            break;
            case 'time_date' :
            default :
                $hint = date( "d.m.Y H:i", $time );
            break;
        }

        return sprintf( "<span title='%s'>%s</span>", $hint, $result );
    }

    private static function getTimeOfDay( $hour ) {
        if ( $hour >= 4 && $hour < 12 ) {
            return _( "утром" );
        } else if ( $hour >= 12 && $hour < 17 ) {
            return _( "днём" );
        } else if ( $hour >= 17 && $hour < 23 ) {
            return _( "вечером" );
        } else if ( ( $hour == 23 || $hour == 24 ) || $hour < 4 ) {
            return _( "ночью" );
        } else {
            return _( "bogus hour" );
        }
    }

    private static function getPrint( $date, array $declOfNum = NULL, $type = NULL, $time_of_day = NULL ) {
        switch ( $type ) {
            case 'day' :
                if ( $date == 2 || $date == -2 ) {
                    $ttype = $date == 2 ? 'two_days_ago' : 'two_days_after';
                } else if ( $date == 1 || $date == -1 ) {
                    $ttype = $date == 1 ? 'yeasterday' : 'tommorow';
                }
            break;

            case 'time' :
                $ttype = $date > 0 ? "moments_ago" : "moments_after";
            break;

            default :
                $ttype = $date > 0 ? "ago" : "after";
        }

        $date = $date < 0 ? $date * -1 : $date;

        if ( !$time_of_day ) {
            $pattern_args = array(
                $date,
                declOfNum( $date, $declOfNum ),
                $time_of_day
            );
        } else {
            $pattern_args = $time_of_day;
        }

        return vsprintf( _( self::$_patterns[ $ttype ] ), $pattern_args );
    }
}