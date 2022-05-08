<?php
namespace kozakl\utils;

/**
 * @deprecated 
 */
function slugify($text)
{
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    return $text;
}
