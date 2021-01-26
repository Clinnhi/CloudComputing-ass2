<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
session_start();
require '../functions/dynamodb_functions.php';
require '../functions/s3_functions.php';
$app = new DynamoDBFunctions();
$s3 = new S3Functions();

$friends = $app->FriendList($_SESSION['username']);

$no_friend_selected = "";
$target_friend;
$target_friend_nametag = "";
$messages;

if (empty($_GET['user'])) {
    $no_chat_selected = "Select a friend to start messaging!";
} else {
    $friendname = $_GET['user'];
    $result = $app->UserDetails($friendname);
    $target_friend = $result[0];
    $target_friend_nametag = $target_friend['fullname']['S'] . " (" . $target_friend['username']['S'] . ")";
    $messages = $app->FetchMessages($_SESSION['username'], $friendname);
}



?>

<html>

<head>
    <meta charset="UTF-8">

    <title>Messages</title>

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
                <li><a href="messaging.php">Messages</a></li>
                <li><a href="../display-user.php">My Profile</a></li>
                <li><a href="../update-profile.php">Update Profile</a></li>
                <li><a href="../connect/connect-list.php">Connected Friends</a></li>
                <li><a href="../connect/connect-request-list.php">Connect Requests</a></li>
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

        <h1>Messages</h1>

        <?php
        if (empty($friends)) {
            echo 'No friends yet. Add some now!';
        }
        ?>

        <div style="width:20%;float:left;">
            <?php foreach ($friends as $user) {
                $userDetails = $app->UserDetails($user['friendname']['S']);
                // var_dump($userDetails);
                $target_fullname = $userDetails[0]['fullname']['S'];
                $target_username = $userDetails[0]['username']['S'];
                $target_userImage = $s3->getProfilePictureLink($target_username);
            ?>
                <tr>
                    <td>
                        <ul style="border-style: groove;padding: 10px;">
                            <img src=<?php echo $target_userImage; ?> style="width:50px;height:50px;">
                            <a href=<?php echo "messaging.php?user=" . $target_username; ?>><?php echo $target_fullname . " (" . $target_username . ")"; ?></a>
                        </ul>
                    </td>
                </tr>


            <?php } ?>
        </div>

        <div style="width:80%; height:80%; float:right;border-style: groove;padding: 10px;">
            <?php if ($target_friend) { ?>
                <h4><?php echo $target_friend_nametag; ?></h4>
            <?php } ?>
            <?php if (!$friendname) { ?>
                <h4><?php echo 'Pick a friend to start a conversation with' ?></h4>
            <?php } ?>
            <hr>

            <textarea>
            <?php
            if ($messages) {
                foreach ($messages as $message) {
                    $userDetails = $app->UserDetails($user['friendname']['S']);
                    // var_dump($userDetails);
                    $message_author = $message['author']['S'];
                    $message_timestamp = $message['timestamp']['N'];
                    $message_content = $message['content']['S'];
                    echo $message_content;
            ?>
               
            <?php }
            } ?>
            </textarea>

            <form style="width:100%;" name="send-message" action="" method="post">
                <input type="text" name="fullname" placeholder="Full Name" required />
                <input type="text" name="username" placeholder="Username" required />
                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Password" required />
                <input type="submit" name="submit" value="Register" />
            </form>
        </div>


    </div>
</body>

</html>