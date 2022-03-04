<!DOCTYPE html>
<html lang="en">
<?php
//TODO: It's late but i need to comment this as soon as possible
session_start();
$_SESSION['err'] = "";
$_SESSION['postText'] = "";

require './dbConnector/dbFunctions.php';

$listPosts = "";
$arrayOfPostIDs = [];
$arrayOfPostIDs = getAllPosts();
$postArray = [];
$postMediaLink;

foreach ($arrayOfPostIDs as $post) {
  $arrayOfMedia_Post = getAllMediaFromPost($post["idPost"]);
  $postMediaLink->postInfo = $post;
  $postMediaLink->images = $arrayOfMedia_Post;
  array_push($postArray, clone $postMediaLink);
}

foreach ($postArray as $post) {
  $text = $post->postInfo["postText"];
  $tempPost = "<article class='message'> <div class='message-header'> </div><div class='message-body'>" . $text . "</div>";

  foreach ($post->images as $image) {
    $tempPost .= "<div class='message-body'><img src='" . $image["nameMedia"] . "'></div>";
  }
  $tempPost .= "</article>";
  $listPosts = $tempPost . $listPosts;
}


?>

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
      <?php echo $listPosts ?>
      <!--  <article class="message">
        <div class="message-header">
          <p>Bienvenue</p>
        </div>
        <div class="message-body">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. <strong>Pellentesque risus mi</strong>, tempus quis placerat ut, porta nec nulla. Vestibulum rhoncus ac ex sit amet fringilla. Nullam gravida purus diam, et dictum <a>felis venenatis</a> efficitur. Aenean ac <em>eleifend lacus</em>, in mollis lectus. Donec sodales, arcu et sollicitudin porttitor, tortor urna tempor ligula, id porttitor mi magna a neque. Donec dui urna, vehicula et sem eget, facilisis sodales sem.
        </div>
      </article> -->

    </div>

  </div>

</body>
<script src="assets/js/index.js"></script>

</html>