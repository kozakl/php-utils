<?php
function removeFrom($str, $search,
                    $offsetRemove = 0,
                    $offsetSearch = 0) {
    return substr($str, 0,
        strpos($str, $search, $offsetSearch) + $offsetRemove);
}
