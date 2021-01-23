<?php 

include "DB.php";
 

if (isset($_POST['name'])){

$sender = $_POST['name'];
// $surname = $_POST['surname'];
$message = $_POST['message'];

echo "Name: " . $sender; echo "<br>";
// echo "Surname: " . $surname; echo "<br>";
echo "message: " . $message; echo "<br>";

$sql_statement = "INSERT INTO messages(sender, message)
					VALUES ('$sender', '$message')";

$result = mysqli_query($db, $sql_statement);
header ("Location: index.php");
// echo "My result is: " . $result;

 }
 else{
 	echo "No Name";
 }
 ?>