<?php
namespace kozakl\utils;

/**
 * @deprecated 
 */
function normalize($rows, $extra = null)
{
    $normalized = [
        'byId' => [],
        'all' => []
    ];
    foreach ($rows as $key => $value) {
        $normalized['byId'][$value['id']] = $value;
        $normalized['all'][] = +$value['id'];
    }
    
    $extra &&
        $normalized = array_merge($normalized, $extra);
    return $normalized;
}
