<?php
// Start Session
session_start();

require '../functions/dynamodb_functions.php';
require '../functions/s3_functions.php';
$app = new DynamoDBFunctions();
$s3 = new S3Functions();

$post_error_message = '';
$post_success_message = '';


$username = $_SESSION['username'];

// Write post POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $timestamp = time(); // get timestamp
    // Check if user uploaded an image
    if (isset($_FILES['userfile']) && $_FILES['userfile']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['userfile']['tmp_name'])) {
        try {
            $app->CreatePost($username, $_POST['content'], $username . $timestamp);
            $s3->uploadPostPicture($username, $_FILES['userfile']['tmp_name'], $timestamp);
            $post_success_message = 'Post successfully made!';
        } catch (Exception $e) {
            $post_error_message = 'Invalid image file or image file too large!';
        }
    }
    // else if no image uploaded
    else {
        try {
            $app->CreatePost($username, $_POST['content'], '-');
            $post_success_message = 'Post successfully made!';
        } catch (Exception $e) {
            $post_error_message = 'Invalid image file or image file too large!';
        }
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
            echo '<div class="alert alert-success"><strong>Success: </strong> ' . $post_success_message . '</div>';
        }
        ?>
        <div>
            <h2>Write a new post</h2>
            <form enctype="multipart/form-data" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                <textarea style="width:50%;" name="content" placeholder="Write something..." required="required"></textarea>
                <p>Upload an image</p>
                <input name="userfile" type="file"><input type="submit" value="Upload">
                <br>
                <button type="submit" class="btn btn-primary btn-block btn-large" style="width:150px;">Post</button>
            </form>
        </div>

</body>

</html>