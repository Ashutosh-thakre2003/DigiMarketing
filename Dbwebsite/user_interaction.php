<?php
// Include the database connection file
include 'db_connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $client_id = $_POST['client_id'];
    $employee_id = $_POST['employee_id'];
    $interaction_date = $_POST['interaction_date'];
    $interaction_type = $_POST['interaction_type'];
    $details = $_POST['details'];
    
    // Insert the interaction into the database
    $sql = "INSERT INTO interactions (client_id, employee_id, interaction_date, interaction_type, details)
            VALUES ('$client_id', '$employee_id', '$interaction_date', '$interaction_type', '$details')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Interaction created successfully";
    } else {
        echo "Error creating interaction: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Interaction</title>
  <style>
    body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f4;
  margin: 0;
  padding: 0;
}

.container {
  max-width: 600px;
  margin: 50px auto;
  padding: 20px;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
  text-align: center;
  margin-bottom: 20px;
}

form {
  margin-top: 20px;
}

label {
  display: block;
  margin-bottom: 8px;
}

select, input[type="date"], input[type="text"], textarea {
  width: 100%;
  padding: 12px;
  margin-bottom: 15px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-sizing: border-box;
  font-size: 16px;
}

input[type="submit"] {
  background-color: #4caf50;
  color: #fff;
  border: none;
  border-radius: 5px;
  padding: 12px 20px;
  cursor: pointer;
  transition: background-color 0.3s;
}

input[type="submit"]:hover {
  background-color: #45a049;
}

  </style>
</head>
<body>
  <h2>Create Interaction</h2>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="client_id">Client:</label>
    <select name="client_id" id="client_id">
        <select name="client_id">
    <option value="">Select Client</option>
    <?php
    // Include the database connection file
    include 'db_connect.php';

    // Query to fetch clients
    $query = "SELECT client_id, CONCAT(first_name, ' ', last_name) AS client_name FROM clients";
    $result = $conn->query($query);

    // Check if there are any clients
    if ($result->num_rows > 0) {
        // Loop through each client and generate an <option> element
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['client_id'] . "'>" . $row['client_name'] . "</option>";
        }
    } else {
        echo "<option value=''>No clients found</option>";
    }

    // Close the database connection
    $conn->close();
    ?>
</select>
    </select><br>
    
    <label for="employee_id">Employee:</label>
        < name="employee_id" id="employee_id">
            <select name="employee_id">
    <option value="">Select Employee</option>
    <?php
    // Include the database connection file
    include 'db_connect.php';

    // Query to fetch employees
    $query = "SELECT employee_id, CONCAT(employee_name) AS employee_name FROM Employee";
    $result = $conn->query($query);

    // Check if there are any employees
    if ($result->num_rows > 0) {
        // Loop through each employee and generate an <option> element
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['employee_id'] . "'>" . $row['employee_name'] . "</option>";
        }
    } else {
        echo "<option value=''>No employees found</option>";
    }

    // Close the database connection
    $conn->close();
    ?>
</select><br>
    
    <label for="interaction_date">Interaction Date:</label>
    <input type="date" name="interaction_date" id="interaction_date"><br>
    
    <label for="interaction_type">Interaction Type:</label>
    <input type="text" name="interaction_type" id="interaction_type"><br>
    
    <label for="details">Details:</label>
    <textarea name="details" id="details"></textarea><br>
    
    <input type="submit" name="submit" value="Create Interaction">
  </form>
</body>
</html>
