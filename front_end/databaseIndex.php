<?php 

require_once('DB.php');

$db = new DB();
$data = $db->viewData();

// var_dump($data);

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Search Friends</title>

	<link rel="stylesheet" type="text/css" href="databaseStyle.css ">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>

	<h1>Search Friends</h1>
	<form action="search.php" method="post">
		<input type="text" name="name" placeholder="Search Here..." id="searchBox" oninput="search(this.value)">
	</form>

	<ul id="dataViewer">
		<?php echo "<table>";
		foreach ($data as $i) 
	{
    	echo "<tr><td><li>".($i['name'])."</td></tr></li>";
    }
		echo "</table>"; ?>

	</ul>

	<script src="main.js"></script>

	<a href="display-user.php"><button type="button" class="btn btn-secondary btn-lg">Go Back to Profile</button>
	</a>


</body>
</html>




<!-- YOUTUBE TUTORIAL -->
<!-- https://www.youtube.com/watch?v=-v53ly8Zlfc -->