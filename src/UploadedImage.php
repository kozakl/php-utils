<?php
namespace kozakl\utils;

class UploadedImage
{
    public $name;
    public $url;
    public $width;
    public $height;
    /**
     * @param
     * @throws
     */
    public function __construct($image, $path, $uniq = true)
    {
        if (!$image) {
            throw new Exception('Image cannot be null');
        } else if ($image->getError() !== UPLOAD_ERR_OK) {
            throw new Exception('Image cannot be uploaded');
        }
        if (!is_dir("../public/uploads/{$path}")) {
            mkdir("../public/uploads/{$path}", 0777, true);
        }
        $uniqName = $uniq ?
            uniqid() . '__' .
            $image->getClientFilename() :
            $image->getClientFilename();
        $size = getimagesize($image->file);
        $image->moveTo("../public/uploads/{$path}/{$uniqName}");
        
        $this->name = $image->getClientFilename();
        $this->url = "uploads/{$path}/" . rawurlencode($uniqName);
        $this->width = $size[0];
        $this->height = $size[1];
    }
}
