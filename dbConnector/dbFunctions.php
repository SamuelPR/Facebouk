<?php

require './dbConnector/databaseConnection.class.php';

function insertPost($postText, $modified)
{
    $req = DatabaseConnection::getInstance()->prepare('INSERT INTO post(postText,creationdate,modificationDate) VALUES(:postText,:creationdate,:modificationDate)');
    $req->execute(array(
        'postText' => $postText,
        'creationdate' => date("Y-m-d H:i:s"),
        'modificationDate' => $modified
    ));
}

function insertMedia($nameFile, $modified, $type, $idPost)
{
    $req = DatabaseConnection::getInstance()->prepare('INSERT INTO media(nameMedia,typeMedia,creationdate,modificationDate, idPost) VALUES(:nameMedia,:typeMedia,:creationdate,:modificationDate,:idPost)');
    $req->execute(array(
        'nameMedia' => $nameFile,
        'creationdate' => date("Y-m-d H:i:s"),
        'modificationDate' => $modified,
        'typeMedia' => $type,
        'idPost' => $idPost
    ));
}

function getMediaByName($name)
{
    $req = DatabaseConnection::getInstance()->query("SELECT idMedia FROM media where name in ('$name')");
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

function selectLastId(){
    $req = DatabaseConnection::getInstance()->query("SELECT LAST_INSERT_ID()");
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

function getAllPosts(){
    $req = DatabaseConnection::getInstance()->query("SELECT * FROM post");
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

function getAllMediaFromPost($idPost){
    $req = DatabaseConnection::getInstance()->query("SELECT * FROM media WHERE idPost = $idPost");
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
}