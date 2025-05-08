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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Advertisement Campaign Data</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Client Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Advertisement Name</th>
                    <th>Advertisement Budget</th>
                    <th>Campaign Name</th>
                    <th>Campaign Budget</th>
                </tr>
            </thead>
            <tbody>
                <?php

                // SQL query to fetch data
                $sql = "SELECT
                            cl.first_name AS `Client Name`,
                            cl.email_address AS `Email`,
                            cl.phone_number AS `Phone Number`,
                            a.advertisement_name AS `Advertisement Name`,
                            a.budget AS `Advertisement Budget`,
                            c.campaign_name AS `Campaign Name`,
                            c.campaign_budget AS `Campaign Budget`
                        FROM
                            Clients cl
                        LEFT JOIN
                            Advertisement a ON cl.client_id = a.client_id
                        LEFT JOIN
                            Campaigns c ON cl.client_id = c.client_id";

                // Execute SQL query
                $result = $conn->query($sql);

                // Check if any rows were returned
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["Client Name"] . "</td>";
                        echo "<td>" . $row["Email"] . "</td>";
                        echo "<td>" . $row["Phone Number"] . "</td>";
                        echo "<td>" . $row["Advertisement Name"] . "</td>";
                        echo "<td>$" . $row["Advertisement Budget"] . "</td>";
                        echo "<td>" . $row["Campaign Name"] . "</td>";
                        echo "<td>$" . $row["Campaign Budget"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No campaigns found for any client.</td></tr>";
                }

                // Close connection
                $conn->close();
                ?>

            </tbody>
        </table>
    </div>
</body>

</html>
