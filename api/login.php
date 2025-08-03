<?php
// Start the session to store user information
session_start();

// Include the database connection script
include("connect.php");

// Sanitize user input to prevent SQL injection
$mobile = mysqli_real_escape_string($connect, $_POST["mobile"]);
$password = mysqli_real_escape_string($connect, $_POST["password"]);
$role = mysqli_real_escape_string($connect, $_POST["role"]);

// Query the database to check if the user exists with the provided credentials
$check = mysqli_query($connect, "SELECT * FROM user WHERE mobile='$mobile' AND password='$password' AND role='$role'");

// If user exists, fetch data and initialize session variables
if (mysqli_num_rows($check) > 0) {

    // Fetch the user's data
    $userdata = mysqli_fetch_array($check);

    // Query to fetch all groups (users with role = 2)
    $groups = mysqli_query($connect, "SELECT * FROM user WHERE role=2");
    $groupsdata = mysqli_fetch_all($groups, MYSQLI_ASSOC);

    // Store user and group data in session variables
    $_SESSION['userdata'] = $userdata;
    $_SESSION['groupsdata'] = $groupsdata;

    // Redirect to the dashboard page
    echo '
    <script>
        window.location="../routes/dashboard.php";
    </script>
    ';
} else {
    // Display an error message and redirect back to the login page
    echo '
    <script>
        alert("Invalid credentials or User not found!");
        window.location="../index.html";
    </script>
    ';
}
?>
