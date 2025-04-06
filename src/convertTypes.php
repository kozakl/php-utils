<?php
namespace kozakl\utils;

function convertTypes($schema, $rows) {
    if (isset($rows[0])) {
        foreach ($rows as $rowsKey => $rowsValue) {
            $rows[$rowsKey] = convertRow($schema, $rowsValue);
        }
        return $rows;
    } else if ($rows) {
        return convertRow($schema, $rows);
    } else {
        return null;
    }
}

function convertRow($schema, $row) {
    foreach ($row as $rowKey => $rowValue) {
        if ($schema[$rowKey] == 'json') {
            $row[$rowKey] = json_decode($rowValue);
        } else if ($rowValue !== null) {
            $row[$rowKey] = $schema[$rowKey]($rowValue);
        } else {
            $row[$rowKey] = $rowValue;
        }
    }
    return $row;
}
