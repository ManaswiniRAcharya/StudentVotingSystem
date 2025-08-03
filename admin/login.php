<!DOCTYPE html>
<html>
<head>
    <title>Admin Login - Student Election Portal</title>
    <link rel="stylesheet" href="../css/stylesheet.css">
</head>
<body>
    <center>
        <div id="headerSection">
            <h1>Admin Login - Student Election Portal</h1>
        </div>
        <hr>
        <div id="bodySection">
            <form action="adminLogin.php" method="post">
                <h2>Login as Admin</h2>
                <input type="email" name="email" placeholder="Enter email" required><br><br>
                <input type="password" name="password" placeholder="Enter password" required><br><br>
                <button type="submit">Login</button><br><br>
                Not registered? Contact system developer to add admin.
            </form>
        </div>
    </center>
</body>
</html>
