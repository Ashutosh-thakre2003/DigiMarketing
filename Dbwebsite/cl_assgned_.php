<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "Vinayak@12210471";
$database = "grade";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// CREATE operation
if(isset($_POST['add'])) {
    $client_name = $_POST['client_name'];
    // $client_email = $_POST['client_email'];
    
    $sql = "INSERT INTO Clients (client_name) VALUES ('$client_name')";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// UPDATE operation
if(isset($_POST['update'])) {
    $id = $_POST['id'];
    $client_name = $_POST['client_name'];
    // $client_email = $_POST['client_email'];
    
    $sql = "UPDATE Clients SET client_name='$client_name' WHERE client_id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// DELETE operation
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM Clients WHERE client_id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Retrieve client details for update operation
if(isset($_GET['edit'])) {
    $id = $_GET['edit'];

    $sql = "SELECT * FROM Clients WHERE client_id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $client_name = $row['client_name'];
        // $client_email = $row['client_email'];
    } else {
        echo "Client not found";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DigiMarketing - We're available for marketing</title>

  <script>
    function scrollToContact() {
      // Scroll to the "Let's Contact With Us" section
      document.getElementById('contact').scrollIntoView({ behavior: 'smooth' });
    }
  </script>
  
  <!-- Favicon -->
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="./assets/css/style.css">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@500;700&family=Roboto:wght@400;500;700&display=swap"
    rel="stylesheet">
  
  <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }
    .container {
        width: 50%;
        margin: auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    h2 {
        text-align: center;
    }
    form {
        margin-top: 20px;
    }
    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }
    input[type="text"],
    input[type="email"],
    input[type="submit"] {
        width: 50%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 16px;
    }
    input[type="submit"] {
        background-color: #4caf50;
        color: white;
        cursor: pointer;
    }
    input[type="submit"]:hover {
        background-color: #45a049;
    }
    .client .email{
        text-align:center;
    }
  </style>
</head>

<body id="top">

  <!-- Header Section -->
  <header class="header" data-header>
    <div class="container">

      <a href="#" class="logo">DigiMarketing</a>

      <nav class="navbar container" data-navbar>
        <ul class="navbar-list">

          <li>
            <a href="index.html" class="navbar-link" data-nav-link>Home</a>
          </li>

          <li>
            <a href="index.html#service" class="navbar-link" data-nav-link>Services</a>
          </li>

          <li>
            <a href="index.html#project" class="navbar-link" data-nav-link>Project</a>
          </li>

          <li>
            <a href="index.html#about" class="navbar-link" data-nav-link>About Us</a>
          </li>

          <li>
            <a href="index.html#blog" class="navbar-link" data-nav-link>Blog</a>
          </li>

          <li>
            <a href="index.html#contact" class="navbar-link" data-nav-link>Contact Us</a>
          </li>

          <li>
            <a href="#" class="btn btn-primary" onclick="scrollToContact()">Get Started</a>
          </li>

        </ul>
      </nav>

      <button class="nav-toggle-btn" aria-label="Toggle menu" data-nav-toggler>
        <ion-icon name="menu-outline" class="open"></ion-icon>
        <ion-icon name="close-outline" class="close"></ion-icon>
      </button>

    </div>
  </header>

  <!-- Client List Section -->
  <section class="section client-list" id="client-list" aria-label="Client List">
    <div class="container">

      <h2 class="h2 section-title">Our Clients</h2>

      <!-- Client Cards -->
      <div class="client-cards">
        <?php
        // READ operation
        $sql = "SELECT * FROM Clients";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='client-card'>";
                echo "<h3 class='client-name'>" . $row["client_name"] . "</h3>";
                echo "<p class='client-description'>Description of " . $row["client_name"] . " or their project.</p>";
                echo "<!-- Add any additional information here -->";
                echo "</div>";
            }
        } else {
            echo "0 results";
        }
        ?>
      </div>

    </div>
  </section>

  <!-- Back to Top Button -->
  <a href="#top" aria-label="back to top" data-back-top-btn class="back-top-btn">
    <ion-icon name="chevron-up" aria-hidden="true"></ion-icon>
  </a>

  <!-- Custom JavaScript -->
  <script src="./assets/js/script.js" defer></script>

  <!-- Ionicon -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>

</body>

</html>