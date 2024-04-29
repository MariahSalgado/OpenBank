<?php
session_start();
require_once 'config.php';
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo "Not logged in";
    exit;
}

// Connect to the database
$conn = new mysqli($host, $db_user, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$customer_id = $_SESSION['customer_id'];  // Assuming you store customer_id in session upon login

// Prepare and execute the query
$stmt = $conn->prepare("SELECT Balance FROM Accounts WHERE CustomerID = ?");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$stmt->bind_result($balance);
$stmt->fetch();
$stmt->close();
$conn->close();

echo $balance; // Return the balance to the AJAX call
?>
