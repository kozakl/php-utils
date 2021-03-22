<?php
namespace kozakl\utils\image;

/**
 * @param {
 *  src
 *  dest
 *  quality
 *  colors
 *  blur
 *  watermark
 *  width
 * } $data
 */
function makeImage($data)
{
    $image = new \Imagick($data->src);
    $data->width &&
        $image->thumbnailImage($data->width, 0);
    $data->colors &&
        $image->quantizeImage($data->colors, \Imagick::COLORSPACE_SRGB, 0, false, false);
    $data->blur &&
        $image->blurImage(0, $data->blur);
    
    if ($data->watermark) {
        $watermark = new \Imagick();
        $watermark->readImage("../public/static/watermark.png");
        $watermark->scaleImage($data->width * 0.25, $data->width * 0.25);
        $image->compositeImage($watermark, \Imagick::COMPOSITE_OVER,
            $image->getImageWidth() - $watermark->getImageWidth(), 0);
    }
    $image->setImageCompression(\Imagick::COMPRESSION_LZW);
    $image->setImageCompressionQuality($data->quality);
    $image->writeImage($data->dest);
}
