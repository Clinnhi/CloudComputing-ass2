<?php

// About Me
$full_name = $_POST['full-name'];
$email = $_POST['email'];
$about_me = $_POST['about-me'];

// Three Facts About Yourself
$fact_one = $_POST['fact-one'];
$fact_two = $_POST['fact-two'];
$fact_three = $_POST['fact-three'];



// Cryptocurrency
$crypto_one = $_POST['crypto-one'];
$crypto_two = $_POST['crypto-two'];
$crypto_three = $_POST['crypto-three'];


// Websites
$website_one = $_POST['website-one-url'];
$website_two = $_POST['website-two-url'];
$website_three = $_POST['website-three-url'];

// Photos
$photo_name = $_POST['photo_name'];


// CRYPTO API

$url = "https://www.coinspot.com.au/pubapi/latest"; 
$getContent = file_get_contents($url);   
$json = json_decode($getContent, true);   


 // Check if the form is submitted 
 if ( isset( $_POST['submit'] ) ) { 
 // retrieve the form data by using the element's name attributes value as key 
 $crypto_one = $_POST['crypto-one']; 
 $crypto_two = $_POST['crypto-two']; // display the results 
 $crypto_three = $_POST['crypto-three'];
}
// echo "Full Name: " . $full_name . "<br>";
// echo "Email: " . $email . "<br>";
// echo "About Me: " . $about_me . "<br>";

// echo "Photo: " . $photo_name . "<br>";


// echo "Cryptocurrency One: " . $crypto_one . "<br>";
// echo "Cryptocurrency Two: " . $crypto_two . "<br>";
// echo "Cryptocurrency Three: " . $crypto_three . "<br>";

// echo "Website One: " . $website_one . "<br>";
// echo "Website Two: " . $website_two . "<br>";
// echo "Website Three: " . $website_three . "<br>";
?>

<html>
  <head>
    <meta charset="UTF-8">

    <title>Profile page</title>
      
    <link rel="stylesheet" href="css/about-me.css">

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

           <form class="form-inline">
            <div class="input-group">
              <div class="input-group-prepend">
            </div>

            
             </div>
           </form>

           <!-- SEARCH USERNAME -->
           <form action="display-user.php" method="get" name="form"> 
            <span class="right_header"> 
              <!-- <input name="search_username" id="search_username" type="text" class="form-control" placeholder="Search Username" aria-label="Username" aria-describedby="basic-addon1"> --><a href="databaseIndex.php"><button type="button" class="btn btn-primary btn-lg">Search Profile</button>
              </a>
            </span>
          </form>
      </nav>



      
      <section id="greetings" class="jumbotron">
        <h1>Cloud Computing Assignment Two <script language="javascript">
        </script>
        </h1>
        <span class="center"> <p> Welcome To <?php echo $full_name ?>'s Profile Page. </br></p> </span>

        <!-- CONNECT WITH ME BUTTON -->
        <!-- <form method="post"> -->
        <div>   
          <button id="primary">Connect With Me!</button>
        </div>
        <script src="javascript/connect-button.js"></script>
        <?php include 'connect-with-me.php' ?> 
        <!-- </form> -->

      </section>


      <section id="about-me">
        <h1>About Me</h1>
        <div class="row">
          <div class="col-md-8">
            <!-- RETRIEVE ABOUT ME -->
            <p><?php echo $about_me ?></p>
            <h2>Some facts...</h2>
            <!-- RETRIEVE FACTS -->
            <ul>
              <li><?php echo $fact_one ?></li>
              <li><?php echo $fact_two ?></b></li>
              <li><?php echo $fact_three ?> </li>
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


      <!-- FAVOURITE CRYPTOS -->
      <section id="links">
        <h1>My Three Favourite Cryptocurrencies</h1>
        <div class="row">
          <div class="col-md-4">
            Cryptocurrency One:
            <!-- Sample PHP API - Code to retrieve btc price -->
            <?php if ($crypto_one != '-'){
              echo strtoupper('$'. $crypto_one);
              echo '<br> Price for ' . $crypto_one . ' is:  $' . round($json['prices'][$crypto_one]["last"], 2) . '<br>';
          }
            else{
              echo 'No crypto selected';
            }
             ?>
          </div>

          <div class="col-md-4">
            Cryptocurrency Two:
            <?php if ($crypto_two != '-'){
              echo strtoupper('$'. $crypto_two);
              echo '<br> Price for ' . $crypto_two . ' is:  $' . round($json['prices'][$crypto_two]["last"], 2) . '<br>';
          }
            else{
              echo 'No crypto selected';
            }
             ?>
          </div>

          <div class="col-md-4">
            Cryptocurrency Three:
            <?php if ($crypto_three != '-'){
              echo strtoupper('$'. $crypto_three);
              echo '<br> Price for ' . $crypto_three . ' is:  $' . round($json['prices'][$crypto_three]["last"], 2) . '<br>';
          }
            else{
              echo 'No crypto selected';
            }
             ?>
          </div>
        </div>
      </section>


      <!-- FAVOURITE WEBSITES -->
      <section id="links">
        <h1>My Three Favourite Websites</h1>
        <div class="row">
          <div class="col-md-4">
            <?php echo 'Website One: ' . ucfirst($website_one) ?>
          </div>

          <div class="col-md-4">
            <?php echo 'Website One: ' . ucfirst($website_two) ?>
          </div>

          <div class="col-md-4">
            <?php echo 'Website One: ' . ucfirst($website_three) ?>
          </div>
        </div>
      </section>

      <!-- Start of CONTACT ME -->
      <section id="contact-me">
        <h1>Contact me</h1>
        <p>Clinton Pham - s3605044@student.rmit.edu.au</p>
        <p>Sean Tan - s3806690@student.rmit.edu.au</p>
      </section>
    </div>
  </body>
</html>