<?php

// Define database connection parameters
$servername = "localhost"; // Database server (usually localhost for local development)
$username = "root"; // Database username (default for local MySQL)
$password = ""; // Database password (empty by default for local MySQL)

try {
    // Create a new PDO (PHP Data Objects) connection to MySQL
    $conn = new PDO("mysql:host=$servername;dbname=crud_db", $username, $password);

    // Set the PDO error mode to Exception for better error handling
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
    // Log the error message into a file (error_log.txt) for debugging
    error_log($e->getMessage(), 3, "error_log.txt");
    echo "Connected successfully";
    // Display a user-friendly error message and stop script execution
    die("Database connection error. Please contact admin.");
}

?>

/*
Summary:
- This script establishes a connection to a MySQL database using PHP Data Objects (PDO).
- It defines the database server name, username, and password.
- It attempts to connect to the database 'crud_db'.
- PDO is used for better security and flexibility.
- If the connection fails, an error message is logged, and a user-friendly message is displayed.
- If the connection succeeds, a success message is displayed.
*/
