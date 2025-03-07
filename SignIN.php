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
    // Get form data
    $Name = trim($_POST['Name']);
    $Email = trim($_POST['Email']);
    $Password = trim($_POST['Password']);
    $Role = trim($_POST['Role']);

    // Check if the email already exists
    $check_sql = "SELECT id FROM $table_name WHERE Email = '$Email'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        header("Location: index.php");
        echo "Record already exists with this email.";
    } else {
        // Insert the new record
        $insert_sql = "INSERT INTO $table_name (Name, Email, Password, Role) VALUES ('$Name', '$Email', '$Password', '$Role')";
        if ($conn->query($insert_sql) === TRUE) {
            header("Location: index.php");
            exit();        } else {
            echo "Error: " . $insert_sql . "<br>" . $conn->error;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../CLG Project/img/favicon-removebg-preview.png">
    <title>Sign up</title>
    <link rel="stylesheet" href="./CLG Project/css/Login.css">
</head>

<body>

    <div class="logo">
        <a href="SignIN.php">
            <img src="./CLG Project/img/logo.png" alt="Logo" width="40" height="40" /></a>
    </div>

    <div class="form-container">
    <h2 id="signin">Sign in</h2>

        <form method="POST">
            <input type="text" name="Name" id="element" placeholder="Enter Name">
            <input type="email" name="Email" id="element" placeholder="Enter Email">
            <input type="password" name="Password" id="element" placeholder="Enter Password">
            <input type="text" name="Role" id="element" placeholder="Enter Role">
            <button id="Addme" type="submit">Add me</button>
        </form>
    </div>

    <p class="copyright">&copy; Copyright 2024 LJ Chatboat. All rights reserved.</p>

</body>

</html>