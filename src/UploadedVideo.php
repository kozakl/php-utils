<?php
namespace kozakl\utils;

class UploadedVideo
{
    public $name;
    public $nameEncoded;
    public $size;
    private $video;
    /**
     * @param
     * @throws
     */
    public function __construct($video, $uniqid = true)
    {
        if (!$video) {
            throw new Exception('Video cannot be null');
        } else if ($video->getError() !== UPLOAD_ERR_OK) {
            throw new Exception('Video cannot be uploaded');
        }
        $this->video = $video;
        $this->name = $uniqid ?
            uniqid() . '__' .
            $video->getClientFilename() :
            $video->getClientFilename();
        $this->nameEncoded = rawurlencode($this->name);
        $this->size = getimagesize($video->file);
    }
    
    public function moveTo($path) {
        $this->video->moveTo($path);
    }
}
