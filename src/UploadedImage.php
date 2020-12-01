<?php
namespace kozakl\utils;

class UploadedImage
{
    public $name;
    public $nameEncoded;
    public $width;
    public $height;
    private $image;
    /**
     * @param
     * @throws
     */
    public function __construct($image, $uniqid = true)
    {
        if (!$image) {
            throw new Exception('Image cannot be null');
        } else if ($image->getError() !== UPLOAD_ERR_OK) {
            throw new Exception('Image cannot be uploaded');
        }
        $size = getimagesize($image->file);
        $this->image = $image;
        $this->name = $uniqid ?
            uniqid() . '__' .
            $image->getClientFilename() :
            $image->getClientFilename();
        $this->nameEncoded = rawurlencode($this->name);
        $this->width = $size[0];
        $this->height = $size[1];
    }
    
    public function moveTo($path) {
        $this->image->moveTo($path);
    }
}
