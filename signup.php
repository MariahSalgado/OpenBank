<?php
// Enable error reporting for debugging (recommended to be turned off in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database credentials
$host = 'localhost';
$username = 'Basic'; // Ensure this username is correct and has the necessary privileges
$password = '9173';
$dbname = 'banking';

// Create database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Check if the form data is posted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize it
    $fname = $conn->real_escape_string($_POST['fname'] ?? '');
    $lname = $conn->real_escape_string($_POST['lname'] ?? '');
    $email = $conn->real_escape_string($_POST['email'] ?? '');
    $pnumber = $conn->real_escape_string($_POST['pnumber'] ?? '');
    $username = $conn->real_escape_string($_POST['username'] ?? '');
    $password = $conn->real_escape_string($_POST['password'] ?? '');

    // Prepare SQL statement to insert form data into the Customers table
    $stmt = $conn->prepare("INSERT INTO Customers (FirstName, LastName, Email, PhoneNumber, Username, Password) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die('MySQL prepare error: ' . $conn->error);
    }

    // Bind parameters and execute the statement
    $stmt->bind_param("ssssss", $fname, $lname, $email, $pnumber, $username, $password);
    if ($stmt->execute()) {
        echo "Thank you for creating an account with us.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
}
$conn->close();
?>

</body>
</html>
