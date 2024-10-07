<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Tables Overview</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h1>Restaurant Tables Overview</h1>

<?php
include 'config.php';

// Step 1: Connect to the database
$dbCon = dbCon($user, $pass);

// Step 2: Fetch all tables from the RestaurantTable table
$sql = "SELECT table_id, table_number, capacity FROM RestaurantTable ORDER BY table_number ASC";
$query = $dbCon->prepare($sql);
$query->execute();
$tables = $query->fetchAll(PDO::FETCH_ASSOC);

// Step 3: Display the tables in a HTML table
if ($tables) {
    echo "<table>";
    echo "<tr><th>Table Number</th><th>Capacity</th><th>Status</th></tr>";

    foreach ($tables as $table) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($table['table_number']) . "</td>";
        echo "<td>" . htmlspecialchars($table['capacity']) . "</td>";

        // Check if the table is booked by querying the Booking table
        $checkBookingQuery = $dbCon->prepare("SELECT COUNT(*) AS booked_count 
            FROM Booking 
            WHERE table_id = :table_id AND date = CURDATE()
        ");
        $checkBookingQuery->bindParam(':table_id', $table['table_id'], PDO::PARAM_INT);
        $checkBookingQuery->execute();
        $bookingStatus = $checkBookingQuery->fetch(PDO::FETCH_ASSOC);

        // Show the status as 'Booked' or 'Available'
        if ($bookingStatus['booked_count'] > 0) {
            echo "<td style='color: red;'>Booked</td>";
        } else {
            echo "<td style='color: green;'>Available</td>";
        }

        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No tables found in the restaurant.";
}
?>

</body>
</html>
