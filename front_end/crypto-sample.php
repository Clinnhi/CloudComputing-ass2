<?php 


$url = "https://www.coinspot.com.au/pubapi/latest"; 
$getContent = file_get_contents($url);   
$json = json_decode($getContent, true);   

 // Check if the form is submitted 
 if ( isset( $_GET['submit'] ) ) { 
 // retrieve the form data by using the element's name attributes value as key 
 $cryptoOne = $_GET['crypto-one']; 
 $cryptoTwo = $_GET['crypto-two']; // display the results 
 $cryptoThree = $_GET['crypto-three'];

 echo '<h3>Form GET Method</h3>'; 
 	echo 'Price for ' . $cryptoOne . ' is:  $' . $json['prices'][$cryptoOne]["last"] . '<br>';
 	echo 'Price for ' . $cryptoTwo . ' is: $' . $json['prices'][$cryptoTwo]["last"] . '<br>';
 	echo 'Price for ' . $cryptoThree . ' is: $' .$json['prices'][$cryptoThree]["last"] . '<br>';
}

 ?>