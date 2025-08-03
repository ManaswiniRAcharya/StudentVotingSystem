<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("location:adminLogin.html");
    exit();
}
include("../api/connect.php");

// Fetch candidates pending approval
$pendingCandidates = mysqli_query($connect, "SELECT * FROM user WHERE role = 2 AND approved = 0");

// Fetch approved candidates
$approvedCandidates = mysqli_query($connect, "SELECT * FROM user WHERE role = 2 AND approved = 1");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Election Portal</title>
    <link rel="stylesheet" href="../css/stylesheet.css">
    <style>
        .candidate-box { border: 1px solid black; padding: 10px; margin-bottom: 10px; background: white; }
        .btn { padding: 5px 10px; margin-right: 5px; }
        .approve { background: green; color: white; }
        .reject { background: red; color: white; }
    </style>
</head>
<body>
    <center>
        <h2>Admin Dashboard</h2>
        <a href="logout.php"><button class="btn">Logout</button></a>
        <hr>

        <h3>Pending Candidate Approvals</h3>
        <?php while ($row = mysqli_fetch_assoc($pendingCandidates)) { ?>
            <div class="candidate-box">
                <img src="../uploads/<?php echo $row['photo']; ?>" height="100" width="100"><br>
                <b>Name:</b> <?php echo $row['name']; ?><br>
                <b>Mobile:</b> <?php echo $row['mobile']; ?><br>
                <form action="../api/adminActions.php" method="POST">
                    <input type="hidden" name="userid" value="<?php echo $row['id']; ?>">
                    <button name="action" value="approve" class="btn approve">Approve</button>
                    <button name="action" value="reject" class="btn reject">Reject</button>
                </form>
            </div>
        <?php } ?>

        <h3>Approved Candidates</h3>
        <?php while ($row = mysqli_fetch_assoc($approvedCandidates)) { ?>
            <div class="candidate-box">
                <img src="../uploads/<?php echo $row['photo']; ?>" height="100" width="100"><br>
                <b>Name:</b> <?php echo $row['name']; ?><br>
                <b>Votes:</b> <?php echo $row['votes']; ?><br>
            </div>
        <?php } ?>
    </center>
</body>
</html>
