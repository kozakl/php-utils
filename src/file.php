<?php
namespace kozakl\utils\file;

function pathJoin(...$paths) {
  return preg_replace('#/+#', '/', implode('/', array_filter($paths)));
}

function delete($path)
{
    if (!is_dir($path)) {
        if (file_exists($path)) {
            unlink($path);
        }
        return;
    }
    $dir = opendir($path);
    while ($file = readdir($dir)) {
        if (($file != '.' ) && ($file != '..')) {
            if (is_dir("$path/$file")) {
                delete("$path/$file");
            } else {
                unlink("$path/$file");
            }
        }
    }
    closedir($dir);
    rmdir($path);
}
