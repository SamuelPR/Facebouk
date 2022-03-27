<?php
session_start();
require_once('./dbConnector/dbFunctions.php');
switch($_SERVER['REQUEST_METHOD']){
    case "DELETE":
        $idPost = filter_input(INPUT_GET, 'idPost');
        if($idPost != ""){
            $tmpFiles = getAllMediaFromPost($idPost);
            if(deletePost($idPost)){
                foreach ($tmpFiles as $media) {
                    unlink($media['nameMedia']);
                }
            }else{
                //TODO bulma alert to tell user about inexistent post
                $_SESSION['deleteError'] = true;
            }
        }
        break;
    case "GET":
        //TODO bonus reload homepage
        break;
}
