<?php
namespace kozakl\utils\string;

function removeFrom($str, $search,
                    $offsetRemove = 0,
                    $offsetSearch = 0) {
    return substr($str, 0,
        strpos($str, $search, $offsetSearch) + $offsetRemove);
}

function removeTo($str, $search,
                  $offsetRemove = 0,
                  $offsetSearch = 0) {
    $index = strpos($str, $search, $offsetSearch);
    if ($index !== false) {
        return substr($str, $index + $offsetRemove);
    } else {
        return $str;
    }
}

function startsWith($str, $search) {
  return strpos($str, $search) === 0;
}
