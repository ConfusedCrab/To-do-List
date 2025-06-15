<?php
// database connection
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];


    // checks the boxes are not blank
    if (empty($name) || empty($email) || empty($message)) {
        $error = "Please fill in all fields before submitting.";
    } else {

        $sql = "INSERT INTO contactUs (`name`, `email`, `message`) VALUES ('$name','$email','$message')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<script>
                  alert('Message sent successfully!');
                     // Redirect 
                      window.location.href = '../main/index.php';
                       </script>";
                    exit;
        } else {
            echo "Error: " . $stmt->error;
            header("Location: ../main/index.php");
            exit;
        }
    }
}