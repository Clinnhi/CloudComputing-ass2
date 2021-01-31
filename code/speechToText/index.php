
<!DOCTYPE html>
<html>
<head>
	<title>Speech To Text</title>
    
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
                <li><a href="../connect/connect-list.php">Connected Friends</a></li>
                <li><a href="../connect/connect-request-list.php">Connect Requests</a></li>
                <li><a href="speechToText/speechIndex.php">Fun Implementations!</a></li>
                <li><a href="../logout.php">Logout</a></li>
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
                    <a href="search-user.php"><button type="button" class="btn btn-primary btn-lg">Find Friends</button>
                    </a>
                </span>
            </form>
        </nav>


    <section id="greetings" class="jumbotron">
        <center><h3>Try out our awesome audio to text feature!<script language="javascript"></center>
        </script>
        </h3>
      </section>




    <center><div class="container">
	<form method="post" enctype="multipart/form-data">
        <p><input type="file" name="audio" accept="audio/*,video/*" /></p>
        <div class="form-group">
            <textarea class="form-control" id="textArea" rows="3" placeholder="Please allow up to 30 seconds for your text to appear after submission."><?php include('speech.php') ?></textarea>
        </div>
        <input type="submit" name="submit" value="Transcribe into text!" />

    </form>
    </center>


</body>
</html>