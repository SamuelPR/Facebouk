<?php
session_start();
$_SESSION['err'] = "";
$_SESSION['postText'] = "";

require './dbConnector/dbFunctions.php';

//? Error message for later use, to indiquate if user missed an obligatory step

// TODO Filter for security
$sizeTotal = 0; //The total size of all the files in MB
$filesReceived = $_FILES["files"]; //List of all the images received
$imgToSave = []; //images that will be transfered to local files and DB
$invalidePost = false;
$errors = [];

//For loop that will count and access every file the user sent
for ($i = 0; $i < count($filesReceived["name"]); $i++) {
    //Constants to define size the server will accept
    define("MAX_SIZE_SINGLE", 3);
    define("MAX_SIZE_TOTAL", 70);

    //imgType is a string of the type of the image; imgSize contains the size adjusted to MB(size multiplied by 0.000001)
    $imgType;
    $imgSize;
    $imgType = explode("/", $filesReceived["type"][$i]);
    $imgSize = $filesReceived["size"][$i];
    $imgSize *= 0.000001;

    //If will check if the image is below max size and if it's one of the accepted types
    if ($imgSize <= constant("MAX_SIZE_SINGLE") && $filesReceived["error"][$i] == 0) {
        if (strtolower($imgType[0]) == "image" || strtolower($imgType[0]) == "video" || strtolower($imgType[0] == "audio")) {//TODO comment new additions of audio and video
            $tmpImg = [
                //Added 2 uniqid to reduce the chances of the images already existing in the DB and temporary local dir
                "name" => uniqid() . uniqid() . $filesReceived["name"][$i],
                "tmp_name" => $filesReceived['tmp_name'][$i],
                "type" => $imgType[0],
                "size" => $imgSize
            ];
            //Adding image size to total size for later verification
            $sizeTotal += $imgSize;
            //All the image's data is stored in variable to later move save them
            array_push($imgToSave, $tmpImg);
        } else {
            $errors['msg'] = $filesReceived["name"][$i] . " n'est pas dans une format acceptée. Seul les images png, jpg et jpeg sont acceptés";
            $invalidePost = true;
            break;
        }
    } else {
        $errors['msg'] = $filesReceived["name"][$i] . " est trop volumineux. Une taille maximum de 3MB est acceptée";
        $invalidePost = true;
        break;
    }
}

if ($invalidePost == false) {
    if ($sizeTotal <= constant("MAX_SIZE_TOTAL")) {
        //TODO: This part got heavily modified, comments need to be rewritten 
        //Initializing dir and dirFile variable, containing respectively the local directory and the directory + filename
        $dir;
        $dirFile;
        $dir = "./assets/img/";
        foreach ($imgToSave as $img) {
            //Each image is verified and if no copy of it already exist in local directory, we then proceed to move then there
            $dirFile = $dir . $img["name"];
            if (file_exists($dirFile)) {
                $img["name"] = uniqid() . uniqid() . uniqid() . "." . $img["type"];
            }
        }
        if (insertNewPost($dir, $imgToSave, date("Y-m-d H:i:s"), $_POST['text'])) {
            foreach ($imgToSave as $img) {
                $dirFile = $dir . $img["name"];
                move_uploaded_file($img['tmp_name'], $dirFile);
            }
        } else {
            $errors['msg'] = "Une erreur est survenue, veuillez recommencer votre post";
            $invalidePost = true;
            header('location: post.php');
        }
        //Heading back to home page
        header('Location: index.php');
    } else {
        $errors['msg'] = "Le volume combiné de vos images est trop grand. Une taille maximum de 70MB est acceptée";
    }
}
if ($errors['msg'] != "") {
    $_SESSION['err'] = $errors['msg'];
    $_SESSION['postText'] = $_POST['text'];
    header('location: post.php');
}
