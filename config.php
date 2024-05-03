<?php
// Database host, usually 'localhost'
$host = 'localhost';

// Database username
$db_user = 'Basic';

// Database password
$db_password = '9173';

// Name of database
$db_name = 'banking';

// Optional: A DSN string for PDO connections could also be included
// $dsn = "mysql:host=$host;dbname=$db_name;charset=utf8mb4";

// You could also include a function to create and return a new database connection
function connect_to_db() {
    // Using global variables from above within this function's scope
    global $host, $db_user, $db_password, $db_name;
    
    // Create a new mysqli connection
    $conn = new mysqli($host, $db_user, $db_password, $db_name);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
?>

