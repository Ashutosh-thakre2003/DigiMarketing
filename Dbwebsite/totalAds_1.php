<?php
// Include the database connection file
include 'db_connect.php';

// Check if the procedure exists
$result = $conn->query("SHOW PROCEDURE STATUS WHERE Db = 'your_database_name' AND Name = 'GetClientTotalBudget'");

if ($result && $result->num_rows > 0) {
    // Procedure already exists
    $result->close();
} else {
    // Procedure does not exist, create it
    $stmt = $conn->query("CREATE PROCEDURE GetClientTotalBudget(IN client_id INT)
                        BEGIN
                            SELECT SUM(budget) AS total_budget FROM Advertisement WHERE client_id = client_id;
                        END");
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advertisement Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-top: 20px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-transform: uppercase;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Advertisement Dashboard</h1>

    <table>
        <thead>
            <tr>
                <th>Client ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Total Advertisements</th>
                <th>Total Budget</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // SQL query to retrieve clients and their total budget for advertisements
            $query = "(SELECT client_id, first_name, last_name, NULL AS employee_name, NULL AS total_advertisements, NULL AS total_budget FROM Clients)
                      UNION
                      (SELECT client_id, NULL AS first_name, NULL AS last_name, employee_name, NULL AS total_advertisements, NULL AS total_budget FROM Employee)
                      ORDER BY total_budget DESC";

            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    if (!empty($row["first_name"])) {
                        // If the row represents a client, get their total budget using the stored procedure
                        $client_id = $row["client_id"];
                        $stmt = $conn->prepare("CALL GetClientTotalBudget(?)");
                        $stmt->bind_param("i", $client_id);
                        $stmt->execute();
                        $stmt->bind_result($total_budget);
                        $stmt->fetch();
                        $stmt->close();
                        $row["total_budget"] = $total_budget;
                    }
                    echo "<tr>
                            <td>".$row["client_id"]."</td>
                            <td>".$row["first_name"]."</td>
                            <td>".$row["last_name"]."</td>
                            <td>".$row["total_advertisements"]."</td>
                            <td>".$row["total_budget"]."</td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No results found</td></tr>";
            }

            // Close connection
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
