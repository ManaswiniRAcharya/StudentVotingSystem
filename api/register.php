<?php
// Include the database connection script
include("connect.php");

// Sanitize user inputs to prevent SQL injection attacks
$name = mysqli_real_escape_string($connect, $_POST['name']);
$mobile = mysqli_real_escape_string($connect, $_POST['mobile']);
$password = mysqli_real_escape_string($connect, $_POST['password']);
$cpassword = mysqli_real_escape_string($connect, $_POST['cpassword']);
$image = $_FILES['photo']['name']; // Get the name of the uploaded file
$tmp_name = $_FILES['photo']['tmp_name']; // Get the temporary file path
$role = $_POST['role']; // Fetch the user role

// Validate name
if (empty($name)) {
    echo '
    <script>
        alert("Name is required.");
        window.location="../routes/register.html";
    </script>
    ';
    exit; // Stop further execution if validation fails
}

// Validate mobile number
if (empty($mobile)) {
    echo '
    <script>
        alert("Mobile number is required.");
        window.location="../routes/register.html";
    </script>
    ';
    exit;
}

// Check if the mobile number has exactly 10 digits
if (!preg_match('/^\d{10}$/', $mobile)) {
    echo '
    <script>
        alert("Mobile number must be exactly 10 digits.");
        window.location="../routes/register.html";
    </script>
    ';
    exit;
}

// Validate password
if (empty($password)) {
    echo '
    <script>
        alert("Password is required.");
        window.location="../routes/register.html";
    </script>
    ';
    exit;
}

// Check if passwords match
if ($password === $cpassword) {
    // If passwords match, move the uploaded image to the specified directory
    move_uploaded_file($tmp_name, "../uploads/$image");

    // Insert the validated user data into the database
    $insert = mysqli_query($connect, "INSERT INTO user (name, mobile, password, photo, role, status, votes) VALUES ('$name', '$mobile', '$password', '$image', '$role', 0, 0)");

    // Check if the data was successfully inserted
    if ($insert) {
        echo '
        <script>
            alert("Registration Successful!");
            window.location="../";
        </script>
        ';
    } else {
        // Display an error message if insertion fails
        echo '
        <script>
            alert("Some error occurred!");
            window.location="../routes/register.html";
        </script>
        ';
    }
} else {
    // If passwords don't match, display an alert and redirect to the registration page
    echo '
    <script>
        alert("Passwords do not match!");
        window.location="../routes/register.html";
    </script>
    ';
}
?>
