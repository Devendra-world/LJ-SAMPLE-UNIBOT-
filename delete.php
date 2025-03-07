<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'chatbot database';

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$table = $_GET['table'] ?? null;
$id = $_GET['id'] ?? null;

if ($table && $id) {
    // Debugging output
    echo "Attempting to delete record from table: " . htmlspecialchars($table) . " with ID: " . htmlspecialchars($id);

    // Secure query
    $sql = "DELETE FROM `" . $conn->real_escape_string($table) . "` WHERE `id` = " . intval($id);
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record Deleted successfully!');</script>";
        echo "<script>window.location.href = 'view_table.php?table=" . urlencode($table) . "';</script>";
        exit;
        } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Invalid table or ID.";
}
?>
