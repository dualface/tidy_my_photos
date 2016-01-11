<?php

require(__DIR__ . '/functions_inc.php');

$files_hash = json_decode(file_get_contents(CUR_DIR . 'hash.json'), true);

if (!isset($files_hash) || !is_array($files_hash)) {
    die();
}

$exists = array();

foreach ($files_hash as $path => $hash) {
    if (isset($exists[$hash])) {
        printf("remove duplicate file '%s'\n", $path);
        // unlink($path);
    } else {
        $exists[$hash] = $path;
    }
}

print("DONE\n\n");
