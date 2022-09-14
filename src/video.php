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
    $data->end = $data->end &&
        $data->end <= $data->start ?
            $data->start + 0.01 : $data->end;
    $options = [
        "-ss $data->start",
        $data->end ?
            "-to $data->end" : '',
        "-i '$data->src'",
        $data->duration ?
            "-t $data->duration" : '',
        "-crf $data->quality",
        "-vf scale=$data->width:-2",
        $data->end ?
            "-c copy" : '',
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
