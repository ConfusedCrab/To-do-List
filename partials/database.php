<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "todo";

// Create connection 
$conn = mysqli_connect($servername, $username, $password, $database);

// Die if connection was not successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>