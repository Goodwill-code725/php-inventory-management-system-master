<?php 	

$localhost = "localhost";
$username = "root";        // Default username for WAMP
$password = "";            // Default password is blank
$dbname = "store";
$store_url = "http://localhost/php-inventory-management-system-master/";

// db connection
$connect = new mysqli($localhost, $username, $password, $dbname);

// check connection
if($connect->connect_error) {
  die("Connection Failed : " . $connect->connect_error);
} else {
  // echo "Successfully connected";
}

?>
