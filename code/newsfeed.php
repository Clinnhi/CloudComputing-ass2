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

// Fetch all friend's Posts
$posts = $app->FetchAllFriendsPosts($_SESSION['username']);

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
                <h2> News Feed </br></h2>
                <button onclick="location.href='post/new-post.php'">Write a new post</button>
            </span>
        </section>

        <!-- FRIEND'S POSTS -->
        <section id="posts">
            <?php
                if (empty($posts)) {
                    echo 'There\'s nothing in your feed!';
                }
            ?>
            <?php foreach ($posts as $post) { 
                $target_username = $post['username']['S'];
                $target_fullname = $app->UserDetails($target_username)[0]['fullname']['S'];
                $userImage = $s3->getProfilePictureLink($target_username);
            ?>

                <div style="border-style: groove;padding: 10px;">
                    <img src=<?php echo $userImage; ?> style="width:50px;height:50px;"><a href=<?php echo "display-user.php?user=" . $target_username ?>><?php echo $target_fullname . " (" . $target_username . ")"; ?></a>
                    <p style="text-align:right;float:right; color:grey"><?php echo 'posted at ' . date("Y-m-d  h:i:s", $post['timestamp']['N']); ?></p><br>
                    <p style="font-size: 25px;"><?php echo $post['content']['S']; ?></p>
                    <?php 
                        if ($post['language']['S'] != 'en') {
                            echo '<p style="font-size:20px;font-style:italic;">Translation:<br>' . $translate->translateText($post['content']['S'], $post['language']['S']) . '</p>';
                        }
                    ?>
                    <?php if ($post['imageURL']['S'] != '-') {
                        $mediaURL = $s3->getPostMediaLink($post['imageURL']['S']);
                        echo '<img src=' . $mediaURL . ' style="width:600px;height:400px; margin-bottom:10px;">';
                    } ?>
                </div>
                <br>

            <?php   }   ?>
        </section>


    </div>
</body>

</html>