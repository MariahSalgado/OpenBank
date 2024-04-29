<?php
session_start();
require_once 'config.php';
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo "Not logged in";
    exit;
}

// Connect to the database
$conn = new mysqli($host, $db_user, $db_password, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$customer_id = $_SESSION['customer_id'];
$amount = $_POST['amount'];
$type = $_POST['type'];  // 'deposit' or 'withdraw'

// Validate amount
if ($amount <= 0) {
    echo "Invalid amount";
    exit;
}

if ($type == 'deposit') {
    $query = "UPDATE Accounts SET Balance = Balance + ? WHERE CustomerID = ?";
} elseif ($type == 'withdraw') {
    $query = "UPDATE Accounts SET Balance = Balance - ? WHERE CustomerID = ?";
    // Additional check to ensure balance cannot go negative
    $stmt = $conn->prepare("SELECT Balance FROM Accounts WHERE CustomerID = ?");
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $stmt->bind_result($current_balance);
    $stmt->fetch();
    if ($current_balance < $amount) {
        echo "Insufficient funds";
        exit;
    }
    $stmt->close();
} else {
    echo "Invalid transaction type";
    exit;
}

$stmt = $conn->prepare($query);
$stmt->bind_param("di", $amount, $customer_id);
if ($stmt->execute()) {
    echo "Transaction successful";
} else {
    echo "Error: " . $stmt->error;
}
$stmt->close();
$conn->close();
?>
