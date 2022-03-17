<?php
//TODO: It's late but i need to comment this as soon as possible
//Starting the session
session_start();

require './dbConnector/dbFunctions.php';

//Reseting every stored value
$_SESSION['err'] = "";
$_SESSION['postText'] = "";


$listPosts = ""; //This will contain the list of posts to display
//This will contain all the infos of posts in DB
$arrayOfPostInfos = [];
$arrayOfPostInfos = getAllPosts();

$postArray = [];
$postMediaLink;

//Foreach post in the array:
foreach ($arrayOfPostInfos as $post) {
  //We get all the medias linked to the IdPost
  $arrayOfMedia_Post = getAllMediaFromPost($post["idPost"]);
  //We then temporarly store it in postMediaLink to link the infos to the different medias
  $postMediaLink->postInfo = $post;
  $postMediaLink->medias = $arrayOfMedia_Post;

  //We then push a clone of the temporary array the postArray
  //The postMediaLink instance is stored in postArray but if we later modify the postMediaLink in the foreach, array_push will modify every instance of postMediaLink in postArray
  //This will cause all values in postArray to be equal to the last stored values in postMediaLink
  //by using 'clone' we instead create and store a clone of postMediaLink, that will not be modified on the next loop
  array_push($postArray, clone $postMediaLink);
}

foreach ($postArray as $post) { //Now we loop in every post stored in postArray
  $text = $post->postInfo["postText"];
  //Creating and storing the base html with the post's text
  $tempPost = "<article class='message'> <div class='message-header'> </div><div class='message-body'>" . $text . "</div>";

  foreach ($post->medias as $media) { //Foreach media in each post

    //We check the type of the media, and add the according html element for the media to be displayed in
    if ($media['typeMedia'] == "image") {
      $tempPost .= "<div class='message-body'><img width='15%' height='15%' src='" . $media["nameMedia"] . "'></div>";
    }
    if ($media['typeMedia'] == "video") {
      //The autoplay and loop will make the video run indefinitely
      $tempPost .= "<div class='message-body'><video width='15%' height='15%' autoplay loop muted><source src='" . $media["nameMedia"] . "'></video></div>";
    }
    if ($media['typeMedia'] == "audio") {
      $tempPost .= "<div class='message-body'><audio controls><source src='" . $media['nameMedia'] . "'></audio> </div>";
    }
  }
  //closing the post's html
  $tempPost .= "<div class='compose has-text-right'><button id='" .  $post->postInfo['idPost'] . "' class='button is-bold is-danger js-modal-trigger' data-target='modal-delete'>Supprimer</button>";
  $tempPost .= "<a class='button is-bold is-info'>Modifier</a></div></article>";
  $listPosts = $tempPost . $listPosts; //We finally add the string containing the html elements to listPosts and loop
}


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
  <div id="FCContainer" class="columns">
    <aside class="column">
      <div class="column">
        <div class="card">
          <div class="card-image">
            <figure class="image"><img src="assets/wallpaperPic.jpg" alt="Image"></figure>
          </div>
          <div class="card-content">

            <div class="media">
              <div class="media-left">
                <figure class="image is-48x48"><img src="assets/profilePic.jpg" alt="Image"></figure>
              </div>
              <div class="media-content">
                <p class="title is-4 no-padding">Lead Developer</p>
              </div>
            </div>
            <div class="content">
              I did everest once, was fun. Now i am CEO of Facebouk.
              <div class="background-icon"><span class="icon-twitter"></span></div>
            </div>
          </div>
        </div>
      </div>
      <div class="column">
        <div class="compose has-text-centered"><a class="button is-primary is-block is-bold"><span class="compose">Postez quelque chose!</span></a></div>
      </div>
    </aside>
    <div id="post-feed" class="column is-10">
      <article class="message is-large">
        <div class="message-body">
          <h2>Bienvenue</h2>
        </div>
      </article>
      <?php echo $listPosts //We simply echo listPosts to display everything
      ?>

    </div>

  </div>
  <!-- Modal-->
  <div id="modal-delete" class="modal">
    <div class="modal-background"></div>

    <div class="modal-content">
      <div class="box">
        <p>Souhaitez-vous supprimer ce post?</p>
        <!-- Your content -->
        <button class='button is-bold is-danger' onclick="postDelete()">Confirmer</button>
      </div>
    </div>
  </div>

</body>
<script src="assets/js/index.js"></script>

</html>