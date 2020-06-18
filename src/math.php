<?php
function clamp($current, $min, $max) {
    return max($min, min($max, $current));
}
