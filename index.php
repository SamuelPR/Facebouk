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
  <nav class="navbar">
    <div class="container">
      <div class="navbar-brand">
        <a class="navbar-item" href="../">
          <img src="../images/bulma.png" alt="Logo">
        </a>
        <span class="navbar-burger burger" data-target="navbarMenu">
          <span></span>
          <span></span>
          <span></span>
        </span>
      </div>
      <div id="navbarMenu" class="navbar-menu">
        <div class="navbar-end">
          <div class=" navbar-item">
            <div class="control has-icons-left">
              <input class="input is-rounded" type="email" placeholder="Search">
              <span class="icon is-left">
                <i class="fa fa-search"></i>
              </span>
            </div>
          </div>
          <a class="navbar-item is-active is-size-5 has-text-weight-semibold">
            Home
          </a>
          <a class="navbar-item is-size-5 has-text-weight-semibold">
            Examples
          </a>
          <a class="navbar-item is-size-5 has-text-weight-semibold">
            Features
          </a>
        </div>
      </div>
    </div>
  </nav>
  <div id="FCContainer" class="columns">
    <aside class="column">
      <div class="column">
        <div class="card">
          <div class="card-image">
            <figure class="image"><img src="https://source.unsplash.com/h-ACUrBngrw/1280x720" alt="Image"></figure>
          </div>
          <div class="card-content">
            <div class="media">
              <div class="media-left">
                <figure class="image is-48x48"><img src="https://avatars.dicebear.com/api/initials/john%20doe.svg" alt="Image"></figure>
              </div>
              <div class="media-content">
                <p class="title is-4 no-padding">Lead Developer</p>
              </div>
            </div>
            <div class="content">
              The Beast stumbled in the dark for it could no longer see the path. It started to fracture and weaken, trying to reshape itself into the form of metal. Even the witches would no longer lay eyes upon it, for it had become hideous and twisted.
              <div class="background-icon"><span class="icon-twitter"></span></div>
            </div>
          </div>
        </div>
      </div>
      <div class="column">
        <div class="compose has-text-centered"><a class="button is-primary is-block is-bold"><span class="compose">Postez quelque chose!</span></a></div>
      </div>
    </aside>
    <div id="post-feed" class="column is-10 hero is-fullheight">
      <article class="message">
        <div class="message-header">
          <p>Hello World</p>
          <button class="delete" aria-label="delete"></button>
        </div>
        <div class="message-body">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. <strong>Pellentesque risus mi</strong>, tempus quis placerat ut, porta nec nulla. Vestibulum rhoncus ac ex sit amet fringilla. Nullam gravida purus diam, et dictum <a>felis venenatis</a> efficitur. Aenean ac <em>eleifend lacus</em>, in mollis lectus. Donec sodales, arcu et sollicitudin porttitor, tortor urna tempor ligula, id porttitor mi magna a neque. Donec dui urna, vehicula et sem eget, facilisis sodales sem.
        </div>
      </article>
    
    </div>
  </div>
</body>

</html>