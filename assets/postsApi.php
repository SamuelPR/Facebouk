<?php
switch($_SERVER['REQUEST_METHOD']){
    case "DELETE":
        $idPost = filter_input(INPUT_GET, 'idPost');
        if($idPost != ""){
            echo json_encode($idPost);


            // TODO Deleting post and local files
        }
        else{
            echo json_encode("Merde");
        }
        break;
    case "GET":
        //TODO bonus reload homepage
        break;
}
