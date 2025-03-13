<?php

function deleteAllFiles() {
    $directory = "./upload/";
    $files = scandir($directory);
    foreach ($files as $file) {
        if ($file != "." && $file != "..") {
            $filePath = $directory . $file;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }
}
