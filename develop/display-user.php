<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
// Start Session
session_start();

require 'functions/dynamodb_functions.php';
require 'functions/s3_functions.php';
$app = new DynamoDBFunctions();
$s3 = new S3Functions();

if (empty($_SESSION['username'])) {
    header("Location: loginpage.php");
}

$target_username = "";

if (empty($_GET['user'])) {
    $target_username = $_SESSION['username'];
    // echo 'EMPTY';
} else {
    $target_username = $_GET['user'];
}

$userDetails = $app->UserDetails($target_username);
$userDetails = $userDetails[0];

$userImage = $s3->getProfilePictureLink($target_username);

$full_name = $userDetails['fullname']['S'];
$email = $userDetails['email']['S'];
$about_me = $userDetails['aboutme']['S'];

// Cryptocurrency
$crypto_one = $userDetails['crypto1']['S'];
$crypto_two = $userDetails['crypto2']['S'];
$crypto_three = $userDetails['crypto3']['S'];


// Websites
$website_one = $userDetails['website1']['S'];
$website_two = $userDetails['website2']['S'];
$website_three = $userDetails['website3']['S'];

// Posts
$user_post = $app->FetchUserPosts($target_username);

// CRYPTO API
$url = "https://www.coinspot.com.au/pubapi/latest";
$getContent = file_get_contents($url);
$json = json_decode($getContent, true);


// Check if the form is submitted 
if (isset($_GET['submit'])) {
    // retrieve the form data by using the element's name attributes value as key 
    $crypto_one = $_POST['crypto-one'];
    $crypto_two = $_POST['crypto-two']; // display the results 
    $crypto_three = $_POST['crypto-three'];
}



// // About Me
// $full_name = $_POST['full-name'];
// $email = $_POST['email'];
// $about_me = $_POST['about-me'];

// // Three Facts About Yourself
// $fact_one = $_POST['fact-one'];
// $fact_two = $_POST['fact-two'];
// $fact_three = $_POST['fact-three'];



// // Cryptocurrency
// $crypto_one = $_POST['crypto-one'];
// $crypto_two = $_POST['crypto-two'];
// $crypto_three = $_POST['crypto-three'];


// // Websites
// $website_one = $_POST['website-one-url'];
// $website_two = $_POST['website-two-url'];
// $website_three = $_POST['website-three-url'];

