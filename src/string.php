<?php
namespace kozakl\utils\string;

function removeTo(string $str, $search, $offsetRemove = 0, $offsetSearch = 0) {
    $index = strpos($str, $search, $offsetSearch);
    if ($index !== false) {
        return substr($str, $index + $offsetRemove);
    } else {
        return $str;
    }
}

function removeFrom(string $str, string $search, $offsetRemove = 0, $offsetSearch = 0) {
    $index = strpos($str, $search, $offsetSearch);
    if ($index !== false) {
        return substr($str, 0, $index + $offsetRemove);
    } else {
        return $str;
    }
}

function startsWith(string $str, string $search) {
  return strpos($str, $search) === 0;
}

function removePolishChars(string $str) {
    $map = [
        'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l',
        'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z', 'ż' => 'z',
        'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'E', 'Ł' => 'L',
        'Ń' => 'N', 'Ó' => 'O', 'Ś' => 'S', 'Ź' => 'Z', 'Ż' => 'Z'
    ];
    return strtr($str, $map);
}

function removeSpecialChars(string $str): string {
    $transliterator = \Transliterator::create('Any-Latin; Latin-ASCII; [:Nonspacing Mark:] Remove; NFC;');
    $str = $transliterator->transliterate($str);
    return preg_replace('/[^\p{L}\p{N}\s]/u', '', $str);
}
