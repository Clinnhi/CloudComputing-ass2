<?php
// Start Session
session_start();

// Load the function class
require 'functions/dynamodb_functions.php';
$app = new DynamoDBFunctions();

$post_error_message = '';
$post_success_message = '';


$username = $_SESSION['username'];

// check update request
if (!empty($_POST['content'])) {
    $content = trim($_POST['content']);
    $imageURL = trim($_POST['content']);

    $result = $app->

    if ($result) {
        $update_success_message = 'Details successfully updated';
    } else {
        $update_error_message = 'Invalid details. Please try again';
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <title>Update Profile</title>

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
                <li><a href="../newsfeed.php">News Feed</a></li>
                <li><a href="../display-user.php">My Profile</a></li>
                <li><a href="../update-profile.php">Update Profile</a></li>
                <li><a href="../connect/connect-list.php">Connected Friends</a></li>
                <li><a href="../connect/connect-request-list.php">Connect Requests</a></li>
                <li><a href="../logout.php">Logout</a></li>
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

        <?php
        if ($post_error_message != "") {
            echo '<div class="alert alert-danger"><strong>Error: </strong> ' . $post_error_message . '</div>';
        }
        if ($post_success_message != "") {
            echo '<div class="alert alert-success"><strong>Error: </strong> ' . $post_success_message . '</div>';
        }
        ?>

        <form action="new-post.php" method="post">
            <h2>Write a new post</h2>

            <label name="content" class="col-sm-3 control-label">Content <span class="asterisk">*</span></label>
            <div class="col-sm-9"><textarea name="content" placeholder="Write something..." required="required"></textarea></div>
            <h4>Image</h4>
            <input name="userfile" type="file"><input type="submit" value="Upload">
            
            <button type="submit" class="btn btn-primary btn-block btn-large" style="width:150px;">Update Profile</button>
        </form>
</body>

</html>