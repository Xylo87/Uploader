
<?php

    // > Import
    require_once './service/functions.php';

    

    // > Upload
    if (isset($_FILES['files'])) {
        upload();
    }


    // > Files directory set
    $directory = "./public/upload/";


    // > File delete
    if (isset($_POST['delete']) && isset($_POST['file_to_delete'])) {
        deleteFile();
    }


    // > All files delete
    if (isset($_POST['deleteAll'])) {
        deleteAllFiles();
    }

?>



<!-- > Header + Nav display -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">

    <!-- Font awesome -->
    <link rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" 
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" 
    crossorigin="anonymous" 
    referrerpolicy="no-referrer" />

    <!-- My CSS -->
    <link rel="stylesheet" href="./assets/style.css">
    <title>Ultra File Uploader by Tiz</title>
</head>

<body>

    <!-- Logo -->
    <div class="logoContainer">
        <a href="https://www.tiz.fr/" target="_blank">
            <img src="./assets/images/logo-tiz-blanc-sansfd-baseline_(1).png" alt="Logo Tiz">
        </a>
    </div>
    
    <!-- Drag & Drop -->
    <div id="dragContainer">
    
        <div id="dropZone">

            <div><img id="dropImg" src="./assets/images/icons8-drag-and-drop-96.png" alt="Drag and Drop icon" style="width: 80px;"></div>
            <div id="dropText">Déposez vos fichiers ici</div>

        </div>

    </div>

    <!-- Container -->
    <div class="container">
    
        <!-- Upload form -->
        <form id="upload" action="" method="POST" enctype="multipart/form-data">
            <label for="file"><u>Fichier</u> :</label>
            <input type="file" name="file" id="file">
            <button type="submit">➜ Upload !</button><br><br>
        </form>
    
        <!-- Title -->
        <div class="title">
            <h1>Mes fichiers</h1>

            <!-- All delete button -->
            <form method="POST">
                <button 
                class="delAllBtn" 
                type="submit" 
                name="deleteAll"><i class="fa-solid fa-triangle-exclamation delAllIcon"></i>Tout supprimer</button>
            </form>

            <hr>
        </div>

        <!-- Gallery -->
        <div class="gallery">


<?php 

// Variables for display
$files = scandir($directory);
$fileArray = [];
$counter = 1;


// > Setting files array for sorted display
foreach ($files as $file) {
    if ($file != '.' && $file != '..') {
        
        $uniqid = pathinfo($file, PATHINFO_FILENAME);
        $fileArray[$file] = $uniqid;
    }
}

// > Sorting files array
arsort($fileArray);



// > Files display
foreach ($fileArray as $file => $uniqid) {

    if ($file === '.' || $file === '..' || $file === '.gitkeep') {
        continue;
    }

    $filePath = $directory . $file;


    // > Text files
    if (strpos($file, 'pdf') || 
    strpos($file, 'txt') || 
    strpos($file, 'docx') || 
    strpos($file, 'doc') || 
    strpos($file, 'odt') ||
    strpos($file, 'xls') ||
    strpos($file, 'xlsx')) {
        
        // > Getting original name for display
        $originalNameFile = './public/original_names_data/'.pathinfo($file, PATHINFO_FILENAME).'_original_name.txt';
        $originalName = file_get_contents($originalNameFile);

        // Truncate names
        if (strlen($originalName) > 25) {
            $originalName = substr($originalName, 0, 25).'...';
        }
        
        echo '
        <div class="imgSet">
            <h3>'.$originalName.'</h3>
            <a href="'.$filePath.'" target="_blank">
                <img class="img" src="./assets/images/text_file.webp" alt="uploaded-file-'.$counter.'">
            </a><br>
            <button class="linkBtn">Copier le lien</button>
            <form method="POST">
                <input type="hidden" name="file_to_delete" value="'.$file.'">
                <button class="delBtn" type="submit" name="delete"><i class="fa-solid fa-trash delIcon"></i></button>
            </form>
        </div>
        ';

    } else {

    // > Images files
        echo '
        <div class="imgSet">
            <a href="'.$filePath.'" target="_blank">
                <img class="img" src="'.$filePath.'" alt="uploaded-file-'.$counter.'">
            </a><br>
            <button class="linkBtn">Copier le lien</button>
            <form method="POST">
                <input type="hidden" name="file_to_delete" value="'.$file.'">
                <button class="delBtn" type="submit" name="delete"><i class="fa-solid fa-trash delIcon"></i></button>
            </form>
        </div>
        ';
    }

    $counter++;

}

?>

        </div>
    </div>

<!-- My JavaScript -->
<script src="./assets/script.js"></script>
</body>
</html>



     

    