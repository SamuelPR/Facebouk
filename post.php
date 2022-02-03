<?php

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
    <?php require("navbar.inc.php") ?>
    <div class="container">
        <form action="#" method="POST" enctype="multipart/form-data">
            <div class="field">
                <label class="label">Name</label>
                <div class="control">
                    <input class="textarea is-primary" type="text" name="text" placeholder="What are you thinking about ?">
                </div>
            </div>
            <div class="field">
            <div class="control">
                <input type="file" class="button" name="fileToUpload[]" accept="image/jpeg,image/png,image/jpg" multiple="multiple">
            </div>
            </div>
            <div class="field">
            <div class="control">
                <button type="submit" class="button is-primary is-block is-bold">Postez quelque chose!</button>
            </div>
            </div>
        </form>
    </div>
</body>
<script src="assets/js/index.js"></script>

</html>