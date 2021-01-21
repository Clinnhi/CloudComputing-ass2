<?php

$full_name = $_POST['full-name'];
$email = $_POST['email'];
$about_me = $_POST['about-me'];

// Cryptocurrency
$crypto_one = $_POST['crypto-one'];
$crypto_two = $_POST['crypto-two'];
$crypto_three = $_POST['crypto-three'];


// Websites
$website_one = $_POST['website-one-url'];
$website_two = $_POST['website-two-url'];
$website_three = $_POST['website-three-url'];

// Photos
$photo_name = $_POST['photo_name'];


echo "Full Name: " . $full_name . "<br>";
echo "Email: " . $email . "<br>";
echo "About Me: " . $about_me . "<br>";

echo "Photo: " . $photo_name . "<br>";


echo "Cryptocurrency One: " . $crypto_one . "<br>";
echo "Cryptocurrency Two: " . $crypto_two . "<br>";
echo "Cryptocurrency Three: " . $crypto_three . "<br>";

echo "Website One: " . $website_one . "<br>";
echo "Website Two: " . $website_two . "<br>";
echo "Website Three: " . $website_three . "<br>";
?>