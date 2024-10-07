-- Create Restaurant table
CREATE TABLE Restaurant (
    restaurant_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    address VARCHAR(100),
    phone VARCHAR(20),
    email VARCHAR(100)
);

-- Insert one restaurant for example
INSERT INTO Restaurant (name, address, phone, email) VALUES
('The Gourmet Spot', '123 Fancy St, Foodville', '123-456-7890', 'info@gourmetspot.com');

-- Create Customer table
CREATE TABLE Customer (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    email VARCHAR(100),
    phone VARCHAR(20)
);

-- Create RestaurantTable table
CREATE TABLE RestaurantTable (
    table_id INT AUTO_INCREMENT PRIMARY KEY,
    table_number INT,
    capacity INT,
    restaurant_id INT,
    FOREIGN KEY (restaurant_id) REFERENCES Restaurant(restaurant_id) ON DELETE CASCADE
);

-- Create Booking table
CREATE TABLE Booking (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE,
    time TIME,
    number_of_guests INT,
    customer_id INT,
    table_id INT,
    FOREIGN KEY (customer_id) REFERENCES Customer(customer_id) ON DELETE CASCADE,
    FOREIGN KEY (table_id) REFERENCES RestaurantTable(table_id) ON DELETE CASCADE
);

-- Insert 10 Customers
INSERT INTO Customer (first_name, last_name, email, phone) VALUES
('John', 'Doe', 'john.doe@example.com', '1234567890'),
('Jane', 'Doe', 'jane.doe@example.com', '2345678901'),
('Michael', 'Smith', 'michael.smith@example.com', '3456789012'),
('Emily', 'Johnson', 'emily.johnson@example.com', '4567890123'),
('Chris', 'Evans', 'chris.evans@example.com', '5678901234'),
('Sarah', 'Connor', 'sarah.connor@example.com', '6789012345'),
('Tom', 'Cruise', 'tom.cruise@example.com', '7890123456'),
('Alice', 'Wonder', 'alice.wonder@example.com', '8901234567'),
('Bob', 'Marley', 'bob.marley@example.com', '9012345678'),
('Diana', 'Prince', 'diana.prince@example.com', '0123456789');

-- Insert 10 Restaurant Tables (linked to the restaurant_id = 1)
INSERT INTO RestaurantTable (table_number, capacity, restaurant_id) VALUES
(1, 4, 1),
(2, 2, 1),
(3, 6, 1),
(4, 4, 1),
(5, 8, 1),
(6, 2, 1),
(7, 4, 1),
(8, 6, 1),
(9, 4, 1),
(10, 2, 1);

-- Insert 10 Bookings (For example purposes, same date and table for demonstration)
INSERT INTO Booking (date, time, number_of_guests, customer_id, table_id) VALUES
('2024-10-10', '19:00:00', 4, 1, 1),
('2024-10-10', '20:00:00', 2, 2, 1),
('2024-10-11', '18:30:00', 6, 3, 2),
('2024-10-10', '19:00:00', 2, 4, 2),
('2024-10-12', '19:30:00', 4, 5, 3),
('2024-10-10', '20:30:00', 4, 6, 3),
('2024-10-11', '19:00:00', 2, 7, 4),
('2024-10-10', '21:00:00', 8, 8, 4),
('2024-10-13', '19:00:00', 6, 9, 5),
('2024-10-10', '19:00:00', 4, 10, 5);


