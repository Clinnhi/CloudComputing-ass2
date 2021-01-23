<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
require 'functions/dynamodb_functions.php';
require 'functions/s3_functions.php';

$app = new DynamoDBFunctions();
$s3 = new S3Functions();

$search_results = "";

if (!empty($_POST['name'])) {
    $search_results = $_POST['name'];
    $data = $app->SearchUser($_POST['name']);
} else {
    $data = $app->SearchUser("");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Search Friends</title>

    <link rel="stylesheet" type="text/css" href="css/databaseStyle.css ">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body>

    <h1>Search Friends</h1>
    <form action="search-user.php" method="post">
        <input type="text" name="name" placeholder="Search Here..." id="searchBox">
        <button type="submit" class="btn btn-primary btn-block btn-large">Search</button>

    </form>
    <br>
    <?php
    if ($search_results != "") {
        echo "Showing search results for \"" . $search_results . "\"<br><br>";
    }
    ?>
    
    <ul id="dataViewer">
        <?php echo "<table>";
        foreach ($data as $user) {
            $fullname = $user['fullname']['S'];
            $username = $user['username']['S'];
            $userImage = $s3->getProfilePictureLink($username);
            echo "<tr><td><li><img src=" . $userImage . " style=\"width:50px;height:50px;\"><a style=\"color:white;\" href=\"display-user.php?user=" . $username . "\">" . $fullname . "</a></td></tr></li>";
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