<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "grade";

// Establish database connection
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Example client signup
$client_first_name = "John";
$client_last_name = "Doe";
$client_email = "john@example.com";
$client_password_hash = password_hash("password123", PASSWORD_DEFAULT); // Hash the password

// Insert the new client into the Clients table
$insert_client_sql = "INSERT INTO Clients (first_name, last_name, email_address, password_hash)
                      VALUES ('$client_first_name', '$client_last_name', '$client_email', '$client_password_hash')";
if ($conn->query($insert_client_sql) === TRUE) {
    $client_id = $conn->insert_id; // Get the auto-generated client ID
    echo "New client registered successfully with ID: $client_id <br>";
} else {
    echo "Error: " . $insert_client_sql . "<br>" . $conn->error;
}

// Example advertisement creation
$advertisement_name = "New Product Launch";
$advertisement_budget = 5000.00;

// Insert the advertisement into the Advertisement table, associating it with the client
$insert_advertisement_sql = "INSERT INTO Advertisement (client_id, advertisement_name, budget)
                              VALUES ('$client_id', '$advertisement_name', '$advertisement_budget')";
if ($conn->query($insert_advertisement_sql) === TRUE) {
    echo "New advertisement created successfully <br>";
} else {
    echo "Error: " . $insert_advertisement_sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
