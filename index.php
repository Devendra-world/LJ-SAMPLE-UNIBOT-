<?php
// Database configuration
$host = 'localhost';
$db_name = 'chatbot database';
$db_user = 'root';
$db_pass = '';
$table_name = 'admins';

// Connect to the database
$conn = new mysqli($host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get email and password from the form
    $Email = trim($_POST['Email']);
    $Password = trim($_POST['Password']);

    // Simple query to verify email and password
    $sql = "SELECT Password FROM $table_name WHERE Email = '$Email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['Password'] === $Password) {
            header("Location: Admin.php");
            exit();
        }
         else {
            echo "Incorrect password.";
        }
    } else {
        echo "No user found with this email.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../CLG Project/img/favicon-removebg-preview.png">
    <title>Sign up / Log in</title>
    <link rel="stylesheet" href="./CLG Project/css/Login.css">
</head>

<body>

    <div class="logo">
        <a href="index.php">
            <img src="./CLG Project/img/logo.png" alt="Logo" width="40" height="40" /></a>
    </div>
    <div class="form-container">
        <h2>Log in into Admin Panel</h2>

        <form method="POST">
            <input type="email" name="Email" id="element" placeholder="Enter Email">
            <input type="password" name="Password" id="element" placeholder="Enter Password">
            <button type="submit">Validate</button>
            <p>For Sign up,<a href="SignIN.php">Click here</a></p>
        </form>
    </div>
    
    <p class="copyright">&copy; Copyright 2024 LJ Unibot. All rights reserved.</p>


</body>

</html>