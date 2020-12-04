<?php
namespace kozakl\utils\validate;

function validateFields($fields, $schema, $default)
{
    $result = implode(',', array_filter(
        explode(',', $fields),
        fn($key)=>
            in_array($key, array_keys($schema))
    ));
    return empty($result) ? $default : $result;
}
