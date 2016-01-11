<?php

define('DS', DIRECTORY_SEPARATOR);
define('CUR_DIR', rtrim(getcwd(), '/\\') . DS);

function search_in_dir($dir, & $paths)
{
    $dir = rtrim($dir, '/\\') . DS;
    $dh = opendir($dir);
    while($filename = readdir($dh)) {
        if ($filename[0] == '.') continue;
        $path = $dir . $filename;
        if (is_dir($path)) {
            search_in_dir($path, $paths);
        } elseif (is_file($path)) {
            $paths[] = $path;
        }
    }
    closedir($dh);
}
