-- First query
SELECT table_id, table_number, capacity
FROM RestaurantTable;


-- Second query
SELECT b.booking_id, b.date, b.time, b.number_of_guests, r.table_id, c.first_name, c.last_name, c.email
FROM Booking b
JOIN Customer c ON b.customer_id = c.customer_id
JOIN RestaurantTable r ON b.table_id = r.table_id
ORDER BY b.date ASC;

-- Second query specific customer
SELECT b.booking_id, b.date, b.time, b.number_of_guests, r.table_id, c.first_name, c.last_name, c.email
FROM Booking b
JOIN Customer c ON b.customer_id = c.customer_id
JOIN RestaurantTable r ON b.table_id = r.table_id
WHERE c.customer_id = 5
ORDER BY b.date ASC;


-- Third query
SELECT b.booking_id, b.date, b.time, b.number_of_guests, r.table_id, c.first_name, c.last_name, c.email
FROM Booking b
JOIN Customer c ON b.customer_id = c.customer_id
JOIN RestaurantTable r ON b.table_id = r.table_id
WHERE r.table_id = 1  
AND b.date = '2024-10-10'
ORDER BY b.time ASC;