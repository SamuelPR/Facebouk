<?php
session_start();
$_SESSION['err'] = "";
$_SESSION['postText'] = "";

require_once('./dbConnector/configuration.inc.php');
require_once('./dbConnector/databaseConnection.class.php');
require_once('./dbConnector/dbFunctions.php');

$mediaInfo = [];

if ($_POST['mediaToChange'] != null) {
    foreach ($_POST['mediaToChange'] as $mediaId) {
        array_push($mediaInfo, getMediaById($mediaId));
    }
}
if (updatePost($mediaInfo, $_POST['text'], $_POST['postId'])) {
    if($mediaInfo != []){
        foreach ($mediaInfo as $media) {
            unlink($media[0]['nameMedia']);
        }
    }
    header("location: index.php");
}