<?php

require(__DIR__ . '/functions_inc.php');

if (!isset($argv) || !is_array($argv)) {
    die("can't read command line arguments.\n");
}

function help()
{
    print <<<EOT

move_all.php [-s SOURCE_DIR] [-o OUTPUT_DIR]


EOT;
}

$argc = count($argv);

$source_dir = CUR_DIR . 'Photos';
$output_dir = CUR_DIR . 'Photos';

array_shift($argv);
while (count($argv)) {
    $a = $argv[0];
    if (!isset($argv[1])) {
        print("invalid option {$a} without argument.\n\n");
        help();
        die();
    }

    $v = $argv[1];
    array_shift($argv);
    array_shift($argv);

    switch ($a) {
    case '-s':
        $source_dir = $v;
        break;
    case '-o':
        $output_dir = $v;
        break;
    default:
        print("invalid option {$a}.\n\n");
        help();
        die();
    }
}

if (!is_dir($source_dir)) {
    $source_dir = realpath(CUR_DIR . $source_dir);
}
if (!is_dir($output_dir)) {
    $output_dir = realpath(CUR_DIR . $output_dir);
}

if (empty($source_dir) || !is_dir($source_dir)) {
    print("invalid SOURCE_DIR {$source_dir}.\n\n");
    help();
    die();
}

if (empty($output_dir) || !is_dir($output_dir)) {
    print("invalid OUTPUT_DIR {$output_dir}.\n\n");
    help();
    die();
}

$source_dir = rtrim(realpath($source_dir), '/\\') . DS;
$output_dir = rtrim(realpath($output_dir), '/\\') . DS;

print <<<EOT

SOURCE_DIR: {$source_dir}
OUTPUT_DIR: {$output_dir}


EOT;

$paths = array();
search_in_dir($source_dir, $paths);
date_default_timezone_set('Asia/Shanghai');

$files_hash = array();
$count = count($paths);
printf("Files count: %d\n", $count);
flush();
$current = 0;
$percent = -1;
$last_percent = -1;

foreach ($paths as $path) {
    $percent = round($current / $count * 100);
    if ($percent > $last_percent) {
        printf("%d%%\n", $percent);
        flush();
        $last_percent = $percent;
    }
    $files_hash[$path] = md5_file($path);
    $current++;
}

print("100%\n");
flush();

$hash_path = $output_dir . 'hash.json';
file_put_contents($hash_path, json_encode($files_hash));

print("DONE\n\n");
