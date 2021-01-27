<?php
// Start Session
session_start();

// Load the function class
require 'functions/dynamodb_functions.php';
$app = new DynamoDBFunctions();

$register_error_message = '';
$register_success_message = '';

// check Login request
if (!empty($_POST['username'])) {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);

    if ($username == "" || $fullname == "" || $email == "" || $password == "") {
        $register_error_message = 'Some fields is empty';
    } else {
        if ($app->Register($username, $fullname, $password, $email, $phone)) {
            $register_success_message = 'Successfully registered!';
        } else {
            $register_error_message = 'Username is taken. Please try a different one.';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<meta charset="utf-8">
<link rel="stylesheet" href="css/design.css" />
</head>

<body>

    <div class="form">

        <h1 style=".center; color: #c9b0d4;font-family: sans-serif"> <u>Register Page</u></h1>
        <?php
        if ($register_error_message != "") {
            echo '<div style="color:white;" class="alert alert-danger"><strong>Error: </strong> ' . $register_error_message . '<br></div>';
        }
        if ($register_success_message != "") {
            echo '<div style="color:white;" class="alert alert-danger"><strong>Success: </strong> ' . $register_success_message . '<br></div>';
        }
        ?>
        <form style="width:30%;" name="registration" action="" method="post">
            <input type="text" name="fullname" placeholder="Full Name" required />
            <input type="text" name="username" placeholder="Username" required />
            <input type="email" name="email" placeholder="Email" required />
            <input type="phone" name="phone" placeholder="Phone Number" required />
            <input type="password" name="password" placeholder="Password" required />
            <input type="submit" name="submit" value="Register" />
        </form>
        <a style="color:white;" href='loginpage.php'>Already resgistered? Login here</a>


    </div>
</body>

</html>