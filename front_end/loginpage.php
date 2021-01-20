<?php 

session_start();
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
        <table align="center" border="0" cellpadding="0" cellspacing="0" style="border-radius: 80px; border: 3px solid #5d4f8b;width: 600px;">
            <tr>
                <td>
                     <h1 style="center; color: #c9b0d4;font-family: sans-serif"><u>
                     Cloud Computing Summer Semester</u></h1>
                </td>
            </tr>
        </table>


    </div>

    <div style="margin-top: -200px;" class="login">
        <h1>Sign In</h1>
        
        <form method="post" action="check_credentials.php">
            <input type="text" name="username" placeholder="Username" required="required" />
            <input type="password" name="password" placeholder="Password" required="required" />

            <button type="submit" class="btn btn-primary btn-block btn-large">Login</button>
               
        </form>

        <a href='registration.php'>Not registered yet? Register Here</a>

    </div>

<?php 
unset($_SESSION["error"]);
 ?>

</body>
</html>