<?php
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

if ($email == 'admin@gmail.com' && $password == 'admin123') {
    $_SESSION['admin'] = true;
    header("location: dashboard.php");
} else {
    echo "<script>alert('Invalid admin credentials'); window.location='login.php';</script>";
}
?>
