<?php
$errors = [];
$data = [];
if (empty($_POST['text'])) {
    $errors['msg'] = 'Text is required.';
}

if (empty($_FILES['myFiles'])) {
    $errors['msg'] = 'No image added';
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
    $data['success'] = true;
    $data['message'] = 'Success!';

    //! Need to be modified, Only for testing purpose
    $totalSize = 0;
    $lstSendImage = $_FILES['myFiles'];
    $lstMedia = []; // Tableau qui stockera toutes les images à importer sur le serveur

    // Parcour les images
    for ($i = 0; $i < count($lstSendImage['name']); $i++) {
        $imageFileType = explode("/", $lstSendImage['type'][$i]);
        $imageSizeInMb = $lstSendImage['size'][$i] * 0.000001; // Stocket et convertir la taille de l'image en MB
        // Verifier si la taille de l'image ne dépasse 3MB & Si le format de l'image est accepté
        if ($imageSizeInMb <= 3 && $imageFileType[1] == "jpg" || $imageFileType[1] == "png" || $imageFileType[1] == "jpeg") {
            $tempImage = [ // Stocker les attributs des images
                "name" => $lstSendImage['name'][$i],
                "type" => $imageFileType[1],
                "size" => $imageSizeInMb
            ];
            $totalSize += $imageSizeInMb;
            array_push($lstMedia, $tempImage); // Ajouter l'image à la liste des images à importer au serveur
        }
    }

    if ($totalSize <= 70) { // Vérifier si la taille total des fichiers ne dépassent pas 80MB
        foreach ($lstMedia as $media) {
            echo "<pre>";
            var_dump($media);
            echo "</pre>";
            // Verifier si le fichier éxiste déjà
            /*if (!file_exists($target_file)) {
            echo "L'image " . $media['name'] . " éxiste déjà !";
        }*/
        }
    }
    
    header('Location: index.php');
}
