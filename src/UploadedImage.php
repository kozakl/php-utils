<?php
class UploadedImage
{
    public $name;
    public $nameEncoded;
    public $size;
    private $image;
    /**
     * @param
     * @throws
     */
    public function __construct($image)
    {
        if (!$image) {
            throw new Exception('Image cannot be null');
        } else if ($image->getError() !== UPLOAD_ERR_OK) {
            throw new Exception('Image cannot be uploaded');
        }
        $this->image = $image;
        $this->name = uniqid() . '__' .
            $image->getClientFilename();
        $this->nameEncoded = rawurlencode($this->name);
        $this->size = getimagesize($image->file);
    }
    
    public function moveTo($path) {
        $this->image->moveTo($path);
    }
}
