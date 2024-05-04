<?php
// Enable error reporting for debugging (recommended to be turned off in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data from the signup html file
    $fname = $conn->real_escape_string($_POST['fname'] ?? '');
    $lname = $conn->real_escape_string($_POST['lname'] ?? '');
    $email = $conn->real_escape_string($_POST['email'] ?? '');
    $pnumber = $conn->real_escape_string($_POST['pnumber'] ?? '');
    $username = $conn->real_escape_string($_POST['username'] ?? '');
    $password = $conn->real_escape_string($_POST['password'] ?? '');

    // SQL statement to insert data into the Customers table
    $stmt = $conn->prepare("INSERT INTO Customers (FirstName, LastName, Email, PhoneNumber, Username, Password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $fname, $lname, $email, $pnumber, $username, $password);
    if ($stmt->execute()) {
        $customer_id = $stmt->insert_id;

	// Creating a new account for the user
	$stmt = $conn->prepare("INSERT INTO Accounts (CustomerID, AccountType, Balance) VALUES (?, 'Checking', 250.00)");
	$stmt->bind_param("i", $customer_id);
	if ($stmt->execute()) {
		echo "Thank you for creating an account with us. $250 has been deposited into your account";
		echo '<a href = "index.html"> Back to login,/a>';
	} else {
		echo "Error: account could not be created" . $stmt->error; }
   } else {
	echo "Error" . $stmt->error; }


    // Close statement and connection
    $stmt->close();
}
$conn->close();
?>

</body>
</html>
