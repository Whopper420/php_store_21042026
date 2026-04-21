<?php
$servername = "172.30.224.1";
$username = "store_app";
$password = "password";
$dbname = "store_dev";

$pdo = new mysqli($servername, $username, $password, $dbname);

if ($pdo->connect_error) {
  die("Connection failed: " . $pdo->connect_error);
}
echo "Connected successfully";
?>