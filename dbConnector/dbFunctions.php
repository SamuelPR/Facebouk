<?php
require './dbConnector/databaseConnection.class.php';

/**
 * Will insert a new post and media to DB
 * 
 * @param string $dir Will contain the local repertory
 * @param string[] $imgArray Will contain the array of image(s) to add
 * @param string $modified Will insert the last modified date to DB(Unecessary as of now)
 * @param string $text Will contain the text of the post
 * 
 * @return bool
 */
function insertNewPost($dir, $imgArray, $modified, $text)
{
    try {
        //Instanciation of the DatabaseConnection and the beginning of transactions
        $req = DatabaseConnection::getInstance();
        $req->beginTransaction();

        //First, we insert a new post in the DB
        $req = DatabaseConnection::getInstance()->prepare('INSERT INTO post(postText,creationdate,modificationDate) VALUES(:postText,:creationdate,:modificationDate)');
        $req->execute(array(
            'postText' => $text,
            'creationdate' => date("Y-m-d H:i:s"),
            'modificationDate' => $modified
        ));
        //With the new post inserted we can now get the last insertedID, which we will use to link media to it
        $tempID = DatabaseConnection::getInstance()->lastInsertId();

        //Then foreach image in the array, we insert it and link it to $tempID, effectivily linking it to the post
        foreach ($imgArray as $img) {
            $req = DatabaseConnection::getInstance()->prepare('INSERT INTO media(nameMedia,typeMedia,creationdate,modificationDate, idPost) VALUES(:nameMedia,:typeMedia,:creationdate,:modificationDate,:idPost)');
            $req->execute(array(
                'nameMedia' => $dir . $img['name'],
                'creationdate' => date("Y-m-d H:i:s"),
                'modificationDate' => $modified,
                'typeMedia' => $img['type'],
                'idPost' => $tempID
            ));
        }

        //If nothing breaks until here, then we finally commit it, making the changes to the DB
        DatabaseConnection::getInstance()->commit();
        return true;
    } catch (Exception $e) {
        //If something broke along the way, then we rollback everything and cancel the last transactions
        DatabaseConnection::getInstance()->rollBack();
        return false;
        exit();
    }
}


function deletePost($id)
{
    try {
        //Instanciation of the DatabaseConnection and the beginning of transactions
        $req = DatabaseConnection::getInstance();
        $req->beginTransaction();

        $req = DatabaseConnection::getInstance()->prepare("DELETE FROM media WHERE idPost in ($id)");
        $req->execute();

        $req = DatabaseConnection::getInstance()->prepare("DELETE FROM post WHERE idPost in ($id)");
        $req->execute();

        //If nothing breaks until here, then we finally commit it, making the changes to the DB
        DatabaseConnection::getInstance()->commit();
        return true;
    } catch (Exception $e) {
        //If something broke along the way, then we rollback everything and cancel the last transactions
        DatabaseConnection::getInstance()->rollBack();
        return false;
        exit();
    }
}

function updatePost($mediaInfo, $text, $id)
{
    try {
        //Instanciation of the DatabaseConnection and the beginning of transactions
        $req = DatabaseConnection::getInstance();
        $req->beginTransaction();

        $newDate = date("Y-m-d H:i:s");
        $req = DatabaseConnection::getInstance()->prepare("UPDATE post SET postText = ('$text'), modificationDate = ('$newDate') WHERE idPost = ('$id')");
        $req->execute();

        if ($mediaInfo != []) {
            foreach ($mediaInfo as $media) {
                $idMedia = $media[0]['idMedia'];
                $req = DatabaseConnection::getInstance()->prepare("DELETE FROM media WHERE idMedia = ($idMedia)");
                $req->execute();
            }
        }

        //If nothing breaks until here, then we finally commit it, making the changes to the DB
        DatabaseConnection::getInstance()->commit();
        return true;
    } catch (Exception $e) {
        //If something broke along the way, then we rollback everything and cancel the last transactions
        DatabaseConnection::getInstance()->rollBack();
        return false;
        exit();
    }
}

/**
 * Will get a media by it's name
 * 
 * @param string $name Contain the name of the media to get
 */
function getMediaByName($name)
{
    $req = DatabaseConnection::getInstance()->query("SELECT idMedia FROM media where name in ('$name')");
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

function getMediaById($id)
{
    $req = DatabaseConnection::getInstance()->query("SELECT * FROM media where idMedia in ('$id')");
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
}


/**
 * Will simply return all post on DB
 */
function getAllPosts()
{
    $req = DatabaseConnection::getInstance()->query("SELECT * FROM post");
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Will return all media linked to a post with idPost
 * 
 * @param int $idPost Will contain the id of the post
 */
function getAllMediaFromPost($idPost)
{
    $req = DatabaseConnection::getInstance()->query("SELECT * FROM media WHERE idPost = $idPost");
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

function getPostFromId($idPost)
{
    $req = DatabaseConnection::getInstance()->query("SELECT * FROM post WHERE idPost = $idPost");
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
}
