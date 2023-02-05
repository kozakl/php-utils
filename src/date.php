<?php
namespace kozakl\utils\date;

function getHolidays($countryCode) {
    $holidays = [
        'PL' => [
            '01-01', '01-06', '05-01',
            '05-03', '08-15', '11-01',
            '11-11', '12-25', '12-24',
            '12-26'
        ]
    ];
    return $holidays[$countryCode];
}

function isWeekend($date) {
    return date('N', strtotime($date)) >= 6;
}

function isEaster($date, $corpusChristi = true) {
    $easter = date('Y-m-d', easter_date(date('Y', strtotime($date))));
    return $date == date('Y-m-d', strtotime($easter. '+1day')) ||
        ($corpusChristi && $date == date('Y-m-d', strtotime($easter. '+60day')));
}

function isHoliday($date, $countryCode = 'PL') {
    return isWeekend($date) ||
        isEaster($date) ||
        in_array(date('m-d', strtotime($date)), getHolidays($countryCode));
}
