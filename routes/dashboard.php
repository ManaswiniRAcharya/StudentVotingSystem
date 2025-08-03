<?php
// Start the session to access session variables
session_start();

// Check if the user data is stored in the session
// If not, redirect the user to the login page
if (!isset($_SESSION['userdata'])) {
    header("location:../index.html"); // Redirects to the login page
}

// Retrieve the user data and group data from the session
$userdata = $_SESSION['userdata'];
$groupsdata = $_SESSION['groupsdata'];

// Check the user's voting status
// If status is 0, the user has not voted, display "Not voted" in red
// If status is not 0, the user has voted, display "Voted" in green
if ($_SESSION['userdata']['status'] == 0) {
    $status = '<b style="color:red">Not voted</b>'; // Voting status: Not voted
} else {
    $status = '<b style="color:green">Voted</b>'; // Voting status: Voted
}
?>

<html>
<head>
    <title>Online Voting System - Dashboard</title>
    <link rel="stylesheet" href="../css/stylesheet.css">
    <style>
        #resultbtn {
            float: left;
            margin: 10px;
            padding: 10px;
            width: 10%;
            border:1px solid black;
            background-color: white;
            color: #123458;
            font-weight: bold;
        }
        #logoutbtn {
            float: right;
            margin: 10px;
            width: 10%;
            border:1px solid black;
            background-color: white;
            color: #123458;
            font-weight: bold;
        }
        #logoutbtn:hover {
            background-color: #030303;
            color: white;
        }
        #resultbtn:hover {
            background-color: #030303;
            color: white;
        }
        #mainpanel {
            padding: 20px;
            display: flex;
            justify-content: space-around;
            align-items: flex-start;
        }
        #Profile {
            background-color: white;
            width: 30%;
            height: 350px;
            padding: 30px 20px;
            overflow: hidden;
            float: left;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin-right: 20px;
            text-align: center;
            line-height: 1.8;
            position: sticky;
            top: 20px;
        }
        #Profile b {
            color: #123458;
        }
        #Profile img {
            border-radius: 50%;
            margin-bottom: 15px;
            border: 2px solid #123458;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            font-size: 16px;
            text-align: left;
        }
        .info-label {
            font-weight: bold;
            color: #123458;
            width: 40%;
        }
        .info-value {
            width: 60%;
        }
        #Group {
            background-color: white;
            width: 60%;
            max-height: 500px;
            overflow-y: auto;
            padding: 20px;
            float: left;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        #votebtn {
            padding: 8px 16px;
            font-size: 15px;
            border-radius: 8px;
            background-color: #123458;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        #votebtn:hover {
            background-color: #030303;
        }
        #voted {
            padding: 8px 16px;
            font-size: 15px;
            border-radius: 8px;
            background-color: green;
            color: white;
            border: none;
        }
        #headerSection h1 {
            margin: 20px 0 10px 0;
        }
        #Group div {
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 20px;
        }
        #Group img {
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div id="mainSection">
        <center>
            <div id="headerSection">
                <a href="result.php"><button id="resultbtn">Result</button></a>
                <a href="logout.php"><button id="logoutbtn">Logout</button></a>
                <h1>WELCOME TO STUDENT ELECTION PORTAL</h1>
            </div>
        </center>
        <hr>
        <div id="mainpanel">
            <div id="Profile">
                <img src="../uploads/<?php echo $userdata['photo'] ?>" height="100" width="100" alt="">

                <div class="info-row">
                    <div class="info-label">Name:</div>
                    <div class="info-value"><?php echo $userdata['name']; ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Mobile:</div>
                    <div class="info-value"><?php echo $userdata['mobile']; ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Status:</div>
                    <div class="info-value"><?php echo $status; ?></div>
                </div>
            </div>

            <div id="Group">
                <?php
                if (isset($groupsdata) && count($groupsdata) > 0) {
                    for ($i = 0; $i < count($groupsdata); $i++) {
                        ?>
                        <div>
                            <img style="float:right" src="../uploads/<?php echo $groupsdata[$i]['photo'] ?>" height="100" width="100" alt="">
                            <b>Group name:</b> <?php echo $groupsdata[$i]['name'] ?><br><br>
                          
                            <form action="../api/vote.php" method="POST">
                                <input type="hidden" name="gvotes" value="<?php echo $groupsdata[$i]['votes'] ?>">
                                <input type="hidden" name="gid" value="<?php echo $groupsdata[$i]['id'] ?>">
                                <?php
                                if ($_SESSION['userdata']['status'] == 0) {
                                    ?>
                                    <input type="submit" name="votebtn" value="Vote" id="votebtn">
                                    <?php
                                } else {
                                    ?>
                                    <button disabled type="button" name="votebtn" value="Vote" id="voted">Voted</button>
                                    <?php
                                }
                                ?>
                            </form>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p>No groups available!</p>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
