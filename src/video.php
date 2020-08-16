<?php
namespace kozakl\utils\video;

function resizeVideo($data, $log)
{
    $data->width = ($data->width / 2 | 0) * 2;
    $options = [
        "-ss $data->start",
        "-i $data->src",
        $data->duration ?
            "-t $data->duration" : '',
        "-crf $data->quality",
        "-vf scale=$data->width:-2",
    ];
    $log->info('FFmpeg',
        (array)shell_exec("ffmpeg "
            .join(' ', $options) .
            " -y -an -vcodec libx264 $data->dest 2>&1"));
    if (!filesize("$data->dest")) {
        unlink("$data->dest");
    }
}
