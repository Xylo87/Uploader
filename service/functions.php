<?php

function upload() {

    $name = $_FILES['file']['name'];
    $type = $_FILES['file']['type'];
    $tmpName = $_FILES['file']['tmp_name'];
    $error = $_FILES['file']['error'];
    $size = $_FILES['file']['size'];

    $extCut = explode('.', $name);
    $ext = strtolower(end($extCut));

    // Authorized extensions
    $authExt = ['jpg', 'jpeg', 'gif', 'png', 'webp', 'avif', 'pdf', 'doc', 'docx', 'txt', 'odt', 'xls', 'xlsx'];

    // Files size
    $maxSize = 1024*1024*50;

    // Setting unique name
    if (in_array($ext, $authExt) && $size <= $maxSize && $error == 0) {
        $uniqueName = uniqid('', true);
        $fileName = $uniqueName.'.'.$ext;

    // > Saving original name to .txt file
    file_put_contents('./public/original_names_data/'.$uniqueName.'_original_name.txt', $name);

    // Moving file to directory
    move_uploaded_file($tmpName, './public/upload/'.$fileName);

    // Flash messages
    // echo '<p class="flashOK">Fichier enregistré !</p>';
    // } else {
    // echo '<p class="flashFail">Extension non autorisée, taille trop importante ou erreur !</p>';
    }
}



function deleteFile() {
    
    // Getting file to delete
    $fileToDelete = $_POST['file_to_delete'];
    
    // Delete name
    $nameDirectory = "./public/original_names_data/";
    $names = scandir($nameDirectory);
    
    foreach ($names as $name) {
        if ($name === '.' || $name === '..' || $name === '.gitkeep') {
            continue;
        }

        $fileId = pathinfo($fileToDelete, PATHINFO_FILENAME);
        if (strpos($name, $fileId) !== false) {

            $namePath = $nameDirectory . $name;
            if (file_exists($namePath)) {
                unlink($namePath);
            }
        }
    }

    // Delete file
    $fileDirectory = "./public/upload/";
    $filePathDel = $fileDirectory . $fileToDelete;

    if (file_exists($filePathDel)) {
        unlink($filePathDel);
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    die;
}



function deleteAllFiles() {

    $fileDirectory = "./public/upload/";
    $files = scandir($fileDirectory);
    
    foreach ($files as $file) {
        if ($file != "." && $file != ".." && $file != ".gitkeep") {
            $filePath = $fileDirectory . $file;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }
    
    $nameDirectory = "./public/original_names_data/";
    $names = scandir($nameDirectory);

    foreach ($names as $name) {
        if ($name != "." && $name != ".." && $name != ".gitkeep") {
            $namePath = $nameDirectory . $name;
            if (file_exists($namePath)) {
                unlink($namePath);
            }
        }
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    die;
}