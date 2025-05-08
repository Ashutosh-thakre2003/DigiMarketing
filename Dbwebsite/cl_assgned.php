<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "Vinayak@12210471";
$database = "grade";

// Establish database connection
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if edit mode is enabled
$editMode = isset($_GET['edit']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Client Management</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f7f7f7;
    }
    .container {
      width: 50%;
      margin: 20px auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h2 {
      margin-top: 0;
    }
    form {
      margin-bottom: 20px;
    }
    label {
      display: block;
      margin-bottom: 5px;
    }
    input[type="text"], input[type="submit"] {
        width:100%;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
      font-size: 16px;
    }
    input[type="submit"] {
      background-color: #4caf50;
      color: #fff;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    input[type="submit"]:hover {
      background-color: #45a049;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 10px;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
    }
    tr:hover {
      background-color: #f2f2f2;
    }
    .actions a {
      margin-right: 5px;
      text-decoration: none;
      color: #007bff;
    }
    .actions a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2><?php echo $editMode ? 'Edit Client' : 'Client List'; ?></h2>
    <?php if ($editMode) : ?>
      <!-- Display update form -->
      <form method="post" action="">
        <?php
        if(isset($_POST['update'])) {
          $id = $_POST['id'];
          $first_name = $_POST['first_name'];
          $last_name = $_POST['last_name'];
          
          $sql = "UPDATE Clients SET first_name='$first_name', last_name='$last_name' WHERE client_id='$id'";
          if ($conn->query($sql) === TRUE) {
            // Redirect to client list after update
            header("Location: cl_assgned.php");
            exit();
          } else {
            echo "Error updating record: " . $conn->error;
          }
        }

        $id = $_GET['edit'];
        $sql = "SELECT *, (SELECT COUNT(*) FROM Advertisement WHERE client_id = Clients.client_id) AS total_advertisements FROM Clients WHERE client_id='$id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $first_name = $row['first_name'];
          $last_name = $row['last_name'];
          $total_advertisements = $row['total_advertisements'];
        } else {
          echo "Client not found";
          exit();
        }
        ?>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo $first_name; ?>">
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo $last_name; ?>">
        <label for="total_advertisements">Total Advertisements:</label>
        <input type="text" id="total_advertisements" name="total_advertisements" value="<?php echo $total_advertisements; ?>" readonly>
        <input type="submit" name="update" value="Update">
      </form>
    <?php else : ?>
      <!-- Display client list -->
      <table>
        <thead>
          <tr>
            <th>Client ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Total Advertisements</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // READ operation
          $sql = "SELECT *, (SELECT COUNT(*) FROM Advertisement WHERE client_id = Clients.client_id) AS total_advertisements FROM Clients";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $row["client_id"] . "</td>";
              echo "<td>" . $row["first_name"] . "</td>";
              echo "<td>" . $row["last_name"] . "</td>";
              echo "<td>" . $row["total_advertisements"] . "</td>";
              echo "<td>
                      <a href='?edit=" . $row["client_id"] . "'>Edit</a>
                    </td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='5'>No clients found</td></tr>";
          }
          ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</body>
</html>
