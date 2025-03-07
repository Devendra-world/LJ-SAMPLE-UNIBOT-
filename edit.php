<?php
// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'chatbot database';
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get table and ID from query parameters
$table = $_GET['table'] ?? null;
$id = $_GET['id'] ?? null;

if ($table && $id) {
    // Fetch table columns
    $columnsResult = $conn->query("SHOW COLUMNS FROM `$table`");
    $columns = [];
    while ($column = $columnsResult->fetch_assoc()) {
        $columns[] = $column['Field'];
    }

    // Fetch row data
    $rowResult = $conn->query("SELECT * FROM `$table` WHERE id = $id");
    $row = $rowResult->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Process form submission
        $updateValues = [];
        foreach ($columns as $column) {
            if ($column !== 'id' && isset($_POST[$column])) {
                $value = $_POST[$column];
                $updateValues[] = "`$column` = '$value'";
            }
        }

        if (!empty($updateValues)) {
            $updateQuery = "UPDATE `$table` SET " . implode(', ', $updateValues) . " WHERE id = $id";
            if ($conn->query($updateQuery)) {
                echo "<script>alert('Record updated successfully!');</script>";
                echo "<script>window.location.href = 'view_table.php?table=" . urlencode($table) . "';</script>";
                exit;
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }
    }
} else {
    echo "Invalid table or ID.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../CLG Project/img/favicon-removebg-preview.png">
    <title>Edit Record</title>
    <link rel="stylesheet" href="./CLG Project/css/edit.css">
</head>

<body>
    <div class="container">
    <h2>Edit Record in Table: <?php echo htmlspecialchars($table); ?></h2>
    <form method="POST">
        <?php if (!empty($columns) && !empty($row)): ?>
            <?php foreach ($columns as $column): ?>
                <?php if ($column !== 'id'): ?>
                    <label for="<?php echo htmlspecialchars($column); ?>">
                        <?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $column))); ?>
                    </label>
                    <input 
                        type="text" 
                        name="<?php echo $column; ?>" 
                        id="<?php echo $column; ?>" 
                        value="<?php echo $row[$column]; ?>" 
                    >
                <?php else: ?>
                    <input type="hidden" name="id" value="<?php echo $row[$column]; ?>">
                <?php endif; ?>
            <?php endforeach; ?>
            <button type="submit">Update</button>
        <?php else: ?>
            <p>Unable to fetch table or row data.</p>
        <?php endif; ?>
    </form>
    </div>
</body>

</html>