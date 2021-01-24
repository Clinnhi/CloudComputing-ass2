<!DOCTYPE html>
<html>
<head>
	<title>Main Page</title>

	    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

</head>
<body>

    <div class="container">
      <nav class="navbar navbar-default">
        <ul class="nav navbar-nav">
          <li><a href="#news-feed">News Feed</a></li>
          <li><a href="#about-me">About Me</a></li>
          <li><a href="#contact-me">Contact Me</a></li>
        </ul>

           <form class="form-inline">
            <div class="input-group">
              <div class="input-group-prepend">
            </div>

            
             </div>
           </form>

           <!-- SEARCH USERNAME -->
           <form action="display-user.php" method="get" name="form"> 
            <span class="right_header"> 
              <!-- <input name="search_username" id="search_username" type="text" class="form-control" placeholder="Search Username" aria-label="Username" aria-describedby="basic-addon1"> --><a href="databaseIndex.php"><button type="button" class="btn btn-primary btn-lg">Search Profile</button>
              </a>
            </span>
          </form>
      </nav>



	<div align="center">
		<b><h2>See What Other People Are Saying!</b></h2>
		<br><br><br>
 	
 	<?php 
 	include "messages.php";
 	 ?>

 	 <br><br><br>

	<form action="sendmsgs.php" method="POST">

		<center>Name</center>
		<input type="input" name="name" placeholder="Type your name"><br>

		

		<div class="form-group">
			<label for="exampleFormControlTextarea1"></label>
			<textarea name="message" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Type Your Message Here"></textarea> <br>
 	 	</div>
		<button >SEND</button>
		
	</form>
	</div>
</div>
</body>
</html>