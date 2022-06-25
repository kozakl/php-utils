<?php
namespace kozakl\utils;
use Exception;

/**
 * @throws Exception
 */
function uploadedVideos($uploaded, $body, $path) {
    foreach ($body ?? [] as $key => $val) {
        is_null($val) &&
            $body[$key] = new UploadedVideo(array_shift($uploaded), $path);
    }
    return $body;
}
