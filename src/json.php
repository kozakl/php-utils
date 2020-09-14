<?php
namespace kozakl\utils\json;

function encode($value, $options = 0, $depth = 512)
{
    if ($value) {
        return json_encode($value, $options, $depth);
    } else {
        return null;
    }
}
