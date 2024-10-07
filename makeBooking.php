<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Booking</title>
</head>
<body>
    <form method="POST" action="makeBooking.php">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name" required>

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>

        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" required>

        <label for="date">Booking Date:</label>
        <input type="date" name="date" id="date" required>

        <label for="time">Time:</label>
        <input type="time" name="time" id="time" required>

        <input type="submit" value="Create Booking">
    </form>
</body>
</html>

<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Establish database connection
    $dbCon = dbCon($user, $pass);

    // Fetch form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Check if customer exists
    $customerQuery = $dbCon->prepare("SELECT customer_id FROM Customer WHERE email = :email");
    $customerQuery->bindParam(':email', $email);
    $customerQuery->execute();
    $customer = $customerQuery->fetch(PDO::FETCH_ASSOC);

    if ($customer) {
        // If customer exists, get the customer_id
        $customer_id = $customer['customer_id'];
    } else {
        // If customer does not exist, insert a new customer
        $customerInsert = $dbCon->prepare("INSERT INTO Customer (first_name, last_name, email, phone) VALUES (:first_name, :last_name, :email, :phone)");
        $customerInsert->bindParam(':first_name', $first_name);
        $customerInsert->bindParam(':last_name', $last_name);
        $customerInsert->bindParam(':email', $email);
        $customerInsert->bindParam(':phone', $phone);
        $customerInsert->execute();
        $customer_id = $dbCon->lastInsertId();  // Get the newly inserted customer ID
    }

    // Find an available table
    $tableQuery = $dbCon->prepare("SELECT table_id FROM RestaurantTable 
        WHERE table_id NOT IN (
            SELECT table_id FROM Booking 
            WHERE date = :date AND time = :time
        ) 
        LIMIT 1
    ");
    $tableQuery->bindParam(':date', $date);
    $tableQuery->bindParam(':time', $time);
    $tableQuery->execute();
    $table = $tableQuery->fetch(PDO::FETCH_ASSOC);

    if ($table) {
        $table_id = $table['table_id'];

        // Insert the booking
        $bookingInsert = $dbCon->prepare("INSERT INTO Booking (date, time, number_of_guests, customer_id, table_id) VALUES (:date, :time, 4, :customer_id, :table_id)");
        $bookingInsert->bindParam(':date', $date);
        $bookingInsert->bindParam(':time', $time);
        $bookingInsert->bindParam(':customer_id', $customer_id);
        $bookingInsert->bindParam(':table_id', $table_id);

        if ($bookingInsert->execute()) {
            echo "Booking successfully created for $first_name at table $table_id!";
        } else {
            echo "Error saving booking.";
        }
    } else {
        echo "No available tables for the selected time.";
    }
}
?>
