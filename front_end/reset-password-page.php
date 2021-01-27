<!DOCTYPE html>
<html>
<meta charset="utf-8">
<link rel="stylesheet" href="css/reset-password.css" />


<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

</head>

<body>
 <div class="form-gap"></div>
<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="text-center">
                  <h3><i class="fa fa-lock fa-4x"></i></h3>
                  <h2 class="text-center">Forgot Password?</h2>
                  <p>Enter your username and we will send an SMS to your phone with a temporary password.</p>
                  <div class="panel-body">
    
                    <form id="register-form" role="form" autocomplete="off" name="reset" action="sns/reset-password-sms.php" method="post">

                      <div class="form-group">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                          
                          <input id="username" name="username" placeholder="Enter username here" class="form-control" required>

                        </div>
                      </div>
                      <div class="form-group">
                        <input name="submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                      </div>
                    </form>
                    <a href='loginpage.php'>Back to Login</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
	</div>
</div>
</body>

</html>
<!-- 


    	<center>
        <h1 style=".center; color: #c9b0d4;font-family: sans-serif"> <u>Reset Password</u></h1>
        
        <p style="color:white;">Enter your username and we will send an SMS to your phone with a temporary password.</p>
        
        <form style="width:30%;" name="reset" action="sns/reset-password-sms.php" method="post">
            <input type="text" name="username" placeholder="Username" required />
            <input type="submit" name="submit" value="Reset Password" />
        </form>
        <a style="color:white;" href='loginpage.php'>Back to Login</a>
        </center>
 -->