<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}
?>


<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "practice_of_php";

// Create connection 
$conn = mysqli_connect($servername, $username, $password, $database);

// Die if connection was not successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>