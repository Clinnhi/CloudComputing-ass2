<?php 
// require_once('DB.php');

// $db = new DB();

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Guestbook</title>
</head>
<body>

	<?php 

	// mysqli_connect("localhost", "root", "", "tutorials");
	// mysqli_select_db("tutorials");


	// Display stuff area
	$query = ('SELECT * FROM guestbook ORDER BY id DESC');
	$numrows = mysqli_num_rows($query);

	if($numrows > 0){
		while($row = mysql_num_rows($query)){
			$id = $row['id'];
			$name = $row['name'];
			$email = $row['email'];
			$message = $row['message'];
			$time = $row['time'];
			$date = $row['date'];
			
			echo "<div>
				$name - at $time on $date </hr>
				$message
			</div>";
			
		}

	}else{
		echo "No posts were found";
	}




	mysql_close();


	 ?>

</body>
</html>