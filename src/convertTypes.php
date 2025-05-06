<?php
namespace kozakl\utils;

function convertTypes($schema, $rows, $asObject = false) {
    if (isset($rows[0])) {
        foreach ($rows as $rowsKey => $rowsValue) {
            $rows[$rowsKey] = convertRow($schema, $rowsValue);
        }
        return $asObject ?
            (object)$rows : $rows;
    } else if ($rows) {
        return $asObject ?
            (object)convertRow($schema, $rows) :
            convertRow($schema, $rows);
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
