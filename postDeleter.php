<?php
require './dbConnector/dbFunctions.php';

$idPost = $_POST['id'];
$mediasFromPost = getAllMediaFromPost($idPost);

foreach ($mediaFromPost as $media) {
    
}
