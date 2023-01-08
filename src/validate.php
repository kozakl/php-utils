<?php
namespace kozakl\utils\validate;

function validateFields($fields, $schema, $default) {
    $result = implode(',', array_filter(
        explode(',', $fields),
        fn($key)=>
            in_array($key, array_keys($schema))
    ));
    return empty($result) ? $default : $result;
}

function validateFilter($value, $filter, $options = []) {
    $unsetOptions = $options;
    unset($unsetOptions['default']);
    $valid = !empty(trim($value)) ?
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
