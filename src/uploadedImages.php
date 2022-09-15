<?php
namespace kozakl\utils;
use Exception;

/**
 * @throws Exception
 */
function uploadedImages($uploaded, $body, $path) {
    foreach ($body ?? [] as $key => $val) {
        if (isset($val['file'])) {
            $image = array_shift($uploaded);
            if (!$image) {
                throw new Exception('Image cannot be null');
            } else if ($image->getError() !== UPLOAD_ERR_OK) {
                throw new Exception('Image cannot be uploaded');
            }
            if (!is_dir("../public/uploads/{$path}")) {
                mkdir("../public/uploads/{$path}", 0777, true);
            }
            $uniqName = uniqid(). '__'.
                $image->getClientFilename();
            $image->moveTo("../public/uploads/{$path}/{$uniqName}");
            
            $body[$key]['url'] = "uploads/{$path}/". rawurlencode($uniqName);
            unset($body[$key]['file']);
        }
    }
    return $body;
}
