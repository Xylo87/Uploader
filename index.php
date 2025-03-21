
<?php

    include 'functions.php';

    // var_dump($_FILES);

    // > Upload (extension verify + size verify + set unique name)
    if (isset($_FILES['file'])) {

        $name = $_FILES['file']['name'];
        $type = $_FILES['file']['type'];
        $tmpName = $_FILES['file']['tmp_name'];
        $error = $_FILES['file']['error'];
        $size = $_FILES['file']['size'];

        $extCut = explode('.', $name);
        // var_dump($extCut);

        $ext = strtolower(end($extCut));
        // var_dump($ext);

        // tableau des extensions autorisées
        $authExt = ['jpg', 'jpeg', 'gif', 'png', 'webp', 'avif'];

        $maxSize = 1024*1024*50;

        if (in_array($ext, $authExt) && $size <= $maxSize && $error == 0) {
            $uniqueName = uniqid('', true);
            $fileName = $uniqueName.'.'.$ext;

            move_uploaded_file($tmpName, './upload/'.$fileName);

            echo '<p class="flashOK">Image enregistrée !</p>';
        } else {
            echo '<p class="flashFail">Extension non autorisée, taille trop importante ou erreur !</p>';
        }
    }

    $directory = "./upload/";

    // > Image delete
    if (isset($_POST['delete']) && isset($_POST['file_to_delete'])) {
        $fileToDelete = $_POST['file_to_delete'];
        $filePathDel = $directory . $fileToDelete;

        if (file_exists($filePathDel)) {
            unlink($filePathDel);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    // > All images delete
    if (isset($_POST['deleteAll'])) {
        $files = scandir($directory);
        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                $filePath = $directory . $file;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

?>



<!-- > Header + Nav display -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" 
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" 
    crossorigin="anonymous" 
    referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <title>Ultra Images Uploader by Tiz</title>
</head>
<body>
    <div class="logoContainer">
        <a href="https://www.tiz.fr/" target="_blank"><img src="./logo-tiz-blanc-sansfd-baseline_(1).png" alt="Logo Tiz"></a>
    </div>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="file"><u>Fichier</u> :</label>
        <input type="file" name="file" id="file">
        <button type="submit">➜ Upload !</button><br><br>
    </form>
    <div class="title">
        <h1>Mes images</h1>
        <form method="POST">
            <button class="delAllBtn" type="submit" name="deleteAll"><i class="fa-solid fa-triangle-exclamation delAllIcon"></i>Tout supprimer</button>
        </form>
        <hr>
    </div>
    <div class="container">
        <div class="gallery">


<?php 

$files = scandir($directory);
$images = [];
$counter = 1;

foreach ($files as $file) {
    if ($file != '.' && $file != '..') {
        
        $uniqid = pathinfo($file, PATHINFO_FILENAME);
        $images[$file] = $uniqid;
    }
}

arsort($images);

// > Images display
foreach ($images as $file => $uniqid) {

    if ($file=== '.' || $file === '..') {
        continue;
    }

    $filePath = $directory . $file;

    echo '
        <div class="imgSet">
            <a href="'.$filePath.'" target="_blank">
                <img class="img" src="'.$filePath.'" alt="uploaded-image-'.$counter.'">
            </a><br>
            <button class="linkBtn">Copier le lien</button>
            <form method="POST">
                <input type="hidden" name="file_to_delete" value="'.$file.'">
                <button class="delBtn" type="submit" name="delete"><i class="fa-solid fa-trash delIcon"></i></button>
            </form>
        </div>
        ';

    $counter++;

}

?>



        </div>
    </div>
<script src="script.js"></script>
</body>
</html>

     

    