<?php
include("../api/connect.php");

$result_date = "2025-04-29"; 
$current_date = date("Y-m-d");
?>
<html>
<head>
    <title>Election Results</title>
    <link rel="stylesheet" href="../css/stylesheet.css">
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    body {
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
        background-color: #D4C9BE;
        text-align: center;
    }

    #headerSection {
        padding: 5px;
        background-color: #123458;
        color: #FFFFFF;
        text-align: center;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom:40px;
    }

    h1 {
        color: #123458;
        font-size: 32px;
        margin-bottom: 30px;
    }

    .message {
        font-size: 22px;
        color: #123458;
        padding: 20px;
        background-color: #FFFFFF;
        border: 2px solid #123458;
        border-radius: 10px;
        display: inline-block;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .result-table {
        margin: 30px auto;
        width: 80%;
        border-collapse: collapse;
        font-size: 18px;
        background-color: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
    }

    .result-table th, .result-table td {
        border: 1px solid #ddd;
        padding: 12px 16px;
        text-align: center;
        transition: background-color 0.3s ease;
    }

    .result-table th {
        background-color: #123458;
        color: white;
        font-weight: 600;
        font-size: 18px;
    }

    .result-table th:first-child {
        width: 20%;
    }

    .result-table th:nth-child(2) {
        width: 50%; 
    }

    .result-table th:nth-child(3) {
        width: 30%;
    }

    .result-table td:first-child {
        width: 30%; 
    }

    .result-table td:nth-child(2) {
        width: 40%; 
    }

    .result-table td:nth-child(3) {
        width: 20%;
    }

    .result-table tr:hover td {
        background-color: #D4C9BE;
    }

    .winner {
        background-color: gold;
        color: #000;
        font-weight: bold;
        font-size: 21px;
    }

    .trophy {
        font-size: 24px;
        color: gold;
        display: inline-block;
    }

    #logoutbtn {
        margin-top: 30px;
        display: inline-block;
        padding: 12px 24px;
        background-color: #123458;
        color: white;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        font-size: 16px;
        transition: background-color 0.3s ease, transform 0.2s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    #logoutbtn:hover {
        background-color: #030303;
        transform: scale(1.05);
    }

    @media (max-width: 768px) {
        .container {
            width: 95%;
            padding: 20px;
        }

        .result-table, .result-table th, .result-table td {
            font-size: 14px;
            padding: 8px;
        }

        #logoutbtn {
            width: 80%;
        }
    }
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OTP Timer</title>
    <style>
        .resend_otp_count {
            color: blue;
            cursor: pointer;
            font-weight: bold;
        }
    </style>
</head>
<body>

</body>
</html>


</head>
<body>
    <div id="headerSection">
        <h2>Election Results</h2>
    </div>


    <?php
    if ($current_date < $result_date) {
        echo '<div class="message">Elections are just around the corner! The portal will go live on ' . date("F d, Y", strtotime($result_date)) . '. Thank you for your patience!</div>';
    } else {
        
        $groups = mysqli_query($connect, "SELECT * FROM user WHERE role=2 ORDER BY votes DESC");
        if (mysqli_num_rows($groups) > 0) {
           
            echo '<table class="result-table">';
            echo '<tr><th>Profile</th><th>Candidate Name</th><th>Votes</th></tr>';
            $isWinner = true;
            while ($row = mysqli_fetch_assoc($groups)) {
                echo '<tr' . ($isWinner ? ' class="winner"' : '') . '>';
                echo '<td><img src="../uploads/' . $row['photo'] . '" width="80" height="80" style="border-radius: 50%; border: 2px solid #123458;"></td>';
                echo '<td>' . $row['name'] . ($isWinner ? ' <span class="trophy">🏆</span>' : '') . '</td>';
                echo '<td>' . $row['votes'] . '</td>';
                echo '</tr>';
                $isWinner = false;
            }
            echo '</table>';
        } else {
            echo '<p class="message">No results available.</p>';
        }
       
    }
    ?>
    <a href="../routes/logout.php" id="logoutbtn">Logout</a>
</body>
</html>



