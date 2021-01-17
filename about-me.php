<html>
  <head>
    <meta charset="UTF-8">

    <title>Profile page</title>
    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

  </head>
  <body>
    <div class="container">
      <nav class="navbar navbar-default">
        <ul class="nav navbar-nav">
          <li><a href="#news-feed">News Feed</a></li>
          <li><a href="#about-me">About Me</a></li>
          <li><a href="#contact-me">Contact Me</a></li>
        </ul>
      </nav>
      
      <section id="greetings" class="jumbotron">
        <h1>Cloud Computing Assignment Two <script language="javascript">
        </script>
        </h1>
        <p> Welcome to my profile page. </br></p>
      </section>


      <section id="about-me">
        <h1>About Me</h1>
        <div class="row">
          <div class="col-md-8">
            <!-- RETRIEVE ABOUT ME -->
            <p>CODE TO RETRIEVE 'ABOUT ME'</p>
            <h2>Some facts...</h2>
            <!-- RETRIEVE FACTS -->
            <ul>
              <li><b></b> </li>
              <li><b></b></li>
              <li><b></b> </li>
            </ul>
          </div>
         <!--  <div class="col-md-4">
            <img class="img-responsive" src="img/marcia.jpg" alt="Marcia profile picture">
          </div> -->
        </div>
      </section>


      <!-- PHOTO SECTION -->
      <!-- RETRIEVE PHOTO -->
      <section id="photos">
        <h1>Photos</h1>

        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
          <!-- Indicators -->
          <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
            <li data-target="#carousel-example-generic" data-slide-to="3"></li>
          </ol>

          <!-- Wrapper for slides -->
          <div class="carousel-inner" role="listbox">
            <div class="item active">
              <img src="images/rx7.png" alt="Mazda Rx7" class="img-responsive">
              <div class="carousel-caption">
                <h3>Mazda RX7</h3>
              </div>
            </div>

            <!-- Sample Photos -->
            <div class="item">
              <img src="images/sti.png" alt="Subaru WRX STI" class="img-responsive">
              <div class="carousel-caption">
                <h3>Subaru WRX STI</h3>
              </div>
            </div>

            <div class="item">
              <img src="images/s2k.png" alt="Honda S2000" class="img-responsive">
              <div class="carousel-caption">
                <h3>Honda S2000</h3>
              </div>
            </div>
          </div>
          <!-- Next/Previous buttons for Photos -->
          <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </section>


      <!-- FAVOURITE WEBSITES -->
      <section id="links">
        <h1>My favorite Websites</h1>
        <div class="row">
          <div class="col-md-3">
            <a href="http://www.youtube.com" class="thumbnail">
              <img src="images/youtube.png" alt="youtube website" height="250" width="250">
            </a>
          </div>
          <div class="col-md-3">
            <a href="http://www.facebook.com/" class="thumbnail">
              <img src="images/facebook-logo.png" alt="facebook website" height="250" width="250">
            </a>
          </div>
          <div class="col-md-3">
            <a href="http://www.twitter.com/" class="thumbnail">
              <img src="images/twitter.png" alt="twitter website" height="250" width="250">
            </a>
          </div>
          <div class="col-md-3">
            <a href="http://www.instagram.com/" class="thumbnail">
              <img src="images/instagram.png" alt="Instagram web page" height="250" width="250">
            </a>
          </div>
        </div>
      </section>
      <section id="contact-me">
        <h1>Contact me</h1>
        <p>Clinton Pham - s3605044@student.rmit.edu.au</p>
        <p>Sean Tan - s3806690@student.rmit.edu.au</p>
      </section>
    </div>
  </body>
</html>