// // Photos
// $photo_name = $_POST['photo_name'];



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
                <li><a href="newsfeed.php">News Feed</a></li>
                <li><a href="messages/messaging.php">Messages</a></li>
                <li><a href="display-user.php">My Profile</a></li>
                <li><a href="update-profile.php">Update Profile</a></li>
                <li><a href="connect/connect-list.php">Connected Friends</a></li>
                <li><a href="connect/connect-request-list.php">Connect Requests</a></li>
                <li><a href="support/contact-form.php">Support Center</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>

            <form class="form-inline">
                <div class="input-group">
                    <div class="input-group-prepend">
                    </div>


                </div>
            </form>

            <!-- SEARCH USERNAME -->
            <!-- SEARCH USERNAME -->
            <form action="display-user.php" method="get" name="form">
                <span class="right_header">
                    <a href="search-user.php"><button type="button" class="btn btn-primary btn-lg">Find Friends</button>
                    </a>
                </span>
            </form>
        </nav>




        <section id="greetings" class="jumbotron">
            <span class="center">
                <?php
                if ($target_username == $_SESSION['username']) {
                    echo '<h2>Your profile page.</h2>';
                    echo '<button onclick="location.href=\'post/new-post.php\'">Write a new post</button>';
                } else {
                    echo '<h2> Welcome To ' . $full_name . '\'s Profile Page. </br></h2>';
                }
                ?>
            </span>

            <!-- CONNECT WITH ME BUTTON -->
            <!-- <form method="post"> -->

            <div>
                <?php // 1. If user is friends with target user, display connected button
                if ($app->isFriend($_SESSION['username'], $target_username)) { ?>
                    <button id="primary" type="button" disabled>Connected</button>
                <?php } ?>

                <?php // 2. If user sent a friend request to target user, display connect request sent button
                if ($app->FriendRequestSent($_SESSION['username'], $target_username)) { ?>
                    <form action="connect/delete-connect-request.php" method="post">
                        <input type="hidden" name="targetname" value=<?php echo $target_username ?>>
                        <button id="primary">Connect request sent, click to undo</button>
                    </form>
                <?php } ?>

                <?php // 3. If user is neither friend nor sent friend request and target user is not user, display connect button
                if (!$app->isFriend($_SESSION['username'], $target_username) && !$app->FriendRequestSent($_SESSION['username'], $target_username) && $target_username != $_SESSION['username']) { ?>
                    <form action="connect/connect-with-me.php" method="post">
                        <input type="hidden" name="targetname" value=<?php echo $target_username ?>>
                        <button id="primary">Connect with me</button>
                    </form>
                <?php } ?>
            </div>
            <!-- </form> -->

        </section>


        <section id="about-me">
            <h1><?php echo $full_name . " (" . $target_username . ")" ?></h1>
            <img src=<?php echo $userImage; ?> style="width:200px;height:200px;">


            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['userfile']) && $_FILES['userfile']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['userfile']['tmp_name'])) {
                $s3->updateProfilePicture($target_username, $_FILES['userfile']['tmp_name']);
            }
            ?>
            <?php
            // make sure its the user's own profile page to have update image feature
            if ($target_username == $_SESSION['username']) { ?>
                <h4>Update profile image</h4>
                <form enctype="multipart/form-data" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                    <input name="userfile" type="file"><input type="submit" value="Upload">
                </form>

            <?php } ?>




            <div class="row">
                <div class="col-md-8">
                    <!-- RETRIEVE ABOUT ME -->
                    <h2>Email</h2>
                    <p><?php echo $email ?></p>
                    <br>
                    <h2>About Me</h2>
                    <p><?php echo $about_me ?></p>

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
                    <?php if ($crypto_one != '-') {
                        echo strtoupper('$' . $crypto_one);
                        echo '<br> Price for ' . $crypto_one . ' is:  $' . round($json['prices'][$crypto_one]["last"], 2) . '<br>';
                    } else {
                        echo 'No crypto selected';
                    }
                    ?>
                </div>

                <div class="col-md-4">
                    Cryptocurrency Two:
                    <?php if ($crypto_two != '-') {
                        echo strtoupper('$' . $crypto_two);
                        echo '<br> Price for ' . $crypto_two . ' is:  $' . round($json['prices'][$crypto_two]["last"], 2) . '<br>';
                    } else {
                        echo 'No crypto selected';
                    }
                    ?>
                </div>

                <div class="col-md-4">
                    Cryptocurrency Three:
                    <?php if ($crypto_three != '-') {
                        echo strtoupper('$' . $crypto_three);
                        echo '<br> Price for ' . $crypto_three . ' is:  $' . round($json['prices'][$crypto_three]["last"], 2) . '<br>';
                    } else {
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

        <!-- USER'S POSTS -->
        <section id="posts">
            <h1>My Posts</h1>
            <?php
            if (empty($user_post)) {
                echo 'You don\'t have any posts yet!';
            }
            ?>
            <?php foreach ($user_post as $post) { ?>

                <div style="border-style: groove;padding: 10px;">
                    <img src=<?php echo $userImage; ?> style="width:50px;height:50px;"><a href=<?php echo "display-user.php?user=" . $target_username ?>><?php echo $full_name . " (" . $target_username . ")"; ?></a>

                    <p style="text-align:right;float:right; color:grey"><?php echo 'posted at ' . date("Y-m-d  h:i:s", $post['timestamp']['N']); ?></p><br>
                    <p style="font-size: 25px;"><?php echo $post['content']['S']; ?></p>
                    <?php if ($post['imageURL']['S'] != '-') {
                        echo '<img src=' . $s3->getPostPictureLink($post['imageURL']['S']) . ' style="width:600px;height:400px; margin-bottom:10px;">';
                    } ?>

                    <?php if ($target_username == $_SESSION['username']) { ?>
                        <form action="post/delete-post.php" method="post">
                            <input type="hidden" name="timestamp" value=<?php echo $post['timestamp']['N'] ?>>
                            <input type="hidden" name="username" value=<?php echo $target_username ?>>
                            <button style="border-color: red; color:red;" id="primary">Delete Post</button>
                        </form>
                    <?php } ?>

                </div>
                <br>

            <?php   }   ?>
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