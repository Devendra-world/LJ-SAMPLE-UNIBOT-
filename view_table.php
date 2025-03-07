<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./CLG Project/img/favicon-removebg-preview.png">
    <link rel="stylesheet" href="./CLG Project/css/Tableview.css">
</head>

<body>
    <div class="logo">
        <a href="Admin.php">
            <img src="./CLG Project/img/logo.png" alt="Logo" width="40" height="40" /></a>
    </div>
    <div class="grad-bar"></div>
    <div class="navbar">
        <?php
        $connect = mysqli_connect("localhost", "root", "", "chatbot database") or die("Could not connect server");
        $sql = "SHOW TABLES";
        $result = $connect->query($sql);
        $tables = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_array()) {
                $tables[] = $row[0];
            }
        }
        ?>
        <?php if (!empty($tables)): ?>
            <?php foreach ($tables as $table): ?>
                <a href="view_table.php?table=<?php echo urlencode($table); ?>"><?php echo htmlspecialchars($table); ?></a>
            <?php endforeach; ?>
        <?php else: ?>
            <a href="#">No Tables Found</a>
        <?php endif; ?>
    </div>

    <?php
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'chatbot database';
    $table = $_GET['table'] ?? null;

    if ($table) {
        $conn = new mysqli($host, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM " . $conn->real_escape_string($table);
        $result = $conn->query($sql);

        if ($result) {
            echo "<h1>Table: " . htmlspecialchars($table) . "</h1>";
            echo "<table border='1'>";
            echo "<tr>";
            while ($field = $result->fetch_field()) {
                echo "<th>" . htmlspecialchars($field->name) . "</th>";
            }
            echo "<th>Edit</th><th>Delete</th>"; // Add Edit and Delete columns
            echo "</tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                foreach ($row as $key => $value) {
                    echo "<td>" . htmlspecialchars($value) . "</td>";
                }
                // Add Edit and Delete links
                echo "<td><a href='edit.php?table=" . urlencode($table) . "&id=" . urlencode($row['id']) . "'>Edit</a></td>";
                echo "<td><a href='delete.php?table=" . urlencode($table) . "&id=" . urlencode($row['id']) . "' onclick=\"return confirm('Are you sure you want to delete this record?');\">Delete</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Error retrieving table: " . $conn->error;
        }

    } else {
        echo "No table specified.";
    }
    ?>

</body>

</html>