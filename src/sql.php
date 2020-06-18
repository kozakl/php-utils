<?php
namespace kozakl\utils\sql;

function prepare($sql, $values)
{
    foreach ($values as $name => $value) {
        $sql = str_replace(":$name", $value, $sql);
    }
    return $sql;
}
