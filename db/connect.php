<?php
$servername = "172.30.224.1";
$username = "store_app";
$password = "password";
$dbname = "store_dev";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>