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
            // Include the database connection file
            include 'db_connect.php';

            // Query to retrieve clients and their total budget for advertisements
            $query = "SELECT c.client_id, c.first_name, c.last_name, COUNT(a.advertisement_name) AS total_advertisements, SUM(a.budget) AS total_budget
                      FROM Clients c
                      LEFT JOIN Advertisement a ON c.client_id = a.client_id
                      GROUP BY c.client_id
                      HAVING total_budget > 1000
                      ORDER BY total_budget DESC";

            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
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

<?php
// Use the provided SQL queries here
// Remember to replace 'db_connect.php' with your actual database connection script
?>
