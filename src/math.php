<?php
namespace kozakl\utils\math;

function clamp(float $current, float $min, float $max) {
    return max($min, min($max, $current));
}
