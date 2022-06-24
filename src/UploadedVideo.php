<?php
namespace kozakl\utils;

class UploadedVideo
{
    public $name;
    public $url;
    public $duration;
    public $width;
    public $height;
    /**
     * @param
     * @throws
     */
    public function __construct($video, $path, $uniq = true)
    {
        if (!$video) {
            throw new Exception('Video cannot be null');
        } else if ($video->getError() !== UPLOAD_ERR_OK) {
            throw new Exception('Video cannot be uploaded');
        }
        if (!is_dir("../public/uploads/{$path}")) {
            mkdir("../public/uploads/{$path}", 0777, true);
        }
        $uniqName = $uniq ?
            uniqid(). '__' .
            $video->getClientFilename() :
            $video->getClientFilename();
        $info = $this->getVideoInfo($video->file);
        $video->moveTo("../public/uploads/{$path}/{$uniqName}");
        
        $this->name = $video->getClientFilename();
        $this->url = "uploads/{$path}/". rawurlencode($uniqName);
        $this->duration = $info->duration;
        $this->width = $info->width;
        $this->height = $info->height;
    }
    
    private function getVideoInfo($file) {
        $info = shell_exec("ffprobe \
            -v quiet \
            -print_format json \
            -show_format \
            -show_streams '$file'");
        $info = json_decode($info)->streams[0];
        return (object)[
            'duration' => $info->duration,
            'width' => $info->width,
            'height' => $info->height
        ];
    }
}
