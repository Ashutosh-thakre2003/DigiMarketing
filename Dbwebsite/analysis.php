<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Employee Information</h2>
    <table>
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Employee Email</th>
                <th>Interaction Date</th>
                <th>Interaction Type</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Include the database connection file
            include 'db_connect.php';

            // Call the stored procedure to fetch employee information
            $stmt = $conn->prepare("CALL GetEmployeeInfo()");
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["employee_name"] . "</td>
                            <td>" . $row["employee_email"] . "</td>
                            <td>" . $row["interaction_date"] . "</td>
                            <td>" . $row["interaction_type"] . "</td>
                            <td>" . $row["details"] . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No interactions found</td></tr>";
            }

            // Close statement and connection
            $stmt->close();
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
