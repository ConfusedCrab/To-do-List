<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sno = $_POST['s_no'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    $sql = "UPDATE notes SET Title = '$title', Description = '$description' WHERE S_no = $sno";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: ../main/index.php?status=updated");
    } else {
        header("Location: ../main/index.php?status=error");
    }
}
?>
