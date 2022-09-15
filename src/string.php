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
