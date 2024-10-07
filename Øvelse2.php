<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
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

<h1>Bookings</h1>
</body>
</html>


<?php
include 'config.php'; // Include your database connection settings
$dbCon = dbCon($user, $pass);


    // SQL query to fetch bookings for the customer
    $sql = "SELECT b.booking_id, b.date, b.time, b.number_of_guests, r.table_id, c.first_name, c.last_name, c.email
            FROM Booking b
            JOIN Customer c ON b.customer_id = c.customer_id
            JOIN RestaurantTable r ON b.table_id = r.table_id
            
            ORDER BY b.date ASC";

    $query = $dbCon->prepare($sql);
    $query->execute();
    $bookings = $query->fetchAll(PDO::FETCH_ASSOC);

    // Display the results
    if ($bookings) {
        echo "<table border='1'>";
        echo "<tr><th>Booking ID</th><th>Date</th><th>Time</th><th>Number of Guests</th><th>Table ID</th><th>Customer Name</th><th>Customer Email</th></tr>";

        foreach ($bookings as $booking) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($booking['booking_id']) . "</td>";
            echo "<td>" . htmlspecialchars($booking['date']) . "</td>";
            echo "<td>" . htmlspecialchars($booking['time']) . "</td>";
            echo "<td>" . htmlspecialchars($booking['number_of_guests']) . "</td>";
            echo "<td>" . htmlspecialchars($booking['table_id']) . "</td>";
            echo "<td>" . htmlspecialchars($booking['first_name'] . ' ' . $booking['last_name']) . "</td>";
            echo "<td>" . htmlspecialchars($booking['email']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No bookings found for this customer.";
    }

?>
