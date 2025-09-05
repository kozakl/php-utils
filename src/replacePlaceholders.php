<?php
namespace kozakl\utils;

use PDO;

function replacePlaceholders(string $template, array $data) {
    foreach ($data as $key => $value) {
        $template = str_replace("{{{$key}}}", $value, $template);
    }
    return $template;
}
