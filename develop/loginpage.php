<?php

// Start Session
session_start();

// Load the function class
require 'functions/dynamodb_functions.php';
$app = new DynamoDBFunctions();

$login_error_message = '';

// check Login request
if (!empty($_POST['username'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username == "") {
        $login_error_message = 'Username field is required';
    } else if ($password == "") {
        $login_error_message = 'Password field is required';
    } else {
        if ($app->Login($username, $password)) {
            $_SESSION['username'] = $username;
            $_SESSION["loggedIn"] = true;
            header("Location: display-user.php"); // Redirect user to dashboard
        } else {
            $login_error_message = 'Invalid username or password. Please try again.';
        }
    }
}
?>
<!doctype html>
<html lang="en-US">
<!--Initial Web-page design attempt-->

<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/design.css" />
</head>

<body>

    <div id="1">
        <table align="center" border="0" cellpadding="0" cellspacing="0" style="border-radius: 22px; border: 2px solid #5d4f8b;width: 825px;">
            <tr>
                <td style="margin-left:5px">
                </td>
                <td>
                    <h1 style=".center; color: #c9b0d4;font-family: sans-serif"><u>
                            Login Page</u></h1>
                </td>
            </tr>
        </table>


    </div>

    <div style="margin-top: -200px;" class="login">
        <h1>Sign In</h1>
        <?php
        if ($login_error_message != "") {
            echo '<div class="alert alert-danger"><strong>Error: </strong> ' . $login_error_message . '</div>';
        }
        ?>
        <form action="loginpage.php" method="post">
            <input type="text" name="username" placeholder="Username" required="required" />
            <input type="password" name="password" placeholder="Password" required="required" />
            <button type="submit" class="btn btn-primary btn-block btn-large">Login</button>
        </form>
        <br>
        <a style="color:white;" href='registerpage.php'>Not registered yet? Register Here</a>
        <br>
        <a style="color:white;" href='reset-password-page.php'>Forgot Password?</a>

    </div>

</body>

</html>