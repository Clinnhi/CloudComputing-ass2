<?php
// Start Session
session_start();

// Load the function class
require 'functions/dynamodb_functions.php';
$app = new DynamoDBFunctions();

$update_error_message = '';
$update_success_message = '';


$username = $_SESSION['username'];

$userDetails = $app->UserDetails($username);
$userDetails = $userDetails[0];

$fullname = $userDetails['fullname']['S'];
$password = $userDetails['password']['S'];
$email = $userDetails['email']['S'];
$about_me = $userDetails['aboutme']['S'];

// Cryptocurrency
$crypto1 = $userDetails['crypto1']['S'];
$crypto2 = $userDetails['crypto2']['S'];
$crypto3 = $userDetails['crypto3']['S'];


// Websites
$website1 = $userDetails['website1']['S'];
$website2 = $userDetails['website2']['S'];
$website3 = $userDetails['website3']['S'];



// check update request
if (!empty($_POST['fullname'])) {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $user_type = 'User';
    $aboutme = trim($_POST['aboutme']);
    $crypto1 = trim($_POST['crypto1']);
    $crypto2 = trim($_POST['crypto2']);
    $crypto3 = trim($_POST['crypto3']);
    $website1 = trim($_POST['website1']);
    $website2 = trim($_POST['website2']);
    $website3 = trim($_POST['website3']);

    $result = $app->UpdatePersonalInfo($username, $fullname, $password, $email, $aboutme, $crypto1, $crypto2, $crypto3, $website1, $website2, $website3);

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

        <?php
        if ($update_error_message != "") {
            echo '<div class="alert alert-danger"><strong>Error: </strong> ' . $update_error_message . '</div>';
        }
        if ($update_success_message != "") {
            echo '<div class="alert alert-success"><strong>Success: </strong> ' . $update_success_message . '</div>';
        }
        ?>

        <form action="update-profile.php" method="post">
            <h1>Personal Info</h1>
            <label name="fullname" class="col-sm-3 control-label">Full Name <span class="asterisk">*</span></label>
            <div class="col-sm-9"><input type="text" name="fullname" value=<?php echo '"' . $fullname . '"'; ?> required="required" /></div>

            <label name="password" class="col-sm-3 control-label">Password <span class="asterisk">*</span></label>
            <div class="col-sm-9"><input type="password" name="password" value=<?php echo '"' . $password . '"'; ?> required="required" /></div>

            <label name="email" class="col-sm-3 control-label">Email <span class="asterisk">*</span></label>
            <div class="col-sm-9"><input type="text" name="email" value=<?php echo '"' . $email . '"'; ?> required="required" /></div>

            <label name="aboutme" class="col-sm-3 control-label">About Me <span class="asterisk">*</span></label>
            <div class="col-sm-9"><textarea name="aboutme" required="required"><?php echo $about_me; ?></textarea></div>

            <h1>Favourite Cryptocurrencies</h1>
            <label>Crypto One:</label>
            <select name="crypto1" id="crypto1">
                <option value="-" <?php if ($crypto1 == "-") { echo 'selected'; } ?>>-</option>
                <option value="btc" <?php if ($crypto1 == "btc") { echo 'selected'; } ?>>Bitcoin</option>
                <option value="eth" <?php if ($crypto1 == "eth") { echo 'selected'; } ?>>Ethereum</option>
                <option value="ltc" <?php if ($crypto1 == "ltc") { echo 'selected'; } ?>>Litecoin</option>
                <option value="xrp" <?php if ($crypto1 == "xrp") { echo 'selected'; } ?>>Ripple</option>
                <option value="powr" <?php if ($crypto1 == "powr") { echo 'selected'; } ?>>Power Ledger</option>
                <option value="trx" <?php if ($crypto1 == "trx") { echo 'selected'; } ?>>Tron</option>
                <option value="eos" <?php if ($crypto1 == "eos") { echo 'selected'; } ?>>EOS</option>
            </select>
            <br><br>

            <label>Crypto Two:</label>
            <select name="crypto2" id="crypto2">
                <option value="-" <?php if ($crypto2 == "-") { echo 'selected'; } ?>>-</option>
                <option value="btc" <?php if ($crypto2 == "btc") { echo 'selected'; } ?>>Bitcoin</option>
                <option value="eth" <?php if ($crypto2 == "eth") { echo 'selected'; } ?>>Ethereum</option>
                <option value="ltc" <?php if ($crypto2 == "ltc") { echo 'selected'; } ?>>Litecoin</option>
                <option value="xrp" <?php if ($crypto2 == "xrp") { echo 'selected'; } ?>>Ripple</option>
                <option value="powr" <?php if ($crypto2 == "powr") { echo 'selected'; } ?>>Power Ledger</option>
                <option value="trx" <?php if ($crypto2 == "trx") { echo 'selected'; } ?>>Tron</option>
                <option value="eos" <?php if ($crypto2 == "eos") { echo 'selected'; } ?>>EOS</option>
            </select>
            <br><br>

            <label>Crypto Three:</label>
            <select name="crypto3" id="crypto3">
                <option value="-" <?php if ($crypto3 == "-") { echo 'selected'; } ?>>-</option>
                <option value="btc" <?php if ($crypto3 == "btc") { echo 'selected'; } ?>>Bitcoin</option>
                <option value="eth" <?php if ($crypto3 == "eth") { echo 'selected'; } ?>>Ethereum</option>
                <option value="ltc" <?php if ($crypto3 == "ltc") { echo 'selected'; } ?>>Litecoin</option>
                <option value="xrp" <?php if ($crypto3 == "xrp") { echo 'selected'; } ?>>Ripple</option>
                <option value="powr" <?php if ($crypto3 == "powr") { echo 'selected'; } ?>>Power Ledger</option>
                <option value="trx" <?php if ($crypto3 == "trx") { echo 'selected'; } ?>>Tron</option>
                <option value="eos" <?php if ($crypto3 == "eos") { echo 'selected'; } ?>>EOS</option>
            </select>
            <br><br>

            <h1>Favourite Websites</h1>
            <label name="website1" class="col-sm-3 control-label">Website1 </label>
            <div class="col-sm-9"><input type="text" name="website1" value=<?php echo $website1; ?> required="required" /></div>
            <label name="website2" class="col-sm-3 control-label">Website2 </label>
            <div class="col-sm-9"><input type="text" name="website2" value=<?php echo $website2; ?> required="required" /></div>
            <label name="website3" class="col-sm-3 control-label">Website3 </label>
            <div class="col-sm-9"><input type="text" name="website3" value=<?php echo $website3; ?> required="required" /></div>

            <button type="submit" class="btn btn-primary btn-block btn-large" style="width:150px;">Update Profile</button>
        </form>
</body>

</html>