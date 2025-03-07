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
      $insertValues[$column] = "'$value'";
    }
  }

  if (!empty($insertValues)) {
    $insertQuery = "INSERT INTO `$selectedTable` (" . implode(", ", array_keys($insertValues)) . ") VALUES (" . implode(", ", $insertValues) . ")";
    if ($conn->query($insertQuery)) {
      echo "<script>alert('Record added successfully!');</script>";
      echo "<script>window.location.href = 'index.php?table=" . urlencode($selectedTable) . "';</script>";
      exit;
    } else {
      echo "Error: " . $conn->error;
    }
  }
}

$connect = mysqli_connect("localhost", "root", "") or die("Could not connect server");

$select_db = mysqli_select_db($connect, "chatbot database");
$sql = "SHOW TABLES";
$result = $connect->query($sql);
$tables = [];

if ($result->num_rows > 0) {
  while ($row = $result->fetch_array()) {
    $tables[] = $row[0];
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" type="image/x-icon" href="./CLG Project/img/favicon-removebg-preview.png">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <title>Admin Panel</title>
  <link rel="stylesheet" href="./CLG Project/css/Admins.css" />
</head>

<body>
  <div class="logo">
    <a href="Admin.php">
      <img src="./CLG Project/img/logo.png" alt="Logo" width="40" height="40" /></a>
  </div>

  <div class="grad-bar"></div>

  <div class="navbar">
    <?php if (!empty($tables)): ?>
      <?php foreach ($tables as $table): ?>
        <a href="view_table.php?table=<?php echo urlencode($table); ?>"><?php echo htmlspecialchars($table); ?></a>
      <?php endforeach; ?>
    <?php else: ?>
      <a href="#">No Tables Found</a>
    <?php endif; ?>
  </div>

  <div class="visit1">
    <h3>
      <a href="./CLG Project/index.php" target="_blank" class="texthead">Visit LJ University Chatbot Site
        <img src="./CLG Project/img/Botcon.jpg" alt="ChatBot" class="icon1" /></a>
    </h3>
  </div>
  <div class="visit2">
    <h3>
      <a href="https://ljku.edu.in/" target="_blank" class="texthead">Visit LJ University Official Website
        <img src="./CLG Project/img/logo.png" alt="Official" class="icon2" /></a>
    </h3>
  </div>

  <div class="visit3">
    <h3>
      <a href="Indata.php" class="texthead" target="_blank">Click Here to Add Data in Database</a>
    </h3>
  </div>

  <div class="visit3">
    <div class="product-card">
      <div class="tag">Under Development</div>
      <h3>
        <a href="./Project/DataIns.php" class="texthead" target="_blank">Click Here to Add Data in Unibot</a>
      </h3>
    </div>
  </div>


  <div class="visit3">
    <div class="product-card">
      <div class="tag">New</div>
      <h3>
        <a href="Futatd.php" class="texthead" target="_blank">Our Future Smart Attendence System</a>
      </h3>
    </div>
  </div>



  <div class="main-profile-container">

    <div>
      <h2 class="Uhead">Unibot Developers and Information</h2>
    </div>

    <div class="procontain">
      <div class="profile">
        <a href="./Profiles/DweejPro.html" class="Name">
          <img src="./CLG Project/img/Dweej.jpg" alt="" id="Dweej">
          <h4>DWEEJ</h4>
          <h4>BHATT</h4>
        </a>
        <p class="LRole">(Leader)</p>
      </div>

      <div class="profile">
        <a href="./Profiles/DevPro.html" class="Name">
          <img src="./CLG Project/img/Devashish.jpg" alt="" id="Devashish">
          <h4>DEVASHISH</h4>
          <h4>MODI</h4>
        </a>
        <p class="CLRole">(Co-Leader)</p>
      </div>

      <div class="profile">
        <a href="./Profiles/DevePro.html" class="Name">
          <img src="./CLG Project/img/Devendra.jpg" alt="" id="Devendra">
          <h4>DEVENDRA</h4>
          <h4>PATADIYA</h4>
        </a>
        <p class="Role">(Member)</p>
      </div>

      <div class="profile">
        <a href="./Profiles/DiyasPro.html" class="Name">
          <img src="./CLG Project/img/DiyaS.jpg" alt="" id="Jinendra">
          <h4>DIYA</h4>
          <h4>SUTHAR</h4>
        </a>
        <p class="Role">(Member)</p>
      </div>

      <div class="profile">
        <a href="./Profiles/DiyapPro.html" class="Name">
          <img src="./CLG Project/img/Diya.jpg" alt="" id="Jinendra">
          <h4>DIYA</h4>
          <h4>PATEL</h4>
        </a>
        <p class="Role">(Member)</p>
      </div>

      <div class="profile">
        <a href="./Profiles/JitendraPro.html" class="Name">
          <img src="./CLG Project/img/Jinendra.jpg" alt="" id="Jinendra">
          <h4>JINENDRA</h4>
          <h4>JAIN</h4>
        </a>
        <p class="Role">(Member)</p>
      </div>

    </div>

    <div class="chart">
      <div>
        <h2 class="Chead1">Required Language Chart</h2>
        <img src="./CLG Project/img/LPIE.jpg" alt="Chart" height="550" width="600" class="Chart1">
      </div>

      <div>
        <h2 class="Chead2">Members Working Chart</h2>
        <img src="./CLG Project/img/HIRAL MAAM.jpg" alt="Chart" height="550" width="600" class="Chart2">
      </div>
    </div>

  </div>

</body>

</html>