<?php
namespace kozakl\utils;

function quote($obj)
{
    if (is_array($obj)) {
        foreach ($obj as $key => $value) {
            if (is_array($value)) {
                $obj[$key] = "'".json_encode($value)."'";
            } else if (is_bool($value)) {
                $obj[$key] = "'".intval($value)."'";
            } else if ($value) {
                $obj[$key] = "'$value'";
            } else {
                $obj[$key] = 'null';
            }
        }
        return $obj;
    } else if ($obj) {
        return "'$obj'";
    } else {
        return 'null';
    }
}
