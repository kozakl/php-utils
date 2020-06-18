<?php
namespace kozakl\utils\image;
use function
    kozakl\utils\file\pathJoin;

function makeImageSet($imageSet)
{
    $image = new Imagick($imageSet->src);
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
            $image->quantizeImage($size['colors'], Imagick::COLORSPACE_SRGB, 0, false, false);
        $size['blur'] &&
            $image->blurImage(0, $size['blur']);
        $image->setImageCompression(Imagick::COMPRESSION_LZW);
        $image->setImageCompressionQuality($imageSet->quality);
        $image->writeImage($dest);
    }
}
