<?php
//start session
session_start();


//cerate constants to store non repeating values
define('SITEURL', 'http://localhost/Food-order/');
define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'binaya');
define('DB_PASSWORD', 'Password@1');
define('DB_NAME', 'food-order');


$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($e)); //database connection
$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($e)); //database selection
