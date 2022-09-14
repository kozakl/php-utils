<?php
namespace kozakl\utils\video;

/**
 * @param {
 *  src
 *  dest
 *  image
 *  quality
 *  start
 *  end
 *  duration
 *  width
 * } $data
 */
function resizeVideo($data, $log) {
    $data->width = ($data->width / 2 | 0) * 2;
    $options = [
        "-ss $data->start",
        "-i '$data->src'",
        $data->end ?
            "-to $data->end" : '',
        $data->duration ?
            "-t $data->duration" : '',
        "-crf $data->quality",
        "-vf scale=$data->width:-2",
    ];
    $log->info('FFmpeg',
        (array)shell_exec("ffmpeg "
            .join(' ', $options) .
            ($data->image ?
                ' -vframes 1' :
                ' -vcodec libx264') . 
            " -y -an  '$data->dest' 2>&1"));
    if (!filesize("$data->dest")) {
        unlink("$data->dest");
    }
}
