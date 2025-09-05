<?php
namespace kozakl\utils;

use Exception;
use function
    kozakl\utils\string\removeFrom;

function uploadFile($uploadedFile, $payload, $path) {
    $baseDir = removeFrom($_SERVER['REQUEST_URI'], '/', 0, 1);
    $publicDir = $baseDir != '/api' ?
        "$_SERVER[DOCUMENT_ROOT]/$baseDir/public" :
        '../public';
    
    if (!$uploadedFile) {
        throw new Exception('File cannot be null.');
    } else if ($uploadedFile->getError() !== UPLOAD_ERR_OK) {
        throw new Exception('File cannot be uploaded.');
    }
    if (!is_dir("$publicDir/uploads/{$path}")) {
        mkdir("$publicDir/uploads/{$path}", 0777, true);
    }
    $uniqName = uniqid(). '__'.
        $uploadedFile->getClientFilename();
    $uploadedFile->moveTo("$publicDir/uploads/{$path}/{$uniqName}");
    
    $payload['url'] = "uploads/{$path}/". rawurlencode($uniqName);
    unset($payload['file']);
    return $payload;
}