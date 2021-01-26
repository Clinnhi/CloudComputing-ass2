<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
session_start();
require '../functions/dynamodb_functions.php';
require '../functions/s3_functions.php';
$app = new DynamoDBFunctions();
$s3 = new S3Functions();

$result = $app->FriendRequestList($_SESSION['username']);
?>

<html>

<head>
    <meta charset="UTF-8">

    <title>Connect Request list</title>

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
                <li><a href="../messages/messaging.php">Messages</a></li>
                <li><a href="../display-user.php">My Profile</a></li>
                <li><a href="../update-profile.php">Update Profile</a></li>
                <li><a href="connect-list.php">Connected Friends</a></li>
                <li><a href="connect-request-list.php">Connect Requests</a></li>
                <li><a href="../support/contact-form.php">Support Center</a></li>
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
                    <a href="../search-user.php"><button type="button" class="btn btn-primary btn-lg">Find Friends</button>
                    </a>
                </span>
            </form>
        </nav>

        <h1>Connect Requests</h1>

        <?php
        if (empty($result)) {
            echo 'No connect requests for now.';
        }
        ?>

        <?php foreach ($result as $user) {
            $userDetails = $app->UserDetails($user['username']['S']);
            // var_dump($userDetails);
            $target_fullname = $userDetails[0]['fullname']['S'];
            $target_username = $userDetails[0]['username']['S'];
            $target_userImage = $s3->getProfilePictureLink($target_username);
        ?>
            <tr>
                <td>
                    <ul>
                        <img src=<?php echo $target_userImage; ?> style="width:50px;height:50px;">
                        <a href=<?php echo "../display-user.php?user=" . $target_username; ?>><?php echo $target_fullname . " (" . $target_username . ")"; ?></a>

                        <form action="accept-connect-request.php" method="post">
                            <input type="hidden" name="targetname" value=<?php echo $target_username ?>>
                            <br>
                            <button id="primary">Accept request</button>
                        </form>

                        <form action="reject-connect-request.php" method="post">
                            <input type="hidden" name="targetname" value=<?php echo $target_username ?>>
                            <button id="primary">Reject</button>
                        </form>
                        <br>

                    </ul>
                </td>
            </tr>


        <?php } ?>
    </div>
</body>

</html>