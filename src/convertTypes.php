<?php
function convertTypes($schema, $rows)
{
    if (isset($rows[0])) {
        foreach ($rows as $rowsKey => $rowsValue) {
            $rows[$rowsKey] = convertRow($schema, $rows[$rowsKey]);
        }
        return $rows;
    } else {
        return convertRow($schema, $rows);
    }
}

function convertRow($schema, $row)
{
    foreach ($row as $rowKey => $rowValue) {
        if ($schema[$rowKey] == 'json') {
            $row[$rowKey] = json_decode($rowValue);
        } else {
            $row[$rowKey] = $schema[$rowKey]($rowValue);
        }
    }
    return $row;
}
