<?php
namespace kozakl\utils;

class UploadedVideo
{
    public $name;
    public $nameEncoded;
    public $duration;
    public $width;
    public $height;
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
        $videoInfo = $this->getVideoInfo($video);
        $this->video = $video;
        $this->name = $uniqid ?
            uniqid() . '__' .
            $video->getClientFilename() :
            $video->getClientFilename();
        $this->nameEncoded = rawurlencode($this->name);
        $this->duration = $videoInfo->duration;
        $this->width = $videoInfo->width;
        $this->height = $videoInfo->height;
    }
    
    public function moveTo($path) {
        $this->video->moveTo($path);
    }
    
    private function getVideoInfo($video) {
        $info = shell_exec("ffprobe \
            -v quiet \
            -print_format json \
            -show_format \
            -show_streams '$video->file'");
        $info = json_decode($info)->streams[0];
        return (object)[
            'duration' => $info->duration,
            'width' => $info->width,
            'height' => $info->height
        ];
    }
}
