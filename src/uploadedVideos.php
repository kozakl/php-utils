<?php
namespace kozakl\utils;
use Exception;

/**
 * @throws Exception
 */
function uploadedVideos($uploaded, $body, $path) {
    foreach ($body ?? [] as $key => $val) {
        if (isset($val['file'])) {
            $video = array_shift($uploaded);
            if (!$video) {
                throw new Exception('Video cannot be null');
            } else if ($video->getError() !== UPLOAD_ERR_OK) {
                throw new Exception('Video cannot be uploaded');
            }
            if (!is_dir("../public/uploads/{$path}")) {
                mkdir("../public/uploads/{$path}", 0777, true);
            }
            $uniqName = uniqid(). '__'.
                $video->getClientFilename();
            $video->moveTo("../public/uploads/{$path}/{$uniqName}");
            
            $body[$key]['url'] = "uploads/{$path}/". rawurlencode($uniqName);
            unset($body[$key]['file']);
        }
    }
    return $body;
}
