<?php
namespace kozakl\utils\validate;

function validateFields($fields, $schema, $default, $implode = true) {
    $schemaKeys = array_keys($schema);
    $result = array_filter(
        explode(',', $fields),
        fn($key) =>
            in_array($key, $schemaKeys)
    );
    if (empty($result)) {
        return $default;
    } else {
        return $implode ?
            implode(',', $result) :
            $result;
    }
}

function validateArrayFields($fields, $schema, $default, $implode = true) {
    $result = array_filter(
        explode(',', $fields),
        fn($key) =>
            in_array($key, $schema)
    );
    if (empty($result)) {
        return $default;
    } else {
        return $implode ?
            implode(',', $result) :
            $result;
    }
}

function validateSubObjectFields($fields, $columnNames) {
    return ",json_object(". implode(',', 
        array_map(fn($field) =>
            "'$field', $columnNames[1].$field",
            $fields
        )
    ). ") as {$columnNames[0]}";
}

function validateFilter($value, $filter, $options = []) {
    $unsetOptions = $options;
    unset($unsetOptions['default']);
    $valid = $value !== null && (
        !empty(trim($value)) ||
        $value == 0
    ) ?
        filter_var($value, $filter, [
            'flags' => FILTER_NULL_ON_FAILURE,
            'options' => $unsetOptions
        ]) : null;
    if ($valid !== null) {
        return $valid;
    } else {
        return $options['default'] ?? null;
    }
}
