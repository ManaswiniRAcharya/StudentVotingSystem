<?php
// Start the session to access session variables
session_start();

// Include the database connection script
include("connect.php");

// Retrieve data from the POST request and convert to integers
$votes = (int)$_POST['gvotes']; // Current votes for the selected group
$total_votes = $votes + 1; // Increment the vote count by 1
$gid = (int)$_POST['gid']; // Group ID for the vote
$uid = $_SESSION['userdata']['id']; // User ID of the voter from session

// Query to update the votes for the selected group
$update_votes = mysqli_query($connect, "UPDATE user SET votes='$total_votes' WHERE id='$gid'");

// Query to update the voting status for the user
$update_user_status = mysqli_query($connect, "UPDATE user SET status=1 WHERE id='$uid'");

// Check if both update queries executed successfully
if ($update_votes && $update_user_status) {
    // Fetch updated group data (all users with role = 2)
    $groups = mysqli_query($connect, "SELECT * FROM user WHERE role=2");
    $groupsdata = mysqli_fetch_all($groups, MYSQLI_ASSOC);

    // Update session variables with user status and group data
    $_SESSION['userdata']['status'] = 1; // Mark user as having voted
    $_SESSION['groupsdata'] = $groupsdata; // Store updated group data in session

    // Redirect to the dashboard with a success message
    echo '
        <script>
            alert("Voting successful!");
            window.location="../routes/dashboard.php";
        </script>
    ';
} else {
    // If an error occurs, display a message and redirect to the dashboard
    echo '
        <script>
            alert("Some error occurred!");
            window.location="../routes/dashboard.php";
        </script>
    ';
}
?>
