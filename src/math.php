<?php
namespace kozakl\utils\math;

function clamp($current, $min, $max) {
    return max($min, min($max, $current));
}
