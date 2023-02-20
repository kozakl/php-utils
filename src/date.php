<?php
namespace kozakl\utils\date;

function getHolidays($countryCode) {
    $holidays = [
        'ch' => [
            '01-01', '01-02', '01-21',
            '01-22', '01-23', '01-24',
            '01-25', '01-26', '01-27',
            '04-05', '04-29', '04-30',
            '05-01', '05-02', '05-03',
            '06-22', '06-23', '06-24',
            '09-29', '09-30', '10-01',
            '10-02', '10-03', '10-04',
            '10-05', '10-06', '12-30',
            '12-31'
        ],
        'jp' => [
            '01-01', '01-02', '01-09',
            '02-11', '02-23', '03-21',
            '04-29', '05-03', '05-04',
            '05-05', '07-17', '08-11',
            '09-18', '09-23', '10-09',
            '11-03', '11-23'
        ],
        'pl' => [
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

function isHoliday($date, $countryCode = 'pl') {
    if ($countryCode == 'ch' ||
        $countryCode == 'jp') {
        return isWeekend($date) ||
            in_array(date('m-d', strtotime($date)), getHolidays($countryCode));
    } else if ($countryCode == 'pl') {
        return isWeekend($date) ||
            isEaster($date) ||
            in_array(date('m-d', strtotime($date)), getHolidays($countryCode));
    }
}
