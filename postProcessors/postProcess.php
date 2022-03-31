<?php
session_start();
$_SESSION['err'] = "";
$_SESSION['postText'] = "";

require_once('../dbConnector/configuration.inc.php');
require_once('../dbConnector/databaseConnection.class.php');
require_once('../dbConnector/dbFunctions.php');

$sizeTotal = 0; //The total size of all the files in MB
$filesReceived = $_FILES["files"]; //List of all the medias received
$mediaToSave = []; //medias that will be transfered to local files and DB
$invalidePost = false;
$errors = [];

//For loop that will count and access every file the user sent
for ($i = 0; $i < count($filesReceived["name"]); $i++) {
    //Constants to define size the server will accept
    define("MAX_SIZE_SINGLE", 3);
    define("MAX_SIZE_TOTAL", 70);

    //mediaType is a string of the type of the media; mediaSize contains the size adjusted to MB(size multiplied by 0.000001)
    $mediaType;
    $mediaSize;
    $mediaType = explode("/", $filesReceived["type"][$i]);
    $mediaSize = $filesReceived["size"][$i];
    $mediaSize *= 0.000001;

    //If will check if the media is below max size and if it's one of the accepted types
    if ($mediaSize <= constant("MAX_SIZE_SINGLE") && $filesReceived["error"][$i] == 0) {
        if (strtolower($mediaType[0]) == "image" || strtolower($mediaType[0]) == "video" || strtolower($mediaType[0] == "audio")) { 
            $tmpMedia = [
                //Added 2 uniqid to reduce the chances of the media already existing in the DB and temporary local dir
                "name" => uniqid() . uniqid() . $filesReceived["name"][$i],
                "tmp_name" => $filesReceived['tmp_name'][$i],
                "type" => $mediaType[0],
                "size" => $mediaSize
            ];
            //Adding media size to total size for later verification
            $sizeTotal += $mediaSize;
            //All the media's data is stored in variable to later move save them
            array_push($mediaToSave, $tmpMedia);
        } else {
            $errors['msg'] = $filesReceived["name"][$i] . " n'est pas dans un type de format acceptée.";
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
        //Initializing dir and dirFile variable, containing respectively the local directory and the directory + filename
        $dir;
        $dirFile;
        $dir = "../assets/img";
        foreach ($mediaToSave as $media) {
            //Each media is verified and if no copy of it already exist in local directory, we then proceed to move then there
            $dirFile = $dir . $media["name"];
            if (file_exists($dirFile)) {
                $media["name"] = uniqid() . uniqid() . uniqid() . "." . $media["type"];
            }
        }
        //Creating a boolean to store if all the medias did get stored
        $mediaCHeck = false;
        //This will contain all filenames to be deleted if the insert in DB or the move_Upload_File failes
        $tmpMediaSave = [];
        foreach ($mediaToSave as $media) {
            $dirFile = $dir . $media["name"]; //dirFile contain the complete filname + directory
            if (move_uploaded_file($media['tmp_name'], $dirFile)) { //If it's a success, we store the moved file directory in tmpMediaSave
                array_push($tmpMediaSave, $dirFile);
                $mediaCHeck = true;
            } else {
                //If a move_uploaded_file failes, we loop inside tmpMediaSave and unlink every file that was previously stored
                foreach ($tmpMediaSave as $file) {
                    unlink($file);
                }
                $errors['msg'] = "Une erreur est survenue, veuillez recommencer votre post";
                $mediaCHeck = false;
                $invalidePost = true;
                header('location: post.php');
                break;
            }
        }
        //If everythings goes right, we try to insert the post in the DB
        if ($mediaCHeck == true) {
            $dir = "assets/img";
            if (insertNewPost($dir, $mediaToSave, date("Y-m-d H:i:s"), $_POST['text'])) {
                //Heading back to home page
                header('Location: ../index.php');
            } else {
                //in case the insert failes, we delete every file locally
                foreach ($tmpMediaSave as $file) {
                    unlink($file);
                }
                $errors['msg'] = "Une erreur est survenue, veuillez recommencer votre post";
                $mediaCHeck = false;
                $invalidePost = true;
                header('location: post.php');
            }
        }
    } else {
        $errors['msg'] = "Le volume combiné de vos fichiers est trop grand. Une taille maximum de 70MB est acceptée";
    }
}
if ($errors['msg'] != "") {
    $_SESSION['err'] = $errors['msg'];
    $_SESSION['postText'] = $_POST['text'];
    header('location: post.php');
}
