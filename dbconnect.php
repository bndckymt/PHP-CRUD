<?php

// Define database connection variables
$servername = "localhost"; // The database server (localhost for local development)
$username = "root"; // Default username for local database
$password = ""; // Default password (empty for XAMPP, WAMP, etc.)

// Create a new connection to the MySQL database
$conn = new mysqli($servername, $username, $password);

// Check if the connection was successful
if ($conn->connect_error) { // If there is an error in the connection
    die("Connection failed: " . $conn->connect_error); // Stop the script and display an error message
}

// If connection is successful, display a success message
echo "Connected successfully";

?>

/*
Summary:
- This script establishes a connection to a MySQL database using the mysqli class.
- It defines the database server name, username, and password.
- It attempts to connect to the database.
- If the connection fails, an error message is displayed, and the script stops.
- If the connection succeeds, a success message is displayed.
*/
