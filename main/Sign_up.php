<!-- 
session_start();
include 'database.php';

$action = $_POST['action'];
$username = $_POST['username'];
$password = $_POST['password'];

if ($action == 'signup') {
    $email = $_POST['email'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: ../main/index.php?status=signup_success");
    } else {
        header("Location: ../main/index.php?status=signup_error");
    }
}

if ($action == 'login') {
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            header("Location: ../main/index.php?status=login_success");
            exit();
        }
    }
    header("Location: ../main/index.php?status=login_error");
}
 -->
<?php
// sign up 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  include '../partials/database.php';
  $username = $_POST["username"];
  $password = $_POST["password"];
  $cpassword = $_POST["cpassword"];
  $email = $_POST["email"];

  // new one 
  $checkUser = "SELECT * FROM users WHERE username='$username'";
  $result = mysqli_query($conn, $checkUser);
  $numExistRows = mysqli_num_rows($result);

  if ($numExistRows > 0) {
    $exists = true;
    echo "<script>alert('Username already exists!');</script>";
    // Redirect 
    header("Location: index.php");
    exit;
  } else if ($password !== $cpassword) {
    echo "<script>alert('Passwords do not match!');</script>";
    // Redirect 
    header("Location: index.php");
    exit;
  } else {
    // hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    // insert user
    $sql = "INSERT INTO users (`username`, `password`,`email`) VALUES('$username', '$hashedPassword','$email')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      header("Location: index.php?status=account_created");
      exit;
    } else {
      header("Location: index.php?status=signup_error&message=" . urlencode($error));
      exit;
    }
  }

}
?>