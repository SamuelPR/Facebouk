<?php
session_start();
require_once('../dbConnector/configuration.inc.php');
require_once('../dbConnector/databaseConnection.class.php');
require_once('../dbConnector/dbFunctions.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Document</title>
</head>

<body>
    <?php require("../navbar.inc.php") ?>
    <div class="container">
        <?php
        if ($_SESSION['err'] != "") {
            echo "<div class='notification is-danger is-light'>";
            echo $_SESSION['err'];
            echo "</div>";
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $btnText = 'Modifier!';
            $postInfo = getPostFromId($_POST['postId']);
            $mediaInfo = getAllMediaFromPost($_POST['postId']);

            $_SESSION['postText'] = $postInfo[0]['postText'];
        } else {
            $btnText = 'Postez quelque chose!';
        }
        ?>
        <?php if($_SERVER['REQUEST_METHOD'] == "POST"){
            echo "<form action='../modifyProcess.php' method='POST' enctype='multipart/form-data'>";
        }else{
            echo "<form action='./postProcess.php' method='POST' enctype='multipart/form-data'>";
        }
        
        
        ?>
        
            <div class="field">


                <label class="label">Name</label>
                <div class="control">
                    <input class="textarea is-primary" type="text" name="text" placeholder="What are you thinking about ?" value=<?php echo $_SESSION['postText'] ?>>
                </div>
            </div>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $postId = $_POST['postId'];
                echo "<input type='hidden' name='postId' value=\"$postId\">";
                foreach ($mediaInfo as $media) {
                    $checkbox = "<input type=\"checkbox\" id=\"" . $media['nameMedia'] . "\" name=\"mediaToChange[]\" value=\"" . $media['idMedia'] . "\">";
                    switch ($media['typeMedia']) {
                        case "image":
                            $checkbox .= " <img class=\"p-1\" src=\"../" . $media['nameMedia'] . "\" width=\"15%\" height=\"15%\">";
                            break;
                        case "video":
                            $checkbox .= "<video width=\"15%\" height=\"15%\" autoplay loop muted><source src=\"../" . $media["nameMedia"] . "\" type=\"" . $media["nameMedia"] . "\"></video>";
                            break;
                        case "audio":
                            $checkbox .= " <audio class=\"p-1\" controls><source src=\"../" . $media['nameMedia'] . "\" type=\"" . $media["nameMedia"] . "\"></audio>";
                            break;
                    }
                    echo $checkbox;
                }
            } else {
                echo "<div class='field'> <div class='control'> <input type='file' class='button' name='files[]' accept='image/*,video/*,audio/*' multiple='multiple'> </div> </div>";
            }
            ?>
            <div class="field">

                <div class="control">
                    <button type="submit" class="button is-primary is-block is-bold"><?= $btnText ?></button>
                </div>

            </div>
        </form>
    </div>
</body>
<script src="../assets/js/index.js"></script>

</html>