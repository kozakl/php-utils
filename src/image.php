<?php
namespace kozakl\utils\image;
use function
    kozakl\utils\file\pathJoin;

/**
 * @param {
 *  src
 *  dest
 *  name
 *  quality
 *  colors
 *  blur
 *  width
 *  format
 * } $data
 */
function makeImage($data)
{
    $image = new \Imagick($data->src);
    $srcInfo = pathinfo($data->src);
    $srcName = $srcInfo['filename'];
    $srcExt = $srcInfo['extension'];
    
    if (!file_exists("$data->dest/$srcName")) {
        mkdir(pathJoin($data->dest, $srcName), 0777, true);
    }
    $dest = pathJoin(
        $data->dest,
        $srcName,
        $data->name .
        ($data->format ?? '.' . $srcExt)
    );
    $data->width &&
        $image->thumbnailImage($data->width, 0);
    $data->colors &&
        $image->quantizeImage($data->colors, \Imagick::COLORSPACE_SRGB, 0, false, false);
    $data->blur &&
        $image->blurImage(0, $data->blur);
    $image->setImageCompression(\Imagick::COMPRESSION_LZW);
    $image->setImageCompressionQuality($data->quality);
    $image->writeImage($dest);
}

function makeImageSet($imageSet)
{
    $image = new \Imagick($imageSet->src);
    $srcInfo = pathinfo($imageSet->src);
    $srcName = $srcInfo['filename'];
    $srcExt = $srcInfo['extension'];
    
    if (!file_exists("$imageSet->dest/$srcName")) {
        mkdir(pathJoin($imageSet->dest, $srcName), 0777, true);
    }
    foreach ($imageSet->sizes as $size) {
        $dest = pathJoin(
            $imageSet->dest,
            $srcName,
            ($size['name'] ?? $srcName) .
            ($imageSet->format ?? '.' . $srcExt)
        );
        $size['value'] &&
            $image->thumbnailImage($size['value'], 0);
        $size['colors'] &&
            $image->quantizeImage($size['colors'], \Imagick::COLORSPACE_SRGB, 0, false, false);
        $size['blur'] &&
            $image->blurImage(0, $size['blur']);
        $image->setImageCompression(\Imagick::COMPRESSION_LZW);
        $image->setImageCompressionQuality($imageSet->quality);
        $image->writeImage($dest);
    }
}
