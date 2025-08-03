<?php
// Establish a connection to the MySQL database
// Parameters: Server name, Username, Password, and Database name
$connect = mysqli_connect("localhost", "root", "", "voting")
 // Check if the connection was successful
 or die("Connection failed: " . mysqli_connect_error());
 // If successful, $connect will now hold the connection resource
?>
