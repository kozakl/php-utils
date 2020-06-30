<?php
namespace kozakl\utils\sql;

function prepare($sql, $values)
{
    foreach ($values as $name => $value) {
        $sql = preg_replace("/(?<!\w):$name(?!\w)/", $value, $sql);
    }
    return $sql;
}
