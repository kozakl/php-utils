<?php
namespace kozakl\utils;

function uploadedImages($uploaded, $body, $path) {
    foreach ($body ?? [] as $key => $val) {
        is_null($val) &&
            $body[$key] = new UploadedImage(array_shift($uploaded), $path);
    }
    return $body;
}
