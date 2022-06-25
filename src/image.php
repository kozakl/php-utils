<?php
namespace kozakl\utils\image;

/**
 * @param {
 *  src
 *  dest
 *  quality
 *  colors
 *  blur
 *  square
 *  width
 *  mark
 * } $data
 */
function makeImage($data) {
    $image = new \Imagick($data->src);
    $data->square ?
        $image->thumbnailImage($data->width, $data->width, true, true) :
        $image->thumbnailImage($data->width, 0);
    $data->colors &&
        $image->quantizeImage($data->colors, \Imagick::COLORSPACE_SRGB, 0, false, false);
    $data->blur &&
        $image->blurImage(0, $data->blur);
    if ($data->mark ?? false) {
        $mark = new \Imagick();
        $mark->readImage("../public/static/mark.png");
        $mark->scaleImage(
            min($image->getImageWidth(), $image->getImageHeight()) *
                $data->mark->scale,
            min($image->getImageWidth(), $image->getImageHeight()) *
                $data->mark->scale
        );
        switch ($data->mark->position) {
            case 'bl' :
                $image->compositeImage($mark, \Imagick::COMPOSITE_OVER,
                    0, $image->getImageHeight() - $mark->getImageHeight());
                break;
        }
    }
    
    $image->setImageCompression(\Imagick::COMPRESSION_LZW);
    $image->setImageCompressionQuality($data->quality);
    $image->writeImage($data->dest);
}
