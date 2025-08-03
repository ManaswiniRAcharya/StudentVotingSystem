<?php
// Start the session to access stored session data
session_start();

// Destroy the session to log out the user and clear session variables
session_destroy();

// Redirect the user to the homepage after logout
header("location: ../");
?>
