<!DOCTYPE html>
<html>
<meta charset="utf-8">
<link rel="stylesheet" href="css/design.css" />
</head>

<body>

    <div class="form">

        <h1 style=".center; color: #c9b0d4;font-family: sans-serif"> <u>Reset Password</u></h1>
        <p style="color:white;">Enter your username and we will send an SMS to your phone with a temporary password.</p>
        <form style="width:30%;" name="reset" action="sns/reset-password-sms.php" method="post">
            <input type="text" name="username" placeholder="Username" required />
            <input type="submit" name="submit" value="Reset Password" />
        </form>
        <a style="color:white;" href='loginpage.php'>Back to Login</a>


    </div>
</body>

</html>