<?php
namespace kozakl\utils\date;

function isWeekend($date) {
    return date('N', strtotime($date)) >= 6;
}

function isEaster($date, $corpusChristi = true) {
    $easter = date('Y-m-d', easter_date(date('Y', strtotime($date))));
    return $date == date('Y-m-d', strtotime($easter. '+1day')) ||
        ($corpusChristi && $date == date('Y-m-d', strtotime($easter. '+60day')));
}

function isHoliday($date) {
    return self::isWeekend($date) ||
           self::isEaster($date)  ||
           in_array(date('m-d', strtotime($date)), self::$holidays);
}
