<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}
?>

<?php
// database connection
include 'database.php'; 

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM notes WHERE S_no = $id";
    mysqli_query($conn, $sql);

     // Redirect back to main page , send user back
   header("Location:../main/index.php?status=deleted");

    // Always call exit after header redirect
    exit(); 
}

echo"in delete.php";
?>
