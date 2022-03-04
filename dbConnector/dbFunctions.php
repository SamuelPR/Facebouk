<?php
//TODO: Comment functions, explain their utility
require './dbConnector/databaseConnection.class.php';

function insertPost($postText, $modified)
{

    try {
        $req = DatabaseConnection::getInstance();

        $req->beginTransaction();



        $req->commit();
        return true;
    } catch (Exception $e) {
        $req->rollBack();
        return false;
        exit();
    }


    /* $req = DatabaseConnection::getInstance()->prepare('INSERT INTO post(postText,creationdate,modificationDate) VALUES(:postText,:creationdate,:modificationDate)');
    $req->execute(array(
        'postText' => $postText,
        'creationdate' => date("Y-m-d H:i:s"),
        'modificationDate' => $modified
    )); */
}

function insertMedia($dir, $imgArray, $modified, $text)
{
    try {
        $req = DatabaseConnection::getInstance();

        $req->beginTransaction();

        $req = DatabaseConnection::getInstance()->prepare('INSERT INTO post(postText,creationdate,modificationDate) VALUES(:postText,:creationdate,:modificationDate)');
        $req->execute(array(
            'postText' => $text,
            'creationdate' => date("Y-m-d H:i:s"),
            'modificationDate' => $modified
        ));

        $tempID = DatabaseConnection::getInstance()->lastInsertId();

        foreach ($imgArray as $img) {
            $req = DatabaseConnection::getInstance()->prepare('INSERT INTO media(nameMedia,typeMedia,creationdate,modificationDate, idPost) VALUES(:nameMedia,:typeMedia,:creationdate,:modificationDate,:idPost)');
            $req->execute(array(
                'nameMedia' => $dir.$img['name'],
                'creationdate' => date("Y-m-d H:i:s"),
                'modificationDate' => $modified,
                'typeMedia' => $img['type'],
                'idPost' => $tempID
            ));
        }


        DatabaseConnection::getInstance()->commit();
        return true;
    } catch (Exception $e) {
        DatabaseConnection::getInstance()->rollBack();
        return false;
        exit();
    }
}

function getMediaByName($name)
{
    $req = DatabaseConnection::getInstance()->query("SELECT idMedia FROM media where name in ('$name')");
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

function selectLastId()
{
}

function getAllPosts()
{
    $req = DatabaseConnection::getInstance()->query("SELECT * FROM post");
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

function getAllMediaFromPost($idPost)
{
    $req = DatabaseConnection::getInstance()->query("SELECT * FROM media WHERE idPost = $idPost");
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
}
