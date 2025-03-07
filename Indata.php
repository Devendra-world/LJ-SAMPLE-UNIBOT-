<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'chatbot database';
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all table names
$tablesResult = $conn->query("SHOW TABLES");
$tables = [];
while ($row = $tablesResult->fetch_array()) {
    $tables[] = $row[0];
}

// Get selected table
$selectedTable = $_GET['table'] ?? null;

// Fetch columns for the selected table
$columns = [];
if ($selectedTable) {
    $columnsResult = $conn->query("SHOW COLUMNS FROM `$selectedTable`");
    while ($column = $columnsResult->fetch_assoc()) {
        $columns[] = $column['Field'];
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $selectedTable) {
    $insertValues = [];
    foreach ($columns as $column) {
        if ($column !== 'id') { // Skip 'id' column if it's auto-increment
            $value = $_POST[$column] ?? '';
            $insertValues[$column] = $conn->real_escape_string($value);
        }
    }

    if (!empty($insertValues)) {
        $insertQuery = "INSERT INTO `$selectedTable` (`" . implode("`, `", array_keys($insertValues)) . "`) 
                        VALUES ('" . implode("', '", $insertValues) . "')";
        if ($conn->query($insertQuery)) {
            echo "<script>alert('Record added successfully!');</script>";
            echo "<script>window.location.href = 'Indata.php?table=" . urlencode($selectedTable) . "';</script>";
            exit;
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./CLG Project/img/favicon-removebg-preview.png">
    <title>Insert Data</title>
    <link rel="stylesheet" href="./CLG Project/css/Admins.css" />
</head>

<body>
    <div class="logo">
        <a href="Admin.php">
            <img src="./CLG Project/img/logo.png" alt="Logo" width="40" height="40" /></a>
    </div>
    <div class="grad-bar"></div>
    <div class="navbar_insert">
        <?php foreach ($tables as $table): ?>
            <a href="?table=<?php echo urlencode($table); ?>"><?php echo htmlspecialchars($table); ?></a>
        <?php endforeach; ?>
    </div>

    <div class="form-container">
        <?php if ($selectedTable): ?>
            <h2 class="inshead">Insert Data into Table: <?php echo htmlspecialchars($selectedTable); ?></h2>
            <form method="POST">
                <?php foreach ($columns as $column): ?>
                    <?php if ($column !== 'id'): ?>
                        <label
                            for="<?php echo htmlspecialchars($column); ?>"><?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $column))); ?>:</label>
                        <input type="text" name="<?php echo htmlspecialchars($column); ?>" id="<?php echo htmlspecialchars($column); ?>">
                    <?php endif; ?>
                <?php endforeach; ?>
                <button type="submit">Submit</button>
            </form>
        <?php else: ?>
            <p>Please select a table given up in navbar to insert Record.</p>
        <?php endif; ?>
    </div>
</body>

</html>
