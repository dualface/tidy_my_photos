<?php

define('DS', DIRECTORY_SEPARATOR);

$workdir = __DIR__ . DIRECTORY_SEPARATOR;

$output_dir = $workdir . 'Exports' . DS;

chdir($output_dir);
$files = glob("*");

$hashs = array();
$hashs_to_files = array();

foreach ($files as $filename) {
    $path = $output_dir . $filename;
    if (!is_file($path)) continue;
    $md5 = md5_file($path);

    if (isset($hashs_to_files[$md5])) {
        unlink($path);
        print("remove {$path}\n");
    } else {
        $hashs[$path] = $md5;
        $hashs_to_files[$md5] = $path;
    }
}
