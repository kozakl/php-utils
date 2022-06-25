<?php
namespace kozakl\utils\number;

function pad2($n) {
    if ($n < 10)
        return '0'. $n;
    return ''. $n;
}

function pad3($n) {
    if ($n < 10)
        return '00'. $n;
    else if ($n < 100)
        return '0'. $n;
    return ''. $n;
}

function pad4($n) {
    if ($n < 10)
        return '000'. $n;
    else if ($n < 100)
        return '00'. $n;
    else if ($n < 1000)
        return '0'. $n;
    return ''. $n;
}

function pad5($n) {
    if ($n < 10)
        return '0000'. $n;
    else if ($n < 100)
        return '000'. $n;
    else if ($n < 1000)
        return '00'. $n;
    else if ($n < 10000)
        return '0'. $n;
    return ''. $n;
}
