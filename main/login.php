<!-- old one 
  $sql = "SELECT * FROM login WHERE Username='$username' AND Password ='$password'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);

    if ($num == 1) {
        $login = true;
         session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;

            header("location: welcome.php");
    }else{
        $error = true;
    }
         -->
<!-- // Fetch user row based on username
         // $sql = "SELECT * FROM login WHERE Username='$username'";
            // Validate user by matching both username and email
             // $sql = "SELECT * FROM users WHERE Username='$username' AND Email='$email'"; -->

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include '../partials/database.php';

    $userInput = $_POST["username"]; // Can be username or email
    $password = $_POST["password"];

    //   new one
    // Search by username OR email
    $sql = "SELECT * FROM users WHERE username='$userInput' OR email='$userInput'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);

    if ($num == 1) {
        $row = mysqli_fetch_assoc($result);
        // Verify hashed password
        if (password_verify($password, $row['password'])) {
            $login = true;
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_id'] = $row['id']; // Assuming 'id' is the primary key in your `users` table

            // Redirect with success status
            header("Location: index.php?status=login_success");
            exit;
        } else {
            // Incorrect password
            header("Location: index.php?status=logerror&msg=Incorrect+password");
            exit;
        }
    } else {
        // User not found
        header("Location: index.php?status=logerror&msg=User+not+found");
        exit;
    }
}
?>