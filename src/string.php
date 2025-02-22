<?php
namespace kozakl\utils\string;

function removeTo($str, $search, $offsetRemove = 0, $offsetSearch = 0) {
    $index = strpos($str, $search, $offsetSearch);
    if ($index !== false) {
        return substr($str, $index + $offsetRemove);
    } else {
        return $str;
    }
}

function removeFrom($str, $search, $offsetRemove = 0, $offsetSearch = 0) {
    $index = strpos($str, $search, $offsetSearch);
    if ($index !== false) {
        return substr($str, 0, $index + $offsetRemove);
    } else {
        return $str;
    }
}

function startsWith($str, $search) {
  return strpos($str, $search) === 0;
}

function removePolishChars($str) {
    $map = [
        'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l',
        'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z', 'ż' => 'z',
        'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'E', 'Ł' => 'L',
        'Ń' => 'N', 'Ó' => 'O', 'Ś' => 'S', 'Ź' => 'Z', 'Ż' => 'Z'
    ];
    return strtr($str, $map);
}
